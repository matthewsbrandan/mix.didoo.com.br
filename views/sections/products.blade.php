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
    <div class="d-flex flex-wrap mx-auto" style="gap: .5rem;">
      @if(count($products->categories) > 0)
        <button
          type="button"
          class="btn btn-danger btn-sm text-uppercase btn-filter-category"
          style="font-weight: 500;"
          onclick="handleFilterAllCategories()"
        >Todos</button>
      @endif
      @foreach($products->categories as $category)
        <button
          type="button"
          class="btn btn-danger btn-sm text-uppercase btn-filter-category"
          style="font-weight: 500;"
          onclick="handleFilterProductCategory($(this))"
        >{{ $category }}</button>
      @endforeach
    </div>
  </div>
  <div class="row pt-3 mb-5 mx-0" id="produtos">
    @foreach($products->items as $prod_item)
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
                src="{{ $prod_item->image->src }}"
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
              </a><br/>
              @isset($prod_item->code)
                <small class="text-danger product-sku" style="
                  @isset($prod_item->styles)
                    {{ innerStyleIssetAttr('color', $prod_item->styles, 'text_highlighted') }}
                  @endisset
                ">SKU / Código: {{ $prod_item->code }}</small>
              @endisset
            </div>
            <div class="product-item-category text-center mb-2 text-uppercase opacity-9">
              <strong>Categoria</strong>: {{ $prod_item->category }}
            </div>
            @isset($prod_item->price)
              <div class="text-center product-item-price-data pt-2 mb-3">
                @if(isset($prod_item->price->current) && !!$prod_item->price->current)
                  <p class="product-item-price display-6 mb-0" style="
                    {{ innerStyleIssetAttr('font-size', $prod_item->price, 'current_fontsize') }}
                  ">R$ {{ number_format($prod_item->price->current, 2,',','.') }}</p>
                @endif
                @if(isset($prod_item->price->old) && !!$prod_item->price->old)
                  <p class="mb-0 product-item-price-from">
                    <span class="old-price text-decoration-line-through text-muted" style="
                      @isset($prod_item->styles)
                        {{ innerStyleIssetAttr('color', $prod_item->styles, 'text_lowlighted') }}
                      @endisset
                      {{ innerStyleIssetAttr('font-size', $prod_item->price, 'old_fontsize') }}
                    ">R$ {{ number_format($prod_item->price->old, 2,',','.') }}</span>
                  </p>
                @endif
              </div>
            @endisset
            @isset($prod_item->validate)
              <div
                class="contador-regressivo rounded"
                data-timer-id="1"
                data-table="products"
                data-date="{{ $prod_item->validate }}"
              >
                <p class="text-uppercase"> Promoção expira em: </p>
                <div class="timer-products-1">131 dias 40m 7s</div>
              </div>
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
  <script>
    if(typeof filterBtnThemeColors === 'undefined'){
      const filterBtnThemeColors = () => ['btn-danger','btn-dark'];

      function handleFilterAllCategories(){
        let [class_active, class_disabled] = filterBtnThemeColors();
        $(`.btn-filter-category`).addClass(class_active).removeClass(class_disabled);
        $('.product-item').show('slow');
      }
      function handleFilterProductCategory(el){
        let [class_active, class_disabled] = filterBtnThemeColors();
        let category = el.html();
  
        $(`.btn-filter-category`).removeClass(class_active).addClass(class_disabled);
  
        $('.product-item').each(function(){
          if($(this).attr('data-category') === category) $(this).show('slow');
          else $(this).hide('slow');
        });
  
        el.addClass(class_active).removeClass(class_disabled);
      }
    }    
  </script>
</div>