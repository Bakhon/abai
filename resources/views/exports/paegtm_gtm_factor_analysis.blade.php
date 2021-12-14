<table style="width: 100%;">
    <thead>
    <tr>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">№</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">ДЗО</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">ДЗО (сокр.)</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">№ Скв</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">м/р</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Индекс пласта до ГТМ</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Qж до ГТМ, м3/сут</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Qн до ГТМ, т/сут</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">обв. до ГТМ, %</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Вид ГТМ</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Дата проведения ГТМ</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Qж план, м3/сут</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Qн план, т/сут</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">обв. план, %</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Индекс пласта после ГТМ</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Qж после ГТМ, м3/сут</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Qн после ГТМ, т/сут</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">обв. после ГТМ, %</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Qж отклонение, м3/сут</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Qн отклонение, т/сут</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Фактор неуспешности</th>
        <th style="border: 1px solid black; height: 30px; font-weight: bold;">Причина недостижения</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $loop->iteration }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->org_name }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->org_name_short }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->uwi }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->oilfield }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->formation_index_before_gtm }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->q_l_before_gtm }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->q_o_before_gtm }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->wct_before_gtm }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->gtm }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->gtm_date }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->q_l_plan }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->q_o_plan }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->wct_plan }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->formation_index_after_gtm }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->q_l_after_gtm }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->q_o_after_gtm }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->wct_after_gtm }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->q_l_deviation }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->q_o_deviation }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->failure_factor }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->failure_reason }}</td>
        </tr>
    @endforeach
    </tbody>
</table>