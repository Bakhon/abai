<table style="width: 100%;">
    <thead>
        <tr>
            <th style="text-align: center; border: 1px solid black; height: 20px" colspan="6">Узел отбора</th>
            <th style="text-align: center; border: 1px solid black; height: 20px" colspan="10">Фактические данные ОМГ ЦА</th>
        </tr>
        <tr>
            <th style="border: 1px solid black; height: 20px">Месторождение</th>
            <th style="border: 1px solid black; height: 20px">НГДУ</th>
            <th style="border: 1px solid black; height: 20px">ЦДНГ</th>
            <th style="border: 1px solid black; height: 20px">ГУ</th>
            <th style="border: 1px solid black; height: 20px">ЗУ</th>
            <th style="border: 1px solid black; height: 20px">Скважина</th>
            <th style="border: 1px solid black; height: 20px">Дата</th>
            <th style="border: 1px solid black; height: 20px">Суточная добыча жидкости, м3/сут</th>
            <th style="border: 1px solid black; height: 20px">Суточная добыча воды, м3/сут</th>
            <th style="border: 1px solid black; height: 20px">Суточная добыча нефти, т/сут</th>
            <th style="border: 1px solid black; height: 20px">Количество газа в СИБ, ст.м3/сут</th>
            <th style="border: 1px solid black; height: 20px">Обводненность, %</th>
            <th style="border: 1px solid black; height: 20px">Давление в буферной емкости, бар</th>
            <th style="border: 1px solid black; height: 20px">Давление на выходе насоса, бар</th>
            <th style="border: 1px solid black; height: 20px">Температура на входе в печь, С</th>
            <th style="border: 1px solid black; height: 20px">Температура на выходе из печи, С</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td style="border: 1px solid black; height: 15px; width: 15px">
                    @if ($item->field === 1)
                        Узень
                    @elseif ($item->field === 2)
                        Карамандыбас
                    @endif
                </td>
                <td style="border: 1px solid black; height: 15px">{{ $item->ngdu->name }}</td>
                <td style="border: 1px solid black; height: 15px">{{ $item->cdng->name }}</td>
                <td style="border: 1px solid black; height: 15px">{{ $item->gu->name }}</td>
                <td style="border: 1px solid black; height: 15px">{{ $item->zu->name }}</td>
                <td style="border: 1px solid black; height: 15px">{{ $item->well->name }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->date }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->daily_fluid_production }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->daily_water_production }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->daily_oil_production }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->daily_gas_production_in_sib }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->bsw }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->surge_tank_pressure }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->pump_discharge_pressure }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->heater_inlet_pressure }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->heater_output_pressure }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
