@isset($elements['service'])
  <li><a href="#servicos" onclick="toggleActiveMainMenu($(this).parent())" style="
    {{ $header_list_config->style ?? '' }}
  ">Serviços</a></li>
@endisset
@isset($elements['who_we_are'])
  <li><a href="#sobre" onclick="toggleActiveMainMenu($(this).parent())" style="
    {{ $header_list_config->style ?? '' }}
  ">Sobre</a></li>
@endisset
@if(
    isset($elements['cms_catalog']) && 
    isset($elements['cms_catalog']->api_url) &&
    isset($elements['cms_catalog']->origin)
)
  <li><a href="#produtos" onclick="toggleActiveMainMenu($(this).parent())" style="
    {{ $header_list_config->style ?? '' }}
  ">Produtos</a></li>
@endif
@isset($elements['cms_gallerys'])
  <li>
    <a href="#galeria" onclick="toggleActiveMainMenu($(this).parent())" style="
      {{ $header_list_config->style ?? '' }}
    ">Galeria</a>
  </li>
@endisset
@if(
  isset($elements['cms_blog']) && 
  isset($elements['cms_blog']->take)
)
  <li>
    <a href="#blog" onclick="toggleActiveMainMenu($(this).parent())" style="
      {{ $header_list_config->style ?? '' }}
    ">Blog</a>
  </li>
@endif
<li>
  <a href="#contato" onclick="toggleActiveMainMenu($(this).parent())" style="
    {{ $header_list_config->style ?? '' }}
  ">Contato</a>
</li>
@isset($elements['schedule'])
  @if(
    isset($header_list_config) && 
    isset($header_list_config->schedule_type) &&
    $header_list_config->schedule_type == 'button'
  )
    <a  
      href="#agendar"
      onclick="toggleActiveMainMenu()"
      class="botao btn btn-primary"
      style="
        {{ $header->button_background ? 'background: '.$header->button_background.';': '' }}
        {{ $header->button_color ? 'color: '.$header->button_color.';': '' }}
      "
    >Agendar Horário</a>
  @else
    <li><a href="#agendar" onclick="toggleActiveMainMenu($(this).parent())" style="
      {{ $header_list_config->style ?? '' }}
    ">Agendar Horário</a></li>
  @endif
@endisset