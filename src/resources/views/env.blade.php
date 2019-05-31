@if($environment)
    <div class="panel">
        Environment
    </div>
    <table class="table mb-4">
        <tr>
            <th>Variable</th>
            <th>Value</th>
        </tr>
        @foreach(getenv() as $var => $value)
            <tr>
                <th class="no-wrap">{{$var}}</th>
                <td>{{$value}} </td>
            </tr>
        @endforeach
    </table>
@endif
