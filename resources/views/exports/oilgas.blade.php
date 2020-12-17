<table style="width: 100%;">
    <thead>
    <tr>
        <th style="border: 1px solid black; height: 20px">Прочие объекты</th>
        <th style="border: 1px solid black; height: 20px">НГДУ</th>
        <th style="border: 1px solid black; height: 20px">ЦДНГ</th>
        <th style="border: 1px solid black; height: 20px">ГУ</th>
        <th style="border: 1px solid black; height: 20px">ЗУ</th>
        <th style="border: 1px solid black; height: 20px">Скважина</th>
        <th style="border: 1px solid black; height: 20px">Дата</th>
        <th style="border: 1px solid black; height: 20px">Плотность нефти при 20°С, кг/м3</th>
        <th style="border: 1px solid black; height: 20px">Вязкость нефти при 20С, мм2/с</th>
        <th style="border: 1px solid black; height: 20px">Вязкость нефти при 40С, мм2/с</th>
        <th style="border: 1px solid black; height: 20px">Вязкость нефти при 50С, мм2/с</th>
        <th style="border: 1px solid black; height: 20px">Вязкость нефти при 60С, мм2/с</th>
        <th style="border: 1px solid black; height: 20px">H2S в газе, ppm</th>
        <th style="border: 1px solid black; height: 20px">О2 в газе, %</th>
        <th style="border: 1px solid black; height: 20px">CO2 в газе, %</th>
        <th style="border: 1px solid black; height: 20px">Плотность газа при 20°С, кг/м3</th>
        <th style="border: 1px solid black; height: 20px">Вязкость газа при 20С, сП</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->other_objects->name }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->ngdu->name }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->cdng->name }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->gu->name }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->zu->name }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->well->name }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->date }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->water_density_at_20 }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->oil_viscosity_at_20 }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->oil_viscosity_at_40 }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->oil_viscosity_at_50 }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->oil_viscosity_at_60 }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->hydrogen_sulfide_in_gas }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->oxygen_in_gas }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->carbon_dioxide_in_gas }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->gas_density_at_20 }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->gas_viscosity_at_20 }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
