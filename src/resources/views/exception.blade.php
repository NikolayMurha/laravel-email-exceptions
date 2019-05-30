@component('mail::panel')
    {{$exception->getMessage()}}
@endcomponent
{{nl2br($exception->getTraceAsString())}}

