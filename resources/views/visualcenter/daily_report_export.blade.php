<table style="border-collapse:collapse;">
    <tr>
        <td colspan="8" style="text-align: center; font-size: 18px; font-weight: bold; border: 1px solid white;">Оперативная информация по добыче нефти и газового конденсата с учетом доли участия АО НК "КазМунайГаз"</td>
    </tr>
    <tr>
        <td style="width: 5px; border: 1px solid white;">&nbsp;</td>
        <td style="width: 50px; border: 1px solid white;">&nbsp;</td>
        <td style="width: 10px; border: 1px solid white;">&nbsp;</td>
        <td style="width: 10px; border: 1px solid white;">&nbsp;</td>
        <td style="width: 10px; border: 1px solid white;">&nbsp;</td>
        <td style="width: 10px; border: 1px solid white;">&nbsp;</td>
        <td style="border: 1px solid white;">&nbsp;</td>
        <td style="width: 140px; border: 1px solid white;">&nbsp;</td>
    </tr>
    <tr>
        <td style="border: 1px solid white;"></td>
        <td style="border: 1px solid white;"></td>
        <td colspan="5" style="text-align: center; font-size: 14px; font-weight: bold; font-style: italic; font-family: Arial; border: 1px solid white;">по состоянию на {{$date}}</td>
        <td style="border: 1px solid white;"></td>
    </tr>
    <tr>
        <td colspan="8" style="text-align: right; font-size: 14px; font-style: italic; font-family: Arial; border: 1px solid white;">тонн</td>
    </tr>
    <tbody>
        <tr>
            <th rowspan="2" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">№<br>п/п</th>
            <th rowspan="2" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Предприятия</th>
            <th rowspan="2" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Доля<br>КМГ</th>
            <th colspan="3" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">СУТОЧНАЯ</th>
            <th rowspan="2" colspan="2" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Причины отклонений</th>
        </tr>
        <tr>
            <th style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">План</th>
            <th style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Факт</th>
            <th style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">(+,-)</th>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center; font-weight: bold">ВСЕГО</td>
            <td></td>
            <td style="text-align:right; font-weight: bold">{{number_format($summary['daily']['plan'],0,',', ' ')}}</td>
            <td style="text-align:right; font-weight: bold">{{number_format($summary['daily']['fact'],0,',', ' ')}}</td>
            @if ($summary['daily']['fact'] - $summary['daily']['plan'] < 0)
                <td style="color: red; text-align:right; font-weight: bold">{{number_format($summary['daily']['fact'] - $summary['daily']['plan'],0,',', ' ')}}</td>
            @else
                 <td style="text-align:right; font-weight: bold">{{number_format($summary['daily']['fact'] - $summary['daily']['plan'],0,',', ' ')}}</td>
            @endif
            <td></td>
        </tr>
        @foreach($daily as $index => $dzo)
            <tr>
                @if ($dzo['orderId'] === 2)
                    <td rowspan="2">{{ $dzo['id'] }}</td>
                    <td>{{ $dzo['name']}}</td>
                    <td rowspan="2" style="text-align:right">{{ $dzo['part']}}%</td>
                @elseif ($dzo['orderId'] !== 3)
                    <td>{{ $dzo['id'] }}</td>
                    <td>{{ $dzo['name']}}</td>
                    <td style="text-align:right">{{ $dzo['part']}}%</td>
                @else
                    <td style="text-indent: 14px;">{{ $dzo['name']}}</td>
                @endif
                <td style="text-align:right">{{ number_format($dzo['plan'],0,',', ' ')}}</td>
                <td style="text-align:right">{{ number_format($dzo['fact'],0,',', ' ')}}</td>
                @if ($dzo['fact'] - $dzo['plan'] < 0)
                    <td style="color: red; text-align:right">{{ number_format($dzo['fact'] - $dzo['plan'],0,',', ' ') }}</td>
                @else
                    <td style="text-align:right">{{ number_format($dzo['fact'] - $dzo['plan'],0,',', ' ') }}</td>
                @endif
                @if (count($dzo['reasons']) > 0 && $dzo['fact'] - $dzo['plan'] < 0)
                    <td colspan="2" style="height:{{{count($dzo['reasons']) * 15}}}px">
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
                @else
                    <td colspan="2"></td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
