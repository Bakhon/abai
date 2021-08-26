<template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle">{{ trans('digital_drilling.gis.open_hole_logging') }}</p>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable gisTable">
                            <tr>
                                <th></th>
                                <th>{{ trans('digital_drilling.gis.radioactive_logging') }}</th>
                                <th>{{ trans('digital_drilling.gis.interval_times') }}</th>
                                <th>{{ trans('digital_drilling.gis.compressibility') }}</th>
                                <th>{{ trans('digital_drilling.gis.Kn_Res') }}</th>
                                <th>{{ trans('digital_drilling.gis.Kn_Acoustic') }}</th>
                            </tr>
                            <tr>
                                <td><p>{{ trans('digital_drilling.gis.depth') }}</p></td>
                                <td>
                                    <p class="inter red"><span class="first">U</span>{{ trans('digital_drilling.gis.GK') }} <i>{{ trans('digital_drilling.gis.gamma') }}</i><span class="second">12</span></p>
                                    <p class="inter blue"><span class="first">1</span>{{ trans('digital_drilling.gis.NK') }} <i>{{ trans('digital_drilling.gis.usd_ed') }}</i><span class="second">5</span></p>
                                </td>
                                <td>
                                    <p class="inter red"><span class="first">180</span>dtp <i>{{ trans('digital_drilling.gis.mks_m') }}</i><span class="second">280</span></p>
                                    <p class="inter blue"><span class="first">300</span>dts <i>{{ trans('digital_drilling.gis.mks_m') }}</i><span class="second">500</span></p>
                                </td>
                                <td>
                                    <p class="inter orange"><span class="first">2</span>Rn <i class="bold"></i><span class="second">0</span></p>
                                </td>
                                <td>
                                    <p>
                                        {{ trans('digital_drilling.gis.conclusion_on_IC') }}<br>
                                        21.09.94</p>
                                    <p class="inter red"><span class="first">0</span>{{ trans('digital_drilling.gis.Kn') }} <i class="bold"></i><span class="second">1</span></p>
                                </td>
                                <td>
                                    <p>
                                        {{ trans('digital_drilling.gis.conclusion_on_RAK') }}<br>
                                        05.12.96
                                    </p>
                                    <p class="inter red"><span class="first">0</span>{{ trans('digital_drilling.gis.Kn') }} <i class="bold"></i><span class="second">1</span></p>
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
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "gis"
    }
</script>

<style scoped>

</style>