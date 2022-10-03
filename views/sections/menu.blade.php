<div id="menu" style="
  {{ innerStyleIssetAttr('background', $menu, 'background', 'transparent', null, true) }}
  {{ innerStyleIssetAttr('color', $menu, 'text_color', '#212529', null, true) }}
">
  <style>
    @media (max-width: 767px) {
      #menu .search-box, #menu .search-box .input-group{
        width: 100%;
        max-width: 100% !important;
      }
    }
  </style>
  <div class="container">
    <div class="d-flex align-items-center justify-content-between flex-column flex-md-row pt-4 pb-4">
      <div class="logo-box">
        <a href="{{ route('home') }}">
          <img src="{{ $menu->logo }}" class="image-logo" alt="{{ $menu->alt_image ?? 'Logo do site' }}">
        </a>
      </div>
      <div class="search-box mt-4 mt-md-0">
        @if(isset($elements) &&
          isset($elements['products']) &&
          isset($elements['products']->items) && 
          count($elements['products']->items) > 0 && !(
            isset($menu_options) && isset($menu_options->hide) && (
              in_array('search_box', $menu_options->hide)
            )
          )
        )
          <form onSubmit="handleSearch(event)" id="form-search">
            <div class="input-group" style="max-width: 18rem;"s>
              <input
                type="text"
                id="input-search"
                class="form-control form-control-lg"
                placeholder="Pesquise aqui..."
                aria-label="Pesquise aqui..."
                onkeyup="handleFilterProducts($(this))"
              >
              <div class="input-group-text" style="
                border-top-right-radius: .5rem;
                border-bottom-right-radius: .5rem;
              ">
                <button
                  class="btn mb-2 p-0 btn-search"
                  type="button"
                  onclick="$(this).parent().prev().focus()"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" style="margin-bottom: -3px;"
                    fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path
                      d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z">
                    </path>
                  </svg>
                </button>
              </div>
              <div class="invalid-feedback">Nenhum produto encontrado</div>
            </div>
          </form>
        @endif
      </div>
      <div class="contact-box text-end d-lg-block d-none">
        @isset($menu->phone) <strong>Celular</strong>: {{ $menu->phone }}<br> @endisset
        @isset($menu->email) <strong>E-mail</strong>: {{ $menu->email }} @endisset
      </div>
    </div>
  </div>
  <script>
    function handleSearch(event){
      event.preventDefault();
      let search = $('#input-search').val();
    }
  </script>
</div>