<section id="cms_blog" style="
  {{ innerStyleIssetAttr('background-image', $cms_blog, 'wallpaper') }}
  {{ innerStyleIssetAttr('order', $cms_blog, 'order', $default_order) }}
">
  <div class="content" id="blog">
    <h2 class="titulo" style="
      {{ innerStyleIssetAttr('color', $cms_blog, ['title','color']) }}
    ">{{ $cms_blog->title->text ?? 'Blog' }}</h2>
    <div class="wrapper-blog">
      <div id="container-blog" style="{{ innerStyleIssetAttr('color', $cms_blog, ['title','color']) }}">
        <p class="text-loading texto">Carregando Posts...</p>
      </div>
      <button
        type="button"
        class="btn btn-left botao"
        style="{{ innerStyleIssetAttr('color', $cms_blog, 'button_arrow') }}"
        onclick="handleScrollNextOrPrevItem(false, 'container-blog', (15 + 1.6 + .4) * 16)"
      >@include('utils.icons.chevron_left')</button>
      <button
        type="button"
        class="btn btn-right botao"
        style="{{ innerStyleIssetAttr('color', $cms_blog, 'button_arrow') }}"
        onclick="handleScrollNextOrPrevItem(true, 'container-blog', (15 + 1.6 + .4) * 16)"
      >@include('utils.icons.chevron_right')</button>
    </div>
    <div class="group-buttons text-center">
      <a
        href="{{ route('blog.feed.index') }}"
        target="_blank"
        class="botao btn btn-danger btn-uppercase"
        style="
          @isset($cms_blog->button)
            {{ innerStyleIssetAttr('color', $cms_blog->button, 'color') }} 
            {{ innerStyleIssetAttr('background', $cms_blog->button, 'background') }}
          @endisset
        "
      >
        {{ isset($cms_blog->button) && isset($cms_blog->button->text) ? $cms_blog->button->text : 'Ver Blog' }}
      </a>
    </div>
  </div>
</section>