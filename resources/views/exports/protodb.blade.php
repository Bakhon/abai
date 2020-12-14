<table style="width: 100%;">
    <thead>
        <tr style="height: 50px;">
            <th style="text-align: center; border: 1px solid black;" rowspan="3">Месторождение</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="3">НГДУ</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="3">ЦДНГ</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="3">ГУ</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="3">Отвод</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="3">ЗУ/ГЗУ</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="3">Номер скважины</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="3">Год бурения</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="3">Горизонт</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="3">Блок</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="3">Действующие интервалы перфорации</th>
            @foreach($data['months_list'] as $month)
                <th style="text-align: center; border: 1px solid black;" colspan="19">
                    {{ $month }}
                </th>
            @endforeach
            <th style="text-align: center; border: 1px solid black;" colspan="6">
                @if ($data['months_count'] > 1)
                    Факт за анализируемый период
                @else
                    Факт с начала года
                @endif
            </th>
        </tr>
        <tr>
            @foreach($data['months_list'] as $month)
                <th style="text-align: center; border: 1px solid black;" colspan="3">Техрежим</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Qж, м3/сут</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Qн, т/сут</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Обв, %</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Дата исследования</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Заключение</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Hдин, м</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Pзатр, атм</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Pзаб, атм</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Pбуф, атм</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Pмакс.нагрузки, кг</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Отработанные дни</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Qн, т</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Qж, м3</th>
                <th style="text-align: center; border: 1px solid black;" colspan="2">Примечание</th>
                <th style="text-align: center; border: 1px solid black;" rowspan="2">Кол-во ПРС</th>
            @endforeach
            <th style="text-align: center; border: 1px solid black;" rowspan="2">Qж, м3/сут</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="2">Qн, т/сут</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="2">Обв, %</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="2">Отработанные дни</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="2">Qн, т</th>
            <th style="text-align: center; border: 1px solid black;" rowspan="2">Qж, м3</th>
        </tr>
        <tr>
            @foreach($data['months_list'] as $month)
                <th style="text-align: center; border: 1px solid black;">Qж, м3/сут</th>
                <th style="text-align: center; border: 1px solid black;">Обв, %</th>
                <th style="text-align: center; border: 1px solid black;">Qн, т/сут</th>
                <th style="text-align: center; border: 1px solid black;">Пробы</th>
                <th style="text-align: center; border: 1px solid black;">Простои</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($data['list'] as $item)
            <tr>
                <td style="border: 1px solid black;">{{ $item['field'] }}</td>
                <td style="border: 1px solid black;">{{ $item['ngdu'] }}</td>
                <td style="border: 1px solid black;">{{ $item['cndg'] }}</td>
                <td style="border: 1px solid black;">{{ $item['gu'] }}</td>
                <td style="border: 1px solid black;">{{ $item['tap'] }}</td>
                <td style="border: 1px solid black;">{{ $item['zu'] }}</td>
                <td style="border: 1px solid black;">{{ $item['uwi'] }}</td>
                <td style="border: 1px solid black;">{{ $item['drill_year'] }}</td>
                <td style="border: 1px solid black;">{{ $item['grzs'] }}</td>
                <td style="border: 1px solid black;">{{ $item['block2'] }}</td>
                <td style="border: 1px solid black;">{{ $item['perf_intr'] }}</td>

                @foreach($item['months'] as $month)
                    <td style="border: 1px solid black;">
                        {{ !empty($month['tm_liquid']) && $month['tm_liquid'] !== 0 ? $month['tm_liquid'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['tm_bsw']) && $month['tm_bsw'] !== 0 ? $month['tm_bsw'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['tm_oil']) && $month['tm_oil'] !== 0 ? $month['tm_oil'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['liq_avg']) && $month['liq_avg'] !== 0 ? $month['liq_avg'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['oil_avg']) && $month['oil_avg'] !== 0 ? $month['oil_avg'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['bsw_avg']) && $month['bsw_avg'] !== 0 ? $month['bsw_avg'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['gdis_date']) && $month['gdis_date'] !== 0 ? $month['gdis_date'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['gdis_conclusion']) && $month['gdis_conclusion'] !== 0 ? $month['gdis_conclusion'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['gdis_hdyn']) && $month['gdis_hdyn'] !== 0 ? $month['gdis_hdyn'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['gdis_pzatr']) && $month['gdis_pzatr'] !== 0 ? $month['gdis_pzatr'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['gdis_pzab']) && $month['gdis_pzab'] !== 0 ? $month['gdis_pzab'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['gdis_pbuf']) && $month['gdis_pbuf'] !== 0 ? $month['gdis_pbuf'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['gdis_pmaxload']) && $month['gdis_pmaxload'] !== 0 ? $month['gdis_pmaxload'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['work_day']) && $month['work_day'] !== 0 ? $month['work_day'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['oil']) && $month['oil'] !== 0 ? $month['oil'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['liquid_val']) && $month['liquid_val'] !== 0 ? $month['liquid_val'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['bsws']) && $month['bsws'] !== 0 ? $month['bsws'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['repairs_text']) && $month['repairs_text'] !== 0 ? $month['repairs_text'] : '' }}
                    </td>
                    <td style="border: 1px solid black;">
                        {{ !empty($month['prs_count']) && $month['prs_count'] !== 0 ? $month['prs_count'] : '' }}
                    </td>
                @endforeach

                <td style="border: 1px solid black;">{{ $item['liq_cumm_avg'] }}</td>
                <td style="border: 1px solid black;">{{ $item['oil_cumm_avg'] }}</td>
                <td style="border: 1px solid black;">{{ $item['bsw_cumm_avg'] }}</td>
                <td style="border: 1px solid black;">{{ $item['work_day_cumm'] }}</td>
                <td style="border: 1px solid black;">{{ $item['oil_cumm'] }}</td>
                <td style="border: 1px solid black;">{{ $item['liq_cumm'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>