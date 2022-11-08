<section id="who_we_are" style="
  {{ innerStyleIssetAttr('background-image', $who_we_are, 'wallpaper') }}
  {{ innerStyleIssetAttr('color', $who_we_are, 'text_color') }}
  @if(!isset($_GET['quem-somos']))
    display: none;
  @endif
  position: relative;
">
  <div class="overlay" style="{{ innerStyleIssetAttr('background', $who_we_are, 'background') }}"></div>
  <div class="container py-5" style="z-index: 1; position: relative;">
    <h2 class="text-center mb-4" style="
      {{ innerStyleIssetAttr('color', $who_we_are, ['title', 'color']) }}
      {{ innerStyleIssetAttr('font-size', $who_we_are, ['title', 'fontsize']) }}
    ">
      {{ handleVerifyAttrs($who_we_are,['title', 'text']) ?? 'Quem Somos' }}
    </h2>
    {!! $who_we_are->body !!}
  </div>
</section>