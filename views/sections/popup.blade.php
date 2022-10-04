<div id="popup">
  <div class="overlay main-overlay">
    <div class="container">
      <section
        style="{{ innerStyle('background', $popup->background) }}"
      >
        <div style="position: relative;">
          <img
            src="{{ $popup->image }}"
            style="min-height: 50vh;"
          />
          <div class="overlay" style="{{ innerStyle('background', $popup->overlay) }}"></div>
        </div>
        <div style="
          padding: 1rem 3rem 2rem;
          position: absolute;
          top: 0;
          bottom: 0;
          height: 100%;
          display: flex;
          align-items: center;
          flex-direction: column;
          justify-content: flex-end;
          margin: auto;
          width: 100%;
          gap: .5rem;
        ">
          @isset($popup->button_one)
            <a
              href="{{ $popup->button_one->link }}"
              class="botao btn btn-primary btn-uppercase border-0"
              style="
                {{ innerStyle('background', $popup->button_one->background) }}
                {{ innerStyle('color', $popup->button_one->color) }}
                height: 2.7rem;
                width: fit-content;
                min-width: 18rem;
                max-width: 100%;
                margin-left: auto;
                margin-right: auto;
                display: flex;
                justify-content: center;
                align-items: center;
                text-align: center;
              "
            >{{ $popup->button_one->text }}</a>
          @endisset
          @isset($popup->button_two)
            <a
              href="{{ $popup->button_two->link }}"
              class="botao btn btn-primary btn-uppercase border-0"
              style="
                {{ innerStyle('background', $popup->button_two->background) }}
                {{ innerStyle('color', $popup->button_two->color) }}
                height: 2.7rem;
                width: fit-content;
                min-width: 18rem;
                max-width: 100%;
                margin-left: auto;
                margin-right: auto;
                display: flex;
                justify-content: center;
                align-items: center;
                text-align: center;
              "
            >{{ $popup->button_two->text }}</a>
          @endisset
        </div>
      </section>
      <button
        class="closeModal"
        type="button"
        onclick="hidePopup();"
        style="{{ innerStyle('color', $popup->color_button_close) }}"
      >@include('utils.icons.close')</button>
    </div>
  </div>
</div>
<script>
  function showPopup(force = false){
    if(!force){
      let was_closed = sessionStorage.getItem('cms@close-popup') ?? null;
      if(was_closed) return;
    }
    $('#popup').show(); 
  }
  function hidePopup(){
    $('#popup').hide();
    sessionStorage.setItem('cms@close-popup', true);
  }
  $(function(){
    $('#popup').bind('click', (e) => {
      if(e.target.classList.contains('main-overlay')) hidePopup();
    });
  });

  @if(in_array($popup->open_in,['start','start_end']))
    $(function(){ showPopup() });
  @endif
  @if($popup->open_in == 'after_seconds' && $popup->delay_seconds)
    $(function(){
      setTimeout(function(){
        showPopup()
      }, {{ $popup->delay_seconds }} * 1000);
    });
  @endif
  @if(in_array($popup->open_in,['end','start_end']))
    window.addEventListener("beforeunload", function(event) { 
      showPopup();
      
      let message = "Tem certeza que deseja sair dessa página?";
      event.returnValue = message; 
      return message;
    });
  @endif
</script>