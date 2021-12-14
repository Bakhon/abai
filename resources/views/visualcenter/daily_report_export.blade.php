<table>
    <tr>
        <td colspan="7" style="text-align: center; font-size: 18px; font-weight: bold;">Оперативная информация по добыче нефти и газового конденсата с учетом доли участия АО НК "КазМунайГаз"</td>
    </tr>
    <tr>
        <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: center; font-size: 14px; font-weight: bold; font-style: italic; font-family: Arial">по состоянию на {{$date}}</td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: right; font-size: 14px; font-style: italic; font-family: Arial">тонн</td>
    </tr>
    <thead>
        <tr>
            <th rowspan="2" style="width: 5px; text-align: center; background-color: #C5D9F1;">№<br>п/п</th>
            <th rowspan="2" style="width: 50px; text-align: center; background-color: #C5D9F1;">Предприятия</th>
            <th rowspan="2" style="width: 10px; text-align: center; background-color: #C5D9F1;">Доля<br>КМГ</th>
            <th colspan="3" style="text-align: center; background-color: #C5D9F1;">СУТОЧНАЯ</th>
            <th rowspan="2" style="width: 140px; text-align: center; background-color: #C5D9F1;">Причины отклонений</th>
        </tr>
        <tr>
            <th style="text-align: center; background-color: #C5D9F1;">План</th>
            <th style="text-align: center; background-color: #C5D9F1;">Факт</th>
            <th style="text-align: center; background-color: #C5D9F1;">(+,-)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $dzo)
            <tr>
                @if ($dzo['orderId'] === 2)
                    <td rowspan="2">{{ $dzo['id'] }}</td>
                    <td>{{ $dzo['name']}}</td>
                    <td rowspan="2" style="text-align:right">{{ $dzo['part']}}</td>
                @elseif ($dzo['orderId'] !== 3)
                    <td>{{ $dzo['id'] }}</td>
                    <td>{{ $dzo['name']}}</td>
                    <td style="text-align:right">{{ $dzo['part']}}</td>
                @else
                    <td style="text-align: right">{{ $dzo['name']}}</td>
                @endif
                <td style="text-align:right">{{ number_format($dzo['plan'],2,',', ' ')}}</td>
                <td style="text-align:right">{{ number_format($dzo['fact'],2,',', ' ')}}</td>
                @if ($dzo['plan'] - $dzo['fact'] < 0)
                    <td style="color: red; text-align:right">{{ number_format($dzo['plan'] - $dzo['fact'],2,',', ' ') }}</td>
                @else
                    <td style="text-align:right">{{ number_format($dzo['plan'] - $dzo['fact'],2,',', ' ') }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>