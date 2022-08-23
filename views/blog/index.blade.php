<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BLOG | {{ $page_config->title ?? 'CMS' }}</title>
  <!-- Fonts -->
  <link rel="shortcut icon" href="{{ $page_config->icon ?? '' }}" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/css/global.css', true) }}" rel="stylesheet"/>
  <link href="{{ asset('css/header.css') }}" rel="stylesheet"/>
  <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
  <style>
    main{
      max-width: 1200px;
      margin: 0 auto 3rem;
    }
    h1{
      font-size: 3.2rem;
      margin-bottom: 1rem;
      margin-top: 6rem;
    }
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
      main{ padding: 0 2rem; }
    }
    @media (max-width: 1300px) {
      main{ padding: 0 3rem; }
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
</head>
<body class="antialiased">
  <main>
    @include('layout.header',[
      'header' => isset($elements['navbar']) ? $elements['navbar'] : (object) [
        'logo' => $page_config->icon
      ],
      'header_config' => (object)[
        'back_to_home' => true,
        'class_name' => 'showing'
      ]
    ])
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
  </main>
  <script>
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
</body>
</html>