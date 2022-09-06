@if(isset($elements['products']))
  <li><a href="{{ route('home') }}#produtos" onclick="toggleActiveMainMenu($(this).parent())" style="
    {{ $header_list_config->style ?? '' }}
  ">Produtos</a></li>
@endif
@isset($elements['who_we_are'])
  <li>
    <a
      href="{{ route('home') }}?quem-somos"
      style="{{ $header_list_config->style ?? '' }}"
    >Quem Somos</a>
  </li>
@endisset
@isset($elements['who_we_are'])
  <li>
    <a
      href="{{ route('home') }}#depoimentos"
      style="{{ $header_list_config->style ?? '' }}"
    >Depoimentos</a>
  </li>
@endisset
@isset($elements['download_catalog'])
  <li>
    <a
      href="{{ route('home') }}#baixar-catalogo"
      style="{{ $header_list_config->style ?? '' }}"
    >Baixar Catálogo</a>
  </li>
@endisset
@if(
  isset($elements['cms_blog']) && 
  isset($elements['cms_blog']->take)
)
  <li>
    <a
      href="{{ route('blog.feed.index') }}"
      style="{{ $header_list_config->style ?? '' }}"
    >Blog</a>
  </li>
@endif
<li>
  <a
    href="{{ route('home') }}#contato"
    style="{{ $header_list_config->style ?? '' }}"
  >Contato</a>
</li>