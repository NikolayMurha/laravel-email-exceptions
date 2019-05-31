@isset($title)
    <div class="panel">{{$title}}</div>
@endisset
<table class="mb-4">
    <tr>
        <td><strong>Message: </strong> {{$exception->getMessage()}}</td>
    </tr>
    <tr>
        <th>
            Stack Trace:
        </th>
    </tr>
    <tr>
        <td>
            {!! nl2br($exception->getTraceAsString()) !!}
        </td>
    </tr>
</table>
