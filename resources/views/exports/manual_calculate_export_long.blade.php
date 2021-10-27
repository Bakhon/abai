<table style="width: 100%;">

    <tbody>
    @foreach($data['pipes'] as $key => $pipe)
        <tr>
            <th colspan="11">{{ 'Труба '.$pipe->oilPipe->name.', от '.$pipe->oilPipe->start_point.' до '.$pipe->oilPipe->end_point }}</th>
        </tr>
        <tr>
            @foreach($data['columnNames'] as $column)
                <th style="border: 1px solid black; height: 20px">{{ $column }}</th>
            @endforeach
        </tr>

        @foreach($pipe->oilPipe->hydroCalcLong as $key =>  $segment)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $segment->distance }}</td>
                <td>{{ $segment->pin }}</td>
                <td>{{ $segment->pout }}</td>
                <td>{{ $segment->tin }}</td>
                <td>{{ $segment->tout }}</td>
                <td>{{ $segment->ev }}</td>
                <td>{{ $segment->vliq }}</td>
                <td>{{ $segment->vgas }}</td>
                <td>{{ $segment->vm }}</td>
                <td>{{ $segment->comment }}</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="11"></td>
        </tr>
        <tr>
            <td colspan="11"></td>
        </tr>
    @endforeach
    </tbody>
</table>
