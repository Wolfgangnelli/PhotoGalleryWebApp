@extends('templates.default')

@section('title', 'Blog')

@section('content')
    <h1>BLOG</h1>
    
    @component('components.card', [
        'img_title' => 'Image blog',
        'img_url' => 'http://lorempixel.com/400/200'
    ])
        <p>This is a beautiful image i took in New York</p>
    @endcomponent

    @component('components.card')
      @slot('img_title', 'Image blog2')
      @slot('img_url', 'http://lorempixel.com/400/200')
        
      <p>This is a beautiful image i took in Paris</p>

    @endcomponent
    
  {{--   @include('components.card', [
        'img_title' => 'Image blog',
        'img_url' => 'http://lorempixel.com/400/200',
        'slot' => ''
    ]) --}}

    <div>
        <x-alert class="text-muted" style="color:yellow" :name="$name" :info="'danger'" :message="'Helloooo'"/>
      </div>

      <div>
          <x-logo>
              <p>Logoooo</p>
          </x-logo>
      </div>

      {{-- div>
          <x-alert>
              @slot('name', $name)
              @slot('info', 'danger')
              @slot('message', 'Hello with slot')
          </x-alert>
      </div> --}}
@endsection

@section('footer')
    @parent

@stop
    
