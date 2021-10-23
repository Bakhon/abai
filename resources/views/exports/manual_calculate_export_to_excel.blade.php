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
        @if(isset($pipe->fluid_speed))
            <tr>
                <td>{{ $pipe->id }}</td>
                <td>{{ $pipe->oilPipe->gu ? $pipe->oilPipe->gu->name : '' }}</td>
                <td>{{ $pipe->date }}</td>
                <td>{{ $pipe->oilPipe->pipeType->outside_diameter }}</td>
                <td>{{ $pipe->oilPipe->pipeType->thickness  }}</td>
                <td>{{ $pipe->length }}</td>
                <td>{{ $pipe->qliq }}</td>
                <td>{{ $pipe->bsw }}</td>
                <td>{{ $pipe->gazf }}</td>
                <td>{{ $pipe->press_start }}</td>
                <td>{{ $pipe->press_end }}</td>
                <td>{{ $pipe->temperature_start }}</td>
                <td>{{ $pipe->temperature_end }}</td>
                <td>{{ $pipe->start_point }}</td>
                <td>{{ $pipe->end_point }}</td>
                <td>{{ $pipe->oilPipe->name }}</td>
                <td>{{ $pipe->mix_speed_avg }}</td>
                <td>{{ $pipe->fluid_speed }}</td>
                <td>{{ $pipe->gaz_speed }}</td>
                <td>{{ $pipe->flow_type }}</td>
                <td>{{ round($pipe->press_change, 4) }}</td>
                <td>{{ $pipe->break_qty }}</td>
                <td>{{ round($pipe->height_drop, 2) }}</td>
            </tr>
        @else
            <tr>
                <td>{{ $pipe->id }}</td>
                <td>{{ $pipe->gu ? $pipe->gu->name : '' }}</td>
                <td>{{ $pipe->omgngdu ? $pipe->omgngdu->date : '' }}</td>
                <td>{{ $pipe->pipeType->outside_diameter }}</td>
                <td>{{ $pipe->pipeType->thickness  }}</td>
                <td>{{ $pipe->lastCoords->m_distance }}</td>
                <td>{{ $pipe->omgngdu ? $pipe->omgngdu->daily_fluid_production : '' }}</td>
                <td>{{ $pipe->omgngdu ? $pipe->omgngdu->bsw : '' }}</td>
                <td>{{ $pipe->omgngdu ? $pipe->omgngdu->gas_factor : '' }}</td>
                <td>{{ $pipe->omgngdu ? $pipe->omgngdu->pressure : '' }}</td>
                <td></td>
                <td>{{ $pipe->omgngdu ? $pipe->omgngdu->temperature_well : '' }}</td>
                <td>{{ $pipe->omgngdu ? (isset($pipe->omgngdu->heater_inlet_temperature) ? $pipe->omgngdu->heater_inlet_temperature : $pipe->omgngdu->temperature_zu) : '' }}</td>
                <td>{{ $pipe->start_point }}</td>
                <td>{{ $pipe->end_point }}</td>
                <td>{{ $pipe->name }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ round($pipe->lastCoords->elevation - $pipe->firstCoords->elevation, 2) }}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
