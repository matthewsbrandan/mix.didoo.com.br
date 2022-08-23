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
    margin-top: 14px;
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
    border: 1px solid rgba(0, 0, 0, 0.281);
    border-radius: 4px;
    padding: 2px 3px;
    color: rgba(0, 0, 0, 0.281);
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
      <header>
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
              <h3><a href="javascript:;" target="_blank"></a></h3>
              <p></p>
              <div class="container-tags"></div>
              <div class="container-price"></div>
            </div>
            <div class="ctn-buttons">
              <a 
                href="javascript:;"
                class="botao btn btn-primary btn-uppercase"
                target="_blank" 
              >Quero saber mais</a>
              <button
                type="button"
                class="botao btn btn-gray btn-uppercase"
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
      if(remove_iframe) $('#modalMultiPhotos .container-img').append(`
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
    setMainPhotoMultiPhotos(data.images[0].src, data.video, true);

    $("#container-multi-photos").html(
      ( data.video ? `
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
      `:'') + data.images.map((img, i) => {
        let index = i;
        if(data.video) index++;
        return `<li 
          class="${ index === 0 ? 'selected' : '' }"
          style="background-image: url('${img.src}')"
          data-image="${img.src}"
          data-index="${index}"
          onclick="handleChangeShowingPhoto($(this))"
        ></li>`;
      }).join('')
    );

    $('#modalMultiPhotos .container-tags').html(
      data.items.map(obj => {
        return obj.item ? `<div class="tags"> ${obj.item} </div>` : '';
      }).join('')
    );

    $('#modalMultiPhotos .section-2 > div > h3 a').html(data.title).attr(
      'href', data.slug ? `{{ route('product.show') }}${data.slug}` : '#'
    );
    $('#modalMultiPhotos .section-2 > div > p').html(data.description);

    $('#modalMultiPhotos .container-price').html('');
    if(data.price) $('#modalMultiPhotos .container-price').html((data.discount_price ? `
      <strong>${formatMoney(data.discount_price)}</strong>
    `:'') + `<strong>${formatMoney(data.price)}</strong>`);
    
    $('#modalMultiPhotos .section-2 > div > a').attr('href', data.button.link)
      .attr('style', `
        ${ data.button.background ? `background: ${data.button.background};` : '' }
        ${ data.button.color ? `color: ${ data.button.color};` : '' }
      `).html(data.button.text);
    $('#modalMultiPhotos .section-2 > div > button').attr('style', `
        ${ data.button_back.background ? `background: ${data.button_back.background};` : '' }
        ${ data.button_back.color ? `color: ${ data.button_back.color};` : '' }
      `).html(data.button_back.text);

    $('#modalMultiPhotos').show();
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
