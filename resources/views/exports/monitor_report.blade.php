<table style="width: 100%;">
    <thead>
    <tr>
        <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center"></th>
        <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center"></th>
        <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center"></th>
        <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center"></th>
        <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center"></th>
        <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center"></th>
        @if(in_array('omgca', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="2">ОМГ
                ДДНГ
            </th>
        @endif
        @if(in_array('omguhe', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="7">ОМГ
                УХЭ
            </th>
        @endif
        @if(in_array('corrosion', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="9">База
                данных по скорости коррозии
            </th>
        @endif
        @if(in_array('omgngdu', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="9">ОМГ
                НГДУ
            </th>
        @endif
        @if(in_array('watermeasurement', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="25">База
                данных по промысловой жидкости и газу
            </th>
        @endif
        @if(in_array('oilgas', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="10">База
                данных по нефти и газу
            </th>
        @endif
    </tr>
    <tr>
        <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center"></th>
        <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="4">Узел
            отбора
        </th>
        <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center"></th>
        @if(in_array('omgca', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="2">
                Фактические данные ОМГ ЦА
            </th>
        @endif
        @if(in_array('omguhe', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="7">
                Фактические данные от УХЭ
            </th>
        @endif
        @if(in_array('corrosion', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="9">
                Скорость коррозии
            </th>
        @endif
        @if(in_array('omgngdu', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="9">
                Фактические данные ГУ
            </th>
        @endif
        @if(in_array('watermeasurement', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="7">Ионный
                состав воды мг/дм3
            </th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="5">
                Физико-химические свойства воды
            </th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="2">Примеси
                в воде
            </th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="5">
                Содержание тяжелых металлов в воде
            </th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="3">
                Растворенные в воде газы
            </th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="3">
                Содержание бактерий
            </th>
        @endif
        @if(in_array('oilgas', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="5">
                Свойства нефти
            </th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold; text-align: center" colspan="5">
                Свойства газа
            </th>
        @endif
    </tr>
    <tr>
        <th style="border: 1px solid black; height: 20px; font-weight: bold">№ п/п</th>
        <th style="border: 1px solid black; height: 20px; font-weight: bold">Прочие объекты</th>
        <th style="border: 1px solid black; height: 20px; font-weight: bold">НГДУ</th>
        <th style="border: 1px solid black; height: 20px; font-weight: bold">ЦДНГ</th>
        <th style="border: 1px solid black; height: 20px; font-weight: bold">ГУ</th>
        <th style="border: 1px solid black; height: 20px; font-weight: bold">Дата</th>
        @if(in_array('omgca', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Планируемая дозировка, г/м3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Техрежим Qв, тыс.м3/год</th>
        @endif
        @if(in_array('omguhe', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Фактическая дозировка, г/м3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Суточный расход ингибитора, кг/сут</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Простой дозатора, сутки</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Причина</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Уровень реагента в хим. блоке, л</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Заправка</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Марка ингибитора коррозии</th>
        @endif
        @if(in_array('corrosion', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Дата начала</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Дата окончания</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Фоновая скорость коррозии, мм/г</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Номер образца-свидетеля</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Масса до установки, гр</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Количество дней экспозиции</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Масса после извлечения, гр</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Скорость коррозии с реагентом, мм/г
            </th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Средняя скорость коррозии, мм/г</th>
        @endif
        @if(in_array('omgngdu', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Суточная добыча жидкости, м3/сут</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Суточная добыча воды, м3/сут</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Суточная добыча нефти, т/сут</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Обводненность, %</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Количество газа в СИБ, ст.м3/сут</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Давление в буферной емкости, бар</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Давление на выходе насоса, бар</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Температура на входе в печи, 0С</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Температура на выходе из печи, 0С</th>
        @endif
        @if(in_array('watermeasurement', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold">НСО3-</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">СО32-</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">SO42-</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Cl-</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Ca2+</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Mg2+</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Na+ + K+</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Плотность воды при 20°С, г/см3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">рН</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Общая минерализация, мг/дм3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Общая жесткость, мг-экв/дм3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Тип воды по Сулину</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Содержание нефтепродуктов, мг/дм3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Механические примеси, мг/дм3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Содержание стронция, мг/дм³</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Содержание бария, мг/дм³</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Содержание общего железа мг/дм3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Содержание трехвалентного железа
                мг/дм3
            </th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Содержание двухвалентного железа
                мг/дм3
            </th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">H2S (после буферной емкости), мг/дм3
            </th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">О2, мг/дм3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">CO2 (после буферной емкости), мг/дм3
            </th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">СВБ, кл/см3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">УОБ, кл/см3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">ТБ, кл/см3</th>
        @endif
        @if(in_array('oilgas', $sections))
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Плотность нефти при 20°С, кг/м3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Вязкость нефти при 20С, мм2/с</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Вязкость нефти при 40С, мм2/с</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Вязкость нефти при 50С, мм2/с</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Вязкость нефти при 60С, мм2/с</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">H2S в газе, ppm</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">О2 в газе, %</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">CO2 в газе, %</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Плотность газа при 20°С, кг/м3</th>
            <th style="border: 1px solid black; height: 20px; font-weight: bold">Вязкость газа при 20С, сП</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $loop->iteration }}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['other_objects']}}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['ngdu']}}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['cdng']}}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['gu']}}</td>
            <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['date']}}</td>
            @if(in_array('omgca', $sections))
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['plan_dosage']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['conditions']}}</td>
            @endif
            @if(in_array('omguhe', $sections))
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['current_dosage']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['daily_inhibitor_flowrate']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['out_of_service_оf_dosing']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['reason']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['level']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['fill']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['inhibitor_brand']}}</td>
            @endif
            @if(in_array('corrosion', $sections))
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['start_date_of_background_corrosion']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['final_date_of_background_corrosion']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['background_corrosion_velocity']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['sample_number']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['weight_before']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['corrosion_days']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['weight_after']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['corrosion_velocity_with_inhibitor']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['avg_corrosion_speed']}}</td>
            @endif
            @if(in_array('omgngdu', $sections))
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['daily_fluid_production']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['daily_water_production']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['daily_oil_production']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['bsw']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['daily_gas_production_in_sib']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['surge_tank_pressure']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['pump_discharge_pressure']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['heater_inlet_pressure']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['heater_outlet_pressure']}}</td>
            @endif
            @if(in_array('watermeasurement', $sections))
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['hydrocarbonate_ion']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['carbonate_ion']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['sulphate_ion']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['chlorum_ion']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['calcium_ion']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['magnesium_ion']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['potassium_ion_sodium_ion']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['density']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['ph']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['mineralization']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['total_hardness']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['water_type_by_sulin']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['content_of_petrolium_products']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['mechanical_impurities']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['strontium_content']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['barium_content']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['total_iron_content']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['ferric_iron_content']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['ferrous_iron_content']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['hydrogen_sulfide']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['oxygen']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['carbon_dioxide']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['sulphate_reducing_bacteria']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['hydrocarbon_oxidizing_bacteria']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['thionic_bacteria']}}</td>
            @endif
            @if(in_array('oilgas', $sections))
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['oil_density_at_20']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['oil_viscosity_at_20']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['oil_viscosity_at_40']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['oil_viscosity_at_50']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['oil_viscosity_at_60']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['hydrogen_sulfide_in_gas']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['oxygen_in_gas']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['carbon_dioxide_in_gas']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['gas_density_at_20']}}</td>
                <td style="border: 1px solid black; height: 15px; width: 15px">{{ $item['gas_viscosity_at_20']}}</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
