@php
  if (!function_exists('formatWhatsappText')) {  
    function formatWhatsappText($text) {
      $text = preg_replace('/\*(.*?)\*/', '<b>$1</b>', $text);  // Negrito
      $text = preg_replace('/_(.*?)_/', '<i>$1</i>', $text);   // Itálico
      $text = preg_replace('/~(.*?)~/', '<s>$1</s>', $text);   // Tachado
      $text = preg_replace('/```(.*?)```/', '<code>$1</code>', $text); // Monoespaçado
      return $text;
    }
  }
@endphp
@extends('layout.app')
@section('head')
  <link href="{{ asset('css/menu.css') }}" rel="stylesheet"/>
  <link href="{{ asset('css/sections/products.css') }}" rel="stylesheet"/>
  <link href="{{ asset('css/sections/footer.css') }}" rel="stylesheet"/>
  <style>
    .logo{ margin-top: -1rem; }
    #products{
      margin: 3.2rem 1.6rem 1rem;
    }
    #products ul li {
      list-style: none;
    }
    #products .product-body {
      display: grid;
      grid-template-columns: 50% 50%;
    }
    #products .product-body section.section-1{
      padding: 10px 15px;
      display: flex;
      flex-direction: column;
      gap: 1rem;
      align-items: center;
      justify-content: center;
    }
    #products .container-img{
      background-position: center;
      background-size: contain;
      background-repeat: no-repeat;

      width: 100%;
      height: 345px;

      display: flex;
      align-items: center;

      border-radius: 4px;
      transition: .6s;
      position: relative;
    }
    #products .container-img span{
      padding: .6rem;
      height: 100%;
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: .6s;
      position: absolute;
      top: 0;
      bottom: 0;
    }
    #products .container-img span.to-back{ left: 0; }
    #products .container-img span.to-next{ right: 0; }
    #products .container-img span:hover{
      background: #fff3;
    }
    #products .container-img span svg{
      font-size: 1.8em;
      color: #fff;
    }
    #products .container-itens{
      overflow-x: auto;
    }
    #products .container-itens ul {
      display: flex;
      gap: 1rem;
      padding-left: .2rem;
      margin-top: 0;
    }
    #products .container-itens ul li{
      width: 50px;
      min-width: 50px;
      height: 50px;
      background-repeat: no-repeat;
      background-size: cover;
      border-radius: 4px;
      cursor: pointer;
      transition: .6s;
    }
    #products .container-itens ul li.selected{
      opacity: .7;
    }
    #products .product-body section.section-2{
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 0 1.5rem;
      align-items: center;
    }
    #products .product-body section.section-2 h3{
      margin-top: 14px;
      margin-bottom: 0;
    }
    #products .product-body section.section-2 p{ margin-top: 12px; }
    #products .product-body section.section-2 .container-tags{
      margin-top: 20px;
      display: flex;
      justify-content: flex-start;
      align-items: center;
      gap: 5px;
    }
    #products .product-body section.section-2 .container-tags .tags{
      border: 1px solid rgba(0, 0, 20, 0.481);
      border-radius: 4px;
      padding: 2px 3px;
      color: rgba(0, 0, 20, 0.681);
    }
    @media (max-width: 700px){
      #products .product-body {
        grid-template-columns: 1fr;
      } 
    }
    #products .container-price{
      margin: 1.4rem 0;
      font-size: 1.3rem;
    }
    #products .container-price strong{ display: block; }
    #products .container-price strong + strong{
      font-size: 1rem;
      text-decoration: line-through;
      color: #667;
      font-weight: 500;
      margin-top: .1rem;
    }
  </style>
