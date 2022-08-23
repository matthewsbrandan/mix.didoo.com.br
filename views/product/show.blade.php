@extends('layout.app')
@section('head')
  <link href="{{ asset('css/header.css') }}" rel="stylesheet"/>
  <link href="{{ asset('css/sections/multi_photos.css') }}" rel="stylesheet"/>
  <style>
    .container{
      margin: 6.2rem 1.6rem;
    }
    .container ul li {
      list-style: none;
    }
    .container .product-body {
      display: grid;
      grid-template-columns: 50% 50%;
    }
    .container .product-body section.section-1{
      padding: 10px 15px;
      display: flex;
      flex-direction: column;
      gap: 1rem;    
    }
    .container .container-img{
      width: 100%;
      height: 345px;
      display: flex;
      align-items: center;
      border-radius: 4px;
      background-size: cover;
      transition: .6s;
      position: relative;
    }
    .container .container-img span{
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
    .container .container-img span.to-back{ left: 0; }
    .container .container-img span.to-next{ right: 0; }
    .container .container-img span:hover{
      background: #fff3;
    }
    .container .container-img span svg{
      font-size: 1.8em;
      color: #fff;
    }
    .container .container-itens{
      overflow-x: auto;
    }
    .container .container-itens ul {
      display: flex;
      gap: 1rem;
      padding-left: .2rem;
      margin-top: 0;
    }
    .container .container-itens ul li{
      width: 50px;
      min-width: 50px;
      height: 50px;
      background-repeat: no-repeat;
      background-size: cover;
      border-radius: 4px;
      cursor: pointer;
      transition: .6s;
    }
    .container .container-itens ul li.selected{
      opacity: .7;
    }
    .container .product-body section.section-2{
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 0 1.5rem;
    }
    .container .product-body section.section-2 h3{
      margin-top: 14px;
      margin-bottom: 0;
    }
    .container .product-body section.section-2 p{ margin-top: 12px; }
    .container .product-body section.section-2 .container-tags{
      margin-top: 20px;
      display: flex;
      justify-content: flex-start;
      align-items: center;
      gap: 5px;
    }
    .container .product-body section.section-2 .container-tags .tags{
      border: 1px solid rgba(0, 0, 0, 0.281);
      border-radius: 4px;
      padding: 2px 3px;
      color: rgba(0, 0, 0, 0.281);
    }
    .container .product-body section.section-2 .ctn-buttons{
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      margin-bottom: 1rem;
      padding: 0px 20px;
      font-size: .9rem;
    }
    @media (max-width: 700px){
      .container .product-body {
        grid-template-columns: 1fr;
      } 
    }
    .container .container-price{
      margin: 1.4rem 0;
      font-size: 1.3rem;
    }
    .container .container-price strong{ display: block; }
    .container .container-price strong + strong{
      font-size: 1rem;
      text-decoration: line-through;
      color: #667;
      font-weight: 500;
      margin-top: .1rem;
    }
  </style>
@endsection
@section('content')
  @include('layout.header',[
    'header' => isset($elements['navbar']) ? $elements['navbar'] : (object) [
      'logo' => $page_config->icon
    ],
    'header_config' => (object)[
      'back_to_home' => true,
      'class_name' => 'showing'
    ]
  ])
  <div class="container">
    @if($product)
      <div class="product-body">
        <section class="section-1">
          <div class="container-img" style="background-image: url('{{ $product->images[0]->src }}');">
            <span class="to-back" onclick="handleChangeShowingPhoto(null, false)">
              @include('utils.icons.chevron_left')
            </span>
            <span class="to-next" onclick="handleChangeShowingPhoto()">
              @include('utils.icons.chevron_right')
            </span>
            @isset($product->video)
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
            @endisset
          </div>
          <div class="container-itens">
            <ul id="container-multi-photos">
              @isset($product->video)
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
              @endisset
              <?php
                foreach($product->images as $i => $image){
                  $index = $i;
                  if(isset($product->video)) $index++;
              ?>
                <li 
                  class="{{ $index === 0 ? 'selected' : '' }}"
                  style="background-image: url('{{ $image->src }}')"
                  data-image="{{ $image->src }}"
                  data-index="{{ $index }}"
                  onclick="handleChangeShowingPhoto($(this))"
                ></li>
              <?php } ?>
            </ul>
          </div>
        </section>
        <section class="section-2">
          <div>
            <h3><a href="javascript:;" target="_blank">{{ $product->title }}</a></h3>
            <p>{{ $product->description }}</p>
            @isset($product->items)      
              <div class="container-tags">
                @foreach($product->items as $item)
                  @if($item->item)
                    <div class="tags">{{ $item->item }}</div>
                  @endif
                @endforeach
              </div>
            @endisset
            <div class="container-price">
              @if($product->discount_price) <strong>{{ formatMoney($product->discount_price) }}</strong> @endif
              @if($product->price) <strong>{{ formatMoney($product->price) }}</strong> @endif
            </div>
          </div>
          <div class="ctn-buttons">
            <a 
              href="{{ $product->button->link ?? 'javascript:;'}}"
              class="botao btn btn-primary btn-uppercase"
              target="_blank" 
              style="
                {{ $product->button->background ? 'background: '.$product->button->background.';' : '' }}
                {{ $product->button->color ? 'color: '.$product->button->color.';' : '' }}
              "
            >{{ $product->button->text ?? 'Quero saber mais' }}</a>
            <a
              href="{{ route('home') }}"
              class="botao btn btn-gray btn-uppercase"
              style="
                {{ $product->button_back->background ? 'background: '.$product->button_back->background.';' : '' }}
                {{ $product->button_back->color ? 'color: '.$product->button_back->color.';' : '' }}
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
    @if(count($elements['multi_photos']->services) > 1)
      <section id="multi_photo">
        <div class="content">
          <h2 class="titulo">Outros</h2>
          <div class="container-multi_photos">
            <?php
              $multi_photos = $elements['multi_photos'];
              foreach($multi_photos->services as $item){
                if($item->slug === $slug) continue;
            ?>
              <div class="multi_photo">
                @if(isset($item->video) && $item->video)
                  <div class="container-video">
                    <iframe
                      src="{{ $item->video }}"
                      frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen=""
                    ></iframe>
                  </div>
                @else
                  <img src="{{ $item->images[0]->src ?? asset('no-image.jpg') }}" alt="{{ $item->title }}"/>
                @endif
                <a
                  href="{{ isset($item->slug) && $item->slug ? route('product.show',['slug' => $item->slug]) : 'javascript:;' }}"
                  @if(isset($item->slug) && $item->slug) target="_blank" @endif
                >
                  <strong style="
                    {{ innerStyle('font-size', $multi_photos->item_title_length, null, $multi_photos->item_title_length . 'px') }}
                  ">{{ $item->title }}</strong>
                </a>
                <p class="texto" style="
                  {{ innerStyle('font-size', $multi_photos->item_description_length, null, $multi_photos->item_description_length . 'px') }}
                ">{{ $item->description }}</p>
                <a
                  href="{{ isset($item->slug) && $item->slug ? route('product.show',['slug' => $item->slug]) : 'javascript:;' }}"
                  class="botao btn btn-gray btn-uppercase"
                  style="
                    {{ $product && $product->button->background ? 'background: '.$product->button->background.';' : '' }}
                    {{ $product && $product->button->color ? 'color: '.$product->button->color.';' : '' }}
                  "
                >{{ $multi_photos->button_see_more->text ?? 'Ver Mais' }}</a>
              </div>
            <?php } ?>
          </div>
        </div>
      </section>
    @endif
  </div>
@endsection
@section('scripts')
  <script>
    const setMainPhotoMultiPhotos = (src, video = null, remove_iframe = false) => {
      if(remove_iframe) $('.container .container-img iframe').remove();
      if(video){
        $('.container .container-img').css('background-image','none');
        if(remove_iframe) $('.container .container-img').append(`
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
        has_video = elem.hasClass('has-video');
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
  </script>
@endsection