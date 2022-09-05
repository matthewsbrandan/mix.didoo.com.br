<div class="newsletter pt-4 pb-3">
  <div class="container text-center">
    <div class="mb-4">
      <h3 class="font-weight-bold">Newsletter</h3>
      Cadastre seu e-mail e receba nossas novidades
    </div>
    <div class="row d-flex justify-content-center">
      <div class="col-lg-7 form-group">
        <input type="text" class="form-control email-newsletter">
      </div>
      <div class="col-lg-3 form-group">
        <button type="button" class="btn btn-primary btn-block btn-newsletter">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check2" style="margin-bottom: -4px;" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"></path>
          </svg>
          Cadastrar
        </button>
      </div>
      <div class="col-lg-10">
        <div class="res-newsletter"></div>
      </div>
    </div>
  </div>
</div>


<section id="download_catalog"  style="
  {{ innerStyleIssetAttr('order', $download_catalog, 'order', $default_order) }}
">
  <img src="{{ $download_catalog->image }}" alt="capa catalogo"/>
  <div class="content">
    <form id="form-download-catalog">
      <h2 class="titulo" style="
        {{ innerStyleIssetAttr('font-size', $download_catalog,'title_length') }}
      "
      >{{ $download_catalog->title }}</h2>
      <p class="texto" style="
        {{ innerStyleIssetAttr('font-size', $download_catalog,'subtitle_length') }}
      "
      >{{ $download_catalog->subtitle }}</p>
      <div class="form-control" style="{{ $download_catalog->border_color ? 'border-color: '.$download_catalog->border_color.';' : '' }}">
        <input type="text" name="name" id="download_catalog-name" placeholder="Nome" required/>
      </div>
      <div class="form-control" style="{{ $download_catalog->border_color ? 'border-color: '.$download_catalog->border_color.';' : '' }}">
        <input type="email" name="email" id="download_catalog-email" placeholder="Email" required/>
      </div>
      <div class="form-control" style="{{ $download_catalog->border_color ? 'border-color: '.$download_catalog->border_color.';' : '' }}">
        <input type="tel" name="whatsapp" id="download_catalog-whatsapp" placeholder="Whatsapp"/>
      </div>
      <button type="submit" class="botao btn btn-primary btn-uppercase"
        style="
          {{ $download_catalog->button->background ? 'background: '.$download_catalog->button->background.';' : '' }}
          {{ $download_catalog->button->color ? 'color: '.$download_catalog->button->color.';' : '' }}
        "
      >{{ $download_catalog->button->text }}</button>
    </form>
  </div>
</section>