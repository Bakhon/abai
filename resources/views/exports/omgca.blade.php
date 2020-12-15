<table style="width: 100%;">
    <thead>
        <tr>
            <th style="text-align: center; border: 1px solid black; height: 20px; width: 20px" colspan="1">Узел отбора</th>
            <th style="text-align: center; border: 1px solid black; height: 20px; width: 60px" colspan="3">Фактические данные ОМГ ЦА</th>
        </tr>
        <tr>
            <th style="text-align: left; border: 1px solid black; height: 20px">ГУ</th>
            <th style="text-align: left; border: 1px solid black; height: 20px">Год</th>
            <th style="text-align: left; border: 1px solid black; height: 20px">Планируемая дозировка, г/м³</th>
            <th style="text-align: left; border: 1px solid black; height: 20px">Техрежим Qв, тыс.м³/год</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td style="border: 1px solid black; height: 15px">{{ $item->gu ? $item->gu->name : '' }}</td>
                <td style="border: 1px solid black; width: 20px; height: 15px">{{ Carbon\Carbon::parse($item->date)->format('Y') }}</td>
                <td style="border: 1px solid black; width: 20px; height: 15px">{{ $item->plan_dosage }}</td>
                <td style="border: 1px solid black; width: 20px; height: 15px">{{ $item->q_v }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
