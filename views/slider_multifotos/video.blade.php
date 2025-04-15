<section id="video" style="
  {{ innerStyle('background-image', $video->wallpaper) }}
  {{ innerStyleIssetAttr('order', $video, 'order', $default_order) }}
">
  <button
    type="button"
    class="btn botao"
    onclick="$(this).hide('slow').next().attr('src','{{ $video->src }}').show('slow');"
    style="
      @isset($video->button)
        {{ innerStyleIssetAttr('background', $video->button, 'background', '#ffff') }}
        {{ innerStyleIssetAttr('color', $video->button, 'color', '#5e72e4') }}
      @endisset
    "
  >@include('utils.icons.play')</button>
  <iframe
    src=""
    style="display: none;"
    frameborder="0"
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
    allowfullscreen=""
  ></iframe>
</section>