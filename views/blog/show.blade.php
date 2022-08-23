<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BLOG FEED | CMS</title>
  <!-- Fonts -->
  <link rel="shortcut icon" href="{{ asset('favicon.png', true) }}" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('assets/css/global.css', true) }}" rel="stylesheet"/>
  <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
  <style>
    main{
      position: relative;
      max-width: 1200px;
      margin: 0 auto 3rem;
    }
    .empty{
      color: var(--gray-500);
    }
    /* BEGIN:: CONTAINER POST */
    .content-post{
      margin-bottom: 1rem;
    }
    .content-image{
      position: relative;
    }
    .post-wallpaper{
      height: 40vh;
      width: 100%;
      object-fit: cover;
      border-bottom-left-radius: .4rem;
      border-bottom-right-radius: .4rem;
      box-shadow: 0 0 30px #00000015;
      filter: brightness(.7);
    }
    .post-info .post-timestamp{
      font-size: .7rem;
      color: var(--gray-500);
      display: block;
      text-align: right;
    }
    .content-image .post-title{
      font-size: 2.6rem;
      line-height: 2.6rem;   
      max-width: 50rem;
      text-align: center;
      margin: auto;

      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      
      display: flex;
      justify-content: center;
      align-items: center;
      
      color: #fefefe;
    }
    .post-info .post-content{
      margin-top: 1rem;
      color: var(--gray-700);
    }
    /* END:: CONTAINER POST | BEGIN:: NAVBAR */
    .nav-bar{
      height: 3rem;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      max-width: calc(1200px - 4rem);
      margin: 0 auto;
      z-index: 1;
    }
    .nav-bar .content-image{
      height: 3rem;
    }
    .nav-bar .content-image .post-wallpaper{
      height: 3rem;
      transition: .3s;
    }
    .nav-bar .nav-info{
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      
      display: flex;
      justify-content: space-between;
      align-items: center;
      
      color: #fefefe;
    }
    .nav-bar .nav-info .nav-title{
      font-size: 1.6rem;
      line-height: 1.6rem;   
      max-width: 50rem;
      transition: .3s;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .nav-bar .nav-info a, .nav-bottom a{
      border: 1px solid var(--gray-200);
      padding: .2rem 1rem;
      border-radius: .4rem;
      margin: 0 .8rem;

      transition: .3s;
    }
    .nav-bar .nav-info a{
      background: #0017;
    }
    .nav-bar .nav-info a:hover, .nav-bottom a:hover{
      background: var(--primary-500);
    }
    .opacity-0{
      opacity: 0;
    }
    /* END:: NAV-BAR | BEGIN:: NAV-BOTTOM */
    .nav-bottom{
      display: flex;
      width: 100%;
      justify-content: space-between;
      color: var(--gray-700);
      position: relative;
    }
    .nav-bottom .prev-post span, .nav-bottom .next-post span{
      position: absolute;
      bottom: -1.6rem;
      opacity: 0;
      transition: .2s;
      max-width: 40%;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .nav-bottom .prev-post span{ left: .2rem; }
    .nav-bottom .next-post span{ right: .2rem; }
    .nav-bottom .prev-post:hover span{ opacity: 1; }
    .nav-bottom .next-post:hover span{ opacity: 1; }
    
    /* END:: NAV-BOTTOM | BEGIN:: CONTAINER OUTHER POSTS */
    .container-outher-posts{
      display: flex;
      overflow-x: auto;
      gap: 1rem;
      margin-top: 2rem;
    }
    .container-outher-posts .content-post{
      width: 23rem;
      min-width: 15rem;
    }
    .container-outher-posts .post-image{
      height: 13rem;
      width: 100%;
      object-fit: cover;
      border-radius: .4rem;
      box-shadow: 0 0 30px #00000015;
    }
    .container-outher-posts .post-info{
      max-height: 10.4rem;
      overflow: hidden;
    }
    .container-outher-posts .post-title{
      display: block;
      margin: .2rem 0;
      font-size: 1.4rem;
      line-height: 1.4rem;
      transition: .1s;
    }
    .container-outher-posts .post-title:hover{
      text-decoration: underline;
    }
    .container-outher-posts .post-timestamp{
      text-align: left;
    }
    .container-outher-posts .post-info .post-excerpt{
      margin-top: 0;
      color: var(--gray-700);
    }
    /* END:: CONTAINER OUTHER POSTS */
    @media (max-width: 1440px) {
      main{ padding: 0 2rem; }
    }
    @media (max-width: 1300px) {
      main{ padding: 0 3rem; }
    }
  </style>
  <script>
    function handleScrolling(event){
      let height = Number($('.post-title').css('height').replace('px',''));
      if($(document).scrollTop() >= height) {
        $('.nav-bar .nav-info .nav-title').removeClass('opacity-0');
        $('.nav-bar .content-image .post-wallpaper').removeClass('opacity-0');
      }else{
        $('.nav-bar .nav-info .nav-title').addClass('opacity-0');
        $('.nav-bar .content-image .post-wallpaper').addClass('opacity-0');
      }
    }
  </script>
</head>
<body class="antialiased" onScroll="handleScrolling(event)">
  <main>
    <nav class="nav-bar">
      <div class="content-image">
        <img src="{{ $post->wallpaper }}" class="post-wallpaper opacity-0" alt="{{ $post->title }}"/>
        <div class="nav-info">
          <a href="{{ route('blog.feed.index') }}">
            &larr;
          </a>
          <h1 class="nav-title  opacity-0">{{ $post->title }}</h1>
          <a href="#more">
            &plus;
          </a>
        </div>
      </div>
    </nav>
    <article class="content-post">
      <div class="content-image">
        <img src="{{ $post->wallpaper }}" class="post-wallpaper" alt="{{ $post->title }}"/>
        <h1 class="post-title">{{ $post->title }}</h1>
      </div>
      <div class="post-info">
        <time class="post-timestamp">
          {{ $post->date_formatted }}
        </time>
        <div class="post-content">{!! getContent($post->content) !!}</div>
      </div>
    </article>
    <section id="more">
      <div class="nav-bottom">
        @if($prevPost)
        <a class="prev-post" href="{{ route('blog.feed.show',['slug' => $prevPost->slug]) }}">
          Anterior
          <span>{{$prevPost->title}}</span>
        </a>
        @else <div></div> @endif
        @if($nextPost)
        <a class="next-post" href="{{ route('blog.feed.show',['slug' => $nextPost->slug]) }}">
          Próximo
          <span>{{$nextPost->title}}</span>
        </a>
        @else <div></div> @endif
      </div>
      <div class="container-outher-posts">
        @foreach($outhers as $index => $outher)
          <div class="content-post">
            <img src="{{ $outher->image }}" class="post-image" alt="{{ $outher->title }}"/>
            <div class="post-info">
              <a href="{{ route('blog.feed.show',['slug' => $outher->slug]) }}">
                <strong class="post-title">{{ $outher->title }}</strong>
              </a>
              <time class="post-timestamp">
                {{ $outher->date_formatted }}
              </time>
              <p class="post-excerpt">{{ $outher->excerpt }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </section>
    @include('blog.partials.comments')
  </main>
</body>
</html>