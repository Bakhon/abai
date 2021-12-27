<template>
    <div class="drilling-graph">
        <div class="drilling-graph-content">
            <div class="drilling-graph-body">
                <div class="drilling-graph-header">
                    <div class="well_body-header-title">
                        Общий график бурения
                    </div>
                    <div class="well_body-header-close" @click="close">
                        {{ trans('digital_drilling.default.close') }}
                    </div>
                </div>
                <div class="drilling-graph-body-content">
                    <div class="graph">
                        <div class="graph-left">
                            <table class="graph-name">
                                <thead>
                                <tr>
                                    <th>
                                        Тип БУ
                                    </th>
                                    <th>
                                        Грузоподъемность БУ
                                    </th>
                                    <th>
                                        Местонахождение БУ
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(graph, i) in dataGraph">
                                        <td>{{graph.rig}}</td>
                                        <td>{{graph.lifting_capacity}}</td>
                                        <td>{{graph.location}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="graph-right">
                            <div class="graph-right-calendar">
                                <table class="calendar-header">
                                    <thead>
                                    <tr>
                                        <th class="calendar-header-month" v-for="i in 12" :key="i">
                                            <div class="calendar-header-name"> {{$moment(i, 'M').format('MMMM')}} 2021</div>
                                            <div class="calendar-header-day">
                                                <div class="day-number" v-for="number in getDaysInMonth(i-1, 2021)">
                                                       <span>
                                                           <span v-if="number%5==0"> {{number}}</span>
                                                       </span>
                                                    <span class="number-line"></span>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="calendar-header-month" v-for="j in 2" >
                                            <div class="calendar-header-name"> {{$moment(j, 'M').format('MMMM')}} 2022</div>
                                            <div class="calendar-header-day">
                                                <div class="day-number" v-for="number in getDaysInMonth(j-1, 2022)">
                                                       <span>
                                                           <span v-if="number%5==0"> {{number}}</span>
                                                       </span>
                                                    <span class="number-line"></span>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(graph, i) in dataGraph">
                                            <td v-for="i in 12">
                                                <div class="graph-card fact"
                                                     v-for="(info, index) in graph.data"
                                                     :class="{otherFact: getDifferenceDay(info.dbeg_fact, info.dend_fact) * 15 < 150}"
                                                     :style="'left:' + $moment(getMonthNumber(info.dbeg_fact), 'D').format('D')*15 + 'px; width:' +
                                                     getDifferenceDay(info.dbeg_fact, info.dend_fact) * 15 + 'px'"
                                                     v-if="$moment(getMonthNumber(info.dbeg_fact), 'M').format('M')  == i && info.dbeg_fact && info.dend_fact">
                                                        Начало -  {{info.dbeg_fact}}
                                                        Окончание - {{info.dend_fact}}
                                                </div>
                                                <div class="graph-card"
                                                     v-for="(info, index) in graph.data"
                                                     :class="{other: getDifferenceDay(info.dbeg_fact, info.dend_fact) * 15 < 150}"
                                                     :style="'left:' + $moment(getMonthNumber(info.dbeg_project), 'D').format('D')*15 + 'px; width:' +
                                                     getDifferenceDay(info.dbeg_project, info.dend_project) * 15 + 'px'"
                                                     v-if="$moment(getMonthNumber(info.dbeg_project), 'M').format('M')  == i && info.graph_data">
                                                    {{info.graph_data}}
                                                </div>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    moment.locale('ru')

    export default {
        name: "DrillingGraph",
        data(){
            return{
                dataGraph: [],
                currentYear: 2021,
                monthNames: [ "January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December" ],
            }
        },
        created(){
            this.getDataGraph()
        },
        methods: {
            close(){
                this.$emit('close')
            },
            getDaysInMonth(month, year) {
                let date = new Date(year, month, 1);
                let days = [];
                while (date.getMonth() === month) {
                    days.push(new Date(date).getDate());
                    date.setDate(date.getDate() + 1);
                }
                return days;
            },
            getDifferenceDay(dbeg, dend){
                let date1 = new Date(dbeg);
                let date2 = new Date(dend);

                var Difference_In_Time = date2.getTime() - date1.getTime();

                return Difference_In_Time / (1000 * 3600 * 24);
            },
            getMonthNumber(date){
                let dateNumber = new Date(date);
                return dateNumber
            },
            async getDataGraph(){
                try{
                    await this.axios.get('http://172.20.103.67:8630' + '/digital_drilling/daily_report/drilling_schedule/').then((response) => {
                        let data = response.data;
                        if (data) {
                            this.dataGraph =  data
                        } else {
                            console.log('No data');
                        }
                    });
                }
                catch (e) {
                    console.log(e)
                }
            },
        },
    }
</script>

<style scoped>
.drilling-graph{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 20000;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}
.drilling-graph-content{
    width: 90vw;
    margin: 60px auto;
    height: 80vh;
    background: #272953;
    box-shadow: 0px 7px 7px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
    padding: 15px;
    border: 1px solid #656A8A;
}
.drilling-graph-body{
    height: 100%;
}
.drilling-graph-header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: bold;
    color: #FFFFFF;
    margin-bottom: 20px;
}
.well_body-header-title{
    font-size: 18px;
    line-height: 22px;
}
.well_body-header-close{
    font-size: 14px;
    line-height: 15px;
    background: #656A8A;
    padding: 5px 18px;
    border-radius: 10px;
    cursor: pointer;
}
.drilling-graph-body-content{
    width: 100%;
    height: calc(100% - 45px);
    border: 1px solid #545580;
    overflow-x: scroll;
    overflow-y: scroll;
}
.graph{
    display: flex;
    align-items: flex-start;
    min-height: 100%;
    width: 100%;
}
.graph-left{
    flex: 0 0 350px!important;
}
.graph-right{
    width: auto;
    background: linear-gradient(0deg,rgba(13,43,77,0) 48%,#3C4270 50%,rgba(13,43,77,0) 52%), linear-gradient(-90deg,rgba(13,43,77,0) 48%,#3C4270 50%,rgba(13,43,77,0) 52%);
    background-size: 15px 15px;
    height: 100%;
}
.graph-right-calendar{
}
.calendar-header{
    position: relative;
}
thead th { position: sticky; top: 0; z-index: 100;}
.calendar-header-month{
    text-align: center;
    border-right: 1px solid #6D7196;
    background: #333975;
    height: 60px;
}
.calendar-header-name{
    height: 36px;
    vertical-align: center;
}
.calendar-header td{
    border-right: 1px solid #6D7196;
    border-bottom: 1px solid #6D7196;
    height: 200px;
    padding: 4px;
    position: relative;
}
.calendar-header .calendar-header-day{
    display: flex;
    align-items: center;
    font-size: 10px;
    background: #1C2154;
    border: 1px solid #545580;
}
.day-number{
    margin-right: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 10px;
}
.day-number span:first-child{
    height: 10px;
}
.number-line{
    width: 1px;
    height: 5px;
    background-color: #ffffff;
    margin-top: 5px;
}
.graph-name{
    position: relative;
}

.graph-name th{
    height: 60px;
    padding: 0 8px;
    font-size: 12px;
    border: 1px solid #545580;
    border-top: 0;
    border-left: 0;
    background: #333975;
}
.graph-name td{
    font-size: 12px;
    background: #333975;
    border-right: 1px solid #545580!important;
    border-bottom: 1px solid #545580!important;
    border-top: 0;
    border-left: 0;
    height: 200px;
    padding: 0 10px;
    text-align: center;
}
.graph-card{
    background: #E7FEEE;
    border: 0.5px solid #009847;
    box-sizing: border-box;
    border-radius: 10px;
    font-size: 11px;
    line-height: 12px;
    color: #000;
    padding: 3px 9px;
    max-height: 100%;
    position: absolute;
    top: 50px;
}
.graph-card.fact{
    font-size: 10px;
    font-weight: bold;
    background-color: #009847;
    top: 15px;
}
.otherFact{
    top: 5px;
}
.other{
    top: 80px;
}
</style>