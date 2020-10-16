<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Users albums gallery">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'My site')</title>

    <!-- Core CSS -->
    <link rel="stylesheet" href="/css/app.css">
    <!-- Boostrap Javascript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

    <link href="/css/lightbox.css" rel="stylesheet" />

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

    </style>

  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" style="color:blue;" href="#">ABM</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{route('home')}}">Home <span class="sr-only">(current)</span></a>
      </li>
      @if (Auth::check() && Auth::user()->email_verified_at)           
          <li class="nav-item">
            <a class="nav-link" href="{{route('albums')}}">Albums</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('album.create')}}">New Album</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('photos.create')}}">New Photo</a>
          </li>
          <li class="nav-item">
            <a href="{{route('categories.index')}}" class="nav-link">Categories</a>
          </li>
        @endif
    </ul>
       <ul class="navbar-nav ml-auto">
         @guest
          <li class="nav-item">
            <a class="nav-link" href="{{route('login')}}">{{ __('Login') }}</a>
          </li>
          {{-- @if (Route::has('Register')) --}}
          <li class="nav-item">
            <a class="nav-link" href="{{route('register')}}">{{ __('Register') }}</a>
          </li>
       {{--    @endif --}}
        @else
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              <span style='color:greenyellow'>
                <i class="fas fa-user-check"></i> 
              </span>
              {{ __('messages.welcome', ['name' => Auth::user()->name]) }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                 <span style='color:red'>
                                  <i class="fas fa-user-times"></i>
                                </span>
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                @if (Auth::user()->isAdmin())             
                <a class="dropdown-item" href="{{route('admin')}}">Admin dash</a>            
              @endif
            </div>
          </li>  
          
        @endguest
       </ul>

{{--     <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form> --}}
  </div>
</nav>

<main role="main" class="container">

    @yield('content')


</main><!-- /.container -->

@section('footer')
 
<script src="/js/lightbox.min.js"></script>
@show
 </body>
</html>
