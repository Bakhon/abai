<template>
    <div class="digitalDrillingTablesPage">
        <div class="characteristic__modal" v-if="calculationModal">
            <div class="characteristic_content">
                <div class="characteristic_header">
                    <div class="header-btn">
                        <div class="btn-tech" @click="singleStage=true" :class="{active: singleStage}">Одноступенчатое</div>
                        <div class="btn-tech" @click="singleStage=false" :class="{active: !singleStage}">Двухступенчатое</div>
                    </div>
                    <div class="characteristic_header-close" @click="calculationModal=false">
                        {{trans("digital_drilling.default.close")}}
                    </div>
                </div>
                <div class="characteristic_content-inner">
                    <div class="characteristic_body">
                        <div v-if="singleStage">
                            <div class="form-row" v-for="(data, i) in formData" :key="i">
                                <label for="">{{data.name}}</label>
                                <input type="number" v-model="data.value" placeholder="|" :class="{error: error && !data.value}">
                                <span class="unitType">{{data.unit}}</span>
                            </div>
                        </div>
                        <div v-else>

                        </div>
                    </div>
                </div>
                <button class="calculate" @click="calculate">
                    Рассчитать
                </button>
            </div>
        </div>
        <div class="well-calculated" v-if="!calculationModal">
            <div class="table-row">
                <table class="table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="4">
                                Исходные данные
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, i) in formData">
                            <td>{{i+1}}</td>
                            <td>{{data.name}}</td>
                            <td>{{data.value}}</td>
                            <td>{{data.unit}}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="4">
                                Расчетная часть
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, i) in calculatedData">
                            <td>{{i+1}}</td>
                            <td>{{data.name}}</td>
                            <td>{{data.value}}</td>
                            <td>{{data.unit}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="img-row">
               <div class="img">
                   <div class="number" v-for="(data, i)  in imgData" :style="numberStyle[i]">
                       {{data}}
                   </div>
                   <img src="/img/digital-drilling/singleStage.png" alt="">
               </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "well-calculation",
        data(){
            return{
                calculationModal: true,
                singleStage: true,
                error: false,
                calculatedData: [
                    {
                        name: 'Интервал открытого ствола',
                        value: null,
                        unit: 'м.'
                    },
                    {
                        name: 'Объём открытого ствола',
                        value: null,
                        unit: 'м3'
                    },
                    {
                        name: 'Объём скважины без спущенной обсадной колонны',
                        value: null,
                        unit: 'м3'
                    },
                    {
                        name: 'Объём скважины со спущенной обсадной колонной',
                        value: null,
                        unit: 'м3'
                    },
                    {
                        name: 'Объём нецементируемого интервала (ВПЦ)',
                        value: null,
                        unit: 'м3'
                    },
                    {
                        name: 'Объём цементируемого пространства',
                        value: null,
                        unit: 'м3'
                    },
                    {
                        name: 'Количество сухой смеси (для затворения раствора)',
                        value: null,
                        unit: 'кг'
                    },
                    {
                        name: 'Объём воды затворения',
                        value: null,
                        unit: 'м.'
                    },
                ],
                formData: [
                    {
                        name: 'Глубина пробуренного ствола:',
                        value: null,
                        unit: 'м.'
                    },
                    {
                        name: 'Диаметр открытого ствола:',
                        value: null,
                        unit: 'м.'
                    },
                    {
                        name: 'Коэффициент каверзности:',
                        value: null,
                        unit: ''
                    },
                    {
                        name: 'Глубина спуска предыдущей обсадной колонны:',
                        value: null,
                        unit: 'м.'
                    },
                    {
                        name: 'Номинальный диаметр предыдущей обсадной колонны:',
                        value: null,
                        unit: 'м.'
                    },
                    {
                        name: 'Толщина стенки предыдущей колонны:',
                        value: null,
                        unit: 'м.'
                    },
                    {
                        name: 'Глубина спуска обсадной колонны:',
                        value: null,
                        unit: 'м.'
                    },
                    {
                        name: 'Номинальный диаметр обсадной колонны:',
                        value: null,
                        unit: 'м.'
                    },
                    {
                        name: 'Толщина стенки обсадной колонны:',
                        value: null,
                        unit: 'м.'
                    },
                    {
                        name: 'Высота подъёма цемента (ВПЦ), от устья:',
                        value: null,
                        unit: 'м.'
                    },
                    {
                        name: 'Плотность цементного раствора:',
                        value: null,
                        unit: 'г/см3'
                    },
                    {
                        name: 'Вода/цементное соотношение:',
                        value: null,
                        unit: ''
                    },
                ],
                form: {
                    measured_depth: null,
                    open_hole_diameter: null,
                    cavern_coefficient: null,
                    last_casing_string_depth: null,
                    nominal_diameter_previous: null,
                    thickness_previous: null,
                    casing_string_depth: null,
                    nominal_diameter: null,
                    thickness: null,
                    cement_top: null,
                    slurry_density: null,
                    water_cement_ratio: null
                },
                imgData: [],
                numberStyle: [
                    'left: -15px; top:150px;',
                    'left: 0px; bottom:184px;',
                    'left: -62px; bottom:-9px;',
                    'left: 429px; top:8px;',
                    'left: 429px; top:225px;',
                    'left: 426px; bottom:259px;',
                    'left: 429px; bottom: 151px;',
                    'left: 429px; bottom: 21px;',
                ]
            }
        },

        methods:{
            async calculate(){
                this.error = false
                this.formData.forEach(element => {
                    if (element.value == null){
                        this.error = true
                    }
                });
                if (!this.error){
                    let index = 0
                    for (let prop in this.form) {
                        this.form[prop] = this.formData[index].value
                        index++
                    }
                    let data = {}
                    await this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/designing/cementing_calc/', this.form).then((response) => {
                        data = response.data
                        let index = 0
                        for (let prop in data) {
                            this.calculatedData[index].value = data[prop]
                            index++
                        }
                        this.imgData = [
                            (this.formData[4].value * 1000) + ' мм.',
                            (this.formData[7].value * 1000) + ' мм.' ,
                            this.formData[0].value + ' м.',
                            'ВПЦ ' + this.formData[9].value + ' м.',
                            this.formData[3].value + ' м.',
                            'V = ' + this.calculatedData[5].value + ' м3',
                            (this.formData[1].value * 1000) + ' мм.',
                            this.formData[6].value + ' м.',

                        ]
                        this.calculationModal = false
                    }).catch((er)=>{
                        console.log(er)
                    });

                }

            },
        },
    }
