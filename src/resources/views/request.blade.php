@if($request)
    <div class="panel">Request</div>
    <div class="sub-panel">Get</div>
    @if(Request::query())
        <table class="table mb-4">
            <tr>
                <th>Variable</th>
                <th>Value</th>
            </tr>
            @foreach(Request::query() as $var => $value)
                <tr>
                    <th class="no-wrap"> {{$var}}</th>
                    <td>{{$value}} </td>
                </tr>
            @endforeach
        </table>
    @else
        Empty
    @endif
    <div class="sub-panel">Post</div>
    @if(Request::post())
        <table class="table mb-4">
            <tr>
                <th>Variable</th>
                <th>Value</th>
            </tr>
            @foreach(Request::post() as $var => $value)
                <tr>
                    <th class="no-wrap"> {{$var}}</th>
                    <td>{{$value}} </td>
                </tr>
            @endforeach
        </table>
    @else
        Empty
    @endif

    @if(Request::header())
        <div class="sub-panel">Headers</div>
        <table class="table mb-4">
            <tr>
                <th>Variable</th>
                <th>Value</th>
            </tr>
            @foreach(Request::header() as $var => $value)
                <tr>
                    <th class="no-wrap"> {{$var}}</th>
                    <td>{{implode(';', $value)}} </td>
                </tr>
            @endforeach
        </table>
    @else
        Empty
    @endif
@endif
