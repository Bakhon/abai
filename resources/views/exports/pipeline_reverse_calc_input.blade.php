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
        @php
            $gas_factor = $bsw = $temp_end = $pressure_end = '';
            $gas_factor = $pipe->omgngdu ? ($pipe->omgngdu->gas_factor ? $pipe->omgngdu->gas_factor : ($pipe->omgngdu->lastWellData ? $pipe->omgngdu->lastWellData->gas_factor : '')) : '';
            $bsw = $pipe->omgngdu ? ($pipe->omgngdu->bsw ? $pipe->omgngdu->bsw : ($pipe->omgngdu->lastWellData ? $pipe->omgngdu->lastWellData->bsw : '')) : '';
            //кгс/см переводятся в ата
            $pressure_end = $pipe->omgngdu_gu ? $pipe->omgngdu_gu->surge_tank_pressure  * 98000/101325 + 1 : '';

            if ($pipe->between_points == 'well-zu') {
            $temp_end = $pipe->omgngdu ? $pipe->omgngdu->temperature_zu : '';
                    if (!$temp_end) {
                      if ($data['zus']->contains('id', $pipe->zu_id)) {
                        $temp_end = 0.1562798 * $pipe->omgngdu->daily_fluid_production - 0.003952925 * $pipe->lastCoords->m_distance + 32.01423;
                    } else {
                        $temp_end = 35;
                    }
                }
            }
        @endphp
        <tr>
            <td>{{ $pipe->id }}</td>
            <td>{{ $pipe->pipeType->outside_diameter }}</td>
            <td>{{ $pipe->pipeType->thickness  }}</td>
            <td>{{ $pipe->lastCoords->m_distance }}</td>
            <td>{{ $pipe->omgngdu ? $pipe->omgngdu->daily_fluid_production : ''}}</td>
            <td>{{ $bsw }}</td>
            <td>{{ $gas_factor }}</td>
            <td></td>
            <td>{{ $pressure_end }}</td>
            <td></td>
            <td>{{ $temp_end }}</td>
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
