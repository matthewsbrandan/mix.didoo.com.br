<header
  id="main-header"
  class="{{ $header_config->class_name ?? '' }}"
  style="
    {{ innerStyleIssetAttr('background', $header, 'background', '#212529ff', null, true) }}
  "
>
  <style>
    #main-header a{
      text-decoration: none;
      {!! innerStyleIssetAttr('color', $header, 'text_color', '#ffffff8c', null, true) !!}
    }
  </style>
  <nav class="nav">
    <a href="{{ route('home') }}" class="logo" style="
      height: 100%;
      display: flex;
      align-items: center;
    "><img src="{{ $page_config->icon }}"/></a>
    <button
      type="button"
      class="toggle-menu"
      onclick="toggleMainMenu($(this), $(this).next())"
      style="
        {{ innerStyleIssetAttr('color', $header, 'text_color') }}
      "
    >@include('utils.icons.menu')</button>
    <ul
      class="horizontal-list"
      style="
        {{ innerStyleIssetAttr('background', $header, 'background') }}
        {{ innerStyleIssetAttr('color', $header, 'text_color') }}
      "
    >
      @if(isset($header_config) && $header_config->back_to_home)
        <li><a href="{{ route('home') }}">Voltar</a></li>
      @else
        @include('layout.header-list',[
          'header_list_config' => (object)[
            'schedule_type' => 'button'
          ]
        ])
      @endif
    </ul>
  </nav>
  <script>
    function toggleMainMenu(elem, target){
      if(target.hasClass('show')) elem.html(`@include('utils.icons.menu')`);
      else elem.html(`@include('utils.icons.close')`);
      target.toggleClass('show');
      $('#main-header').toggleClass('show');
    }
    function toggleActiveMainMenu(target = null){
      $('#main-header .horizontal-list li').removeClass('active');
      if(target) target.addClass('active');
  
      if($('#main-header').hasClass('show')) $('#main-header .toggle-menu').click();
    }
  </script>
</header>