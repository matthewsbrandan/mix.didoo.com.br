<section id="multi_photo" style="
  {{ innerStyle('background-image', $multi_photos->image) }}
  {{ innerStyleIssetAttr('order', $multi_photos, 'order', $default_order) }}
">
  <div class="content" id="multi-fotos">
    <div class="wrapper">
      <h2 class="titulo" style="
        {{ innerStyleIssetAttr('font-size', $multi_photos->title, 'length') }}
        {{ innerStyle('color', $multi_photos->title->color) }}
      ">
        {{ $multi_photos->title->text }}
        <button
          type="button"
          class="btn-search"
          onclick="callSearchBoxMultiPhotos()"
        >@include('utils.icons.search')</button>
      </h2>
      <p class="subtitulo subtitle" style="
        {{ innerStyleIssetAttr('font-size', $multi_photos->subtitle, 'length') }}
        {{ innerStyle('color', $multi_photos->subtitle->color) }}
      ">{{ $multi_photos->subtitle->text }}</p>
    </div>
    <div class="overflow">
      <div class="container-multi_photos wrapper">
        @foreach($multi_photos->services as $item)
          <div
            class="multi_photo"
            data-slug="{{ $item->slug }}"
            data-title="{{ $item->title }}"
            data-description="{{ $item->description }}"
          >
            @if(isset($item->video) && $item->video)
              <div class="container-video">
                <iframe
                  src="{{ $item->video }}"
                  frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen=""
                ></iframe>
              </div>
            @else <img src="{{ $item->images[0]->src ?? asset('no-image.jpg') }}" alt="{{ $item->title }}"/> @endif
            <a
              href="{{ isset($item->slug) && $item->slug ? route('product.show',['slug' => $item->slug]) : 'javascript:;' }}"
              @if(isset($item->slug) && $item->slug) target="_blank" @endif
            >
              <strong style="
                {{ innerStyleIssetAttr('font-size', $multi_photos->service_title, 'length') }}
                {{ innerStyle('color', $multi_photos->service_title->color) }}
              ">{{ $item->title }}</strong>
            </a>
            <p class="texto" style="
              {{ innerStyleIssetAttr('font-size', $multi_photos->service_description, 'length') }}
              {{ innerStyle('color', $multi_photos->service_description->color) }}
            ">{{ $item->description }}</p>
            <a
              href="javascript:;"
              class="botao btn btn-primary btn-uppercase"
              style="
                {{ $multi_photos->button_see_more->background ? 'background: '.$multi_photos->button_see_more->background.';' : '' }}
                {{ $multi_photos->button_see_more->color ? 'color: '.$multi_photos->button_see_more->color.';' : '' }}
              "
              onclick='handleShowMultiPhotos({!! json_encode($item) !!})'
            >{{ $multi_photos->button_see_more->text ?? 'Ver Mais' }}</a>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  @if(isset($multi_photos->overlay) && $multi_photos->overlay)
    <div class="overlay" style="background: {{ $multi_photos->overlay }}"></div>
  @endif
</section>