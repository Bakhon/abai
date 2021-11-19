<table style="width: 100%;">
    <thead>
    <tr>
        @foreach($data['columnNames'] as $item)
            <th style="border: 1px solid black; height: 20px">{{ $item }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data['pipes'] as $key => $pipe)
        <tr>
            <td>{{ $pipe->id }}</td>
            <td>{{ $pipe->pipeType->outside_diameter }}</td>
            <td>{{ $pipe->pipeType->thickness  }}</td>
            <td>{{ $pipe->lastCoords->m_distance }}</td>
            <td>{{ $pipe->omgngdu ? $pipe->omgngdu->daily_fluid_production : ''}}</td>
            <td>{{ $pipe->omgngdu ? $pipe->omgngdu->bsw : ''}}</td>
            <td>{{ $pipe->gu ? 0 : ''}}</td>
            <td>{{ $pipe->omgngdu ? $pipe->omgngdu->pump_discharge_pressure + 1: ''}}</td>
            <td></td>
            <td>{{ $pipe->omgngdu ? ($pipe->omgngdu->heater_output_temperature ? $pipe->omgngdu->heater_output_temperature : $pipe->omgngdu->heater_inlet_temperature) : '' }}</td>
            <td></td>
            <td>{{ $pipe->start_point }}</td>
            <td>{{ $pipe->end_point }}</td>
            <td>{{ $pipe->name }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $pipe->lastCoords->elevation - $pipe->firstCoords->elevation}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
