<table style="width: 100%;">
    <thead>
    <tr>
        <th style="text-align: center; border: 1px solid black; height: 20px" colspan="6">Узел отбора</th>
        <th style="text-align: center; border: 1px solid black; height: 20px" colspan="10">Фактические данные ОМГ ЦА
        </th>
    </tr>
    <tr>
        <th style="border: 1px solid black; height: 20px">Дата отбора</th>
        <th style="border: 1px solid black; height: 20px">Прочие объекты</th>
        <th style="border: 1px solid black; height: 20px">НГДУ</th>
        <th style="border: 1px solid black; height: 20px">ЦДНГ</th>
        <th style="border: 1px solid black; height: 20px">ГУ</th>
        <th style="border: 1px solid black; height: 20px">ЗУ</th>
        <th style="border: 1px solid black; height: 20px">Скважина</th>
        <th style="border: 1px solid black; height: 20px">НСО3-</th>
        <th style="border: 1px solid black; height: 20px">СО32-</th>
        <th style="border: 1px solid black; height: 20px">SO42-</th>
        <th style="border: 1px solid black; height: 20px">Cl-</th>
        <th style="border: 1px solid black; height: 20px">Ca2+</th>
        <th style="border: 1px solid black; height: 20px">Mg2+</th>
        <th style="border: 1px solid black; height: 20px">Na+K+</th>
        <th style="border: 1px solid black; height: 20px">Плотность при 20°С, г/см3</th>
        <th style="border: 1px solid black; height: 20px">рН</th>
        <th style="border: 1px solid black; height: 20px">Общая минерализация, мг/дм3</th>
        <th style="border: 1px solid black; height: 20px">Общая жесткость, мг-экв/дм3</th>
        <th style="border: 1px solid black; height: 20px">Тип воды по Сулину</th>
        <th style="border: 1px solid black; height: 20px">Содержание нефтепродуктов, мг/дм3</th>
        <th style="border: 1px solid black; height: 20px">Механические примеси, мг/дм3</th>
        <th style="border: 1px solid black; height: 20px">Содержание стронция, мг/дм³</th>
        <th style="border: 1px solid black; height: 20px">Содержание бария, мг/дм³</th>
        <th style="border: 1px solid black; height: 20px">Содержание общего железа мг/дм3</th>
        <th style="border: 1px solid black; height: 20px">Содержание трехвалентного железа мг/дм3</th>
        <th style="border: 1px solid black; height: 20px">Содержание двухвалентного железа мг/дм3</th>
        <th style="border: 1px solid black; height: 20px">H2S, мг/дм3 (после буферной емкости)</th>
        <th style="border: 1px solid black; height: 20px">О2, мг/дм3</th>
        <th style="border: 1px solid black; height: 20px">CO2, мг/дм3 (после буферной емкости)</th>
        <th style="border: 1px solid black; height: 20px">СВБ, кл/см3</th>
        <th style="border: 1px solid black; height: 20px">УОБ, кл/см3</th>
        <th style="border: 1px solid black; height: 20px">ТБ, кл/см3</th>
        <th style="border: 1px solid black; height: 20px">Месторождение</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td style="border: 1px solid black; height: 15px">{{ $item->date }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->other_objects->name }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->ngdu->name }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->cdng->name }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->gu->name }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->zu->name }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->well->name }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->hydrocarbonate_ion }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->carbonate_ion }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->sulphate_ion }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->chlorum_ion }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->calcium_ion }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->magnesium_ion }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->potassium_ion_sodium_ion }}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->density}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->ph}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->mineralization}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->total_hardness}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->waterTypeBySulin->name}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->content_of_petrolium_products}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->mechanical_impurities}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->strontium_content}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->barium_content}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->total_iron_content}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->ferric_iron_content}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->ferrous_iron_content}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->hydrogen_sulfide}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->oxygen}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->carbon_dioxide}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->sulphateReducingBacteria->name}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->hydrocarbonOxidizingBacteria->name}}</td>
            <td style="border: 1px solid black; height: 15px">{{ $item->thionicBacteria->name}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
