<div class="card"> {{-- CARD  --}}
  <div class="header"> {{-- HEADER --}}
    <img src="{{ $review->avatar }}" class="avatar"/>
    <div>
      <strong style="{{ innerStyle('color', $review->author->color) }}">{{ $review->author->text }}</strong>
      <em class="date" style="{{ innerStyle('color', $review->date->color) }}">{{ $review->date->text }}</em>
    </div>
  </div>
  <div class="stars" style="color: #f7b500">
    @for($i = 0; $i < 5; $i++)
      @if($i < $review->stars)
        @include('utils.icons.star', ['icon' => (object)['width' => '14px', 'height' => '14px']])
      @else
        @include('utils.icons.star_empty', ['icon' => (object)['width' => '14px', 'height' => '14px']])
      @endif
    @endfor
  </div>
  {{-- [ ] ADICIONAR FUNCIONALIDADE DE LER MAIS --}}
  <p class="description" style="
    {{ innerStyleIssetAttr('color', $review->description, 'color') }}
  ">{{ $review->description->text }}</p>
</div>