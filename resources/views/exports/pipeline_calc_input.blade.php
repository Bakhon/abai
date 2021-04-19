<table style="width: 100%;">
    <thead>
    <tr>
        @foreach($data['columnNames'] as $item)
            <th style="border: 1px solid black; height: 20px">{{ $item }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data['points'] as $key => $item)
        @if($item->gu OR $item->trunkline_end_point)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->map_pipe->pipeType->outside_diameter }}</td>
                <td>{{ $item->map_pipe->pipeType->thickness  }}</td>
                <td>{{ $item->map_pipe->lastCoords->m_distance }}</td>
                <td>{{ $item->lastOmgngdu ? $item->lastOmgngdu->daily_fluid_production : ''}}</td>
                <td>{{ $item->lastOmgngdu ? $item->lastOmgngdu->bsw : ''}}</td>
                <td>{{ $item->gu ? 0 : ''}}</td>
                <td>{{ $item->lastOmgngdu ? $item->lastOmgngdu->pump_discharge_pressure : ''}}</td>
                <td></td>
                <td>{{ $item->lastOmgngdu ? $item->lastOmgngdu->heater_output_temperature : '' }}</td>
                <td></td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->trunkline_end_point->name }}</td>
                <td>{{ $item->map_pipe->name }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $item->map_pipe->lastCoords->elevation - $item->map_pipe->firstCoords->elevation}}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
