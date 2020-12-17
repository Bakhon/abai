<table style="width: 100%;">
    <thead>
    <tr>
        <th style="border: 1px solid black; height: 20px">ГУ</th>
        <th style="border: 1px solid black; height: 20px">Длина</th>
        <th style="border: 1px solid black; height: 20px">Внешний диаметр</th>
        <th style="border: 1px solid black; height: 20px">Внутренний диаметр</th>
        <th style="border: 1px solid black; height: 20px">Толщина стенок</th>
        <th style="border: 1px solid black; height: 20px">Жесткость</th>
        <th style="border: 1px solid black; height: 20px">Материал</th>
        <th style="border: 1px solid black; height: 20px">Участок</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->gu->name }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->length }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->outside_diameter }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->inner_diameter }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->thickness }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->roughness }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->material_id }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item->plot }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
