<section id="service" style="
  {{ innerStyleIssetAttr('background-image', $service, 'image') }}
  {{ innerStyleIssetAttr('order', $service, 'order', $default_order) }}
">
  <div class="content" id="servicos" style="
    {{ innerStyle('color', $service->text_color) }}
  ">
    <h2 class="titulo" style="
      {{ innerStyleIssetAttr('font-size', $service, 'title_length') }}
    ">{{ $service->title }}</h2>
    <p class="subtitulo subtitle" style="
      {{ innerStyleIssetAttr('font-size', $service, 'subtitle_length') }}
    ">{{ $service->subtitle }}</p>
    <div class="container-services">
      @foreach($service->services as $item)
        <div class="service">
          <img src="{{ $item->image }}" alt="{{ $item->title }}"/>
          <strong style="
            {{ innerStyleIssetAttr('font-size', $service, 'item_title_length') }}
          ">{{ $item->title }}</strong>
          <p class="texto" style="
            {{ innerStyleIssetAttr('font-size', $service, 'item_description_length') }}
          ">{{ $item->description }}</p>
          <a
            href="{{ $item->button->link }}"
            class="botao btn btn-primary btn-uppercase"
            target="_blank"
            style="
              border: none !important;
              box-shadow: none !important;
              {{ $item->button->background ? 'background: '.$item->button->background.';' : '' }}
              {{ $item->button->color ? 'color: '.$item->button->color.';' : '' }}
            "
          >{{ $item->button->text }}</a>
        </div>
      @endforeach
    </div>
  </div>
  @if(isset($service->overlay) && $service->overlay)
    <div class="overlay" style="background: {{ $service->overlay }}"></div>
  @endif
</section>