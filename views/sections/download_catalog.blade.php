<section id="download_catalog"  style="
  {{ innerStyleIssetAttr('order', $download_catalog, 'order', $default_order) }}
  {{ innerStyleIssetAttr('background', $download_catalog, 'background') }}
  {{ innerStyleIssetAttr('color', $download_catalog, 'color') }}
">
  <div class="newsletter py-4">
    <div class="container text-center" id="baixar-catalogo">
      <img src="{{ $download_catalog->image }}" alt="capa catalogo"/>
      <div class="d-flex flex-column justify-content-center text-start">
        <div class="mb-4 row d-flex justify-content-center">
          <div class="col-md-10">
            <h3 class="font-weight-bold">{{ $download_catalog->title ?? 'Baixar Catálogo' }}</h3>
            {{ $download_catalog->subtitle ?? 'Cadastre seu e-mail e receba nossas novidades' }}
          </div>
        </div>
        <form id="form-download-catalog">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-7 col-md-10 form-group mb-2">
              <input
                type="email"
                id="download_catalog-email"
                class="form-control email-newsletter"
                placeholder="Digite o email..."
                required
              >
            </div>
            <div class="col-lg-3 col-md-10 form-group">
              @if(
                isset($download_catalog->button) &&
                isset($download_catalog->button->background)
              )
                <style>
                  #download_catalog .btn-submit,
                  #download_catalog .btn-submit:hover{
                    background: #ffdddd44;
                    border: none;
                  }
                </style>
              @endif
              <button
                type="submit"
                class="btn btn-dark btn-block btn-newsletter btn-submit"
                style="
                  {{
                    isset($download_catalog->button) ? innerStyleIssetAttr(
                      'color',
                      $download_catalog->button,
                      'color'
                    ) : ''
                  }}
                "
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check2" style="margin-bottom: -4px;" viewBox="0 0 16 16">
                  <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"></path>
                </svg>
                {{
                  isset($download_catalog->button) && $download_catalog->button->text ? 
                  $download_catalog->button->text : 'Baixar'
                }}
              </button>
            </div>
            <div class="col-md-10">
              <div class="res-newsletter"></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>