@endsection
@section('content')
  @include('sections.menu',[
    'menu' => $elements['menu'],
    'code' => $elements['code'],
    'menu_options' => (object)[
      'hide' => ['search_box']
    ]
  ])
  @include('utils.navbar',[
    'navbar' => $elements['navbar']
  ])
  <div class="container mx-auto" id="products">
    @if($product)
      <div class="product-body">
        <section class="section-1">
          <div class="container-img" style="
            {{ 
              innerStyleIssetAttr(
                'background-image',
                $product,
                ['image','src'],
                'url(\'' . asset('images/no-image.jpg') . '\')'
              )
            }}
          ">
            <span class="to-back" onclick="handleChangeShowingPhoto(null, false)">
              @include('utils.icons.chevron_left')
            </span>
            <span class="to-next" onclick="handleChangeShowingPhoto()">
              @include('utils.icons.chevron_right')
            </span>
            @php
              $video_position = isset($product->video) ? (
                isset($product->video_position) ? $product->video_position : 'start'
              ) : null;
            @endphp
            @if(isset($product->video) && $video_position === 'start')
              <iframe
                src="{{ $product->video }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen=""
                style="
                  width: 100%;
                  height: 100%;
                  background: #000000;
                  border-radius: .6rem;
                "
              ></iframe>
            @endif
          </div>
          @if(isset($product->video) || isset($product->outher_images))
            <div class="container-itens">
              <ul id="container-multi-photos">
                @if(isset($product->video) && $video_position === 'start')
                  <li 
                    class="has-video selected"
                    style="
                      background-image: none;
                      background: #ccd;
                      display: flex;
                      align-items: center;
                      justify-content: center;
                    "
                    data-image="none"
                    data-index="0"
                    onclick="handleChangeShowingPhoto($(this))"
                  >@include('utils.icons.play')</li>
                @endif
                <li 
                  class="{{ !isset($product->video) || $video_position === 'final' ? 'selected' : '' }}"
                  style="background-image: url('{{ $product->image->src }}')"
                  alt="{{ $product->image->alt ?? '' }}"
                  data-image="{{ $product->image->src }}"
                  data-index="{{ !isset($product->video) ? '0' : '1' }}"
                  onclick="handleChangeShowingPhoto($(this))"
                ></li>
                @foreach($product->outher_images as $i => $image)
                  <li 
                    style="background-image: url('{{ $image->src }}')"
                    alt="{{ $image->alt ?? '' }}"
                    data-image="{{ $image->src }}"
                    data-index="{{ $i + 1 + (!isset($product->video) ? 0 : 1) }}"
                    onclick="handleChangeShowingPhoto($(this))"
                  ></li>
                @endforeach
                @if(isset($product->video) && $video_position === 'final')
                  <li 
                    class="has-video"
                    style="
                      background-image: none;
                      background: #ccd;
                      display: flex;
                      align-items: center;
                      justify-content: center;
                    "
                    data-image="none"
                    data-index="0"
                    onclick="handleChangeShowingPhoto($(this))"
                  >@include('utils.icons.play')</li>
                @endif
              </ul>
            </div>
          @endisset
        </section>
        <section class="section-2">
          <div class="product-info rounded-4 container px-3" style="
            background: #eee;
          ">
            <div class="text-start">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                  <h3 style="
                    text-decoration: none;
                    {{ innerStyleIssetAttr('font-size', $product->title, 'fontsize') }}
                  ">{{ $product->title->text }}</h3>
                  @isset($product->code)
                    <small class="text-danger product-sku" style="
                      @isset($product->styles)
                        {{ innerStyleIssetAttr('color', $product->styles, 'text_highlighted') }}
                      @endisset
                    ">SKU / Código: {{ $product->code }}</small>
                  @endisset
                  <div class="product-item-category text-uppercase opacity-9">
                    <strong>Categoria</strong>: {{ $product->category }}
                  </div>
                </div>
                <button
                  class="btn btn-link mb-0 p-0 text-dark ms-2"
                  type="button"
                  onclick='handleShareProduct({!! json_encode($product) !!},{!! $internal ? 'true':'false' !!})'
                >
                  @include('utils.icons.share')
                </button>
              </div>
              @isset($product->description)
                <p style="font-size: .9rem;">{!! nl2br(formatWhatsappText(e($product->description))) !!}</p>
              @endisset
              @if(isset($product->tags) && count($product->tags) > 0)
                <div class="container-tags">
                  @foreach($product->tags as $obj)
                    @if($obj->item) <div class="tags"> {{ $obj->item }} </div> @endif
                  @endforeach
                </div>
              @endif
              @isset($product->price)
                <div class="product-item-price-data pt-2 mb-3">
                  @if(isset($product->price->current) && !!$product->price->current)
                    <p class="product-item-price display-6 mb-0" style="
                      {{ innerStyleIssetAttr('font-size', $product->price, 'current_fontsize') }}
                    ">R$ {{ number_format($product->price->current,2,',','.') }}</p>
                  @endif
                  @if(isset($product->price->old) && !!$product->price->old)
                    <p class="mb-0 product-item-price-from">
                      <span class="old-price text-decoration-line-through text-muted" style="
                        @isset($product->styles)
                          {{ innerStyleIssetAttr('color', $product->styles, 'text_lowlighted') }}
                        @endisset
                        {{ innerStyleIssetAttr('font-size', $product->price, 'old_fontsize') }}
                      ">R$ {{ number_format($product->price->old,2,',','.') }}</span>
                    </p>
                  @endif
                </div>
              @endisset
            </div>
            @if(
              isset($elements['code']) &&
              isset($elements['code']->whatsapp) &&
              isset($product->select_buttons) && 
              in_array('Pedir pelo whatsapp', $product->select_buttons)
            )
              <button
                type="button"
                class="botao btn mb-2 w-100"
                onclick='handleSendProductToWhatsapp({!!
                  json_encode($product)
                !!},{!! $internal ? 'true':'false' !!})'
                style="
                  background: #34af23;
                  color: white;
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  font-weight: 500;
                "
              >
                {{ $elements['products']->button_wpp_text ?? 'Pedir pelo' }} @include('utils.icons.whatsapp',['icons' => (object)[
                  'color' => 'currentColor',
                  'style' =>'margin-left: .3rem;'
                ]])
              </button>
            @endif
            @if(
              isset($product->select_buttons) && 
              in_array('Comprar agora', $product->select_buttons) &&
              isset($product->link_button_buy_now) &&
              !!$product->link_button_buy_now
            )
              <a
                href="{{ $product->link_button_buy_now }}"
                target="_blank"
                class="botao btn mb-2 w-100"
                style="
                  {{ innerStyleIssetAttr('background', $elements['products']->button_buy_now, 'background') }}
                  {{ innerStyleIssetAttr('color', $elements['products']->button_buy_now, 'color') }}
                  font-weight: 500;
                "
              >{{ $elements['products']->text ?? 'Comprar agora' }}</a>
            @endif
            <a
              href="{{ route('home') }}"
              class="botao btn btn-dark mb-3 w-100"
              style="
                {{ innerStyleIssetAttr('background', $product->button, 'background') }}
                {{ innerStyleIssetAttr('color', $product->button, 'color') }}
                font-weight: 500;
              "
            >Voltar para o site</a>
          </div>
        </section>
      </div>
    @else
      <div style="
        margin: auto;
        width: 100%;
        height: 20rem;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        border-radius: 1rem;
      ">
        <h2 class="titulo">Produto/Serviço<br/>não encontrado</h2>
        <div class="overlay" style="
          background: #0022;
          border-radius: 1rem;
        "></div>
      </div>
    @endif
    @if(count($elements['products']->items) > 1)
      <section id="product">
        <div class="content">
          <hr/>
          <h2 class="titulo text-center mt-5">Outros</h2>
          <div class="container-products row pt-3 mb-5 mx-0" id="produtos">
            @foreach($elements['products']->items as $prod_item)
              @php
                if($prod_item->slug === $slug) continue;
                $product_url = $internal ? route('internal_product.show', ['slug' => $prod_item->slug]) : route('product.show', ['slug' => $prod_item->slug]);
              @endphp
              <div
                class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-3 product-item {{
                  isset($elements['products']->columns) && $elements['products']->columns != 1 ? (
                    $elements['products']->columns == 2 ? 'col-6':(
                      $elements['products']->columns == 3 ? 'col-4':''
                    )
                  ):''
                }}"
                data-category="{{ $prod_item->category }}"
              >
                <div class="product-item-container border h-100 p-3 rounded d-flex flex-column" style="
                  @isset($prod_item->styles)
                    {{ innerStyleIssetAttr('background', $prod_item->styles, 'background', '#ffffffff') }}
                    {{ innerStyleIssetAttr('border-color', $prod_item->styles, 'border_color', '#ffffffff', null, true) }}
                    {{ innerStyleIssetAttr('color', $prod_item->styles, 'text_color') }}
                  @endisset
                ">
                  <div class="product-item-data position-relative">
                    <a
                      class="product-item-image-link"
                      href="{{ $product_url }}"
                      target="_blank"
                    >
                      <div class="product-item-image">
                        <img
                          src="{{ $prod_item->image->src }}"
                          class="rounded w-100"
                          alt="{{ $prod_item->image->alt ?? $prod_item->title->text ?? 'Imagem do produto' }}"
                        />
                      </div>
                    </a>
                  </div>
                  <div class="product-container pt-3">
                    <div class="product-item-name text-center mb-1">
                      <a href="{{ $product_url }}" style="color: inherit;">
                        <strong class="text-uppercase h5" style="
                          {{ innerStyleIssetAttr('font-size', $prod_item->title, 'fontsize') }}
                        ">{{ $prod_item->title->text }}</strong>
                      </a><br/>
                      @isset($prod_item->code)
                        <small class="text-danger product-sku" style="
                          @isset($prod_item->styles)
                            {{ innerStyleIssetAttr('color', $prod_item->styles, 'text_highlighted') }}
                          @endisset
                        ">SKU / Código: {{ $prod_item->code }}</small>
                      @endisset
                    </div>
                    <div class="product-item-category text-center mb-2 text-uppercase opacity-9">
                      <strong>Categoria</strong>: {{ $prod_item->category }}
                    </div>
                    @isset($prod_item->price)
                      <div class="text-center product-item-price-data pt-2 mb-3">
                        @if(isset($prod_item->price->current) && !!$prod_item->price->current)
                          <p class="product-item-price h3 mb-0" style="
                            {{ innerStyleIssetAttr('font-size', $prod_item->price, 'current_fontsize') }}
                          ">R$ {{ $prod_item->price->current }}</p>
                        @endif
                        @if(isset($prod_item->price->old) && !!$prod_item->price->old)
                          <p class="mb-0 product-item-price-from">
                            <span class="old-price text-decoration-line-through text-muted" style="
                              @isset($prod_item->styles)
                                {{ innerStyleIssetAttr('color', $prod_item->styles, 'text_lowlighted') }}
                              @endisset
                              {{ innerStyleIssetAttr('font-size', $prod_item->price, 'old_fontsize') }}
                            ">R$ {{ $prod_item->price->old }}</span>
                          </p>
                        @endif
                      </div>
                    @endisset
                    @isset($prod_item->validate)
                      <div
                        class="contador-regressivo rounded"
                        data-timer-id="1"
                        data-table="products"
                        data-date="{{ $prod_item->validate }}"
                      >
                        <p class="text-uppercase"> Promoção expira em: </p>
                        <div class="timer-products-1">131 dias 40m 7s</div>
                      </div>
                    @endisset
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </section>
    @endif
  </div>
  @include('sections.footer',[
    'menu' => $elements['menu'],
    'footer' => $elements['footer'],
    'code' => $elements['code'],
  ])
