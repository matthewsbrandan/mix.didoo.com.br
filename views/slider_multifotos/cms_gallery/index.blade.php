<section id="cms_gallery" style="
  {{
    isset($cms_gallery->image) && $cms_gallery->image ? 
    innerStyle('background-image', $cms_gallery->image) :
    innerStyle('background', $cms_gallery->background) 
  }}
  {{ innerStyleIssetAttr('order', $cms_gallery, 'order', $default_order) }}

">
  <div class="content" id="galeria" style="
    {{ innerStyle('color', $cms_gallery->text_color) }}
  ">
    <h2 style="
      {{ innerStyleIssetAttr('font-size', $cms_gallery, 'title_length') }}
    ">{{ $cms_gallery->title }}</h2>
    <p style="
      {{ innerStyleIssetAttr('font-size', $cms_gallery, 'subtitle_length') }}
    ">{{ $cms_gallery->subtitle }}</p>
    <div
      class="wrapper-gallery {{ (!isset($cms_gallery->mode) || $cms_gallery->mode === 'Carrossel de Imagens') ? 'carousel-gallery' : ($cms_gallery->mode === 'Padrão Mosaico' ?  'mosaic-gallery' : 'netflix-gallery') }}"
      data-rows="{{ $cms_gallery->rows ?? '1'}}"
    >
      <div id="container-gallery">
        <p class="text-loading texto">Carregando Galeria...</p>
      </div>
      <button
        type="button"
        class="btn btn-left botao"
        style="
          @isset($cms_gallery->button)
            {{ innerStyleIssetAttr('color', $cms_gallery->button, 'color', '#fff') }}
            {{ innerStyleIssetAttr('background', $cms_gallery->button, 'background', '#5e72e4') }}
          @endisset
        "
        onclick="handleScrollNextOrPrevItem(false, 'container-gallery', (15 + (2 * .4)) * 16)"
      >@include('utils.icons.chevron_left')</button>
      <button
        type="button"
        class="btn btn-right botao"
        style="
          @isset($cms_gallery->button)
            {{ innerStyle('color', $cms_gallery->button, 'color', '#fff') }}
            {{ innerStyle('background', $cms_gallery->button, 'background', '#5e72e4') }}
          @endisset
        "
        onclick="handleScrollNextOrPrevItem(true, 'container-gallery', (15 + (2 * .4)) * 16)"
      >@include('utils.icons.chevron_right')</button>
    </div>
  </div>
  <div id="modal-zoom-gallery-image" onclick="closeZoomImage()" style="display: none;">
    <span class="close">&times;</span>
    <img class="modal-content" id="modal-zoom-img">
    <button
      type="button"
      class="btn btn-left botao"
      style="
        @isset($cms_gallery->button)
          {{ innerStyleIssetAttr('color', $cms_gallery->button, 'color', '#fff') }}
          {{ innerStyleIssetAttr('background', $cms_gallery->button, 'background', '#5e72e4') }}
        @endisset
      "
      onclick="handleScrollNextOrPrevItem(false, 'container-gallery', (15 + (2 * .4)) * 16)"
    >@include('utils.icons.chevron_left')</button>
    <button
      type="button"
      class="btn btn-right botao"
      style="
        @isset($cms_gallery->button)
          {{ innerStyle('color', $cms_gallery->button, 'color', '#fff') }}
          {{ innerStyle('background', $cms_gallery->button, 'background', '#5e72e4') }}
        @endisset
      "
      onclick="handleScrollNextOrPrevItem(true, 'container-gallery', (15 + (2 * .4)) * 16)"
    >@include('utils.icons.chevron_right')</button>
  </div>
  
  @if(isset($cms_gallery->overlay) && $cms_gallery->overlay)
    <div class="overlay" style="background: {{ $cms_gallery->overlay }}"></div>
  @endif
</section>