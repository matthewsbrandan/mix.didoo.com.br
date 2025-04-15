<section id="video_depoiments" style="
  {{ innerStyleIssetAttr('background-image', $video_depoiments, 'image') }}
  {{ innerStyleIssetAttr('order', $video_depoiments, 'order', $default_order) }}
">
  <div class="content">
    <h2 class="titulo" style="
      {{ innerStyleIssetAttr('font-size', $video_depoiments, 'title_length') }}
      {{ innerStyleIssetAttr('color', $video_depoiments, 'text_color') }}
    ">{{ $video_depoiments->title }}</h2>
    <p class="subtitulo" style="
      {{ innerStyleIssetAttr('font-size', $video_depoiments, 'subtitle_length') }}
      {{ innerStyleIssetAttr('color', $video_depoiments, 'text_color') }}
    ">{{ $video_depoiments->substitle }}</p>
    <div class="wrapper-depoiments depoiment-filled">
      <div class="container-depoiments" id="container-depoiments">
        @foreach($video_depoiments->depoiments as $depoiment)
          @if(!in_array($depoiment->link,['#','']))
            <div
              class="container-depoiment-item"
              style="{{ innerStyle('background-image', $depoiment->wallpaper) }}"
            >
              <button
                type="button"
                class="btn botao"
                style="{{ innerStyle('background', $video_depoiments->button->color).' '.innerStyle('color', $video_depoiments->button->background) }}"
                onclick="$(this).hide('slow').next().attr('src','{{ $depoiment->link }}').show('slow');"
              >@include('utils.icons.play')</button>
              <iframe
                src=""
                style="display: none;"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen=""
              ></iframe>
            </div>
          @endif
        @endforeach
      </div>
      <button
        type="button"
        class="btn btn-left botao"
        style="
          {{ innerStyle('color', $video_depoiments->button->color).' '.innerStyle('background', $video_depoiments->button->background) }}
          display: flex;
          align-items: center;
          justify-content: center;
        "
        onclick="handleScrollNextOrPrevItem(false, 'container-depoiments', (15 + (2 * .6)) * 16)"
      >@include('utils.icons.chevron_left')</button>
      <button
        type="button"
        class="btn btn-right botao"
        style="
          {{ innerStyle('color', $video_depoiments->button->color).' '.innerStyle('background', $video_depoiments->button->background) }}
          display: flex;
          align-items: center;
          justify-content: center;
        "
        onclick="handleScrollNextOrPrevItem(true, 'container-depoiments', (15 + (2 * .6)) * 16)"
      >@include('utils.icons.chevron_right')</button>
    </div>
    <a
      href="{{ $video_depoiments->button->link }}"
      target="_blank"
      class="botao btn btn-primary btn-uppercase"
      style="
        border: none !important;
        box-shadow: none !important;
        display: flex;
        justify-content: center;
        {{ $video_depoiments->button->background ? 'background: '.$video_depoiments->button->background.';' : '' }}
        {{ $video_depoiments->button->color ? 'color: '.$video_depoiments->button->color.';' : '' }}
      "
    >{{ $video_depoiments->button->text }}</a>
  </div>
  @if(isset($video_depoiments->overlay) && $video_depoiments->overlay)
    <div class="overlay" style="background: {{ $video_depoiments->overlay }}"></div>
  @endif
</section>