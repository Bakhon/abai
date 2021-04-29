<table style="width: 100%;">
    <thead>
    <tr>
        @foreach($data['columnNames'] as $item)
        <th style="border: 1px solid black; height: 20px">{{ $item }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data['results'] as $key => $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->oilPipe->pipeType->outside_diameter }}</td>
        <td>{{ $item->oilPipe->pipeType->thickness  }}</td>
        <td>{{ $item->length }}</td>
        <td>{{ $item->qliq }}</td>
        <td>{{ $item->bsw }}</td>
        <td>{{ $item->gazf }}</td>
        <td>{{ $item->press_start }}</td>
        <td>{{ $item->press_end }}</td>
        <td>{{ $item->temperature_start }}</td>
        <td>{{ $item->temperature_end }}</td>
        <td>{{ $item->start_point }}</td>
        <td>{{ $item->end_point }}</td>
        <td>{{ $item->oilPipe->name }}</td>
        <td>{{ $item->mix_speed_avg }}</td>
        <td>{{ $item->fluid_speed }}</td>
        <td>{{ $item->gaz_speed }}</td>
        <td>{{ $item->flow_type }}</td>
        <td>{{ $item->press_change }}</td>
        <td>{{ $item->break_qty }}</td>
        <td>{{ $item->height_drop }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
