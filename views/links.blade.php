@extends('layout.app')
@section('head')
  <link href="{{ asset('css/header.css') }}" rel="stylesheet"/>
  <style>
    main{ overflow: hidden; }
    .container{
      padding: 2rem;
      overflow: auto;
      position: relative;
      background-size: cover;
      background-position-x: center;
      height: 100vh;
      width: 100vw;
    }
    .content > div{
      max-width: 800px;
      margin: auto;
    }
    .image {
      border-radius: .6rem;
      object-fit: cover;
    }
  </style>
@endsection
@section('content')
  <div class="container" style="
    {{ innerStyle('background-image', $links->background) }}
  ">
    <div class="content" style="z-index: 1; position: relative;">
      <div>
        <img src="{{ $links->logo }}" class="image" alt="logo" style="
          width: 10rem;
          margin: auto auto .4rem;
          display: block;
        "/>
        @foreach($links->links as $link)
          <a href="{{ $link->link }}" target="_blank">
            <img src="{{ $link->image }}" class="image" alt="link" style="
              width: 100%;
              height: 15rem;
              margin: .4rem 0;
            "/>
          </a>
        @endforeach
      </div>
    </div>
    <div class="overlay" style="background: {{ $links->overlay }}; position: fixed;"></div>
  </div>
@endsection