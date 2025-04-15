<section id="google_reviews" style="
  {{ innerStyleIssetAttr('background-image', $google_reviews, 'image') }}
  {{ innerStyleIssetAttr('order', $google_reviews, 'order', $default_order) }}
">
  <div class="content">
    <h2 class="titulo" style="
      {{ innerStyleIssetAttr('font-size', $google_reviews->title, 'length') }}
      {{ innerStyle('color', $google_reviews->title->color) }}
    ">{{ $google_reviews->title->text }}</h2>
    <p class="description texto" style="
      {{ innerStyleIssetAttr('font-size', $google_reviews->subtitle, 'length') }}
      {{ innerStyle('color', $google_reviews->subtitle->color) }}
    ">{{ nl2br($google_reviews->subtitle->text) }}</p>

    <img
      src="{{ asset('images/google-my-business.png') }}"
      alt="Google Meu Negócio"
      class="google-reviews"
      style="width: 200px;"
    />
    <div class="wrapper">
      <div class="reviews container-reviews" id="container-reviews">
        @if(count($google_reviews->reviews) > 4)
          <div>
            @foreach(array_slice($google_reviews->reviews, 0, ceil(
              count($google_reviews->reviews) / 2
            )) as $review)
              @include('slider_multifotos.google_reviews.partials.card')
            @endforeach
          </div>
          <div>
            @foreach(array_slice($google_reviews->reviews, ceil(
              count($google_reviews->reviews) / 2
            )) as $review)
              @include('slider_multifotos.google_reviews.partials.card')
            @endforeach
          </div>
        @else
          <div>
            @foreach($google_reviews->reviews as $review)
              @include('slider_multifotos.google_reviews.partials.card')
            @endforeach
          </div>
        @endif
      </div>
      <button
        type="button"
        class="btn btn-left botao"
        style="
          display: flex;
          justify-content: center;
          align-items: center;
          {{ innerStyle('color', $google_reviews->button_navigate->color).' '.innerStyle('background', $google_reviews->button_navigate->background) }}
        "
        onclick="handleScrollNextOrPrevItem(false, 'container-reviews', (18 + (2 * .5)) * 16)"
      >@include('utils.icons.chevron_left')</button>
      <button
        type="button"
        class="btn btn-right botao"
        style="
          display: flex;
          justify-content: center;
          align-items: center;
          {{ innerStyle('color', $google_reviews->button_navigate->color).' '.innerStyle('background', $google_reviews->button_navigate->background) }}
        "
        onclick="handleScrollNextOrPrevItem(true, 'container-reviews', (18 + (2 * .5)) * 16)"
      >@include('utils.icons.chevron_right')</button>
    </div>

    @if($google_reviews->button->text)
      <a
        href="{{ $google_reviews->button->link }}"
        target="_blank"
        class="botao btn btn-primary btn-uppercase"
        style="
          border: none !important;
          box-shadow: none !important;
          display: inline-flex;
          {{ $google_reviews->button->background ? 'background: '.$google_reviews->button->background.';' : '' }}
          {{ $google_reviews->button->color ? 'color: '.$google_reviews->button->color.';' : '' }}
        "
      >{{ $google_reviews->button->text }}</a>
    @endif
  </div>
  @if(isset($google_reviews->overlay) && $google_reviews->overlay)
    <div class="overlay" style="background: {{ $google_reviews->overlay }}"></div>
  @endif
</section>