<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="3">Название (тип) раствора</th>
            <th colspan="2">Интервал (по стволу), м</th>
            <th colspan="14">Параметры бурового раствора</th>
        </tr>
        <tr>
            <th colspan="1" rowspan="2">От (верх)</th>
            <th colspan="1" rowspan="2">До (низ)</th>
            <th colspan="1" rowspan="2" class="verticalText"><span>Плотность, кг/м3</span></th>
            <th colspan="1" rowspan="2" class="verticalText"><span>Условная вязкость, сек</span></th>
            <th colspan="1" rowspan="2" class="verticalText"><span>Водоотдача, см3/30 мин</span></th>
            <th colspan="2">СНС, фунт/100фут2</th>
            <th colspan="1" rowspan="2" class="verticalText"><span>Корка, мм</span></th>
            <th colspan="3">Содержание твердой фазы, % (об.)</th>
            <th colspan="1" rowspan="2">рН</th>
            <th colspan="1" rowspan="2" class="verticalText"><span>Минерализация по Са2+, мг/л, не более</span></th>
            <th colspan="1" rowspan="2" class="verticalText"><span>пластическая вязкость, сантипуазах</span></th>
            <th colspan="1" rowspan="2" class="verticalText"><span>динамическое напряжение сдвига, фунт/100фут2</span></th>
            <th colspan="1" rowspan="2" class="verticalText"><span>плотность до утяжеления, кг/м3</span></th>
        </tr>
        <tr>
            <th colspan="1">1 мин</th>
            <th colspan="1">10 мин</th>
            <th colspan="1" class="verticalText"><span>(активной)</span></th>
            <th colspan="1" class="verticalText"><span>песка</span></th>
            <th colspan="1" class="verticalText"><span>Всего</span></th>
        </tr>
        <tr>
            <td v-for="i in 17">{{i+1}}</td>
        </tr>
        <tr v-for="i in 20">
            <td v-for="i in 17"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "rasters-params"
    }
</script>

<style scoped>

</style>