</script>

<style scoped>
    .digitalDrillingTablesPage{
        background: #20274F;
        overflow-x: scroll;
    }
    .well-calculated{
        min-width: 1477px;
        width: 100%;
        height: auto;
        display: flex;
    }
    .table-row{
        width: 621px;
    }
    .img-row{
        width: 856px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .img-row .img{
        position: relative;
        width: 533px;
        display: flex;
        align-items: center;
    }
    .img-row .img .number{
        font-weight: bold;
        font-size: 18px;
        line-height: 22px;
        color: #FFFFFF;
        position: absolute;
    }
    .form-row{
        display: flex;
        align-items: center;
        justify-content: flex-end;
        margin-bottom: 10px;
    }
    .form-row input{
        background: #1F2142;
        border: 0.5px solid #454FA1;
        box-sizing: border-box;
        border-radius: 4px;
        width: 113px;
        margin: 0 6px;
        padding: 0 5px;
        color: #ffffff;
    }
    .form-row .unitType{
        width: 44px;
    }
    .calculate{
        display: block;
        margin: 20px auto;
        font-weight: bold;
        font-size: 14px;
        line-height: 17px;
        background: #2E50E9;
        padding: 7px 40px;
        border: 0;
        border-radius: 10px;
        color: #FFFFFF;
    }
    .form-row .error{
        border: 1px solid red!important;
    }
    .characteristic__modal{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        z-index: 20000;
        background: rgba(0, 0, 0, 0.5);
    }
    .characteristic_content{
        max-width: 700px;
        margin: 120px auto 0;
        height: 70vh;
        background: #272953;
        box-shadow: 0px 7px 7px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        padding: 15px 15px 80px 15px;
        border: 1px solid #656A8A;
    }
    .characteristic_content-inner{
        height: calc(100% - 40px);
        border: 10px solid rgba(69, 77, 125, 0.702);
        padding: 6px;
    }
    .characteristic_content .characteristic_body{
        max-height: 100%;
        height: auto;
        overflow-y: scroll;
        overflow-x: hidden;
        padding: 15px 20px 0 0;
    }
    .digital_drilling .characteristic_body::-webkit-scrollbar-thumb{
        background: #656A8A;
        border-radius: 10px;
    }
    .digital_drilling .characteristic_body::-webkit-scrollbar{
        width:4px;
    }

    .characteristic_header{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .header-btn{
        display: flex;
    }
    .btn-tech{
        margin-right: 5px;
        background: #31335F;
        min-width: 150px;
        padding: 6px 15px 2px;
        text-align: center;
        cursor: pointer;
        border-radius: 10px 10px 0 0;
        color: #8389AF;
        align-self:end;
    }
    .btn-tech.active{
        font-weight: bold;
        padding: 10px 20px;
        background: rgba(69, 77, 125, 0.702);
        color: #ffffff;
    }
    .characteristic_header span{
        font-family: Harmonia Sans Pro Cyr;
        font-style: normal;
        font-weight: bold;
        font-size: 16px;
        line-height: 19px;

        color: #FFFFFF;
    }
    .characteristic_header-close{
        background: #656A8A;
        border-radius: 10px;
        padding:0 15px;
        font-weight: bold;
        font-size: 16px;
        height: 26px;
        cursor: pointer;
    }

    .modalTable td{
        padding: 15px!important;
    }
    .characteristic__modal td{
        padding: 10px 5px!important;
    }
    .characteristic img{
        margin-left: 5px;
    }

    button{
        color: #FFFFFF;
    }
    thead th { position: sticky; top: 0; background: #333975; }
    .defaultTable{
        margin-bottom: 14px;
    }
    .defaultTable td{
        padding: 10px!important;
    }
    .defaultTable tr td:first-child{
        background: #333975;
    }
</style>