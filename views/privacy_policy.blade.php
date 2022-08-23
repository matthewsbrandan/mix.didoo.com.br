@extends('layout.app')
@section('head')
  <link href="{{ asset('css/header.css') }}" rel="stylesheet"/>
  <style>
    .container{
      padding: 2rem;
      max-width: 1100px;
      margin: auto;
    }
  </style>
@endsection
@section('content')
  @include('layout.header',[
    'header' => isset($elements['navbar']) ? $elements['navbar'] : (object) [
      'logo' => $page_config->icon
    ],
    'header_config' => (object)[
      'back_to_home' => true
    ]
  ])
  <div class="container">
    {!! $elements['privacity_policy']->content !!}
  </div>
@endsection