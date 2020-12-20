<table style="width: 100%;">
    <thead>
        <tr>
            <th style="text-align: center; border: 1px solid black; height: 20px" colspan="6">Узел отбора</th>
            <th style="text-align: center; border: 1px solid black; height: 20px" colspan="5">Фактические данные ОМГ ЦА</th>
        </tr>
        <tr>
            <th style="border: 1px solid black; height: 20px">Месторождение</th>
            <th style="border: 1px solid black; height: 20px">НГДУ</th>
            <th style="border: 1px solid black; height: 20px">ЦДНГ</th>
            <th style="border: 1px solid black; height: 20px">ГУ</th>
            <th style="border: 1px solid black; height: 20px">ЗУ</th>
            <th style="border: 1px solid black; height: 20px">Скважина</th>
            <th style="border: 1px solid black; height: 20px">Дата</th>
            <th style="border: 1px solid black; height: 20px">Ингибитор</th>
            <th style="border: 1px solid black; height: 20px">Фактическая дозировка, г/м3</th>
            <th style="border: 1px solid black; height: 20px">Суточный расход ингибитора, кг/сут</th>
            <th style="border: 1px solid black; height: 20px">Простой дозатора, сутки</th>
            <th style="border: 1px solid black; height: 20px">Причина</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->field->name }}</td>
                <td style="border: 1px solid black; height: 15px">{{ $item->ngdu->name }}</td>
                <td style="border: 1px solid black; height: 15px">{{ $item->cdng->name }}</td>
                <td style="border: 1px solid black; height: 15px">{{ $item->gu->name }}</td>
                <td style="border: 1px solid black; height: 15px">{{ $item->zu->name }}</td>
                <td style="border: 1px solid black; height: 15px">{{ $item->well->name }}</td>
                <td style="border: 1px solid black; height: 15px; width: 18px">{{ $item->date }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->inhibitor->name }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->current_dosage }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->daily_inhibitor_flowrate }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">
                    @if($item->out_of_service_оf_dosing == 1)
                        Был простой
                    @else
                        Простоя не было
                    @endif
                </td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->reason }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
