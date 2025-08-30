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
  <div class="container-categories d-flex">
    <div class="d-flex" style="gap: .5rem; flex-direction: column;">
      @foreach($products->categories as $category)
        <button
          type="button"
          class="btn btn-danger btn-sm text-uppercase btn-filter-category"
          style="font-weight: 500;align-self: flex-start; margin: 0 1.6rem; border-radius: 2rem; padding-left: 1rem; padding-right: 1rem;"
          onclick="handleFilterProductCategory($(this))"
        >{{ $category }}</button>
        <div class="row pt-3 mb-5 mx-0" id="produtos" style="overflow-x: auto;">
          @foreach(array_filter($products->items, fn($prod_item) => $prod_item->category === $category) as $prod_item)
            @php $product_url = $internal ? route('internal_product.show', ['slug' => $prod_item->slug]) : route('product.show', ['slug' => $prod_item->slug]); @endphp
            <div
              class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-3 product-item {{
                isset($products->columns) && $products->columns != 1 ? (
                  $products->columns == 2 ? 'col-6':(
                    $products->columns == 3 ? 'col-4':''
                  )
                ):''
              }}"
              data-category="{{ $prod_item->category ?? null }}"
              data-name="{{ $prod_item->title->text ?? null }}"
              data-code="{{ $prod_item->code ?? null }}"
              data-slug="{{ $prod_item->slug ?? null }}"
            >
              <div class="product-item-container border h-100 p-3 rounded d-flex flex-column" style="
                @isset($prod_item->styles)
                  {{ innerStyleIssetAttr('background', $prod_item->styles, 'background', '#ffffffff') }}
                  {{ innerStyleIssetAttr('border-color', $prod_item->styles, 'border_color', '#ffffffff', null, true) }}
                  {{ innerStyleIssetAttr('color', $prod_item->styles, 'text_color') }}
                @endisset
              ">
                <div class="product-item-data position-relative">
                  <div class="product-item-image" onclick='handleShowMultiPhotos({!! json_encode($prod_item) !!}, {!! $internal ? 'true':'false' !!})'>
                    <img
                      src="{{ $prod_item->image->src ?? '' }}"
                      class="rounded w-100"
                      alt="{{ $prod_item->image->alt ?? $prod_item->title->text ?? 'Imagem do produto' }}"
                    />
                  </div>
                </div>
                <div class="product-container pt-3">
                  <div class="product-item-name text-center mb-1">
                    <a
                      class="product-item-image-link"
                      href="{{ $product_url }}"
                      target="_blank"
                    >
                      <strong class="text-uppercase h5" style="
                        {{ innerStyleIssetAttr('font-size', $prod_item->title, 'fontsize') }}
                      ">{{ $prod_item->title->text }}</strong>
                    </a>
                  </div>
                  @isset($prod_item->description)
                    <p style="font-size: .9rem;">
                      {{ $prod_item->description }}
                    </p>
                  @endisset
                </div>          
                <div class="product-link product-item-url text-center mt-auto w-100">
                  <button
                    type="button"
                    class="btn btn-danger btn-block"
                    onclick='handleShowMultiPhotos({!! json_encode($prod_item) !!},{!! $internal ? 'true':'false' !!})'
                    style="
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