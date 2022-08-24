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
          <li class="nav-item active">
            <a class="nav-link" href="https://pocket.devrocket.com.br/">Página Inicial</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="https://pocket.devrocket.com.br/quem-somos">Quem Somos</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="https://pocket.devrocket.com.br/servicos">Depoimentos</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="https://pocket.devrocket.com.br/cardapio">Baixar Catálog</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="https://pocket.devrocket.com.br/noticias">Blog</a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item ">
            <a
              class="nav-link"
              href="https://pocket.devrocket.com.br/contato"
            >Contato</a>
          </li>
          @if(isset($navbar->facebook) && $navbar->facebook)
            <li class="nav-item">
              <a
                class="nav-link"
                href="https://www.facebook.com/{{ $navbar->facebook }}"
                target="_blank"
              ><i class="fab fa-facebook"></i> <span class="mobile">Facebook</span></a>
            </li>
          @endif
          @if(isset($navbar->instagram) && $navbar->instagram)
            <li class="nav-item">
              <a
                class="nav-link"
                href="https://www.instagram.com/{{ $navbar->instagram}}"
                target="_blank"
              ><i class="fab fa-instagram"></i> <span class="mobile">Instagram</span></a>
            </li>
          @endif
          @if(isset($navbar->twitter) && $navbar->twitter)
            <li class="nav-item">
              <a 
                class="nav-link"
                href="https://twitter.com/{{ $navbar->twitter }}"
                target="_blank"
              ><i class="fab fa-twitter"></i> <span class="mobile">Twitter</span></a>
            </li>
          @endif
        </ul>
      </div>
    </div>
  </div>
</nav>