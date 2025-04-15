<section id="new_section" style="
  {{ innerStyleIssetAttr('background-image', $new_section, 'image') }}
  {{ innerStyleIssetAttr('order', $new_section, 'order', $default_order) }}
">
  <div class="content">
    <h2 class="titulo" style="
      {{ $new_section->text_color ? 'color: '.$new_section->text_color.';' : '' }}
      {{ innerStyleIssetAttr('font-size', $new_section, 'title_length') }}
    ">{{ $new_section->title }}</h2>
    <p class="description texto" style="
      {{ $new_section->text_color ? 'color: '.$new_section->text_color.';' : '' }}
      {{ innerStyleIssetAttr('font-size', $new_section, 'description_length') }}
    ">{!! $new_section->description !!}</p>
    <a
      href="{{ $new_section->button->link }}"
      target="_blank"
      class="botao btn btn-primary btn-uppercase"
      style="
        border: none !important;
box-shadow: none !important;
        {{ $new_section->button->background ? 'background: '.$new_section->button->background.';' : '' }}
        {{ $new_section->button->color ? 'color: '.$new_section->button->color.';' : '' }}
      "
    >{{ $new_section->button->text }}</a>
  </div>
  @if(isset($new_section->overlay) && $new_section->overlay)
    <div class="overlay" style="background: {{ $new_section->overlay }}"></div>
  @endif
</section>