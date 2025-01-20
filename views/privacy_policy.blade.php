@extends('layout.app')
@section('head')
  <link href="{{ asset('css/menu.css') }}" rel="stylesheet"/>
  <style>
    #privacy-policy{
      padding: 3.5rem 2rem 2rem;
      max-width: 1100px;
      margin: auto;
    }
  </style>
@endsection
@section('content')
  @include('sections.menu',[
    'code' => $elements['code'],
    'menu' => $elements['menu'],
    'menu_options' => (object)[
      'hide' => ['search_box']
    ]
  ])
  @include('utils.navbar',[
    'navbar' => $elements['navbar']
  ])
  <div class="container" id="privacy-policy">
    {!! $elements['privacity_policy']->content !!}
  </div>
@endsection
@section('scripts')
  <script>
    function handleToggleHomeAndWhoWeAre(){
      window.location.href = "{{ route('home') }}";
    }
  </script>
@endsection