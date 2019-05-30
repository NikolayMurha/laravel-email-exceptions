@extends('laravel-email-exceptions::layout')

@section('content')
    <div class="panel">
        There has been an exception thrown on {{link_to($appUrl)}}
    </div>
    <table class="summary">
        <tr>
            <td>
                <h2>Application</h2>
                {{$appName}}
            </td>
        </tr>
        <tr>
            <td>
                <h2>Environment</h2>
                {{$appEnv}}
            </td>
        </tr>
        <tr>
            <td>
                <h2>File</h2>
                {{$exception->getFile()}}
            </td>
        </tr>
        <tr>
            <td>
                <h2>Type</h2>
                {{ get_class($exception) }}
            </td>
        </tr>
    </table>

    @include('laravel-email-exceptions::exception', ['exception'=>$exception])

    @if($environment)
        <table>
            <tr>
                <th colspan="2">Environment</th>
            </tr>
            <tr>
                <th>Variable</th>
                <th>Value</th>
            </tr>
            @foreach($environment as $var => $value)
                <tr>
                    <td> {{$var}}</td>
                    <td>{{$value}} </td>
                </tr>
            @endforeach
        </table>
    @endif

    @if($request)
        <table>
            <tr>
                <th colspan="2">Request</th>
            </tr>
            <tr>
                <th>Variable</th>
                <th>Value</th>
            </tr>
            @foreach($request as $var => $value)
                <tr>
                    <td> {{$var}}</td>
                    <td>{{$value}} </td>
                </tr>
            @endforeach
        </table>
    @endif

    {{--    @if($previousExceptions)--}}
    {{--        @component('mail::panel')--}}
    {{--            Previous exceptions--}}
    {{--        @endcomponent--}}
    {{--        @each('laravel-email-exceptions::exception', $previousExceptions, 'exception')--}}
    {{--    @endif--}}
@endsection
