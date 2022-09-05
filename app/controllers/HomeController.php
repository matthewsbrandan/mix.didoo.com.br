<?php

include_once __DIR__."/Controller.php";

class HomeController extends Controller{
  public function index(){
    [$data, $err] = $this->cms->get("page/data/".$this->theme_slug);
    if(!$data || !$data->result || $err) return view('error-404');

    $page_config = $data->response->datas[0];
    $elements = $data->response->elements;
    
    $parsedElements = [];
    foreach($elements as $element){     
      $data = $element->datas ? $element->datas[0] : null;
      if($data){
        if($data->active){
          $data = json_decode($data->data);
          if($data) foreach($data as &$item){
            if(is_string($item) && $jsonParsed = json_decode($item)) $item = $jsonParsed;
          }
        }
        else $data = null;
      }
      $parsedElements[$element->class_name] = $data;
    }
    $parsedElements = $this->fakeElements($parsedElements);
    // REQUIRED SECTIONS
    if(!$parsedElements['menu'] || !$parsedElements['navbar']) return view('error-500',[
      'page_config' => $page_config,
      'message' => "Não foi possível localizar as informações do menu ou da barra de navegação!<br/><small>É obrigatório preencher as informações deste elementos.</small>"
    ]);

    // EXCEPTIONS
    $parsedElements = $this->sectionExceptions($parsedElements);
    $existingOrders = $this->handleExistingOrders($parsedElements);
    
    return view('index',[
      'page_config' => $page_config,
      'elements' => $parsedElements,
      'existingOrders' => $existingOrders,
      'cms_page_token' => $this->cms->getPageToken()
    ]);
  }
  public function policy(){
    [$data, $err] = $this->cms->get("page/data-select/".$this->theme_slug."&privacity_policy");

    if(!$data || !$data->result || $err) return view('error-404');

    $page_config = $data->response->datas[0];
    $elements = $data->response->elements;
    
    $parsedElements = [];
    foreach($elements as $element){
      $data = $element->datas ? $element->datas[0] : null;
      if($data){
        if($data->active){
          $data = json_decode($data->data);
          if($data) foreach($data as &$item){
            if(is_string($item) && $jsonParsed = json_decode($item)) $item = $jsonParsed;
          }
        }
        else $data = null;
      }
      $parsedElements[$element->class_name] = $data;
    }

    return view('privacy_policy',[
      'page_config' => $page_config,
      'elements' => $parsedElements
    ]);
  }
  public function links(){
    [$data, $err] = $this->cms->get("page/data-select/".$this->theme_slug."&links");

    if(!$data || !$data->result || $err) return view('error-404');

    $page_config = $data->response->datas[0];
    $elements = $data->response->elements;
    
    $parsedElements = [];
    foreach($elements as $element){
      $data = $element->datas ? $element->datas[0] : null;
      if($data){
        if($data->active){
          $data = json_decode($data->data);
          if($data) foreach($data as &$item){
            if(is_string($item) && $jsonParsed = json_decode($item)) $item = $jsonParsed;
          }
        }
        else $data = null;
      }
      $parsedElements[$element->class_name] = $data;
    }

    $page_config->title = $page_config->title . ' | Links';
    return view('links',[
      'page_config' => $page_config,
      'links' => $parsedElements['links']
    ]);
  }
  public function product($slug = null){
    if(!$slug) return view('error-404');
    [$data, $err] = $this->cms->get("page/data-select/".$this->theme_slug."&multi_photos,navbar");
    if(!$data || !$data->result || $err) return view('error-404');

    $page_config = $data->response->datas[0];
    $elements = $data->response->elements;
    
    $parsedElements = [];
    foreach($elements as $element){
      $data = $element->datas ? $element->datas[0] : null;
      if($data){
        if($data->active){
          $data = json_decode($data->data);
          if($data) foreach($data as &$item){
            if(is_string($item) && $jsonParsed = json_decode($item)) $item = $jsonParsed;
          }
        }
        else $data = null;
      }
      $parsedElements[$element->class_name] = $data;
    }
    $parsedElements = $this->sectionExceptions($parsedElements);
    try{
      $products = $parsedElements['multi_photos']->services;
      $product = null;
      if($slug){
        foreach($products as $product_item){
          if($product_item->slug === $slug){
            $product = $product_item;
            break;
          }
        }
      }
      if($product){
        $page_config->title = $product->title . ' | '. $page_config->title;
        $page_config->metadescription = $product->description;
      }
      return view('product.show',[
        'page_config' => $page_config,
        'elements' => $parsedElements,
        'product' => $product,
        'slug' => $slug
      ]);
    }catch(Exception $e){
      return view('error-500',[
        'message' => 'Houve um erro ao carregar o produto/serviço'
      ]);
    }
  }
  protected function sectionExceptions($elements){
    if(isset($elements['multi_photos'])) recursiveArrayJsonParsed($elements['multi_photos']);
    if(isset($elements['products'])) $this->handleProductCategories($elements['products']);
    
    return $elements;
  }
  protected function handleExistingOrders($elements){
    $existingOrders = [];
    foreach($elements as $key => $element){
      if(in_array($key, [
        'code',
        'navbar',
        'banner',
        'jivochat',
        'privacity_policy',
        'footer',
        'popup',
        'links'
      ])) continue;

      if($key == 'section_dynamic' && isset($element->section_dynamic)){
        foreach($element->section_dynamic as $section){
          if(isset($section->order) && $section->order) $existingOrders[] = $section->order;
        }
        continue;
      }

      if(isset($element->order) && $element->order) $existingOrders[] = $element->order;
    }
    return $existingOrders;
  }
  protected function handleProductCategories(&$products){
    if(!isset($products->items)){
      $products = null;
      return;
    }
    $categories = [];
    foreach($products->items as $item){
      if(!in_array($item->category, $categories)) $categories[] = $item->category;
    }
    $products->categories = $categories;
  }
  protected function fakeElements($elements){
    $products = (object)[
      'order' => 1,
      'background' => '#ffffff00',
      'title' => (object)[
        'text' => 'Produtos Personalizados',
        'color' => '',
        'fontsize' => ''
      ],
      'items' => [(object)[
        'slug' => 'balde-de-cerveja',
        'code' => 'BC01',
        'category' => 'Bebidas',
        'styles' => [
          'background' => '#ffffffff',
          'border_color' => '',
          'text_color' => '',
          'text_highlighted' => '',
          'text_lowlighted' => '',
        ],
        'image' => (object)[
          'src' => 'https://site.didoo.com.br/galleries/1/tema-mix/1661313651_1.png',
          'alt' => 'Balde de Cerveja'
        ],
        'title' => (object)[
          'text' => 'Balde de Cerveja',
          'fontsize' => ''
        ],
        'price' => (object)[
          'current' => '289,00',
          'old' => '389,00',
          'current_fontsize' => '',
          'old_fontsize' => ''
        ],
        'button' => (object)[
          'text' => 'Mais Informações',
          'background' => '',
          'color' =>  ''
        ]
      ],(object)[
        'slug' => 'caneca-para-cerveja',
        'code' => 'BC01',
        'category' => 'Bebidas',
        'styles' => [
          'background' => '#ffffffff',
          'border_color' => '',
          'text_color' => '',
          'text_highlighted' => '',
          'text_lowlighted' => '',
          'button_categories_color' => ''
        ],
        'image' => (object)[
          'src' => 'https://site.didoo.com.br/galleries/1/tema-mix/1661314232_1.png',
          'alt' => 'Caneca para Cerveja'
        ],
        'title' => (object)[
          'text' => 'Caneca para Cerveja',
          'fontsize' => ''
        ],
        'price' => (object)[
          'current' => '189,00',
          'old' => '',
          'current_fontsize' => '',
          'old_fontsize' => ''
        ],
        'button' => (object)[
          'text' => 'Mais Informações',
          'background' => '',
          'color' =>  ''
        ]
      ],(object)[
        'slug' => 'porta-copos',
        'code' => 'PC01',
        'category' => 'Brinde',
        'background' => '#ffffffff',
        'border_color' => '',
        'text_color' => '',
        'text_highlighted' => '',
        'text_lowlighted' => '',
        'image' => (object)[
          'src' => 'https://site.didoo.com.br/galleries/1/tema-mix/1661314493_1.png',
          'alt' => 'Porta Copos'
        ],
        'title' => (object)[
          'text' => 'Porta Copos',
          'fontsize' => ''
        ],
        'price' => (object)[
          'current' => '',
          'old' => '',
          'current_fontsize' => '',
          'old_fontsize' => ''
        ],
        'button' => (object)[
          'text' => 'Mais Informações',
          'background' => '',
          'color' =>  ''
        ]
      ]]
    ];
    $testimonial = (object)[
      'order' => 2,
      'background' => 'transparent',
      'title' => (object)[
        'text' => 'Depoimentos de Clientes',
        'color' => '',
        'fontsize' => ''
      ],
      'text_color_highlight' => '#dc3545ff',
      'text_color' => '',
      'depoiments' => [
        (object)[
          'image' => 'http://site.didoo.com.br/galleries/1/tema-mix/1662163180_6.jpg',
          'name' => 'Vanessa da Silva',
          'city_state' => 'Bauru / SP',
          'stars' => 5,
          'description' => 'Melhor pizza da vida'
        ],(object)[
          'image' => 'http://site.didoo.com.br/galleries/1/tema-mix/1662163180_7.jpg',
          'name' => 'Vinicius Santos',
          'city_state' => 'São Paulo / SP',
          'stars' => 4,
          'description' => 'Entrega rápida'
        ],(object)[
          'image' => 'http://site.didoo.com.br/galleries/1/tema-mix/1662163180_5.jpg',
          'name' => 'Norma Vicentino',
          'city_state' => 'Marília / SP',
          'stars' => 5,
          'description' => 'Amei tudo!'
        ],(object)[
          'image' => 'http://site.didoo.com.br/galleries/1/tema-mix/1662163180_4.jpg',
          'name' => 'Maria Aparecida',
          'city_state' => 'Santos / SP',
          'stars' => 3,
          'description' => 'Excelentes produtos, ótima qualidade!'
        ],(object)[
          'image' => 'http://site.didoo.com.br/galleries/1/tema-mix/1662163180_1.jpg',
          'name' => 'Alexandre Rodrigues',
          'city_state' => 'Rio de Janeiro / RJ',
          'stars' => 4,
          'description' => 'Top, super recomendo!'
        ],(object)[
          'image' => 'http://site.didoo.com.br/galleries/1/tema-mix/1662163180_2.jpg',
          'name' => 'Judite Alencar',
          'city_state' => 'Belo Horizonte / MG',
          'stars' => 5,
          'description' => 'Atendimento impecável'
        ],(object)[
          'image' => 'http://site.didoo.com.br/galleries/1/tema-mix/1662163180_3.jpg',
          'name' => 'Luciano Mathias',
          'city_state' => 'Ubatuba / SP',
          'stars' => 4,
          'description' => 'Lanches tops!'
        ]
      ]
    ];
    $footer = (object)[
      'image' => null,
      'overlay' => null,
      'background' => '#dc3545ff',
      'text_color' => '#ffffffff',
      'logo' => 'https://site.didoo.com.br/galleries/1/tema-mix/1662119936_1.png',
      'description_length' => null,
      'address' => "Rua Carlos Gomes, 45 - Centro. CEP: 17.501-000 - Marília/SP",
      'title_length' => null,
      'email' => 'contato@didoo.com.br',
      'email_2' => 'suporte@didoo.com.br',
      'whatsapp' => '(19) 99999-9999',
      'phone_fix' => null,
      'phone_cel' => null,
      'facebook' => null,
      'instagram' => null,
      'youtube' => null,
      'twitter' => null,
      'tiktok' => null,
      'pinterest' => null,
      'linkedin' => null,
      'behance' => null,
      'google_business' => null
    ];

    return $elements + [
      'products' => $products,
      'testimonial' => $testimonial,
      'footer' => $footer
    ];
  }
}