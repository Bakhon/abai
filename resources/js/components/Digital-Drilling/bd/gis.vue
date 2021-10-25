<template>
    <div class="digitalDrillingWindow">
        <div class="gis-header">
            <span>ДЗО</span>
            <span>Месторождение</span>
            <span>Скважина 411</span>
        </div>
        <div class="gis-graph">
            <table class="table default-table gis-table">
                <tr>
                    <th class="width-90"></th>
                    <th>{{ trans('digital_drilling.gis.radioactive_logging') }}</th>
                    <th>{{ trans('digital_drilling.gis.interval_times') }}</th>
                    <th>{{ trans('digital_drilling.gis.compressibility') }}</th>
                    <th>{{ trans('digital_drilling.gis.Kn_Res') }}</th>
                    <th>{{ trans('digital_drilling.gis.Kn_Acoustic') }}</th>
                </tr>
                <tr class="border-left">
                    <td class="align-bottom">{{ trans('digital_drilling.gis.depth') }}</td>
                    <td>
                        <p class="inter red">
                            <span class="first">U</span>
                            <span class="text">{{ trans('digital_drilling.gis.GK') }}
                            <i>{{ trans('digital_drilling.gis.gamma') }}</i></span>
                            <span class="second">12</span>
                        </p>
                    </td>
                    <td>
                        <p class="inter red"><span class="first">180</span>
                            <span class="text">
                                dtp <i>{{ trans('digital_drilling.gis.mks_m') }}</i>
                            </span>
                            <span class="second">280</span></p>

                    </td>
                    <td></td>
                    <td class="text-center">
                        {{ trans('digital_drilling.gis.conclusion_on_IC') }}<br>
                        21.09.94
                    </td>
                    <td class="text-center">
                        {{ trans('digital_drilling.gis.conclusion_on_RAK') }}<br>
                        05.12.96
                    </td>
                </tr>
                <tr class="b_color">
                    <td></td>
                    <td>
                        <p class="inter blue">
                            <span class="first">1</span>
                            <span class="text">{{ trans('digital_drilling.gis.NK') }}
                            <i>{{ trans('digital_drilling.gis.usd_ed') }}</i></span>
                            <span class="second">5</span></p>
                    </td>
                    <td>
                        <p class="inter blue"><span class="first">300</span>
                            <span class="text">
                                dts <i>{{ trans('digital_drilling.gis.mks_m') }}</i>
                                </span>
                            <span class="second">500</span></p>
                    </td>
                    <td>
                        <p class="inter orange flex"><span class="first">2</span>
                            <span class="text">
                                Rn <span class="bold"></span>
                            </span>
                            <span class="second">0</span></p>
                    </td>
                    <td>
                        <p class="inter sangria_red flex">
                            <span class="first">0</span>
                            <span class="text">
                                {{ trans('digital_drilling.gis.Kn') }}
                            <i class="bold"></i>
                            </span>
                            <span class="second">1</span></p>
                    </td>
                    <td>
                        <p class="inter sangria_red flex">
                            <span class="first">0</span>
                            <span class="text">
                                {{ trans('digital_drilling.gis.Kn') }}
                            <i class="bold"></i>
                            </span>
                            <span class="second">1</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="graphText">1 800</p>
                        <p class="graphText">1 802</p>
                        <p class="graphText">1 004</p>
                        <p class="graphText">1 806</p>
                        <p class="graphText">1 808</p>
                        <p class="graphText">1 010</p>
                        <p class="graphText">1 812</p>
                        <p class="graphText">1 014</p>
                        <p class="graphText">1 816</p>
                        <p class="graphText">1 818</p>
                        <p class="graphText">1 020</p>
                        <p class="graphText">1 822</p>
                        <p class="graphText">1 824</p>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "gis"
    }
</script>

<style scoped>
    .digitalDrillingWindow {
        font-family: Harmonia Sans Pro Cyr;
        background: #34365D;
        width: 100%;
        height: 100%;
    }
    .digitalDrillingWindow .gis-header{
        display: flex;
        align-items: center;
        font-style: normal;
        font-weight: bold;
        font-size: 16px;
        line-height: 19px;
        color: #FFFFFF;
        padding: 14px 8px;
    }
    .digitalDrillingWindow .gis-header span{
        border-right: 1px solid #a7a8bc;
        padding-right: 5px;
        margin-right: 5px;
    }
    .digitalDrillingWindow .gis-header span:last-child{
        border-right: 0;
        padding-right: 0;
        margin-right: 0;
    }
    .gis-graph{
        padding: 5px;
    }
    .table{
        background: #272953
    }
    .table tr th{
        border: 1px solid #545580;
        background: #333975;
        text-align: center;
    }
    .table tr td{
        border: 1px solid #545580;
        border-top: 0;
    }
    .table tr.border-left td{
        border-left: 1px solid #545580;
        border-right: 1px solid #545580;
        border-bottom: 0;
        background: rgba(52, 54, 93, 94);
    }
    .table tr.b_color td{
        background: rgba(69, 77, 125, 0.3);
    }
    .graphText{
        font-weight: bold;
        font-size: 13px;
        line-height: 16px;
        color: #FFFFFF;
        margin-bottom: 20px;
    }
    .width-90{
        width: 90px;
    }
    p.inter{
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 20px 0 0;
    }
    p.inter.blue .text i{
        color: #82BAFF;
        border-bottom: 1px solid #82BAFF;

    }
    p.inter.red .text i{
        color: #E3000F;
        border-bottom: 1px solid #E3000F;
    }
    p.inter.red .text{
        color: #E3000F;
        margin-top: -35px;
    }
    p.inter.red{
        border-bottom: 1px solid #545580;
        padding-bottom: 3px;
    }
    p.inter.blue{
        margin: 0;
    }
    p.inter .text i{
        padding-bottom: 2px;
        margin: -2px 0 0 5px;
    }

    p.inter.blue .text{
        color: #82BAFF;
        margin-top: -10px;
    }
    p.inter.orange, p.inter.sangria_red{
        margin-top: 0;
    }
    p.inter.flex .text{
        display: flex;
        align-items: flex-end;
    }
    p.inter .text .bold{
        height: 2px;
        width: 50px;
        display: block;
        margin-left: 4px;
    }
    p.inter.orange .text .bold{
        color: #FBA409;
        background-color: #FBA409;
    }
    p.inter.orange .text{
        color: #FBA409;
        margin-top: -10px;
    }
     p.inter.sangria_red .text .bold{
         color: #FF0000;
         background-color: #FF0000;
     }
    p.inter.sangria_red .text{
        color: #FF0000;
        margin-top: -10px;
    }
</style>