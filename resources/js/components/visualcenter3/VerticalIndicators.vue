<template>
    <div>
        <div class="first-string">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td class="w-50">
                            <div class="first-td-header">
                                <div class="in-work">план</div>
                                <div class="txt4" v-if="specificIncomePlanTG">
                                    {{
                                        new Intl.NumberFormat("ru-RU").format(
                                            specificIncomePlanTG
                                        )
                                    }}
                                </div>
                                <div class="in-work">факт</div>
                                <div class="txt4" v-if="specificIncomeFactTG">
                                    {{
                                        new Intl.NumberFormat("ru-RU").format(
                                            specificIncomeFactTG
                                        )
                                    }}
                                </div>
                                <div class="in-idle">тенге/тонна</div>
                            </div>
                            <div class="second-td-header">
                                <div class="vert-line"></div>
                            </div>
                        </td>

                        <td class="w-50">
                            <div class="in-work">план</div>
                            <div class="txt4" v-if="specificIncomePlanUSD">
                                {{
                                    new Intl.NumberFormat("ru-RU").format(specificIncomePlanUSD)
                                }}
                            </div>
                            <div class="in-work">факт</div>
                            <div class="txt4" v-if="specificIncomeFactUSD">
                                {{
                                    new Intl.NumberFormat("ru-RU").format(specificIncomeFactUSD)
                                }}
                            </div>
                            <div class="in-idle">$/bbl</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="right-side-bottom">
                                <div class="txt2">Удельные доходы</div>
                                <div class="percent-arrow">
                                    <div class="arrow"></div>
                                    <div class="txt2-2">48%</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="first-string first-string2">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td class="w-50">
                            <div class="first-td-header">
                                <div class="in-work">план</div>
                                <div class="txt4" v-if="unitCostsPlanTG">
                                    {{ new Intl.NumberFormat("ru-RU").format(unitCostsPlanTG) }}
                                </div>
                                <div class="in-work">факт</div>
                                <div class="txt4" v-if="unitCostsFactTG">
                                    {{ new Intl.NumberFormat("ru-RU").format(unitCostsFactTG) }}
                                </div>
                                <div class="in-idle">тенге/тонна</div>
                            </div>
                            <div class="second-td-header">
                                <div class="vert-line"></div>
                            </div>
                        </td>

                        <td class="w-50">
                            <div class="in-work">план</div>
                            <div class="txt4" v-if="unitCostsPlanUSD">
                                {{ new Intl.NumberFormat("ru-RU").format(unitCostsPlanUSD) }}
                            </div>
                            <div class="in-work">факт</div>
                            <div class="txt4" v-if="unitCostsFactUSD">
                                {{ new Intl.NumberFormat("ru-RU").format(unitCostsFactUSD) }}
                            </div>
                            <div class="in-idle">$/bbl</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="right-side-bottom">
                                <div class="txt2">Удельные расходы</div>
                                <div class="percent-arrow">
                                    <div class="arrow"></div>
                                    <div class="txt2-2">48%</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="first-string first-string2">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td class="w-50">
                            <div class="first-td-header">
                                <div class="in-work">план</div>
                                <div class="txt4" v-if="kvlPerTonPlan">
                                    {{ new Intl.NumberFormat("ru-RU").format(kvlPerTonPlan) }}
                                </div>
                                <div class="in-idle">тенге/тонна</div>
                            </div>
                            <div class="second-td-header">
                                <div class="vert-line2"></div>
                            </div>
                        </td>
                        <td>
                            <div class="in-work">факт</div>
                            <div class="txt4" v-if="kvlPerTonFact">
                                {{ new Intl.NumberFormat("ru-RU").format(kvlPerTonFact) }}
                            </div>
                            <div class="in-idle">тенге/тонна</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="right-side-bottom">
                                <div class="txt2">КВЛ на тонну</div>
                            </div>
                        </td>
                        <td>
                            <div class="right-side-bottom">
                                <div class="arrow"></div>
                                <div class="txt2-2">48%</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="first-string first-string2">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td class="w-50">
                            <div class="first-td-header">
                                <div class="in-work">рентабельные</div>
                                <div class="txt4" v-if="actualEfficiencyGTMP">
                                    {{
                                        new Intl.NumberFormat("ru-RU").format(
                                            actualEfficiencyGTMP
                                        )
                                    }}
                                </div>
                                <div class="in-idle">тенге/тонна</div>
                            </div>
                            <div class="second-td-header">
                                <div class="vert-line2"></div>
                            </div>
                        </td>
                        <td class="w-50">
                            <div class="in-work">нерентабельные</div>
                            <div class="txt4" v-if="actualEfficiencyGTMUN">
                                {{
                                    new Intl.NumberFormat("ru-RU").format(actualEfficiencyGTMUN)
                                }}
                            </div>

                            <div class="in-idle">$/bbl</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="right-side-bottom">
                                <div class="txt2">Фактическая эффективность ГТМ</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="first-string first-string2">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td class="w-50">
                            <div class="first-td-header">
                                <div class="in-work">рентабельные</div>
                                <div class="txt4" v-if="actualDrillingEfficiencyP">
                                    {{
                                        new Intl.NumberFormat("ru-RU").format(
                                            actualDrillingEfficiencyP
                                        )
                                    }}
                                </div>
                                <div class="in-idle">тенге/тонна</div>
                            </div>
                            <div class="second-td-header">
                                <div class="vert-line2"></div>
                            </div>
                        </td>

                        <td class="w-50">
                            <div class="in-work">нерентабельные</div>
                            <div class="txt4" v-if="actualDrillingEfficiencyUN">
                                {{
                                    new Intl.NumberFormat("ru-RU").format(
                                        actualDrillingEfficiencyUN
                                    )
                                }}
                            </div>
                            <div class="in-idle">$/bbl</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="right-side-bottom">
                                <div class="txt2">Фактическая эффективность бурения</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="first-string first-string2">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td class="size-td">
                            <div class="margin-left-5-pc">
                                <div class="number">24</div>
                                <div class="in-idle2">млн. тенге</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="txt2">Штрафы и пени</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>
<script src="./VerticalIndicators.js"></script>