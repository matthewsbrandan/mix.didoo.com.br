<section id="banner" style="
  {{ innerStyle('background-image', $banner->image) }}
">
  <div class="content">
    <div>
      <hgroup>
        <strong class="subtitulo" style="
          {{ $banner->caption->color ? 'color: '.$banner->caption->color.';' : '' }}
          {{ innerStyleIssetAttr('font-size', $banner->caption, 'length') }}
        ">{{ $banner->caption->text }}</strong>
        <h1 class="titulo" style="
          {{ $banner->title->color ? 'color: '.$banner->title->color.';' : '' }}
          {{ innerStyleIssetAttr('font-size', $banner->title, 'length') }}
        ">{{ $banner->title->text }}</h1>
      </hgroup>
      <p class="texto description" style="
        {{ $banner->description->color ? 'color: '.$banner->description->color.';' : '' }}
        {{ innerStyleIssetAttr('font-size', $banner->description, 'length') }}
      ">{!! $banner->description->text !!}</p>
      @isset($banner->button)
        <a
          class="botao btn btn-primary btn-uppercase"
          href="{{ $banner->button->link }}"
          style="
            align-self: center;
            {{ innerStyle('background', $banner->button->background) }}
            {{ innerStyle('color', $banner->button->color) }}
          "
        >{{ $banner->button->text }}</a>
      @endisset
    </div>
  </div>
  <div class="overlay" style="background: {{ $banner->overlay }}"></div>
</section>