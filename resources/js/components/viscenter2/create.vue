<template>
    <div>
        <table>
            <tr>
                <td class="fs" rowspan="3">Добыча нефти</td>
                <td class="bg" colspan="7">Добыча нефти, тонн</td>
                <td class="bg" colspan="7">Сдача нефти, тонн</td>
            </tr>
            <tr>
                <td class="bg" rowspan="2"> План на месяц,тонн</td>
                <td class="bg" colspan="3">За сутки</td>
                <td class="bg" colspan="3">С начала месяца</td>
                <td class="bg" rowspan="2">План на месяц,тонн</td>
                <td class="bg" colspan="3">За сутки</td>
                <td class="bg" colspan="3">С начала месяца</td>
            </tr>
            <tr>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
                <td class="bg">(+,-)</td>
            </tr>
            <tr>
                <td class="fs">Нефть,тн</td>
                <td>460538</td>
                <td><input disabled v-model="dobycha_nefti_plan"></td>
                <td>
                    <input type="float" name='dobycha_nefti_fact'  v-model="dobycha_nefti_fact" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="(this.dobycha_nefti_fact<this.dobycha_nefti_plan*0.5 && this.dobycha_nefti_fact>0) || this.dobycha_nefti_fact>this.dobycha_nefti_plan*2 || this.dobycha_nefti_fact==0">Вы уверены ?</div>
                    <div class="alert alert-warning" role="alert" v-if="this.dobycha_nefti_fact<0">Негативные значения не принимаются</div>
                </td>
                <td>3</td>
                <td>5</td>
                <td>7</td>
                <td>9</td>
                <td>459593</td>
                <td><input disabled v-model="sdacha_nefti_plan"></td>
                <td>
                    <input type="float" name='sdacha_nefti_fact'  v-model="sdacha_nefti_fact" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="(this.sdacha_nefti_fact<this.sdacha_nefti_plan*0.5 && this.sdacha_nefti_fact>0) || this.sdacha_nefti_fact>this.sdacha_nefti_plan*2 || this.sdacha_nefti_fact==0">Вы уверены ?</div>
                    <div class="alert alert-warning" role="alert" v-if="this.sdacha_nefti_fact<0">Негативные значения не принимаются</div>
                </td>
                <td>15</td>
                <td>17</td>
                <td>19</td>
                <td></td>
            </tr>
            <tr>
                <td class="fs">Конденсат,тн</td>
                <td>474</td>
                <td><input disabled v-model="dobycha_nefti_condensat_plan"></td>
                <td>
                    <input type="float" name='dobycha_nefti_condensat_fact'  v-model="dobycha_nefti_condensat_fact" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="(this.dobycha_nefti_condensat_fact<this.dobycha_nefti_condensat_plan*0.5 && this.dobycha_nefti_condensat_fact>0) || this.dobycha_nefti_condensat_fact>this.dobycha_nefti_condensat_plan*2 || this.dobycha_nefti_condensat_fact==0">Вы уверены ?</div>
                    <div class="alert alert-warning" role="alert" v-if="this.dobycha_nefti_condensat_fact<0">Негативные значения не принимаются</div>
                </td>
                <td>4</td>
                <td>6</td>
                <td>8</td>
                <td>10</td>
                <td>12</td>
                <td><input disabled v-model="sdacha_nefti_condensat_plan"></td>
                <td>
                    <input type="float" name='sdacha_nefti_condensat_fact'  v-model="sdacha_nefti_condensat_fact" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="(this.sdacha_nefti_condensat_fact<this.sdacha_nefti_condensat_plan*0.5 && this.sdacha_nefti_condensat_fact>0) || this.sdacha_nefti_condensat_fact>this.sdacha_nefti_condensat_plan*2 || this.sdacha_nefti_condensat_fact==0">Вы уверены ?</div>
                    <div class="alert alert-warning" role="alert" v-if="this.sdacha_nefti_condensat_fact<0">Негативные значения не принимаются</div>
                </td>
                <td>16</td>
                <td>18</td>
                <td>20</td>
                <td></td>
            </tr>

            <tr>
            <td colspan="8"></td>
            <td colspan="7">Дополнительная информация будет отображаться в этой ячейке</td>
            </tr>
        </table>

        <br>
        <br>

        <div class="left-side">
            <table>
                <tr>
                    <td class="fs" rowspan="2">Добыча газа</td>
                    <td class="bg" rowspan="2">План на месяц,тыс. м3</td>
                    <td class="bg" colspan="3">За сутки</td>
                    <td class="bg" colspan="3">С начала месяца</td>
                </tr>
                <tr>
                    <td class="bg">План</td>
                    <td class="bg">Факт</td>
                    <td class="bg">(+,-)</td>
                    <td class="bg">План</td>
                    <td class="bg">Факт</td>
                    <td class="bg">(+,-)</td>
                </tr>
                <tr>
                    <td class="fs">Всего, в т.ч.</td>
                    <td>1</td>
                    <td><input disabled v-model="dobycha_gaza_total_tch_plan"></td>
                    <td>
                        <input type="float" name='dobycha_gaza_total_tch_fact'  v-model="dobycha_gaza_total_tch_fact" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="(this.dobycha_gaza_total_tch_fact<this.dobycha_gaza_total_tch_plan*0.5 && this.dobycha_gaza_total_tch_fact>0) || this.dobycha_gaza_total_tch_fact>this.dobycha_gaza_total_tch_plan*2 || this.dobycha_gaza_total_tch_fact==0">Вы уверены ?</div>
                        <div class="alert alert-warning" role="alert" v-if="this.dobycha_gaza_total_tch_fact<0">Негативные значения не принимаются</div>

                    </td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td class="fs">Всего природный</td>
                    <td>7</td>
                    <td><input disabled v-model="dobycha_gaza_total_prirodnyi_plan"></td>
                    <td>
                        <input type="float" name='dobycha_gaza_total_prirodnyi_fact'  v-model="dobycha_gaza_total_prirodnyi_fact" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="(this.dobycha_gaza_total_prirodnyi_fact<this.dobycha_gaza_total_prirodnyi_plan*0.5 && this.dobycha_gaza_total_prirodnyi_fact>0) || this.dobycha_gaza_total_prirodnyi_fact>this.dobycha_gaza_total_prirodnyi_plan*2 || this.dobycha_gaza_total_prirodnyi_fact==0">Вы уверены ?</div>
                        <div class="alert alert-warning" role="alert" v-if="this.dobycha_gaza_total_prirodnyi_fact<0">Негативные значения не принимаются</div>
                    </td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                </tr>
                <tr>
                    <td class="fs">Газовые месторождения ДЗО</td>
                    <td>13</td>
                    <td><input disabled v-model="dobycha_gaza_gazovyie_mest_dzo_plan"></td>
                    <td>
                        <input type="float" name='dobycha_gaza_gazovyie_mest_dzo_fact'  v-model="dobycha_gaza_gazovyie_mest_dzo_fact" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="(this.dobycha_gaza_gazovyie_mest_dzo_fact<this.dobycha_gaza_gazovyie_mest_dzo_plan*0.5 && this.dobycha_gaza_gazovyie_mest_dzo_fact>0) || this.dobycha_gaza_gazovyie_mest_dzo_fact>this.dobycha_gaza_gazovyie_mest_dzo_plan*2 || this.dobycha_gaza_gazovyie_mest_dzo_fact==0">Вы уверены ?</div>
                        <div class="alert alert-warning" role="alert" v-if="this.dobycha_gaza_gazovyie_mest_dzo_fact<0">Негативные значения не принимаются</div>
                    </td>
                    <td>15</td>
                    <td>16</td>
                    <td>17</td>
                    <td>18</td>
                </tr>
                <tr>
                    <td class="fs">ГСП ДЗО</td>
                    <td>19</td>
                    <td><input disabled v-model="dobycha_gaza_gsp_dzo_plan"></td>
                    <td>
                        <input type="float" name='dobycha_gaza_gsp_dzo_fact'  v-model="dobycha_gaza_gsp_dzo_fact" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="(this.dobycha_gaza_gsp_dzo_fact<this.dobycha_gaza_gsp_dzo_plan*0.5 && this.dobycha_gaza_gsp_dzo_fact>0) || this.dobycha_gaza_gsp_dzo_fact>this.dobycha_gaza_gsp_dzo_plan*2 || this.dobycha_gaza_gsp_dzo_fact==0">Вы уверены ?</div>
                        <div class="alert alert-warning" role="alert" v-if="this.dobycha_gaza_gsp_dzo_fact<0">Негативные значения не принимаются</div>
                    </td>
                    <td>21</td>
                    <td>22</td>
                    <td>23</td>
                    <td>24</td>
                </tr>
                <tr>
                    <td class="fs">Попутный</td>
                    <td>25</td>
                    <td><input disabled v-model="dobycha_gaza_poputnyi_plan"></td>
                    <td>
                        <input type="float" name='dobycha_gaza_poputnyi_fact'  v-model="dobycha_gaza_poputnyi_fact" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="(this.dobycha_gaza_poputnyi_fact<this.dobycha_gaza_poputnyi_plan*0.5 && this.dobycha_gaza_poputnyi_fact>0) || this.dobycha_gaza_poputnyi_fact>this.dobycha_gaza_poputnyi_plan*2 || this.dobycha_gaza_poputnyi_fact==0">Вы уверены ?</div>
                        <div class="alert alert-warning" role="alert" v-if="this.dobycha_gaza_poputnyi_fact<0">Негативные значения не принимаются</div>
                    </td>
                    <td>27</td>
                    <td>28</td>
                    <td>29</td>
                    <td>30</td>
                </tr>

            </table>


            <br><br>
            <table>
                <tr>
                    <td class="fs" rowspan="2">Закачка воды, тыс.м3</td>
                    <td class="bg" rowspan="2">План на месяц,тыс. м3</td>
                    <td class="bg" colspan="3">За сутки</td>
                    <td class="bg" colspan="3">С начала месяца</td>
                </tr>
                <tr>
                    <td class="bg">План</td>
                    <td class="bg">Факт</td>
                    <td class="bg">(+,-)</td>
                    <td class="bg">План</td>
                    <td class="bg">Факт</td>
                    <td class="bg">(+,-)</td>
                </tr>
                <tr>
                    <td class="fs">Всего</td>
                    <td>4760</td>
                    <td><input disabled v-model="zakachka_vody_total_plan"></td>
                    <td>
                        <input type="float" name='zakachka_vody_total_fact'  v-model="zakachka_vody_total_fact" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="(this.zakachka_vody_total_fact<this.zakachka_vody_total_plan*0.5 && this.zakachka_vody_total_fact>0) || this.zakachka_vody_total_fact>this.zakachka_vody_total_plan*2 || this.zakachka_vody_total_fact==0">Вы уверены ?</div>
                        <div class="alert alert-warning" role="alert" v-if="this.zakachka_vody_total_fact<0">Негативные значения не принимаются</div>
                    </td>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td class="fs">В т. ч. морская</td>
                    <td>1111</td>
                    <td><input disabled v-model="zakachka_vody_tch_morskaya_plan"></td>
                    <td>
                        <input type="float" name='zakachka_vody_tch_morskaya_fact'  v-model="zakachka_vody_tch_morskaya_fact" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="(this.zakachka_vody_tch_morskaya_fact<this.zakachka_vody_tch_morskaya_plan*0.5 && this.zakachka_vody_tch_morskaya_fact>0) || this.zakachka_vody_tch_morskaya_fact>this.zakachka_vody_tch_morskaya_plan*2 || this.zakachka_vody_tch_morskaya_fact==0">Вы уверены ?</div>
                        <div class="alert alert-warning" role="alert" v-if="this.zakachka_vody_tch_morskaya_fact<0">Негативные значения не принимаются</div>
                    </td>
                    <td>5</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td class="fs">Сточная</td>
                    <td>3649</td>
                    <td><input disabled v-model="zakachka_vody_stochnaya_plan"></td>
                    <td>
                        <input type="float" name='zakachka_vody_stochnaya_fact'  v-model="zakachka_vody_stochnaya_fact" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="(this.zakachka_vody_stochnaya_fact<this.zakachka_vody_stochnaya_plan*0.5 && this.zakachka_vody_stochnaya_fact>0) || this.zakachka_vody_stochnaya_fact>this.zakachka_vody_stochnaya_plan*2 || this.zakachka_vody_stochnaya_fact==0">Вы уверены ?</div>
                        <div class="alert alert-warning" role="alert" v-if="this.zakachka_vody_stochnaya_fact<0">Негативные значения не принимаются</div>
                    </td>
                    <td>9</td>
                    <td>10</td>
                    <td>11</td>
                    <td>12</td>
                </tr>
            </table>
        </div>

        <div class="right-side">
            <table>
                <tr>
                    <td class="bg" colspan="2">Простой добывающих скважин</td>
                </tr>

                <tr>
                    <td class="left">ОПРС</td>
                    <td>
                        <input type="float" name='oprs' v-model="oprs"  class="square2">
                        <div class="alert alert-warning" role="alert" v-if="this.oprs<0">Негативные значения не принимаются</div>
                        <div class="alert alert-warning" role="alert" v-if="this.oprs==0">Вы уверены?</div>
                    </td>
                </tr>
                <tr>
                    <td class="left">ПРС</td>
                    <td>
                        <input type="float" name='prs' v-model="prs" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="this.prs<0">Негативные значения не принимаются</div>
                        <div class="alert alert-warning" role="alert" v-if="this.prs==0">Вы уверены?</div>
                    </td>
                </tr>
                <tr>
                    <td class="left">ОКРС</td>
                    <td>
                        <input type="float" name='okrs' v-model="okrs" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="this.okrs<0">Негативные значения не принимаются</div>
                        <div class="alert alert-warning" role="alert" v-if="this.okrs==0">Вы уверены?</div>
                    </td>
                </tr>
                <tr>
                    <td class="left">КРС</td>
                    <td>
                        <input type="float" name='krs' v-model="krs" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="this.krs<0">Негативные значения не принимаются</div>
                        <div class="alert alert-warning" role="alert" v-if="this.krs==0">Вы уверены?</div>
                    </td>
                </tr>
                <tr>
                    <td class="left">Исследования скважин</td>
                    <td>
                        <input type="float" name='wells_study' v-model="wells_study" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="this.wells_study<0">Негативные значения не принимаются</div>
                        <div class="alert alert-warning" role="alert" v-if="this.wells_study==0">Вы уверены?</div>
                    </td>
                </tr>

                <tr>
                    <td class="left">Нерентабельные</td>
                    <td>
                        <input type="float" name='unprofitable' v-model="unprofitable" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="this.unprofitable<0">Негативные значения не принимаются</div>
                        <div class="alert alert-warning" role="alert" v-if="this.unprofitable==0">Вы уверены?</div>
                    </td>
                </tr>
                <tr>
                    <td class="left">Ограничение скважин по добыче</td>
                    <td>
                        <input type="float" name='mining_wells_restriction' v-model="mining_wells_restriction" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="this.mining_wells_restriction<0">Негативные значения не принимаются</div>
                        <div class="alert alert-warning" role="alert" v-if="this.mining_wells_restriction==0">Вы уверены?</div>
                    </td>
                </tr>

                <tr>
                    <td class="left">Прочие</td>
                    <td>
                        <input type="float" name='others' v-model="others" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="this.others<0">Негативные значения не принимаются</div>
                        <div class="alert alert-warning" role="alert" v-if="this.others==0">Вы уверены?</div>
                    </td>
                </tr>
                <tr>
                    <td class="left">Всего</td>
                    <td>483</td>
                </tr>
                <tr>
                    <td class="left">Недобор нефти, тонн</td>
                    <td>1212</td>
                </tr>
            </table>

        </div>

        <div class="right-side2">
            <table>
                <tr>
                    <td class="left">Товарный остаток, тонн</td>
                </tr>
                <tr>
                    <td>
                        <input type="float" name='tovarnyi_ostatok' v-model="tovarnyi_ostatok" class="square2">
                        <div class="alert alert-warning" role="alert" v-if="this.tovarnyi_ostatok<0">Негативные значения не принимаются</div>
                        <div class="alert alert-warning" role="alert" v-if="this.tovarnyi_ostatok==0">Вы уверены?</div>
                    </td>
                </tr>
            </table>

        </div>

        <div class="right-side2">
            <table>
                <tr>
                    <td class="left">Выбор ДЗО</td>
                </tr>
                <tr>
                    <td>
                        <select class="form-control"  name="dzo" v-model="dzo" v-show="dzos.length > 0">
                        <option v-for="row in dzos" v-bind:value="row.id">{{ row.name }}</option>
                        </select>
                    </td>
                </tr>
            </table>

        </div>

        <br><br>
        <table>
            <tr>
                <td class="fs" rowspan="3">Динамика фонда скважин</td>
                <td class="bg" colspan="5">Добывающий фонд</td>
                <td class="bg" rowspan="2">Ожидание ликвидации</td>
                <td class="bg" rowspan="2">В консервации</td>
                <td class="bg" colspan="5">Нагнетательный фонд</td>
                <td class="bg" rowspan="2">Ожидание ликвидации</td>
                <td class="bg" rowspan="2">В консервации</td>
            </tr>
            <tr>
                <td class="bg">Экспл.</td>
                <td class="bg">Действ.</td>
                <td class="bg">Простой</td>
                <td class="bg">Б/д</td>
                <td class="bg">Освоение</td>
                <td class="bg">Экспл.</td>
                <td class="bg">Действ.</td>
                <td class="bg">Простой</td>
                <td class="bg">Б/д</td>
                <td class="bg">Обустройство</td>
            </tr>
            <tr>
                <td>
                    <input type="integer" name='expl' v-model="expl" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.expl<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.expl==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='deistv' v-model="deistv" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.deistv<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.deistv==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='prostoy' v-model="prostoy" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.prostoy<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.prostoy==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='b_d' v-model="b_d" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.b_d<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.b_d==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='osvoenie' v-model="osvoenie" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.osvoenie<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.osvoenie==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='ozhidanie_likvidacii' v-model="ozhidanie_likvidacii" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.ozhidanie_likvidacii<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.ozhidanie_likvidacii==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='v_konservacii' v-model="v_konservacii" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.v_konservacii<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.v_konservacii==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='expl2' v-model="expl2" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.expl2<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.expl2==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='deistv2' v-model="deistv2" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.deistv2<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.deistv2==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='prostoy2' v-model="prostoy2" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.prostoy2<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.prostoy2==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='b_d2' v-model="b_d2" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.b_d2<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.b_d2==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='obustroystvo' v-model="obustroystvo" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.obustroystvo<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.obustroystvo==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='ozhidanie_likvidacii2' v-model="ozhidanie_likvidacii2" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.ozhidanie_likvidacii2<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.ozhidanie_likvidacii2==0">Вы уверены?</div>
                </td>
                <td>
                    <input type="integer" name='v_konservacii2' v-model="v_konservacii2" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.v_konservacii2<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.v_konservacii2==0">Вы уверены?</div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="7">Здесь будет дополнительная информация </td>
                <td colspan="7">Здесь будет дополнительная информация </td>
            </tr>
        </table>

        <br><br>

        <table>
            <tr>
                <td class="fs" rowspan="4">Бурение скважин</td>
                <td class="bg" colspan="7">Проходка, метр</td>
                <td class="bg" colspan="4">Ввод скважин</td>
            </tr>
            <tr>
                <td class="bg" rowspan="2">План на месяц</td>
                <td class="bg" colspan="3">Суточная</td>
                <td class="bg" colspan="3">С начала месяца</td>
                <td class="bg" rowspan="2">План на месяц</td>
                <td class="bg">За сутки</td>
                <td class="bg" colspan="2">С начала месяца</td>
            </tr>
            <tr>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
                <td class="bg">(+,-)</td>
                <td class="bg">Факт</td>
                <td class="bg">План</td>
                <td class="bg">Факт</td>
            </tr>
            <tr>
                <td>26828</td>
                <td><input disabled v-model="burenie_skvajin_prohodka_plan"></td>
                <td>
                    <input type="float" name='burenie_skvajin_prohodka_fact'  v-model="burenie_skvajin_prohodka_fact" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="(this.burenie_skvajin_prohodka_fact<this.burenie_skvajin_prohodka_plan*0.5 && this.burenie_skvajin_prohodka_fact>0) || this.burenie_skvajin_prohodka_fact>this.burenie_skvajin_prohodka_plan*2 || this.burenie_skvajin_prohodka_fact==0">Вы уверены ?</div>
                    <div class="alert alert-warning" role="alert" v-if="this.burenie_skvajin_prohodka_fact<0">Негативные значения не принимаются</div>
                </td>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>19</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
            </tr>
        </table>

        <br><br>
        <table>
            <tr>
                <td class="fs">Причины невыполнения</td>
            </tr>
        </table>

        <br>
        <table>
            <tr>
                <td class="bg" colspan="9">Аварийные остановки месторождения (откл.эл.энергий и др.)</td>
            </tr>
            <tr>
                <td class="bg" rowspan="2">НГДУ</td>
                <td class="bg" rowspan="2">ГУ</td>
                <td class="bg" rowspan="2">Кол.скв.</td>
                <td class="bg" rowspan="2">Вр.откл.</td>
                <td class="bg" rowspan="2">Вр.вкл.</td>
                <td class="bg" colspan="2">Потери</td>
                <td class="bg" rowspan="2">Вр.прост.,мин</td>
                <td class="bg" rowspan="2">Причины аварийного отключения</td>
            </tr>
            <tr>
                <td class="bg">Qж м3.</td>
                <td class="bg">Qн тн.</td>
            </tr>
            <tr>
                <td>Итого</td>
                <td></td>
                <td>19</td>
                <td></td>
                <td></td>
                <td>6,9</td>
                <td>0,8</td>
                <td>0:11</td>
                <td></td>
            </tr>
            <tr>
                <td> 
                    <input type="float" name='ngdu' v-model="ngdu" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.ngdu<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.ngdu==0">Вы уверены?</div>
                </td>
                <td> 
                    <input type="float" name='gu' v-model="gu" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.gu<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.gu==0">Вы уверены?</div>
                </td>
                <td> 
                    <input type="integer" name='well_number' v-model="well_number" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.well_number<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.well_number==0">Вы уверены?</div>
                </td>
                <td> 
                    <input type="text" name='shutdown_time'  class="square2">
                </td>
                <td> 
                    <input type="text" name='turnon_time'  class="square2">
                </td>
                <td> 
                    <input type="float" name='qzh_loss' v-model="qzh_loss" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.qzh_loss<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.qzh_loss==0">Вы уверены?</div>
                </td>
                <td> 
                    <input type="float" name='qn_loss' v-model="qn_loss" class="square2">
                    <div class="alert alert-warning" role="alert" v-if="this.qn_loss<0">Негативные значения не принимаются</div>
                    <div class="alert alert-warning" role="alert" v-if="this.qn_loss==0">Вы уверены?</div>
                </td>
                <td> 
                    <input type="text" name='prostoy_time'  class="square2">
                </td>
                <td> 
                    <input type="text" name='emerg_shutdown_reason'  class="square2">
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <button type="submit" :disabled="this.dobycha_nefti_fact<0 || this.dobycha_nefti_condensat_fact<0 || this.sdacha_nefti_fact<0 || this.sdacha_nefti_condensat_fact<0 ||  this.dobycha_gaza_total_tch_fact<0 || this.dobycha_gaza_total_prirodnyi_fact<0 || this.dobycha_gaza_gazovyie_mest_dzo_fact<0 || this.dobycha_gaza_gsp_dzo_fact<0 || this.dobycha_gaza_poputnyi_fact<0 || this.zakachka_vody_total_fact<0 || this.zakachka_vody_tch_morskaya_fact<0 || this.zakachka_vody_stochnaya_fact<0 || this.burenie_skvajin_prohodka_fact<0 || this.oprs<0 || this.prs<0 || this.okrs<0 || this.krs<0 || this.wells_study<0 || this.unprofitable<0 || this.mining_wells_restriction<0 || this.others<0 || this.tovarnyi_ostatok<0 || this.expl<0 || this.deistv<0 || this.prostoy<0 || this.b_d<0 || this.osvoenie<0 || this.ozhidanie_likvidacii<0 || this.v_konservacii<0 || this.expl2<0 || this.deistv2<0 || this.prostoy2<0 || this.b_d2<0 || this.obustroystvo<0 || this.ozhidanie_likvidacii2<0 || this.v_konservacii2<0" class="btn btn-primary">Сохранить</button>
    </div>
