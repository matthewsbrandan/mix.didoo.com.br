@php
  if (!function_exists('formatWhatsappText')) {  
    function formatWhatsappText($text) {
      $text = str_replace('&lt;br&gt;', '<br>', $text);
      $text = str_replace('&lt;br /&gt;', '<br>', $text);
      $text = preg_replace('/\*(.*?)\*/', '<b>$1</b>', $text);  // Negrito
      $text = preg_replace('/_(.*?)_/', '<i>$1</i>', $text);   // Itálico
      $text = preg_replace('/~(.*?)~/', '<s>$1</s>', $text);   // Tachado
      $text = preg_replace('/```(.*?)```/', '<code>$1</code>', $text); // Monoespaçado
      return $text;
    }
  }
@endphp
<div id="products" style="
  {{ innerStyleIssetAttr('background', $products, 'background', 'transparent') }}
  {{ innerStyleIssetAttr('order', $products, 'order', $default_order) }}
">
  <h1 class="text-center mb-4 mt-5" style="
    @isset($products->title)
      {{ innerStyleIssetAttr('color', $products->title, 'color') }}
      {{ innerStyleIssetAttr('font-size', $products->title, 'size') }}
    @endisset
  ">{{ $products->title->text ?? 'Produtos Personalizados' }}</h1>
  <div class="container-categories">
    <div class="d-flex" style="gap: .5rem; flex-direction: column; padding: 1rem;">
      @foreach($products->categories as $category)
        <button
          type="button"
          class="btn btn-sm text-uppercase btn-filter-category hover-brightness-90"
          style="
            font-weight: 500;align-self: flex-start; margin: 0 1.6rem; border-radius: 2rem; padding-left: 1rem; padding-right: 1rem;
            {{ innerStyleIssetAttr('color', $products->category, 'color', '#fff') }}
            {{ innerStyleIssetAttr('background', $products->category, 'background', '#dc3545') }}
          "
        >{{ $category }}</button>
        <div class="d-flex pt-3 mb-5 mx-0" id="produtos" style="overflow-x: auto; gap: 2rem;">
          @foreach(array_filter($products->items, fn($prod_item) => $prod_item->category === $category) as $prod_item)
            @php $product_url = $internal ? route('internal_product.show', ['slug' => $prod_item->slug]) : route('product.show', ['slug' => $prod_item->slug]); @endphp
            <div
              class="product-item"
              style="width: 16.25rem;"
              data-category="{{ $prod_item->category ?? null }}"
              data-name="{{ $prod_item->title->text ?? null }}"
              data-code="{{ $prod_item->code ?? null }}"
              data-slug="{{ $prod_item->slug ?? null }}"
            >
              <div class="product-item-container border h-100 p-2 d-flex flex-column" style="
                border-radius: 2rem;
                @isset($prod_item->styles)
                  {{ innerStyleIssetAttr('background', $prod_item->styles, 'background', '#ffffffff') }}
                  {{ innerStyleIssetAttr('border-color', $prod_item->styles, 'border_color', '#ffffffff', null, true) }}
                  {{ innerStyleIssetAttr('color', $prod_item->styles, 'text_color') }}
                @endisset
              ">
                <div class="product-item-data position-relative">
                  <div
                    class="product-item-image"
                    onclick='handleShowMultiPhotos({!! json_encode($prod_item) !!}, {!! $internal ? 'true':'false' !!})'
                    style="position: relative; overflow: hidden; width: 15rem; height: 15rem; border-radius: 1.6rem;"
                  >
                    <div style="
                      background-image: url('{{ $prod_item->image->src ?? '' }}');
                      position: absolute;
                      top: 0; left: 0; bottom: 0; right: 0;
                      background-position: center;
                      background-size: cover;
                      filter: blur(8px);
                      z-index: 0;
                    "></div>
                    <img
                      src="{{ $prod_item->image->src ?? '' }}"
                      style="border-radius: 1.6rem; width: 15rem; height: 15rem; object-fit: contain; z-index: 10; position: relative;"
                      alt="{{ $prod_item->image->alt ?? $prod_item->title->text ?? 'Imagem do produto' }}"
                    />
                  </div>
                </div>
                <div class="product-container pt-2">
                  <div class="product-item-name">
                    <a
                      class="product-item-image-link"
                      href="{{ $product_url }}"
                      target="_blank"
                    >
                      <strong
                        class="truncate-2"
                        style="{{ innerStyleIssetAttr('font-size', $prod_item->title, 'fontsize') }}">{{ $prod_item->title->text }}</strong>
                    </a>
                  </div>
                  @isset($prod_item->description)
                    <p class="truncate-1" style="font-size: .9rem; opacity: 0.9;">
                      {{ strip_tags(formatWhatsappText($prod_item->description)) }}
                    </p>
                  @endisset
                </div>          
                <div class="product-link product-item-url text-center mt-auto w-100">
                  <button
                    type="button"
                    class="btn btn-danger btn-block"
                    onclick='handleShowMultiPhotos({!! json_encode($prod_item) !!},{!! $internal ? 'true':'false' !!})'
                    style="
                      width: 100%;
                      border-radius: 1.2rem;
                      font-size: .9rem;
                      {{ innerStyleIssetAttr('background', $prod_item->button, 'background') }}
                      {{ innerStyleIssetAttr('color', $prod_item->button, 'color') }}
                    "
                  > {{ isset($prod_item->button) && isset($prod_item->button->text) ?  $prod_item->button->text : 'Mais Informações' }} </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endforeach
    </div>
  </div>
</div>