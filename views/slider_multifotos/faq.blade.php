<section id="faq" style="
  {{ innerStyleIssetAttr('background-image', $faq, 'image') }}
  {{ innerStyleIssetAttr('order', $faq, 'order', $default_order) }}
">
  <div class="content" style="background: {{ $faq->background }}">
    <h2 class="titulo" style="
      {{ $faq->text_color ? 'color: '.$faq->text_color.';' : '' }}
      {{ innerStyleIssetAttr('font-size', $faq, 'title_length') }}
    ">
      {{ $faq->title }}
    </h2>
    <style>
      .icon-toggler{
        {{ innerStyle('color',$faq->answer_color) }}
      }
    </style>
    <ul>
      @foreach($faq->questions as $i => $question)
        <li style="
          {{ innerStyleIssetAttr('font-size', $faq, 'description_length') }}
        ">
          <strong 
            onclick="$(this).next().toggle('slow'); toggleIconPlusMinus($(this).children('.icon-toggler'))"
            style="{{ $faq->text_color ? 'color: '.$faq->text_color.';' : '' }}"
          >
            @if($i === 0)
              <span class="icon-toggler icon-minus">@include('utils.icons.minus')</span>
            @else
              <span class="icon-toggler icon-plus">@include('utils.icons.plus')</span>
            @endif
            {{ $question->title }}
          </strong>
          <p class="texto" style="
            {{ $i > 0 ? 'display: none; ':'' }}
            {{ $faq->answer_color ? 'color: '.$faq->answer_color.';' : '' }}
          ">{{ $question->description }}</p>
        </li>
      @endforeach
    </ul>
  </div>
  @if(isset($faq->overlay) && $faq->overlay)
    <div class="overlay" style="background: {{ $faq->overlay }}"></div>
  @endif
</section>