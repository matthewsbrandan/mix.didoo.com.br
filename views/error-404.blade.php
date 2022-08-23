<?php
  if(!isset($page_config)) $page_config = (object)[
    'icon' => asset('favicon.png', true),
    'title' => 'Erro 404'
  ];
?>
@extends('layout.app')
@section('head')
  <style>
    main{
      max-width: 1200px;
      min-height: calc(100vh - 3rem);
      margin: 0 auto 3rem;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    h1{
      font-size: 3.2rem;
      margin-bottom: 0;
    }
    @media (max-width: 1440px) {
      main{ padding: 0 2rem; }
    }
    @media (max-width: 1300px) {
      main{ padding: 0 3rem; }
    }
    @media (max-width: 400px) {
      h1{ font-size: 10vw; }
    }
  </style>
@endsection
@section('content')
  <h1>404</h1>
  <p>Página não encontrada</p>
@endsection