<table style="width: 100%;">
    <thead>
        <tr>
            <th style="border: 1px solid black; height: 20px">Месторождение</th>
            <th style="border: 1px solid black; height: 20px">НГДУ</th>
            <th style="border: 1px solid black; height: 20px">ЦДНГ</th>
            <th style="border: 1px solid black; height: 20px">ГУ</th>
            <th style="border: 1px solid black; height: 20px">Дата начала</th>
            <th style="border: 1px solid black; height: 20px">Дата окончания </th>
            <th style="border: 1px solid black; height: 20px">Фоновая скорость </th>
            <th style="border: 1px solid black; height: 20px">Дата начало замера скорости коррозии с реагентом</th>
            <th style="border: 1px solid black; height: 20px">Дата окончания замера скорости коррозии с реагентом</th>
            <th style="border: 1px solid black; height: 20px">Скорость коррозии</th>
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
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->ngdu->name }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->cdng->name }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->gu->name }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->start_date_of_background_corrosion }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->final_date_of_background_corrosion }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->background_corrosion_velocity }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->start_date_of_corrosion_velocity_with_inhibitor_measure }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->final_date_of_corrosion_velocity_with_inhibitor_measure }}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->corrosion_velocity_with_inhibitor }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
