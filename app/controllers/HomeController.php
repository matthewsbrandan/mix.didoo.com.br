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
    [$data, $err] = $this->cms->get("page/data-select/".$this->theme_slug."&privacity_policy,navbar,menu,code");

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
    [$data, $err] = $this->cms->get("page/data-select/".$this->theme_slug."&code,products,navbar,menu,footer");
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
      $products = $parsedElements['products']->items;
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
        $page_config->title = ($product->title->text ?? 'Produto') . ' | '. $page_config->title;
        $page_config->metadescription = $product->description ?? null;
      }

      return view('product.show',[
        'page_config' => $page_config,
        'elements' => $parsedElements,
        'product' => $product,
        'slug' => $slug,
        'internal' => false
      ]);
    }catch(Exception $e){
      return view('error-500',[
        'message' => 'Houve um erro ao carregar o produto/serviço'
      ]);
    }
  }
  public function internalProduct($slug = null){
    if(!$slug) return view('error-404');
    [$data, $err] = $this->cms->get("page/data-select/".$this->theme_slug."&code,internal_products,navbar,menu,footer");
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
      $parsedElements['products'] = $parsedElements['internal_products'];
      $products = $parsedElements['internal_products']->items;
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
        $page_config->title = ($product->title->text ?? 'Produto') . ' | '. $page_config->title;
        $page_config->metadescription = $product->description ?? null;
      }

      return view('product.show',[
        'page_config' => $page_config,
        'elements' => $parsedElements,
        'product' => $product,
        'slug' => $slug,
        'internal' => true
      ]);
    }catch(Exception $e){
      return view('error-500',[
        'message' => 'Houve um erro ao carregar o produto/serviço'
      ]);
    }
  }
  protected function sectionExceptions($elements){
    if(isset($elements['products'])){
      recursiveArrayJsonParsed($elements['products']);
      $this->handleProductCategories($elements['products']);
    }
    if(isset($elements['service']) && is_array($elements['service']->services)){
      foreach($elements['service']->services as &$service){
        if(is_string($service->button) && 
          $jsonParsed = json_decode($service->button)
        ) $service->button = $jsonParsed;
      }
    }
    if(isset($elements['google_reviews']) && is_array($elements['google_reviews']->reviews)){
      foreach($elements['google_reviews']->reviews as &$reviews){
        if(isset($reviews->author) && 
          is_string($reviews->author) && 
          $jsonParsed = json_decode($reviews->author)
        ) $reviews->author = $jsonParsed;

        if(isset($reviews->date) && 
          is_string($reviews->date) && 
          $jsonParsed = json_decode($reviews->date)
        ) $reviews->date = $jsonParsed;
        
        if(isset($reviews->description) && 
          is_string($reviews->description) && 
          $jsonParsed = json_decode($reviews->description)
        ) $reviews->description = $jsonParsed;
      }
    }
    if(isset($elements['banner']) && isset($elements['banner']->model)){
      recursiveArrayJsonParsed($elements['banner']->model);
    }
    if(isset($elements['internal_products']) && $elements['internal_products']->slug){
      [$data, $err] = $this->cms->get("product/get-all/".$elements['internal_products']->slug);

      if($data && $data->result && $data->data){
        $elements['internal_products']->items = [];
        $categories = [];
        foreach($data->data as $item){
          $category_name = $item->category ? $item->category->name : null;
          $item->category = $category_name;
          if($category_name && !in_array($category_name, $categories)){
            $categories[] = $category_name;
          }
          $elements['internal_products']->items[] = $item;

          if($item->image) $item->image = (object)[
            'src' => $item->image,
            'alt' => $item->image_description
          ];
          
          $item->title = (object)[
            'text' => $item->name,
            'fontsize' => $elements['internal_products']->title_fontsize,
          ];
          

          $item->price = (object)[
            'current' => $item->discount_price ? $this->parseStrMoneyToDecimal($item->discount_price) : $this->parseStrMoneyToDecimal($item->price),
            'old' => $item->discount_price ? $this->parseStrMoneyToDecimal($item->price) : null,
            'current_fontsize' => $elements['internal_products']->price_current_fontsize,
            'old_fontsize' => $elements['internal_products']->price_old_fontsize,
          ];
          $item->tags = [];
          if($item->additional_info){
            foreach(explode(',', $item->additional_info) as $info){
              $item->tags[] = (object)['item' => trim($info)];
            }
          }

          $item->outher_images = [];
          $item->styles = $elements['internal_products']->styles;

          if($item->images){
            foreach($item->images as $image){
              $item->outher_images[] = (object)[
                'src' => $image->src,
                'alt' => $image->description
              ];
            }
          }          

          $item->link_button_buy_now = $item->payment_link;

          $item->button = $elements['internal_products']->button;
          $item->select_buttons = [];
          if($item->active_actions){
            foreach($item->active_actions as $action){
              if($action === 'Whatsapp') $item->select_buttons[] = "Pedir pelo whatsapp";
              else if($action === 'Comprar Agora') $item->select_buttons[] = "Comprar agora";
            }
          }
        }
        $elements['internal_products']->categories = $categories;
      }
    }

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
    foreach($products->items as &$item){
      #region HANDLE TEXT SLASHES
      if(isset($item->category)) $item->category = str_replace("'","", $item->category);
      if(isset($item->title) &&
        isset($item->title->text)
      ) $item->title->text = str_replace("'","", $item->title->text);
      if(isset($item->description)) $item->description = str_replace("'","", $item->description);
      #endregion HANDLE TEXT SLASHES

      if(!in_array($item->category, $categories)) $categories[] = $item->category;
      if(isset($item->outher_images)){
        $item->outher_images = array_filter($item->outher_images, function($outher){
          if($outher && isset($outher->src) && $outher->src) return true;
          return false;
        });
      }
    }
    $products->categories = $categories;
  }
  protected function fakeElements($elements){
    return $elements + [];
  }
  protected function parseStrMoneyToDecimal($value){
    return str_replace(['.', ','], ['', '.'], $value);
  }
}