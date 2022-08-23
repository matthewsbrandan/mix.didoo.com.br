<section id="cms_blog" style="
  {{ innerStyle('color', $cms_blog->background) }}
  {{ innerStyleIssetAttr('order', $cms_blog, 'order', $default_order) }}
">
  <div class="content" id="blog">
    <h2 class="titulo" style="{{ innerStyle('color', $cms_blog->text_color) }}">{{ $cms_blog->title }}</h2>
    <div class="wrapper-blog">
      <div id="container-blog" style="{{ innerStyle('color', $cms_blog->text_color) }}">
        <p class="text-loading texto">Carregando Posts...</p>
      </div>
      <button
        type="button"
        class="btn btn-left botao"
        style="{{ innerStyle('color', $cms_blog->button->color).' '.innerStyle('background', $cms_blog->button->background) }}"
        onclick="handleScrollNextOrPrevItem(false, 'container-blog', (15 + 1.6 + .4) * 16)"
      >@include('utils.icons.chevron_left')</button>
      <button
        type="button"
        class="btn btn-right botao"
        style="{{ innerStyle('color', $cms_blog->button->color).' '.innerStyle('background', $cms_blog->button->background) }}"
        onclick="handleScrollNextOrPrevItem(true, 'container-blog', (15 + 1.6 + .4) * 16)"
      >@include('utils.icons.chevron_right')</button>
    </div>
    <div class="group-buttons">
      <a
        href="{{ route('blog.feed.index') }}"
        target="_blank"
        class="botao btn btn-primary btn-uppercase"
        style="
          {{ $cms_blog->button->background ? 'background: '.$cms_blog->button->background.';' : '' }}
          {{ $cms_blog->button->color ? 'color: '.$cms_blog->button->color.';' : '' }}
        "
      >Ver Blog</a>
    </div>
  </div>
</section>