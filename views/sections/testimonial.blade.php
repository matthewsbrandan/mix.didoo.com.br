<section id="testimonial" class="py-5" style="
  {{ innerStyleIssetAttr('background', $testimonial, 'background', 'transparent') }}
  {{ innerStyleIssetAttr('order', $testimonial, 'order', $default_order) }}
">
  <div class="container" id="depoimentos">
    <h3 class="text-center mb-5" style="
      {{ innerStyleIssetAttr('color', $testimonial->title, 'color') }}
      {{ innerStyleIssetAttr('font-size', $testimonial->title, 'fontsize') }}
    ">
      {{ $testimonial->title->text ?? 'Depoimentos de Cliente' }}
    </h3>
    <div class="slick-depoiments">
      @foreach($testimonial->depoiments as $i => $depoiment)
        <div
          class="slick-slide {{ $i == 0 ? 'slick-current' : '' }} slick-active"
          aria-describedby="slick-slide-control01"
          id="depoiment-item-{{ $i }}"
          data-slick-index="{{ $i }}"
          aria-hidden="true"
          role="tabpanel"
          tabindex="-1"
          style="width: 230px;"
        >
          <div>
            <div style="width: 100%; display: inline-block;">
              <div class="depoiment-item">
                <div class="depoiment-image">
                  <img
                    src="{{ $depoiment->image }}"
                    alt="{{ $depoiment->name }}"
                    class="rounded-circle mx-auto"
                    style="
                      width: 12rem;
                      height: 12rem;
                      object-fit: cover;
                    "
                  />
                </div>
                <div class="text-center d-flex flex-column align-items-center pt-2">
                  <strong class="text-uppercase" style="
                    {{ innerStyleIssetAttr('color', $testimonial, 'text_color_highlight', '#ff0000') }}
                  ">{{ $depoiment->name }}</strong>
                  <div class="depoiment-city-state">{{ $depoiment->city_state }}</div>
                  <div class="depoiment-stars" style="
                    {{ innerStyleIssetAttr('color', $testimonial, 'text_color_highlight', '#ff0000') }}
                  ">
                    @for($num_star = 0; $num_star < $depoiment->stars; $num_star++)
                      <i class="far fa-star"></i>
                    @endfor
                  </div>
                  <div class="depoiment-description">{{ $depoiment->description }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>