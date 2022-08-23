@extends('layout.app')
  <link href="{{ asset('assets/css/global.css', true) }}" rel="stylesheet"/>
  <style>
    main{
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      width: 100vw;

      background: var(--primary-500);
    }
    img{
      width: 8rem;
      height: 8rem;
      object-fit: cover;
    }
    p{
      text-align: center;
      color: var(--gray-50);
    }
  </style>
@section('head')
@endsection
@section('content')
  <img src="{{ asset('favicon.png', true) }}" alt="Logo"/>
  <p>Conheça o nosso CMS e crie seu site.</p>
  <a href="{{ $cms_url }}" class="botao btn btn-gray" target="_blank">
    Crie seu site
  </a>
@endsection