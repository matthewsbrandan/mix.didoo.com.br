@extends('layout.app')
@section('head')
  <link href="{{ asset('css/menu.css') }}" rel="stylesheet"/>
  <link href="{{ asset('css/sections/products.css') }}" rel="stylesheet"/>
  <style>
    :root {
      --gray-50: #f0f6ff;
      --gray-100: #e2e8f0;
      --gray-200: #d1d7df;
      --gray-500: #99a;
      --gray-700: #747480;
      --dark-300: #33393f;
      --dark-500: #212529;
      --green-100: #03a06230;
      --green-500: #03a062;
      --green-800: #025e39;
      --red-500: #dc3545;
      --red-800: #842029;
      --orange-500: #fb6340;
      --primary-500: #5E72E4;
    }
    .wrapper-page{
      max-width: 1200px;
      margin: 0 auto 3rem;
    }
    h1{
      font-size: 3.2rem;
      margin-bottom: 1rem;
      margin-top: 4rem;
    }
    a,a:hover{ color: currentColor; }
    a:not(:hover){ text-decoration: none; }
    .empty{
      color: var(--gray-500);
    }
    .container-posts{
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.2rem;
    }
    .content-post{
      margin-bottom: 1rem;
    }
    .post-image{
      height: 13rem;
      width: 100%;
      object-fit: cover;
      border-radius: .4rem;
      box-shadow: 0 0 30px #00000015;
    }
    .post-info{
      max-height: 10.4rem;
      overflow: hidden;
    }
    .post-info .post-timestamp{
      font-size: .7rem;
      color: var(--gray-500);
      display: block;
    }
    .post-info .post-title{
      display: block;
      margin: .2rem 0;
      font-size: 1.4rem;
      line-height: 1.4rem;
      transition: .1s;
    }
    .post-title:hover{
      text-decoration: underline;
    }
    .post-info .post-excerpt{
      margin-top: 0;
      color: var(--gray-700);
    }
    .post-main{
      display: flex;
      width: 100%;
      gap: 1.6rem;
      margin-bottom: 2rem;
    }
    .post-main .post-image{
      height: 18rem;
      max-width: 32rem;
    }
    .post-main .post-info{
      max-width: 25rem;
      max-height: 16rem;
      margin: auto 0;
    }
    .post-main .post-info .post-title{
      font-size: 2.2rem;
      line-height: 2.2rem;
    }
    #more-posts{
      display: block;
      text-align: center;
      font-size: .8rem;
      color: var(--gray-700);
    }
    #more-posts:hover{
      text-decoration: underline;
      color: var(--dark-500);
    }
    @media (max-width: 1440px) {
      .wrapper-page{ padding: 0 2rem; }
    }
    @media (max-width: 1300px) {
      .wrapper-page{ padding: 0 3rem; }
    }
    @media (max-width: 1100px) {
      .container-posts{ grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 1000px) {
      .post-main{ flex-direction: column; }
      .post-main .post-image{
        width: 100%;
        max-width: 100%;
      }
      .post-main .post-info{
        max-width: 100%;
        max-height: 16rem;
        margin: auto 0;
      }
    }
    @media (max-width: 760px) {
      .container-posts{ grid-template-columns: 1fr; }
      .post-main{
        margin-bottom: 1rem;
        gap: .6rem;
      }
      .post-main .post-info .post-title{
        font-size: 1.4rem;
        line-height: 1.4rem;
      }
    }
    @media (max-width: 400px) {
      h1{ font-size: 10vw; }
    }
  </style>
@endsection
@section('content')
  @include('sections.menu',[
    'menu' => $elements['menu'],
    'code' => $elements['code'],
    'menu_options' => (object)[
      'hide' => ['search_box']
    ]
  ])
  @include('utils.navbar',[
    'navbar' => $elements['navbar']
  ])
  <div class="wrapper-page">
    <h1>BLOG FEED</h1>
    @if(count($posts) > 0)
    <div class="content-post post-main">
      <img src="{{ $posts[0]->image }}" class="post-image" alt="{{ $posts[0]->title }}"/>
      <div class="post-info">
        <a href="{{ route('blog.feed.show',['slug' => $posts[0]->slug]) }}">
          <strong class="post-title">{{ $posts[0]->title }}</strong>
        </a>
        <time class="post-timestamp">
          {{ $posts[0]->date_formatted }}
        </time>
        <p class="post-excerpt">{{ $posts[0]->excerpt }}</p>
      </div>
    </div>
    @else
      <p class="empty">Nenhuma publicação disponível.</p>
    @endif
    <div class="container-posts">
      @foreach($posts as $index => $post)
      @php if($index === 0) continue; @endphp
      <div class="content-post">
        <img src="{{ $post->image }}" class="post-image" alt="{{ $post->title }}"/>
        <div class="post-info">
          <a href="{{ route('blog.feed.show',['slug' => $post->slug]) }}">
            <strong class="post-title">{{ $post->title }}</strong>
          </a>
          <time class="post-timestamp">
            {{ $post->date_formatted }}
          </time>
          <p class="post-excerpt">{{ $post->excerpt }}</p>
        </div>
      </div>
      @endforeach
    </div>
    @if(count($posts) > 0)
    <a href="javascript: morePosts();" id="more-posts">carregar mais...</a>
    @endif
  </div>
@endsection
@section('scripts')
  <script>
    function handleToggleHomeAndWhoWeAre(){
      window.location.href = "{{ route('home') }}";
    }
    // BEGIN:: API URLS
    let tempPostsApiUrl = "{!! route('blog.feed.more',['skip' => 0]) !!}";
    const postsApiUrl = tempPostsApiUrl.substr(0, tempPostsApiUrl.length - 1);
    let tempShowPostApiUrl = "{!! route('blog.feed.show',['slug' => 0]) !!}";
    const showPostApiUrl = tempShowPostApiUrl.substr(0, tempShowPostApiUrl.length - 1);
    // END:: API URLS
    function morePosts(){
      let skip = $('.content-post').length;
      params = skip;

      $.ajax({
        url: postsApiUrl + params,
        headers: {"access-token": `{{ $cms_page_token }}`},
        method: "GET"
      }).done(function(data){
        if(data.result){
          if(data.response.posts.length === 0) $('#more-posts').remove();
          else data.response.posts.forEach(post => {
            handleAddPost(post);
          });
        }
      });
    }
    function handleAddPost(post){
      let html = `
        <div class="content-post">
          <img src="${ post.image }" class="post-image" alt="${ post.title }"/>
          <div class="post-info">
            <a href="${ showPostApiUrl }${ post.slug }">
              <strong class="post-title">${ post.title }</strong>
            </a>
            <time class="post-timestamp">
              ${ post.date_formatted }
            </time>
            <p class="post-excerpt">${ post.excerpt }</p>
          </div>
        </div>
      `;
      $('.container-posts').append(html);
    }
  </script>
@endsection