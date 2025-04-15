<section id="text_divider" style="
  {{ innerStyleIssetAttr('background-image', $text_divider, 'image') }}
  {{ innerStyleIssetAttr('order', $text_divider, 'order', $default_order) }}
">
  <div class="content" style="background: {{ $text_divider->background }}">
    <h2 class="titulo"style="
      {{ $text_divider->text_color ? 'color: '.$text_divider->text_color.';' : '' }}
      {{ innerStyleIssetAttr('font-size', $text_divider, 'title_length') }}
    ">
    {{ $text_divider->title }}
    </h2>

    <p class="texto" style="
      {{ $text_divider->text_color ? 'color: '.$text_divider->text_color.';' : '' }}
      {{ innerStyleIssetAttr('font-size', $text_divider, 'description_length') }}
    ">
    {{ $text_divider->description }}
    </p>

    <a
      href="{{ $text_divider->button->link }}"
      target="_blank"
      class="botao btn btn-primary btn-uppercase"
      style="
        border: none !important;
box-shadow: none !important;
        {{ $text_divider->button->background ? 'background: '.$text_divider->button->background.';' : '' }}
        {{ $text_divider->button->color ? 'color: '.$text_divider->button->color.';' : '' }}
      "
    >{{ $text_divider->button->text }}</a>
  </div>
  @if(isset($text_divider->overlay) && $text_divider->overlay)
    <div class="overlay" style="background: {{ $text_divider->overlay }}"></div>
  @endif
</section>