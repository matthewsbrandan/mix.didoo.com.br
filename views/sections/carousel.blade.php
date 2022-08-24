<div id="carousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    @foreach($carousel->items as $i => $item)
      <div class="carousel-item carousel-item-banners banner-link {{ $i == 0 ? 'active' : '' }}">
        <a href="{{ $item->link }}">
          <img 
            class="d-block w-100"
            src="{{ $item->src }}"
            alt="{{ $item->legend }}"
          >
        </a>
      </div>
    @endforeach
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Próximo</span>
  </button>
</div>