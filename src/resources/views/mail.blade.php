@component('mail::message')
    @component('mail::panel')
        There has been an exception thrown on {{link_to($appUrl)}}
    @endcomponent
    @component('mail::table')
        |------------------|------------------------------------|
        | Application      |          {{$appName}}              |
        |------------------|------------------------------------|
        | Environment      |          {{$appEnv}}               |
        |------------------|------------------------------------|
        | File             |         {{$e->getFile()}}          |
        |------------------|------------------------------------|
        | Type             |     {{ get_class($exception) }}    |
        |------------------|------------------------------------|
    @endcomponent
    @include('laravel-email-exceptions::exception', ['exception'=>$exception])

    @if($environment)
        @component('mail::panel')
            Environment
        @endcomponent
        @component('mail::table')
            |   Variable    |        Value      |
            |----------------|------------------|
            @foreach($environment as $var => $value)
                |    {{$var}}    |   {{$value}}     |
                |----------------|------------------|
            @endforeach
        @endcomponent
    @endif

    @if($request)
        @component('mail::panel')
            Request
        @endcomponent
        @component('mail::table')
            |   Variable    |        Value      |
            |----------------|------------------|
            @foreach($request as $var => $value)
                |    {{$var}}    |   {{print_r($value, true)}}  |
                |----------------|------------------|
            @endforeach
        @endcomponent
    @endif

    @if($previousExceptions)
        @component('mail::panel')
            Previous exceptions
        @endcomponent
        @each('laravel-email-exceptions::exception', $previousExceptions, 'exception')
    @endif
@endcomponent
