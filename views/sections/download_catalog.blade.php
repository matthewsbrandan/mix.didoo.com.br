<section id="download_catalog"  style="
  {{ innerStyleIssetAttr('order', $download_catalog, 'order', $default_order) }}
  {{ innerStyleIssetAttr('background', $download_catalog, 'background') }}
  {{ innerStyleIssetAttr('color', $download_catalog, 'color') }}
">
  <div class="newsletter py-4">    
    <div class="container text-center" id="baixar-catalogo">
      <div>
        @if (
          (isset($download_catalog->pdf_url_2) && $download_catalog->pdf_url_2->src) ||
          (isset($download_catalog->pdf_url_3) && $download_catalog->pdf_url_3->src) ||
          (isset($download_catalog->pdf_url_4) && $download_catalog->pdf_url_4->src) ||
          (isset($download_catalog->pdf_url_5) && $download_catalog->pdf_url_5->src)
        )
          <div style="
            margin-bottom: 1rem;
            {{ innerStyleIssetAttr('background', $download_catalog->selection_box, 'background', '#fff2') }}
            {{ innerStyleIssetAttr('color', $download_catalog->selection_box, 'color') }}
            padding: .5rem 1rem .8rem;
          ">
            <style>
              #download_catalog .catalog_option{ padding: 0; }
              #download_catalog .catalog_option.active{
                border: 3px solid {{ isset($download_catalog->color) ? $download_catalog->color : '#000' }};
              }
            </style>
            <strong style="font-weight: 600;display: block;margin-bottom: .4rem;text-align: left;font-size: .9rem;">
              Selecione o Catálogo que deseja baixar:
            </strong>
          
            <div style="display: flex; gap: .4rem; overflow-x: auto;">
              <button type="button" class="catalog_option active" onClick="toggleCatalogToDownload('1')" data-variation="1">
                <img
                  src="{{ $download_catalog->image }}"
                  alt="capa catalogo"
                  style="width: 8rem; height: 6rem; object-fit: cover;"
                />
              </button>
              @if(isset($download_catalog->pdf_url_2) && $download_catalog->pdf_url_2->src)
                <button type="button" class="catalog_option" onClick="toggleCatalogToDownload('2')" data-variation="2">
                  <img src="{{ $download_catalog->pdf_url_2->src }}" alt="catálogo 2" style="width: 8rem; height: 6rem; object-fit: cover;"/>
                </button>
              @endif
              @if(isset($download_catalog->pdf_url_3) && $download_catalog->pdf_url_3->src)
                <button type="button" class="catalog_option" onClick="toggleCatalogToDownload('3')" data-variation="3">
                  <img src="{{ $download_catalog->pdf_url_3->src }}" alt="catálogo 3" style="width: 8rem; height: 6rem; object-fit: cover;"/>
                </button>
              @endif
              @if(isset($download_catalog->pdf_url_4) && $download_catalog->pdf_url_4->src)
                <button type="button" class="catalog_option" onClick="toggleCatalogToDownload('4')" data-variation="4">
                  <img src="{{ $download_catalog->pdf_url_4->src }}" alt="catálogo 4" style="width: 8rem; height: 6rem; object-fit: cover;"/>
                </button>
              @endif
              @if(isset($download_catalog->pdf_url_5) && $download_catalog->pdf_url_5->src)
                <button type="button" class="catalog_option" onClick="toggleCatalogToDownload('5')" data-variation="5">
                  <img src="{{ $download_catalog->pdf_url_5->src }}" alt="catálogo 5" style="width: 8rem; height: 6rem; object-fit: cover;"/>
                </button>
              @endif
            </div>
          </div>
        @endif
        <img src="{{ $download_catalog->image }}" alt="capa catalogo" id="catalog_wallpaper" style="
          width: 100%;
          object-fit: cover;
        "/>
      </div>

      <div class="d-flex flex-column justify-content-center text-start">
        <div class="mb-4 row d-flex justify-content-center">
          <div class="col-md-10">
            <h3 class="font-weight-bold">{{ $download_catalog->title ?? 'Baixar Catálogo' }}</h3>
            {{ $download_catalog->subtitle ?? 'Cadastre seu e-mail e receba nossas novidades' }}
          </div>
        </div>
        <form id="form-download-catalog">
          <div class="mb-4 row d-flex justify-content-center">
            <div class="col-md-10">
              <div class="form-group mb-2">
                <input
                  type="text"
                  id="download_catalog-name"
                  class="form-control email-newsletter"
                  placeholder="Digite o seu nome..."
                  required
                >
              </div>
              <div class="form-group mb-2">
                <input
                  type="tel"
                  id="download_catalog-whatsapp"
                  class="form-control email-newsletter"
                  placeholder="Digite o whatsapp..."
                  required
                >
              </div>
              <div class="form-group mb-2">
                <input
                  type="email"
                  id="download_catalog-email"
                  class="form-control email-newsletter"
                  placeholder="Digite o email..."
                  required
                >
              </div>
              <div class="form-group">
                @if(
                  isset($download_catalog->button) &&
                  isset($download_catalog->button->background)
                )
                  <style>
                    #download_catalog .btn-submit,
                    #download_catalog .btn-submit:hover{
                      background: #ffdddd44;
                      border: none !important;
                      box-shadow: none !important;
                    }
                  </style>
                @endif
                <button
                  type="submit"
                  class="btn btn-dark btn-block btn-newsletter btn-submit"
                  style="
                    {{
                      isset($download_catalog->button) ? (
                        innerStyleIssetAttr(
                          'color', $download_catalog->button, 'color'
                        ) . ' ' . innerStyleIssetAttr(
                          'background', $download_catalog->button, 'background'
                        )
                      ): ''
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