@endsection
@section('scripts')
  <script>
    const setMainPhotoMultiPhotos = (src, video = null, remove_iframe = false) => {
      if(remove_iframe) $('.container .container-img iframe').remove();
      if(video){
        $('.container .container-img').css('background-image','none');
        if(remove_iframe || $('.container .container-img iframe').length === 0) $('.container .container-img').append(`
          <iframe
            src="${ video }"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen=""
            style="
              width: 100%;
              height: 100%;
              background: #000000;
              border-radius: .6rem;
            "
          ></iframe>
        `);
        else $('.container .container-img iframe').show();
      }
      else{
        $('.container .container-img').css(
          'background-image',
          `url('${src}')`
        );
        if(!remove_iframe) $('.container .container-img iframe').hide();
      }
    }
    function handleChangeShowingPhoto(elem = null, to_next = true){
      let image = null;
      if(elem){
        image = elem.attr('data-image');
        has_video = elem.hasClass('has-video') ? '{{ isset($product->video) ? $product->video : '' }}' : null;
        if(!image) return;

        $('#container-multi-photos li').removeClass('selected');
        elem.addClass('selected');

        setMainPhotoMultiPhotos(image, has_video);
      }else{
        let limit = $('#container-multi-photos li').length;
        let current = $('#container-multi-photos li.selected');
        let target_index = 0;

        if(!current[0]) current = $('#container-multi-photos li:first-child()');
        if(!current[0]) return;
        target_index = Number(current.attr('data-index') ?? 0);
        if(to_next){
          target_index++;
          if(target_index >= limit) target_index = 0;
        }else{
          target_index--;
          if(target_index < 0) target_index = limit - 1;
        }
        $(`#container-multi-photos [data-index=${target_index}]`).click();
      }
    }
    function handleSendProductToWhatsapp(product,internal){
      let title = product.title && product.title.text ? product.title.text : '_Produto Sem Título_';
      let message = `*${title + (product.code ? ` - ${product.code}` : '')}*\n`;
      if(product.category) message+= `(${product.category})\n`;
      if(product.price && product.price.current) message+= `R$ ${product.price.current}\n`;
      message+= `\n{{ $internal ? route('internal_product.show', ['slug' => '']) : route('product.show', ['slug' => '']) }}${product.slug}`;

      let whatsapp = `{{
        isset($elements['code']) && isset($elements['code']->whatsapp) ? 
          numberWhatsappFormat($elements['code']->whatsapp) :  null
      }}`;
      let url = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}${
        whatsapp ? `&phone=${whatsapp}`:''
      }`;
      window.open(url, '_blank');
    }
    function handleToggleHomeAndWhoWeAre(){
      window.location.href = "{{ route('home') }}";
    }
    function handleShareProduct(product,internal){
      let title = product.title && product.title.text ? product.title.text : '_Produto Sem Título_';
      let url = `{{ $internal ? route('internal_product.show', ['slug' => '']) : route('product.show', ['slug' => '']) }}${product.slug}`;

      let text = `*${title + (product.code ? ` - ${product.code}` : '')}* \n`;
      if(product.category) text+= `(${product.category}) \n`;
      if(product.price && product.price.current) text+= `R$ ${product.price.current} \n`;

      navigator.share({
        title, text, url
      });
    }
  </script>
@endsection