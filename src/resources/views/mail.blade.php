@extends('laravel-email-exceptions::layout')

@section('content')
    <div class="panel">
        There has been an exception thrown on {{link_to($appUrl)}}
    </div>
    <table class="table mb-4">
        <tr>
            <th>Application</th>
            <td>{{$appName}}</td>
        </tr>
        <tr>
            <th>Environment</th>
            <td>{{$appEnv}}</td>
        </tr>
        <tr>
            <th>File</th>
            <td>{{$exception->getFile()}}</td>
        </tr>
        <tr>
            <th>Type</th>
            <td>{{ get_class($exception) }}</td>
        </tr>
    </table>

    @include('laravel-email-exceptions::exception', ['exception'=>$exception, 'title'=> "Exception"])
    @include('laravel-email-exceptions::env')
    @include('laravel-email-exceptions::request')

    @if($allExceptions)
        <div class="panel">Previous exceptions</div>
        @each('laravel-email-exceptions::exception', $allExceptions, 'exception')
    @endif
@endsection
