@isset($title)
    <div class="panel">{{$title}}</div>
@endisset
<table class="table mb-4">
    <tr>
        <td class="p-0">
            <table>
                <tr>
                    <th>Message:</th>
                    <td>{{$exception->getMessage()}}</td>
                </tr>
                <tr>
                    <th>File:</th>
                    <td>{{$exception->getFile()}}:{{$exception->getLine()}}</td>
                </tr>
                <tr>
                    <th>Code:</th>
                    <td>{{$exception->getCode()}}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th>Stack Trace:</th>
    </tr>
    <tr>
        <td>
            {!! nl2br($exception->getTraceAsString()) !!}
        </td>
    </tr>
</table>
