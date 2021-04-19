<table style="width: 100%;">
    <thead>
    <tr>
        <th style="border: 1px solid black; height: 20px">№</th>
        <th style="border: 1px solid black; height: 20px">out_dia</th>
        <th style="border: 1px solid black; height: 20px">wall_thick</th>
        <th style="border: 1px solid black; height: 20px">length</th>
        <th style="border: 1px solid black; height: 20px">qliq</th>
        <th style="border: 1px solid black; height: 20px">wc</th>
        <th style="border: 1px solid black; height: 20px">gazf</th>
        <th style="border: 1px solid black; height: 20px">press_start</th>
        <th style="border: 1px solid black; height: 20px">press_end</th>
        <th style="border: 1px solid black; height: 20px">temp_start</th>
        <th style="border: 1px solid black; height: 20px">temp_end</th>
        <th style="border: 1px solid black; height: 20px">start_point</th>
        <th style="border: 1px solid black; height: 20px">end_point</th>
        <th style="border: 1px solid black; height: 20px">name</th>
        <th style="border: 1px solid black; height: 20px">mix_speed_avg</th>
        <th style="border: 1px solid black; height: 20px">fluid_speed</th>
        <th style="border: 1px solid black; height: 20px">gaz_speed</th>
        <th style="border: 1px solid black; height: 20px">flow_type</th>
        <th style="border: 1px solid black; height: 20px">press_change</th>
        <th style="border: 1px solid black; height: 20px">break_qty</th>
        <th style="border: 1px solid black; height: 20px">height_drop</th>

    </tr>
    </thead>
    <tbody>
    @foreach($data as $key => $item)
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
