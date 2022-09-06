@extends('layout.app')
@section('head')
  <link href="{{ asset('css/header.css') }}" rel="stylesheet"/>
  <style>
    .container{
      padding: 5.5rem 2rem 2rem;
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
      'back_to_home' => true,
      'class_name' => 'showing'
    ]
  ])
  <div class="container">
    {!! $elements['privacity_policy']->content !!}
  </div>
@endsection
@section('scripts')
  <!-- <script src="{{ asset('js/header.js') }}"></script> -->
@endsection