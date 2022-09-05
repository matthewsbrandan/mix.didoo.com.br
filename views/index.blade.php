@extends('layout.app')
@section('head')
  <link href="{{ asset('css/cookies.css') }}" rel="stylesheet"/>
  <link href="{{ asset('css/menu.css') }}" rel="stylesheet"/>
  @isset($elements['products'])
    <link href="{{ asset('css/sections/products.css') }}" rel="stylesheet"/>
  @endisset
  @isset($elements['testimonial'])
    <link rel="stylesheet" type="text/css" href="{{ asset('js/slick-1.8.1/slick/slick.css') }}"/>
    <link href="{{ asset('css/sections/testimonial.css') }}" rel="stylesheet"/>
  @endisset
  <link href="{{ asset('css/sections/footer.css') }}" rel="stylesheet"/>
  <style> #flex-order{ display: flex; flex-direction: column; } </style>
  @isset($elements['section_dynamic'])
    <style>
      <?php foreach($elements['section_dynamic']->section_dynamic as $section){ echo $section->css; } ?>
    </style>
  @endisset
  @if(isset($elements['code']) && $elements['code']->head) {!! $elements['code']->head !!} @endif
@endsection

@section('content')
  @if(isset($elements['code']) && $elements['code']->init_body) {!! $elements['code']->init_body !!} @endif
  @include('sections.menu',[
    'menu' => $elements['menu']
  ])
  @include('utils.navbar',[
    'navbar' => $elements['navbar']
  ])
  @isset($elements['carousel'])
    @include('sections.carousel',[
      'carousel' => $elements['carousel']
    ])
  @endisset
  <section id="flex-order">
    <?php $order = 0; ?>
    @isset($elements['products'])
      @include('sections.products',[
        'products' => $elements['products'],
        'default_order' => handleIncrementOrder($order, $existingOrders)
      ])
    @endisset

    @isset($elements['testimonial'])
      @include('sections.testimonial',[
        'testimonial' => $elements['testimonial'],
        'default_order' => handleIncrementOrder($order, $existingOrders)
      ])
    @endisset


    @isset($elements['multi_photos'])
      @include('sections.multi_photos',[
        'multi_photos' => $elements['multi_photos'],
        'default_order' => handleIncrementOrder($order, $existingOrders)
      ])
    @endisset

    @isset($elements['section_dynamic'])
      @foreach($elements['section_dynamic']->section_dynamic as $i => $section)
        <section id="section_dynamic_{{$i}}"
          style="{{ innerStyleIssetAttr('order', $section, 'order', $order) }}"
        >{!! $section->html !!}</section>
      @endforeach
    @endisset
  </section>
  @include('sections.footer',[
    'footer' => $elements['footer']
  ])
@endsection

@section('scripts')
  @isset($elements['carousel'])
    <script>
      const carousel = new bootstrap.Carousel('#carousel')
    </script>
  @endisset
  @isset($elements['testimonial'])
    <script type="text/javascript" src="{{ asset('js/slick-1.8.1/slick/slick.min.js') }}"></script>
    <script>
      $(document).ready(function(){
        if($('.slick-depoiments').length > 0) {
          $('.slick-depoiments').slick({
            dots: true,
            autoplay: false,
            lazyLoad: "ondemand",
            infinite: true,
            slidesToShow: ($(window).width() > 768) ? 3 : 1,
            slidesToScroll: ($(window).width() > 768) ? 3 : 1,
            responsive: [
              {
                breakpoint: 1024,
                settings: {
                  slidesToShow: 3,
                  slidesToScroll: 3,
                }
              },
              {
                breakpoint: 600,
                settings: {
                  slidesToShow: 2,
                  slidesToScroll: 2
                }
              },
              {
                breakpoint: 480,
                settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
                }
              }
            ]
          });
        }
      });
    </script>
  @endisset
  @isset($elements['multi_photos'])
    @include('utils.modalMultiPhotos')
    @include('utils.modalSearchBox')
  @endisset
  @isset($elements['popup'])
    @include('sections.popup',[
      'popup' => $elements['popup']
    ])
  @endisset
  @include('layout.cookies')
  @if(isset($elements['jivochat']) && $elements['jivochat']->widget)
    <script src="//code-sa1.jivosite.com/widget/{{ $elements['jivochat']->widget }}" async></script>
  @endif
  <script>
    const icons = {
      minus: `@include('utils.icons.minus')`,
      plus: `@include('utils.icons.plus')`
    }
    function toggleIconPlusMinus(target){
      if(target.hasClass('icon-minus')) target.html(icons.plus);
      else target.html(icons.minus);
      target.toggleClass('icon-minus icon-plus');
    }
    function handleScrollNextOrPrevItem(next, id, widthContent){
      let container = getById(id);
      let maxWidth = container.scrollWidth;

      let newPositionScroll = 0;
      if(next){
        newPositionScroll = container.scrollLeft + widthContent;
      
        if(newPositionScroll > maxWidth) container.scrollLeft = maxWidth;
        else container.scrollLeft = newPositionScroll;
      }else{
        newPositionScroll = container.scrollLeft - widthContent;
      
        if(newPositionScroll < 0) container.scrollLeft = 0;
        else container.scrollLeft = newPositionScroll;
      }
    }
    function formatMoney(price){
      let price_formatted = String(price).replace(',','');
      price_formatted = price_formatted.replace('.',',');
      let arr_price = price_formatted.split(',');
      if(arr_price.length < 2) arr_price.push('00');
      arr_price[1] = arr_price[1].padEnd(2,'0');

      return `R$ ${ arr_price.join(',') }`;
    }
  </script>  
  @if(isset($elements['code']) && $elements['code']->final_body) {!! $elements['code']->final_body !!} @endif
@endsection