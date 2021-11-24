<template>
    <div class="CapitalInvestments">
        <table class="table defaultTable">
            <tbody>
            <tr>
                <th rowspan="2" >БКП / Account</th>
                <th rowspan="2" >Проект / Project</th>
                <th>Факт / Actual</th>
                <th>Факт / Actual</th>
                <th>Оценка / Expected</th>
                <th>Утв. План / Appr. Рlan</th>
            </tr>
            <tr>
                <th>
                    <select name="" id="" v-model="factFirst" @change="filterSap">
                        <option :value="year.year" v-for="year in years">
                            {{year.year}} г.
                        </option>
                    </select>
                </th>
                <th>
                    <select name="" id="" v-model="factLast" @change="filterSap">
                        <option :value="year.year" v-for="year in years">
                            {{year.year}} г.
                        </option>
                    </select>
                </th>
                <th>
                    <select name="" id="" v-model="planFirst" @change="filterSap">
                        <option :value="year.year" v-for="year in years">
                            {{year.year}} г.
                        </option>
                    </select>
                </th>
                <th>
                    <select name="" id="" v-model="planLast" @change="filterSap">
                        <option :value="year.year" v-for="year in years">
                            {{year.year}} г.
                        </option>
                    </select>
                </th>
            </tr>
            <tr v-for="investment in investments">
                <td></td>
                <td>{{investment.name_ru}}</td>
                <td>{{investment.value_fact1}}</td>
                <td>{{investment.date_fact2}}</td>
                <td>{{investment.value_plan1}}</td>
                <td>{{investment.value_plan2}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import {globalloadingMutations} from '@store/helpers';
    export default {
        name: "CapitalInvestments",
        data(){
            return{
                factFirst: 2016,
                factLast: 2018,
                planFirst: 2016,
                planLast: 2018,
                investments: [],
                years: [
                    { year: 2015},
                    { year: 2016},
                    { year: 2017},
                    { year: 2018},
                    { year: 2019},
                    { year: 2020},
                    { year: 2021},
                ],
            }
        },
        created(){
            this.filterSap()
        },
        methods:{
            ...globalloadingMutations([
                'SET_LOADING'
            ]),
            async filterSap(){
                this.SET_LOADING(true);
                let query = "?fact1=" + this.factFirst + "&fact2=" + this.factLast
                    + "&plan1=" + this.planFirst + "&plan2=" + this.planLast
                try{
                    await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/capital_investment/'+query).then((response) => {
                        let data = response.data;
                        if (data) {
                            this.investments = data;
                        } else {
                            console.log('No data');
                        }
                    });
                }
                catch (e) {
                    console.log(e)
                    this.investments = []
                }
                this.SET_LOADING(false);
            },
        },
    }
</script>

<style scoped>
    .CapitalInvestments{
        width: 100%;
        height: 100%;
        background: #272953;
    }
    th{
        vertical-align: middle;
        padding: 10px 3px!important;
        font-size: 12px;

    }
    .CapitalInvestments .account{
        width: 120px;
    }
    .CapitalInvestments .project{
        width: 700px;
    }
    select{
        width: 100%;
        color: #FFFFFF;
        background: #334296;
        border: 0.5px solid #454FA1;
        border-radius: 4px;
        padding: 5px;
    }
    select:focus{
        outline: none;
    }

</style>