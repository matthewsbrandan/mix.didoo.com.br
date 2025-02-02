@if(isset($elements['products']->has_modal) && $elements['products']->has_modal === 'Sim')
  <style>
    #modalMultiPhotos{
      display: none;
      z-index: 99999;
    }
    #modalMultiPhotos .overlay{
      background: rgba(0,0,20,.6);
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: 99999;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    #modalMultiPhotos .overlay .container{
      display: block !important;
      background: #fff;
      width: 100%;
      max-width: 45rem;
      height: auto;
      max-height: calc(100vh - 2rem);
      margin: auto 1rem;
      border-radius: 5px;
      box-shadow: 0 0 60px rgba(0,0,0,.05);
      position: relative;
    }
    #modalMultiPhotos .overlay .container header{
      font-size: 1.5rem;
      font-weight: 600;
      display: flex;
      flex-wrap: inherit;
      justify-content: space-between;
      align-items: center;
      padding: 1.5rem 1.5rem 1.2rem;
      border-bottom: 1px solid #dde;
    }
    #modalMultiPhotos .overlay .container button.closeModal{
      background: transparent;
      border: 0;
      font-size: 1.2rem;
      cursor: pointer;
      padding-right: 0;
    }
    #modalMultiPhotos .overlay .container > section{
      overflow-y: auto;
      max-height: calc(100vh - 9rem);
      font-size: 1rem;
    }
    #modalMultiPhotos .overlay .container > section p{
      color: #668;
    }
    #modalMultiPhotos ul li {
      list-style: none;
    }
    #modalMultiPhotos .modal-body {
      display: grid;
      grid-template-columns: 50% 50%;
    }
    #modalMultiPhotos .modal-body section.section-1{
      padding: 10px 15px;
      display: flex;
      flex-direction: column;
      gap: 1rem;    
    }
    #modalMultiPhotos .container-img{
      width: 100%;
      height: 345px;
      display: flex;
      align-items: center;
      border-radius: 4px;
      background-size: cover;
      transition: .6s;
      position: relative;
    }
    #modalMultiPhotos .container-img span{
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
    #modalMultiPhotos .container-img span.to-back{ left: 0; }
    #modalMultiPhotos .container-img span.to-next{ right: 0; }
    #modalMultiPhotos .container-img span:hover{
      background: #fff3;
    }
    #modalMultiPhotos .container-img span svg{
      font-size: 1.8em;
      color: #fff;
    }
    #modalMultiPhotos .container-itens{
      overflow-x: auto;
    }
    #modalMultiPhotos .container-itens ul {
      display: flex;
      gap: 1rem;
      padding-left: .2rem;
      margin-top: 0;
    }
    #modalMultiPhotos .container-itens ul li{
      width: 50px;
      min-width: 50px;
      height: 50px;
      background-repeat: no-repeat;
      background-size: cover;
      border-radius: 4px;
      cursor: pointer;
      transition: .6s;
    }
    #modalMultiPhotos .container-itens ul li.selected{
      opacity: .7;
    }
    #modalMultiPhotos .modal-body section.section-2{
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 0 1.5rem;
    }
    #modalMultiPhotos .modal-body section.section-2 h3{
      margin-bottom: 0;
    }
    #modalMultiPhotos .modal-body section.section-2 p{ margin-top: 12px; }
    #modalMultiPhotos .modal-body section.section-2 .container-tags{
      margin-top: 20px;
      display: flex;
      justify-content: flex-start;
      align-items: center;
      gap: 5px;
    }
    #modalMultiPhotos .modal-body section.section-2 .container-tags .tags{
      border: 1px solid rgba(0, 0, 20, 0.481);
      border-radius: 4px;
      padding: 2px 3px;
      color: rgba(0, 0, 20, 0.681);
    }
    #modalMultiPhotos .modal-body section.section-2 .ctn-buttons{
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      margin-bottom: 1rem;
      padding: 0px 20px;
      font-size: .9rem;
    }
    @media (max-width: 700px){
      #modalMultiPhotos .modal-body {
        grid-template-columns: 1fr;
      } 
    }
    #modalMultiPhotos .container-price{
      margin: 1.4rem 0;
      font-size: 1.3rem;
    }
    #modalMultiPhotos .container-price strong{ display: block; }
    #modalMultiPhotos .container-price strong + strong{
      font-size: 1rem;
      text-decoration: line-through;
      color: #667;
      font-weight: 500;
      margin-top: .1rem;
    }
  </style>
  <div id="modalMultiPhotos">
    <div class="overlay">
      <div class="container">
        <header class="px-2 py-3">
          {{ $page_config->title ?? 'CMS' }}
          <button class="closeModal" type="button" onclick="$('#modalMultiPhotos').hide();">
            @include('utils.icons.close')
          </button>
        </header>
        <section>
          <div class="modal-body">
            <section class="section-1">
              <div class="container-img">
                <span class="to-back" onclick="handleChangeShowingPhoto(null, false)">
                  @include('utils.icons.chevron_left')
                </span>
                <span class="to-next" onclick="handleChangeShowingPhoto()">
                  @include('utils.icons.chevron_right')
                </span>              
              </div>
              <div class="container-itens">
                <ul id="container-multi-photos"></ul>
              </div>
            </section>
            <section class="section-2">
              <div>
                <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
                  <h3 class="title">
                    <a href="javascript:;" target="_blank" style="
                      color: inherit;
                      text-decoration: none;
                    "></a>
                  </h3>
                  <button
                    class="btn btn-link mb-0 p-0 text-dark ms-2"
                    type="button"
                    onclick='handleShareProduct({!! json_encode($product) !!})'
                  >@include('utils.icons.share')
                  </button>
                </div>
                <p></p>
                <div class="container-tags"></div>
                <div class="container-price"></div>
              </div>
                
              <div class="ctn-buttons">
                @if(
                  isset($elements['code']) &&
                  isset($elements['code']->whatsapp)
                )
                  <button
                    type="button"
                    class="botao btn mb-2 w-100 btn-whatsapp"
                    style="
                      background: #34af23;
                      color: white;
                      display: flex;
                      align-items: center;
                      justify-content: center;
                      font-weight: 500;
                    "
                  >
                    {{ 
                      handleVerifyAttrs($elements['products'], 'button_wpp_text') ?? 'Pedir pelo'
                    }} @include('utils.icons.whatsapp',['icons' => (object)[
                      'color' => 'currentColor',
                      'style' =>'margin-left: .3rem;'
                    ]])
                  </button>
                @endif                
                <a
                  href="#"
                  target="_blank"
                  class="botao btn mb-2 w-100 btn-external"
                  style="
                    {{ innerStyleIssetAttr('background', $elements['products']->button_buy_now, 'background') }}
                    {{ innerStyleIssetAttr('color', $elements['products']->button_buy_now, 'color') }}
                    font-weight: 500;
                  "
                >{{ $elements['products']->button_buy_now->text ?? 'Comprar agora' }}</a>
                <a 
                  href="javascript:;"
                  class="botao btn btn-danger more-info"
                  target="_blank" 
                >Quero saber mais</a>
                <button
                  type="button"
                  class="botao btn btn-secondary mt-2 btn-uppercase"
                  onclick="$('#modalMultiPhotos').hide();"
                >Fechar e voltar</button>
              </div>
            </section>
          </div>
        </section>
      </div>
    </div>
  </div>
  <script>
    // FUNCTION ONLOAD
    $(function(){
      $('#modalMultiPhotos').bind('click', (e) => {
        if(e.target.classList.contains('overlay')){
          $('#modalMultiPhotos').hide();
        }
      });
    });
    const setMainPhotoMultiPhotos = (src, video = null, remove_iframe = false) => {
      if(remove_iframe) $('#modalMultiPhotos .container-img iframe').remove();
      if(video){
        $('#modalMultiPhotos .container-img').css('background-image','none');
        if(remove_iframe || $('#modalMultiPhotos .container-img iframe').length === 0) $('#modalMultiPhotos .container-img').append(`
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
        else $('#modalMultiPhotos .container-img iframe').show();
      }
      else{
        $('#modalMultiPhotos .container-img').css(
          'background-image',
          `url('${src}')`
        );
        if(!remove_iframe) $('#modalMultiPhotos .container-img iframe').hide();
      }
    }
    function handleShowMultiPhotos(data){
      setMainPhotoMultiPhotos(data.image.src, (
        data.video_position === 'final' ? undefined : data.video
      ), true);

      $("#container-multi-photos").html("");

      const liVideo = (selected) => `
        <li 
          class="has-video ${selected ? 'selected':''}"
          style="
            background-image: none;
            background: #ccd;
            display: flex;
            align-items: center;
            justify-content: center;
          "
          data-image="none"
          data-video="${data.video}"
          data-index="0"
          onclick="handleChangeShowingPhoto($(this))"
        >@include('utils.icons.play')</li>
      `;

      const isStartVideo = data.video && data.video_position !== 'final';
      if(data.video || data.outher_images) $("#container-multi-photos").html(
        ((isStartVideo) ? liVideo(true) : '' ) + `
          <li 
            class="${isStartVideo ? '' : 'selected'}"
            style="background-image: url('${data.image.src}')"
            data-image="${data.image.src}"
            data-index="${isStartVideo ? '1':'0'}"
            onclick="handleChangeShowingPhoto($(this))"
          ></li>
        ` + (data.outher_images ? (
          data.outher_images.map((img, i) => { 
            let index = i + 1;
            if(data.video) index++;

            return `
              <li 
                style="background-image: url('${img.src}')"
                data-image="${img.src}"
                data-index="${index}"
                onclick="handleChangeShowingPhoto($(this))"
              ></li>
            `;
          }).join('')
        ):'') + (
          data.video && data.video_position === 'final' ? liVideo(false) : ''
        )
      );

      let link = data.slug ? `{{ route('product.show') }}${data.slug}` : '#';
      $('#modalMultiPhotos .section-2 h3.title a').html(data.title.text).attr(
        'href', link
      );
      $('#modalMultiPhotos .section-2 > div > p').html(data.description);

      $('#modalMultiPhotos .container-tags').html(
        data.tags.map(obj => {
          return obj.item ? `<div class="tags"> ${obj.item} </div>` : '';
        }).join('')
      );

      $('#modalMultiPhotos .container-price').html('');
      if(data.price) $('#modalMultiPhotos .container-price').html(`
        <div class="product-item-price-data pt-2 mb-3">
          ${data.price.current && !!data.price.current ? `
              <p class="product-item-price h5 mb-0" style="
                ${ 
                  data.price.current_fontsize ?
                  `font-size: ${data.price.current_fontsize}px`:
                  'current_fontsize'
                }
              ">R$ ${ data.price.current }</p>
          `: ( data.price.old && !!data.price.old ? `
            <p class="mb-0 product-item-price-from">
              <span class="old-price text-decoration-line-through text-muted" style="
                ${
                  data.styles && data.styles.text_lowlighted ? 
                  ` color: ${ data.styles.text_lowlighted }; `:''
                } ${ data.price.old_fontsize ? ` font-size: ${ data.price.old_fontsize}px; `:'' }
              ">R$ ${ data.price.old }</span>
            </p>
          `:``
          )}
        </div>
      `);
      
      @if(
        isset($elements['code']) &&
        isset($elements['code']->whatsapp)
      )
        if(
          Array.isArray(data.select_buttons) &&
          data.select_buttons.includes('Pedir pelo whatsapp')
        ) $('#modalMultiPhotos .btn-whatsapp').attr(
          'onclick',
          `handleSendProductToWhatsapp(${JSON.stringify(data)})`
        ).show();
        else $('#modalMultiPhotos .btn-whatsapp').hide();
      @endif
      if(
        Array.isArray(data.select_buttons) &&
        data.select_buttons.includes('Comprar agora') &&
        data.link_button_buy_now
      ){
        $('#modalMultiPhotos .btn-external').attr('href', data.link_button_buy_now).show();
      }else $('#modalMultiPhotos .btn-external').hide();
      

      $('#modalMultiPhotos .more-info').attr('href', link)
        .attr('style', `
          ${ data.button.background ? `background: ${data.button.background};` : '' }
          ${ data.button.color ? `color: ${ data.button.color};` : '' }
        `).html(data.button.text);

      $('#modalMultiPhotos').show();
    }
    
    function handleChangeShowingPhoto(elem = null, to_next = true){
      let image = null;
      if(elem){
        image = elem.attr('data-image');
        has_video = elem.hasClass('has-video');
        video = has_video ? elem.attr('data-video') : null;
        if(!image) return;

        $('#container-multi-photos li').removeClass('selected');
        elem.addClass('selected');

        setMainPhotoMultiPhotos(image, video);
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
    function handleSendProductToWhatsapp(product){
      let title = product.title && product.title.text ? product.title.text : '_Produto Sem Título_';
      let message = `*${title + (product.code ? ` - ${product.code}` : '')}*\n`;
      if(product.category) message+= `(${product.category})\n`;
      if(product.price && product.price.current) message+= `R$ ${product.price.current}\n`;
      message+= `\n{{ route('product.show', ['slug' => '']) }}${product.slug}`;

      let whatsapp = `{{
        isset($elements['code']) && isset($elements['code']->whatsapp) ? 
          numberWhatsappFormat($elements['code']->whatsapp) :  null
      }}`;
      let url = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}${
        whatsapp ? `&phone=${whatsapp}`:''
      }`;
      window.open(url, '_blank');
    }
    function handleShareProduct(product){
      let title = product.title && product.title.text ? product.title.text : '_Produto Sem Título_';
      let url = `{{ route('product.show', ['slug' => '']) }}${product.slug}`;

      let text = `*${title + (product.code ? ` - ${product.code}` : '')}* \n`;
      if(product.category) text+= `(${product.category}) \n`;
      if(product.price && product.price.current) text+= `R$ ${product.price.current} \n`;

      navigator.share({
        title, text, url
      });
    }
  </script>
@else
  <script>
    function handleShowMultiPhotos(data){
      let link = data.slug ? `{{ route('product.show') }}${data.slug}` : '#';
      window.open(link, '_blank')
    }
  </script>
@endif

