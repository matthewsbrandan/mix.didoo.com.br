@extends('layout.app')
@section('head')
  <link href="{{ asset('css/cookies.css') }}" rel="stylesheet"/>
  <link href="{{ asset('css/menu.css') }}" rel="stylesheet"/>
  <link href="{{ asset('css/popup.css') }}" rel="stylesheet"/>
  @isset($elements['products'])
    <link href="{{ asset('css/sections/products.css') }}" rel="stylesheet"/>
  @endisset
  @if(
    isset($elements['cms_blog']) && 
    isset($elements['cms_blog']->take)
  )
    <link href="{{ asset('css/sections/cms_blog.css') }}" rel="stylesheet"/>
  @endif
  @isset($elements['download_catalog'])
    <link href="{{ asset('css/sections/download_catalog.css') }}" rel="stylesheet"/>
  @endisset
  @if(isset($elements['testimonial']) || (
    isset($elements['banner']) && $elements['banner']->model->model_type == 'carousel'
  ))
    <link rel="stylesheet" type="text/css" href="{{ asset('js/slick-1.8.1/slick/slick.css') }}"/>
  @endif
  @isset($elements['testimonial'])
    <link href="{{ asset('css/sections/testimonial.css') }}" rel="stylesheet"/>
  @endisset
  <link href="{{ asset('css/sections/contact.css') }}" rel="stylesheet"/>
  <link href="{{ asset('css/sections/footer.css') }}" rel="stylesheet"/>
  <style> #flex-order{ display: flex; flex-direction: column; } </style>
  @isset($elements['section_dynamic'])
    <style>
      <?php foreach($elements['section_dynamic']->section_dynamic as $section){ echo $section->css; } ?>
    </style>
  @endisset
  
  {{-- #region SLIDER-MULTIFOTOS ITEMS --}}
  @isset($elements['banner'])
    <link href="{{ asset('css/sections/slider_multifotos/banner/'.$elements['banner']->model->model_type.'.css') }}" rel="stylesheet"/>
  @endisset
  @isset($elements['new_section'])
    <link href="{{ asset('css/sections/slider_multifotos/new_section.css') }}" rel="stylesheet"/>
  @endisset
  @isset($elements['section_list'])
    <link href="{{ asset('css/sections/slider_multifotos/section_list.css') }}" rel="stylesheet"/>
  @endisset
  @isset($elements['service'])
    <link href="{{ asset('css/sections/slider_multifotos/service.css') }}" rel="stylesheet"/>
  @endisset
  @isset($elements['text_divider'])
    <link href="{{ asset('css/sections/slider_multifotos/text_divider.css') }}" rel="stylesheet"/>
  @endisset
  @if(
    isset($elements['cms_catalog']) && 
    isset($elements['cms_catalog']->api_url) &&
    isset($elements['cms_catalog']->origin)
  )
    <link href="{{ asset('css/sections/slider_multifotos/cms_catalog.css') }}" rel="stylesheet"/>
  @endif
  @isset($elements['cms_gallery'])
    <link href="{{ asset('css/sections/slider_multifotos/cms_gallery.css') }}" rel="stylesheet"/>
  @endisset
  @isset($elements['video'])
    <link href="{{ asset('css/sections/slider_multifotos/video.css') }}" rel="stylesheet"/>
  @endisset
  @isset($elements['schedule'])
    <link href="{{ asset('css/sections/slider_multifotos/schedule.css') }}" rel="stylesheet"/>
  @endisset
  @isset($elements['faq'])
    <link href="{{ asset('css/sections/slider_multifotos/faq.css') }}" rel="stylesheet"/>
  @endisset
  @isset($elements['video_depoiments'])
    <link href="{{ asset('css/sections/slider_multifotos/video_depoiments.css') }}" rel="stylesheet"/>
  @endisset
  @isset($elements['google_reviews'])
    <link href="{{ asset('css/sections/slider_multifotos/google_reviews.css') }}" rel="stylesheet"/>
  @endisset
  {{-- #endregion SLIDER-MULTIFOTOS ITEMS --}}

  <script src="https://kit.fontawesome.com/e2f5b82175.js" crossorigin="anonymous"></script>
  @if(isset($elements['code']) && $elements['code']->head) {!! $elements['code']->head !!} @endif
@endsection

@section('content')
  @if(isset($elements['code']) && $elements['code']->init_body) {!! $elements['code']->init_body !!} @endif
  @include('sections.menu',[
    'code' => $elements['code'],
    'menu' => $elements['menu']
  ])
  @include('utils.navbar',[
    'navbar' => $elements['navbar']
  ])
  <div id="home-page" style="
    @if(isset($_GET['quem-somos']) || isset($_GET['contato']))
      display: none;
    @endif
  ">
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
          'default_order' => handleIncrementOrder($order, $existingOrders),
          'internal' => false
        ])
      @endisset

      @isset($elements['internal_products'])
        @if(
          isset($elements['internal_products']->horizontal_list_by_category) &&
          $elements['internal_products']->horizontal_list_by_category === 'Sim'
        ) @include('sections.products_alt',[
          'products' => $elements['internal_products'],
          'default_order' => handleIncrementOrder($order, $existingOrders),
          'internal' => true
        ])
        @else @include('sections.products',[
          'products' => $elements['internal_products'],
          'default_order' => handleIncrementOrder($order, $existingOrders),
          'internal' => true
        ])
        @endif

      @endisset
  
      @if(
        isset($elements['cms_blog']) && 
        isset($elements['cms_blog']->take)
      )
        @include('sections.cms_blog',[
          'cms_blog' => $elements['cms_blog'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endif
  
      @isset($elements['download_catalog'])
        @include('sections.download_catalog',[
          'download_catalog' => $elements['download_catalog'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endisset
  
      @isset($elements['testimonial'])
        @include('sections.testimonial',[
          'testimonial' => $elements['testimonial'],
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

      {{-- #region SLIDER-MULTIFOTOS ITEMS --}}
      @isset($elements['banner'])
        @include('slider_multifotos.banner.index',[
          'banner_variations' => $elements['banner'],
          'variation' => $elements['banner']->model->model_type
        ])
      @endisset
      @isset($elements['new_section'])
        @include('slider_multifotos.new_section',[
          'new_section' => $elements['new_section'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endisset
      @isset($elements['section_list'])
        @include('slider_multifotos.section_list',[
          'section_list' => $elements['section_list'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endisset
      @isset($elements['service'])
        @include('slider_multifotos.service',[
          'service' => $elements['service'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endisset
      @isset($elements['text_divider'])
        @include('slider_multifotos.text_divider',[
          'text_divider' => $elements['text_divider'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endisset
      @if(
        isset($elements['cms_catalog']) && 
        isset($elements['cms_catalog']->api_url) &&
        isset($elements['cms_catalog']->origin)
      )
        @include('slider_multifotos.cms_catalog',[
          'cms_catalog' => $elements['cms_catalog'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endif

      @isset($elements['video_depoiments'])
        @include('slider_multifotos.video_depoiments',[
          'video_depoiments' => $elements['video_depoiments'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endisset

      @isset($elements['cms_gallery'])
        @include('slider_multifotos.cms_gallery.index',[
          'cms_gallery' => $elements['cms_gallery'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endisset

      @isset($elements['video'])
        @include('slider_multifotos.video',[
          'video' => $elements['video'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endisset

      @isset($elements['schedule'])
        @include('slider_multifotos.schedule',[
          'schedule' => $elements['schedule'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endisset

      @isset($elements['google_reviews'])
        @include('slider_multifotos.google_reviews.index',[
          'google_reviews' => $elements['google_reviews'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endisset
      
      @isset($elements['faq'])
        @include('slider_multifotos.faq',[
          'faq' => $elements['faq'],
          'default_order' => handleIncrementOrder($order, $existingOrders)
        ])
      @endisset
      {{-- #endregion SLIDER-MULTIFOTOS ITEMS --}}
    </section>
  </div>
  @isset($elements['who_we_are'])
    @include('sections.who_we_are',[
      'who_we_are' => $elements['who_we_are']
    ])
  @endisset
  @isset($elements['contact'])
    @include('sections.contact',[      
      'code' => $elements['code'],
      'contact' => $elements['contact']
    ])
  @endisset
  @include('sections.footer',[
    'menu' => $elements['menu'],
    'code' => $elements['code'],
    'footer' => $elements['footer']
  ])
@endsection

@section('scripts')
  <script>
    function handleToggleHomeAndWhoWeAre(to_home){
      let show = to_home ? $('#home-page') : $('#who_we_are');
      let hide = to_home ? $('#who_we_are') : $('#home-page');
      let active = to_home ? $('#btn-to-home-page') : $('#btn-to-who-we-are');
      let normal = to_home ? $('#btn-to-who-we-are') : $('#btn-to-home-page');
      
      show.show();
      hide.hide();

      active.addClass('active');
      normal.removeClass('active');

      if(to_home && typeof initSlickDepoiments === 'function'){
        initSlickDepoiments();
      }
    }
  </script>
  @isset($elements['carousel'])
    <script> const carousel = new bootstrap.Carousel('#carousel'); </script>
  @endisset
  @if(isset($elements['testimonial']) ||  (
    isset($elements['banner']) && $elements['banner']->model->model_type == 'carousel'
  ))
    <script type="text/javascript" src="{{ asset('js/slick-1.8.1/slick/slick.min.js') }}"></script>
  @endif
  @isset($elements['testimonial'])
    <script>
      let slickDepoimentsIsInitilized = false;
      const initSlickDepoiments = () => {
        if($('.slick-depoiments').length > 0 && $('.slick-depoiments').is(':visible')) {
          if(slickDepoimentsIsInitilized) return;
          slickDepoimentsIsInitilized = true;
          
          console.log('[slick-initialized]');
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
      }

      $(document).ready(function(){ initSlickDepoiments() });
    </script>
  @endisset
  @if(
    isset($elements['cms_blog']) && 
    isset($elements['cms_blog']->take)
  )
    <script>
      // INITIALIZATION
      const cms_blog = {
        url: `{{ route('blog.feed.more') }}`,
        take: `{{ $elements['cms_blog']->take }}`,
        token: `{{ $cms_page_token }}`,
        show: `{!! route('blog.feed.show',['slug' => '']) !!}`
      };
    </script>
    <script src="{{ asset('js/cms_blog.js') }}"></script>
  @endif
  @if(isset($elements['products']) || isset($elements['internal_products']))
    @include('utils.modalMultiPhotos')
    @include('utils.modalSearchBox')
    <script>
      function handleFilterProducts(el){
        let value = el.val().toLowerCase();
        if(value.length > 0){
          $('#flex-order > section:not(#products), #carousel').hide('slow');

          $('.product-item').each(function(){
            let name = $(this).attr('data-name').toLowerCase();
            let code = $(this).attr('data-code').toLowerCase();
            let slug = $(this).attr('data-slug').toLowerCase();
            let category = $(this).attr('data-category').toLowerCase();
            
            let hide = true
            if(name && name.includes(value)) hide = false;
            else if(code && code.includes(value)) hide = false;
            else if(slug && slug.includes(value)) hide = false;
            else if(category && category.includes(value)) hide = false;

            if(hide) $(this).hide().addClass('hide');
            else $(this).show().removeClass('hide');
          });

          if($('.product-item:not(.hide)').length === 0) el.addClass('is-invalid');
          else el.removeClass('is-invalid');
        }
        else{
          $('#flex-order > section:not(#products), #carousel, .product-item').show('slow');
          $('.product-item').removeClass('hide');
          el.removeClass('is-invalid');
        }
      }
    </script>
  @endif
  @if(
    isset($elements['download_catalog']) &&
    isset($elements['download_catalog']->pdf_url)
  )
    <script>
      $(document).ready(function() {
        $('#download_catalog-whatsapp').mask('(00) 00000-0000');
      });
      // INITIALIZATION
      const download_catalog = {
        page_id: `{{ $page_config->page_id }}`,
        page_owner_id: `{{ $page_config->user_id }}`,
        url: `{{ route('api.contact.send') }}`,
        token: `{{ $cms_page_token }}`,
        pdf_catalog_url: `{{ $elements['download_catalog']->pdf_url }}`
      };
    </script>
    <script src="{{ asset('js/download_catalog.js') }}"></script>
  @endif
  @isset($elements['popup'])
    @include('sections.popup',[
      'popup' => $elements['popup']
    ])
  @endisset
  <script>
    $(document).ready(function() {
      $('#contact-phone').mask('(00) 00000-0000');
    });
    $('#form-contact').on('submit', handleShedule);
    async function handleShedule(event){
      event.preventDefault();
      let page_phone = `{{ 
        isset($elements['code']) &&
        $elements['code']->whatsapp ? 
        numberWhatsappFormat($elements['code']->whatsapp):'' 
      }}`;
      if(page_phone.length == 0) page_phone = null;

      let name = $('#contact-name').val();
      let email = $('#contact-email').val();
      let phone = $('#contact-phone').val();
      let subject = $('#contact-subject').val();
      let message = $('#contact-message').val();

      let page_id = `{{ $page_config->page_id }}`;
      let page_owner_id = `{{ $page_config->user_id }}`;

      let dataSendMessage = {
        name, email, phone,
        message: subject ? `<b>${subject}</b><br/>${message}` : message,
        outhers: {subject},
        page_id, page_owner_id
      };

      
      let userMessage = ` *NOME:* ${name} \n\n*E-MAIL:* ${email}\n\n*TELEFONE:* ${phone ?? '-'}\n\n*ASSUNTO:* ${subject ?? '-'}\n\n*MENSAGEM:* \n\n ${message}`;
      userMessage = window.encodeURIComponent(userMessage);

      try{
        const data = await $.ajax({
          url: `{{ route('api.contact.send') }}`,
          data: dataSendMessage,
          headers: {"access-token": `{{ $cms_page_token }}`},
          method: "POST"
        });

        if(data.result){
          if(page_phone) handleSendToWhatsapp(page_phone,userMessage);
          showMessage('Enviado com sucesso','Contato');
          handleClearFormContact();
        }else
        if(page_phone) handleSendToWhatsapp(page_phone,userMessage, true);
      }catch(err){
        console.log(err);
        if(page_phone) handleSendToWhatsapp(page_phone,userMessage, true);
      }
    }
    function handleSendToWhatsapp(phone, text, confirm = false){
      if(confirm) showMessage(`
        <p>Não foi possível armazenar sua mensagem. Deseja enviar mesmo assim?</p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
          <a
            href="https://api.whatsapp.com/send?phone=${phone}&text=${text}"
            class="btn btn-primary"
          >Sim</a>
          <button
            type="button"
            class="btn btn-gray"
            onclick="$('#modalMessage').hide();"
          >Não</button>
        </div>
      `,'Agendamento');
      else window.open(`https://api.whatsapp.com/send?phone=${phone}&text=${text}`);  
    }
    function handleClearFormContact(){
      $('#contact-name').val('');
      $('#contact-email').val('');
      $('#contact-phone').val('');
      $('#contact-subject').val('');
      $('#contact-message').val('');
    }
  </script>
  @include('layout.cookies')

  {{-- #region SLIDER-MULTIFOTOS ITEMS --}}
  @if(isset($elements['banner']) && $elements['banner']->model->model_type == 'carousel')
    <script>
      $('#banner .carousel').slick({
        fade: true,
        arrows: true,
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2500,
      });

      $('#banner .slick-prev').html(`@include('utils.icons.chevron_left')`);
      $('#banner .slick-next').html(`@include('utils.icons.chevron_right')`);
    </script>
  @endif
  @if(
    isset($elements['cms_catalog']) && 
    isset($elements['cms_catalog']->api_url) &&
    isset($elements['cms_catalog']->origin)
  )
    <script>
      // INTIALIZATION
      const cms_catalog = {
        api_url: `{{ $elements['cms_catalog']->api_url }}`,
        take: `{{ $elements['cms_catalog']->take }}`,
        token: `{{ $elements['cms_catalog']->token }}`,
        origin: `{{ $elements['cms_catalog']->origin }}`
      };
    </script>
    <script src="{{ asset('js/cms_catalog.js') }}"></script>
  @endif
  @if(
    isset($elements['cms_gallery']) &&
    isset($elements['cms_gallery']->slug)
  )
    <script>
      // INTIALIZATION
      const cms_gallery = {
        slug: `{{ $elements['cms_gallery']->slug }}`,
        token: `{{ $cms_page_token }}`,
        take: <?php echo $elements['cms_gallery']->take ?? 'null'; ?>,
        url: `{{ route('api.gallery.show',['slug' => $elements['cms_gallery']->slug]) }}`
      };
    </script>
    <script src="{{ asset('js/cms_gallery.js') }}"></script>
  @endif
  @isset($elements['schedule'])
    <script>
      // INITIALIZATION
      const schedule = {
        whatsapp: `<?php echo isset($elements['code']) && $elements['code']->whatsapp ? numberWhatsappFormat($elements['code']->whatsapp) : 'null'; ?>`,
        page_id: `{{ $page_config->page_id }}`,
        page_owner_id: `{{ $page_config->user_id }}`,
        url: `{{ route('api.contact.send') }}`,
        token: `{{ $cms_page_token }}`,
      };
    </script>
    <script src="{{ asset('js/schedule.js') }}"></script>
  @endisset
  {{-- #endregion SLIDER-MULTIFOTOS ITEMS --}}

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
  @if(isset($elements['code']) && $elements['code']->final_body)
    {!! $elements['code']->final_body !!}
  @endif
@endsection