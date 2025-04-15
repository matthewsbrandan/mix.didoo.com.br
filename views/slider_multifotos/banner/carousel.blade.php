<section id="banner">
  <div class="carousel">
    @foreach($banner->images as $index => $image)
      <div class="carousel-item" style="background-image: url('{{ $image->src }}');">
        <div class="content">
          <div>
            <h1 class="titulo" style="
              {{ $image->title->color ? 'color: '.$image->title->color.';' : '' }}
              {{ innerStyleIssetAttr('font-size', $banner, 'title_length') }}
            ">{{ $image->title->text }}</h1>
            <p class="texto description" style="
              {{ $image->description->color ? 'color: '.$image->description->color.';' : '' }}
              {{ innerStyleIssetAttr('font-size', $banner, 'description_length') }}
            ">{!! $image->description->text !!}</p>
            @isset($image->button)
              <a
                class="botao btn btn-primary btn-uppercase"
                href="{{ $image->button->link }}"
                style="
                  align-self: center;
                  {{ innerStyle('background', $image->button->background) }}
                  {{ innerStyle('color', $image->button->color) }}
                "
              >{{ $image->button->text }}</a>
            @endisset
          </div>
        </div>
        <div class="overlay" style="background: {{ $image->overlay }}"></div>
      </div>
    @endforeach
  </div>
</section>