</template>











        

<script>

export default {
  data: function () {
    return {
        dobycha_gaza_total_tch_plan:2, 
        dobycha_gaza_total_tch_fact:null,
        dobycha_gaza_total_prirodnyi_plan:8,
        dobycha_gaza_total_prirodnyi_fact:null,
        dobycha_gaza_gazovyie_mest_dzo_plan:14,
        dobycha_gaza_gazovyie_mest_dzo_fact:null,
        dobycha_gaza_gsp_dzo_plan:20,
        dobycha_gaza_gsp_dzo_fact:null,
        dobycha_gaza_poputnyi_plan:26,
        dobycha_gaza_poputnyi_fact:null,
        dobycha_nefti_plan:1,
        dobycha_nefti_fact:null,
        dobycha_nefti_condensat_plan:2,
        dobycha_nefti_condensat_fact:null,
        sdacha_nefti_plan:13,
        sdacha_nefti_fact:null,
        sdacha_nefti_condensat_plan:14,
        sdacha_nefti_condensat_fact:null,
        zakachka_vody_total_plan:154,
        zakachka_vody_total_fact:null,
        zakachka_vody_tch_morskaya_plan:36,
        zakachka_vody_tch_morskaya_fact:null,
        zakachka_vody_stochnaya_plan:118,
        zakachka_vody_stochnaya_fact:null,
        burenie_skvajin_prohodka_plan:865,
        burenie_skvajin_prohodka_fact:null,
        oprs:null,
        prs:null,
        okrs:null,
        krs:null,
        wells_study:null,
        unprofitable:null,
        mining_wells_restriction:null,
        others:null,
        expl:null,
        deistv:null,
        prostoy:null,
        b_d:null,
        osvoenie:null,
        ozhidanie_likvidacii:null,
        v_konservacii:null,
        expl2:null,
        deistv2:null,
        prostoy2:null,
        b_d2:null,
        obustroystvo:null,
        ozhidanie_likvidacii2:null,
        v_konservacii2:null,
        ngdu:null,
        gu:null,
        well_number:null,
        qzh_loss:null,
        qn_loss:null,
        tovarnyi_ostatok:null,
        dzo:null,
        dzos: [
            {"id":"1", "name" : "КБМ"},
            {"id":"2", "name" : "КГМ"},
            {"id":"3", "name" : "КОА"},
            {"id":"4", "name" : "КТМ"},
            {"id":"5", "name" : "ММГ"},
            {"id":"6", "name" : "ОМГ"}
        ],
    }
  },
    
};
</script>
<style scoped>

</style>
