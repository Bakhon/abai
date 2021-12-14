<table style="border-collapse:collapse;">
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
            <th rowspan="2" style="width: 5px; text-align: center; background-color: #C5D9F1; border: 1px solid black;">№<br>п/п</th>
            <th rowspan="2" style="width: 50px; text-align: center; background-color: #C5D9F1; border: 1px solid black;">Предприятия</th>
            <th rowspan="2" style="width: 10px; text-align: center; background-color: #C5D9F1; border: 1px solid black;">Доля<br>КМГ</th>
            <th colspan="3" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">СУТОЧНАЯ</th>
            <th rowspan="2" style="width: 140px; text-align: center; background-color: #C5D9F1; border: 1px solid black;">Причины отклонений</th>
        </tr>
        <tr>
            <th style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">План</th>
            <th style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Факт</th>
            <th style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">(+,-)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($daily as $index => $dzo)
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
                    <td style="text-indent: 14px;">{{ $dzo['name']}}</td>
                @endif
                <td style="text-align:right">{{ number_format($dzo['plan'],0,',', ' ')}}</td>
                <td style="text-align:right">{{ number_format($dzo['fact'],0,',', ' ')}}</td>
                @if ($dzo['plan'] - $dzo['fact'] < 0)
                    <td style="color: red; text-align:right">{{ number_format($dzo['plan'] - $dzo['fact'],0,',', ' ') }}</td>
                @else
                    <td style="text-align:right">{{ number_format($dzo['plan'] - $dzo['fact'],0,',', ' ') }}</td>
                @endif
                @if (count($dzo['reasons']) > 0)
                    <td>
                        @foreach($dzo['reasons'] as $index => $reason)
                            {{$reason[0]}}
                            @if ($reason[1] !== null)
                                , потери - {{$reason[1]}} т.
                            @endif
                            @if (count($dzo['reasons']) - 1 !== $index)
                                <br>
                            @endif
                        @endforeach
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>