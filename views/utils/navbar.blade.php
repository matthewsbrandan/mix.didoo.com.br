<nav
  class="navbar navbar-expand-lg navbar-dark border-bottom" id="navbar"
  style="
    {{ innerStyleIssetAttr('background', $navbar, 'background', '#212529ff', null, true) }}
    {{ innerStyleIssetAttr('border-color', $navbar, 'border_color', '#343a40ff', null, true) }}
    border-width: 4px !important;
  "
>
  <style>
    #navbar .nav-link{ {!! innerStyleIssetAttr('color', $navbar, 'text_color', '#ffffff8c', null, true) !!} }
    #navbar .nav-item.active{ font-weight: bold; }
  </style>
  <div class="container">
    <!-- Toggle Mobile -->
    <button
      class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
      aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"
    ><span class="navbar-toggler-icon"></span></button>

    <!-- Itens Menu -->
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="d-flex justify-content-between w-100">
        <ul class="navbar-nav">
          <li class="nav-item @if(!isset($_GET['quem-somos'])) active @endif" id="btn-to-home-page">
            <a
              class="nav-link"
              href="javascript:;"
              onclick="handleToggleHomeAndWhoWeAre(true)"
              ondblclick="window.location.href='{{ route('home') }}';"
            >Página Inicial</a>
          </li>
          @isset($elements['who_we_are'])
            <li class="nav-item @if(isset($_GET['quem-somos'])) active @endif" id="btn-to-who-we-are">
              <a
                class="nav-link"
                href="javascript:;"
                onclick="handleToggleHomeAndWhoWeAre(false)"
                ondblclick="window.location.href='{{ route('home') }}?quem-somos';"
              >Quem Somos</a>
            </li>
          @endisset
          @isset($elements['testimonial'])
            <li class="nav-item ">
              <a
                class="nav-link"
                href="#depoimentos"
                onclick="handleToggleHomeAndWhoWeAre(true)"
              >Depoimentos</a>
            </li>
          @endisset
          @isset($elements['download_catalog'])
            <li class="nav-item ">
              <a
                class="nav-link"
                href="#baixar-catalogo"
                onclick="handleToggleHomeAndWhoWeAre(true)"
              >Baixar Catálogo</a>
            </li>
          @endisset
          @isset($elements['cms_blog'])
            <li class="nav-item ">
              <a class="nav-link" href="{{ route('blog.feed.index') }}">Blog</a>
            </li>
          @endisset
        </ul>
        <ul class="navbar-nav">
          @isset($elements['contact'])
            <li class="nav-item ">
              <a
                class="nav-link"
                href="{{ route('home') }}?contato"
              >Contato</a>
            </li>
          @endisset
          @if(isset($navbar->facebook) && $navbar->facebook)
            <li class="nav-item">
              <a
                class="nav-link"
                href="https://www.facebook.com/{{ $navbar->facebook }}"
                target="_blank"
              >
                @include('utils.icons.facebook',['icons' => (object)[
                  'color' => 'currentColor'
                ]])
              </a>
            </li>
          @endif
          @if(isset($navbar->instagram) && $navbar->instagram)
            <li class="nav-item">
              <a
                class="nav-link"
                href="https://www.instagram.com/{{ $navbar->instagram}}"
                target="_blank"
              >
                @include('utils.icons.instagram',['icons' => (object)[
                  'color' => 'currentColor'
                ]])
              </a>
            </li>
          @endif
          @if(isset($navbar->twitter) && $navbar->twitter)
            <li class="nav-item">
              <a 
                class="nav-link"
                href="https://twitter.com/{{ $navbar->twitter }}"
                target="_blank"
              >
                @include('utils.icons.twitter',['icons' => (object)[
                  'color' => 'currentColor'
                ]])
              </a>
            </li>
          @endif
        </ul>
      </div>
    </div>
  </div>
</nav>