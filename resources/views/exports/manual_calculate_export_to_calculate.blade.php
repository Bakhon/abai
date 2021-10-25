<table style="width: 100%;">
    <thead>
    <tr>
        @foreach($data['columnNames'] as $column)
        <th style="border: 1px solid black; height: 20px">{{ $column }}</th>
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
        <td>{{ $pipe->omgngdu->daily_fluid_production ?? null }}</td>
        <td>{{ $pipe->omgngdu->bsw ?? null }}</td>
        <td>{{ $pipe->omgngdu->gas_factor ?? null }}</td>

        @if($pipe->omgngdu && !($pipe->gu->omgngdu[0]->surge_tank_pressure ?? null) )
        <td>{{ $pipe->omgngdu->pressure }}</td>
        @else
        <td></td>
        @endif

        @if ($pipe->between_points == 'zu-gu' AND ($pipe->gu->omgngdu[0]->surge_tank_pressure ?? null) )
        <td>{{ $pipe->gu->omgngdu[0]->surge_tank_pressure * 0.9678 + 1}}</td>
        @else
        <td></td>
        @endif

        <td>{{ $pipe->omgngdu->temperature_well ?? null }}
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
        <td>{{ $pipe->omgngdu->sg_oil ?? null }}</td>
        <td>{{ $pipe->omgngdu->sg_gas ?? null }}</td>
        <td>{{ $pipe->omgngdu->sg_water ?? null }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