<table style="border-collapse:collapse;">
    <tr>
        <td colspan="8" style="text-align: right; font-size: 14px; font-style: italic; font-family: Arial">тонн</td>
    </tr>
    <tbody>
        <tr>
            <th rowspan="3" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">№<br>п/п</th>
            <th rowspan="3" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Предприятия</th>
            <th rowspan="3" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Доля<br>КМГ</th>
            <th rowspan="3" style="width: 10px; text-align: center; background-color: #C5D9F1; border: 1px solid black;">План на<br>{{$monthName}}</th>
            <th rowspan="2" colspan="3" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">С НАЧАЛА МЕСЯЦА на<br>{{$date}}</th>
            <th rowspan="3" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Причины отклонений</th>
        </tr>
        <tr></tr>
        <tr>
            <th style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">План</th>
            <th style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Факт</th>
            <th style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">(+,-)</th>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center; font-weight: bold">ВСЕГО</td>
            <td></td>
            <td style="text-align:right; font-weight: bold">{{number_format($summary['monthly']['monthlyPlan'],0,',', ' ')}}</td>
            <td style="text-align:right; font-weight: bold">{{number_format($summary['monthly']['plan'],0,',', ' ')}}</td>
            <td style="text-align:right; font-weight: bold">{{number_format($summary['monthly']['fact'],0,',', ' ')}}</td>
            @if ($summary['monthly']['fact'] - $summary['monthly']['plan'] < 0)
                <td style="color: red; text-align:right; font-weight: bold">{{number_format($summary['monthly']['fact'] - $summary['monthly']['plan'],0,',', ' ')}}</td>
            @else
                 <td style="text-align:right; font-weight: bold">{{number_format($summary['monthly']['fact'] - $summary['monthly']['plan'],0,',', ' ')}}</td>
            @endif
            <td></td>
        </tr>
        @foreach($monthly as $index => $dzo)
            <tr>
                @if ($dzo['orderId'] === 2)
                    <td rowspan="2">{{ $dzo['id'] }}</td>
                    <td>{{ $dzo['name']}}</td>
                    <td rowspan="2" style="text-align:right">{{ $dzo['part']}}%</td>
                @elseif ($dzo['orderId'] !== 3)
                    <td>{{ $dzo['id'] }}</td>
                    <td>{{ $dzo['name']}}</td>
                    <td style="text-align:right">{{ $dzo['part']}}%</td>
                @else
                    <td style="text-indent: 14px;">{{ $dzo['name']}}</td>
                @endif
                <td style="text-align:right">{{ number_format($dzo['monthlyPlan'],0,',', ' ') }}</td>
                <td style="text-align:right">{{ number_format($dzo['plan'],0,',', ' ')}}</td>
                <td style="text-align:right">{{ number_format($dzo['fact'],0,',', ' ')}}</td>
                @if ($dzo['fact'] - $dzo['plan'] < 0)
                    <td style="color: red; text-align:right">{{ number_format($dzo['fact'] - $dzo['plan'],0,',', ' ') }}</td>
                @else
                    <td style="text-align:right">{{ number_format($dzo['fact'] - $dzo['plan'],0,',', ' ') }}</td>
                @endif
                @if (count($dzo['reasons']) > 0 && $dzo['fact'] - $dzo['plan'] < 0)
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
<table style="border-collapse:collapse;">
    <tr>
        <td colspan="8" style="text-align: right; font-size: 14px; font-style: italic; font-family: Arial">тонн</td>
    </tr>
    <tbody>
        <tr>
            <th rowspan="2" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">№<br>п/п</th>
            <th rowspan="2" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Предприятия</th>
            <th rowspan="2" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Доля<br>КМГ</th>
            <th rowspan="2" style="width: 10px; text-align: center; background-color: #C5D9F1; border: 1px solid black;">План на<br>{{$yearId}} г.</th>
            <th colspan="3" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">За {{$monthId}} мес.</th>
            <th rowspan="2" style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Причины отклонений</th>
        </tr>
        <tr>
            <th style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">План</th>
            <th style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">Факт</th>
            <th style="text-align: center; background-color: #C5D9F1; border: 1px solid black;">(+,-)</th>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center; font-weight: bold">ВСЕГО</td>
            <td></td>
            <td style="text-align:right; font-weight: bold">{{number_format($summary['yearly']['yearlyPlan'],0,',', ' ')}}</td>
            <td style="text-align:right; font-weight: bold">{{number_format($summary['yearly']['plan'],0,',', ' ')}}</td>
            <td style="text-align:right; font-weight: bold">{{number_format($summary['yearly']['fact'],0,',', ' ')}}</td>
            @if ($summary['yearly']['fact'] - $summary['yearly']['plan'] < 0)
                <td style="color: red; text-align:right; font-weight: bold">{{number_format($summary['yearly']['fact'] - $summary['yearly']['plan'],0,',', ' ')}}</td>
            @else
                 <td style="text-align:right; font-weight: bold">{{number_format($summary['yearly']['fact'] - $summary['yearly']['plan'],0,',', ' ')}}</td>
            @endif
            <td></td>
        </tr>
        @foreach($yearly as $index => $dzo)
            <tr>
                @if ($dzo['orderId'] === 2)
                    <td rowspan="2">{{ $dzo['id'] }}</td>
                    <td>{{ $dzo['name']}}</td>
                    <td rowspan="2" style="text-align:right">{{ $dzo['part']}}%</td>
                @elseif ($dzo['orderId'] !== 3)
                    <td>{{ $dzo['id'] }}</td>
                    <td>{{ $dzo['name']}}</td>
                    <td style="text-align:right">{{ $dzo['part']}}%</td>
                @else
                    <td style="text-indent: 14px;">{{ $dzo['name']}}</td>
                @endif
                <td style="text-align:right">{{ number_format($dzo['yearlyPlan'],0,',', ' ') }}</td>
                <td style="text-align:right">{{ number_format($dzo['plan'],0,',', ' ')}}</td>
                <td style="text-align:right">{{ number_format($dzo['fact'],0,',', ' ')}}</td>
                @if ($dzo['fact'] - $dzo['plan'] < 0)
                    <td style="color: red; text-align:right">{{ number_format($dzo['fact'] - $dzo['plan'],0,',', ' ') }}</td>
                @else
                    <td style="text-align:right">{{ number_format($dzo['fact'] - $dzo['plan'],0,',', ' ') }}</td>
                @endif
                @if (count($dzo['reasons']) > 0 && $dzo['fact'] - $dzo['plan'] < 0)
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