<div id="who_we_are" style="
  {{ innerStyleIssetAttr('background', $who_we_are, 'background') }}
  {{ innerStyleIssetAttr('background-image', $who_we_are, 'wallpaper') }}
  {{ innerStyleIssetAttr('color', $who_we_are, 'text_color') }}
  @if(!isset($_GET['quem-somos']))
    display: none;
  @endif
">
  <div class="container py-5">
    <h2 class="text-center mb-4" style="
      {{ innerStyleIssetAttr('color', $who_we_are, ['title', 'color']) }}
      {{ innerStyleIssetAttr('font-size', $who_we_are, ['title', 'fontsize']) }}
    ">
      {{ handleVerifyAttrs($who_we_are,['title', 'text']) ?? 'Quem Somos' }}
    </h2>
    {!! $who_we_are->body !!}
  </div>
</div>