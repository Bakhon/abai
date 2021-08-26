<template>
  <div class="flex-container">
    <div class="flex__item__block__1">
      <div class="title__block">{{ trans('pgno.chislo_kachanii') }}</div>
      <div class="title__block__min__1">
        <span class="pr-87 pl-2">{{ trans('pgno.minimum') }}</span>
        <input v-model="settings.spmMin" class="shgn-input" type="text">
        {{ trans('measurements.m3/day') }}
      </div>
      <div class="title__block__max__1">
        <span class="pr-80 pl-2">{{ trans('pgno.maximum') }}</span>
        <input v-model="settings.spmMax" class="shgn-input" type="text">
        {{ trans('measurements.m3/day') }}
      </div>
    </div>

    <div class="flex__item__block__1">
      <div class="title__block">{{ trans('pgno.dlina_hoda') }}</div>
      <div class="title__block__min__1">
        <span class="pr-87 pl-2">{{ trans('pgno.minimum') }}</span>
        <input v-model="settings.strokeLenMin" class="shgn-input" type="text">
        {{ trans('measurements.m3/day') }}
      </div>
      <div class="title__block__max__1">
        <span class="pr-80 pl-2">{{ trans('pgno.maximum') }}</span>
        <input v-model="settings.strokeLenMax" class="shgn-input" type="text">
        {{ trans('measurements.m3/day') }}
      </div>
    </div>

    <div class="flex__item__block__1">
      <div class="title__block">{{ trans('pgno.kpod') }}</div>
      <div class="title__block__max" style="display: flex; flex-direction: column;">
        <div class="block1">
          <div class="title__block__kpod">
            <input class="checkbox__block__1" v-model="settings.kPodMode" type="radio" v-bind:value="true"/>
            <label class="label-kpod">{{ trans('pgno.calc_min_value') }}</label>
            <input type="text" class="input-box-gno podbor-kpod-block-3" v-model="settings.kpodMin"
                   :disabled="!kPodMode">
          </div>
        </div>

        <div class="block2">
          <div class="title__block__kpod">
            <input class="checkbox__block__1" v-model="settings.kPodMode" type="radio" v-bind:value="false"/>
            <label class="label-kpod">{{ trans('pgno.use_value') }}</label>
            <input type="text" class="input-box-gno podbor-kpod-block-3" v-model="kpodCalced" :disabled="true">
          </div>
        </div>

        <div class="block3">
          <div class="title__block__kpod" style="display: flex; flex-direction: row; ">
            <div class="asd" style="width: 55px; text-align: center;">Ø</div>
            <div class="asd" style="width: 80px; text-align: center;">Длина хода</div>
            <div class="asd" style="width: 95px; text-align: center;">Число качаний</div>
            <div class="asd">Qж</div>
          </div>
        </div>
        <div class="block4">
          <div class="title__block__pump__1__flex">

            <select class="input-box-gno k-pod" v-model="kPodSettings.pumpType" @change="calKpod()">
              <option v-for="dm in diametersShgn" :key="dm.value" :value="dm.pumpType">
                {{ dm.value }}
              </option>
            </select>
            <input type="text" class="input-box-gno podbor-kpod-block-1" v-model="kPodSettings.strokeLen" @change="calKpod()">
            <input type="text" class="input-box-gno podbor-kpod-block-2" v-model="kPodSettings.spm" @change="calKpod()">
            <input type="text" class="input-box-gno podbor-kpod-block-3" v-model="kPodSettings.ql" @change="calKpod()">

          </div>
        </div>

      </div>
    </div>
    <div class="flex__item__block__1">
      <div class="title__block"><span>{{ trans('pgno.diametr_nasosov') }}, {{ trans('measurements.mm') }}</span></div>
      <div class="title__block__pump">
        <div class="title__block__pump_list">

          <div class="title__block__pump__1">
            <input class="checkbox__block__1" v-model="settings.pumpTypes" value="27" type="checkbox"/>
            <label class="checkbox__block__label__1">27</label>
          </div>

          <div class="title__block__pump__1">
            <input class="checkbox__block__1" v-model="settings.pumpTypes" value="32" type="checkbox"/>
            <label class="checkbox__block__label__1">32</label>
          </div>

          <div class="title__block__pump__1">
            <input class="checkbox__block__1" v-model="settings.pumpTypes" value="38" type="checkbox"/>
            <label class="checkbox__block__label__1">38</label>
          </div>

        </div>

        <div class="title__block__pump_list__2">

          <div class="title__block__pump__1">
            <input class="checkbox__block__1" v-model="settings.pumpTypes" value="44" type="checkbox"/>
            <label class="checkbox__block__label__1">44</label>
          </div>

          <div class="title__block__pump__1">
            <input class="checkbox__block__1" v-model="settings.pumpTypes" value="50" type="checkbox"/>
            <label class="checkbox__block__label__1">50</label>
          </div>

          <div class="title__block__pump__1">
            <input class="checkbox__block__1" v-model="settings.pumpTypes" value="57" type="checkbox"/>
            <label class="checkbox__block__label__1">57</label>
          </div>

        </div>

        <div class="title__block__pump_list__3">

          <div class="title__block__pump__1">
            <input class="checkbox__block__1" v-model="settings.pumpTypes" value="60" type="checkbox"/>
            <label class="checkbox__block__label__1">60</label>
          </div>

          <div class="title__block__pump__1">
            <input class="checkbox__block__1" v-model="settings.pumpTypes" value="70" type="checkbox"/>
            <label class="checkbox__block__label__1">70</label>
          </div>

          <div class="title__block__pump__1">
            <input class="checkbox__block__1" v-model="settings.pumpTypes" value="95" type="checkbox"/>
            <label class="checkbox__block__label__1">95</label>
          </div>

        </div>
      </div>


    </div>

    <div class="flex__item__block__1">

      <div class="title__block"><u>{{ trans('pgno.group_posadka') }}</u>
        <img @click="onClick()" src="../../../images/info-shgn.svg" alt="">
      </div>

      <div class="title__block__pump">
        <div class="title__block__pump_list">

          <div class="title__block__pump__1">
            <input value="1" class="checkbox__block__1" v-model="settings.groupPosad" name="posad1" type="radio"/>
            <label class="checkbox__block__label__1">1</label>
          </div>

          <div class="title__block__pump__1">
            <input value="2" class="checkbox__block__1" v-model="settings.groupPosad" name="posad1" type="radio"/>
            <label class="checkbox__block__label__1">2</label>
          </div>

          <div class="title__block__pump__1">
            <input value="3" class="checkbox__block__1" v-model="settings.groupPosad" name="posad1" type="radio"/>
            <label class="checkbox__block__label__1">3</label>
          </div>

        </div>

        <div class="title__block__pump_list__2">

          <div class="title__block__pump__1">
            <input value="4" class="checkbox__block__1" v-model="settings.groupPosad" name="posad1" type="radio"/>
            <label class="checkbox__block__label__1">4</label>
          </div>

          <div class="title__block__pump__1">
            <input value="5" class="checkbox__block__1" v-model="settings.groupPosad" name="posad1" type="radio"/>
            <label class="checkbox__block__label__1">5</label>
          </div>

          <div class="title__block__pump__1__text">
            <input value="podbor" class="checkbox__block__1" v-model="settings.groupPosad" name="posad1"
                   type="radio"/>
            <label class="checkbox__block__label__1">{{ trans('pgno.podbor') }}</label>
          </div>

        </div>
      </div>

    </div>

    <div class="flex__item__block__1">
      <div class="title__block">{{ trans('pgno.prim_komponovka') }}</div>
      <div class="title__block__pump">
        <div class="block__dm__pump__1">
          <input type="checkbox" v-model="settings.komponovka" value="yakor"/>
          <label for="checkbox1">{{ trans('pgno.yakor_truboderzhatel') }}</label>
        </div>


        <div class="block__dm__pump__2">
          <input type="checkbox" v-model="settings.komponovka" value="paker"/>
          <label for="checkbox1">{{ trans('pgno.paker') }}</label>
        </div>

        <div class="block__dm__pump__3">
          <input type="checkbox" v-model="settings.komponovka" value="hvostovik"/>
          <label for="checkbox1">{{ trans('pgno.hvostovik') }}</label>
        </div>

      </div>
    </div>

    <div class="flex__item__block__1">
      <div class="title__block">{{ trans('pgno.kon_kolony_shtang') }}</div>
      <div class="title__block__pump">
        <div class="title__block__pump_list">

          <div class="title__block__pump__1">
            <input value="1" class="checkbox__block__1" v-model="settings.stupColumns" name="stup" type="radio"/>
            <label class="checkbox__block__label__1">1 {{ trans('pgno.stup') }}</label>
          </div>

          <div class="title__block__pump__1">
            <input value="2" class="checkbox__block__1" v-model="settings.stupColumns" name="stup" type="radio"/>
            <label class="checkbox__block__label__1">2 {{ trans('pgno.stup') }}</label>
          </div>

          <div class="title__block__pump__1">
            <input value="3" class="checkbox__block__1" v-model="settings.stupColumns" name="stup" type="radio"
                   :disabled="true"/>
            <label class="checkbox__block__label__1">3 {{ trans('pgno.stup') }}</label>
          </div>

        </div>
        <div class="title__block__pump_list__2">
          <div class="title__block__pump__1__heavy__down">
            <input class="checkbox__block__1" v-model="settings.heavyDown" name="stup" type="checkbox"/>
            <label class="checkbox__block__label__1">{{ trans('pgno.heavy_down') }}</label>
          </div>
        </div>
      </div>
    </div>

    <div class="flex__item__block__1">
      <div class="title__block">{{ trans('pgno.dm_shtang') }}, {{ trans('measurements.mm') }}</div>
      <div class="title__block__pump">
        <div class="title__block__pump__list">
          <div class="title__block__pump_list">
            <div class="title__block__pump__1">
              <input class="checkbox__block__1" v-model="settings.rodsTypes" value="13" type="checkbox"/>
              <label class="checkbox__block__label__1">13</label>
            </div>

            <div class="title__block__pump__1">
              <input class="checkbox__block__1" v-model="settings.rodsTypes" value="16" type="checkbox"/>
              <label class="checkbox__block__label__1">16</label>
            </div>

            <div class="title__block__pump__1">
              <input class="checkbox__block__1" v-model="settings.rodsTypes" value="19" type="checkbox"/>
              <label class="checkbox__block__label__1">19</label>
            </div>
          </div>

          <div class="title__block__pump_list__2">
            <div class="title__block__pump__1">
              <input class="checkbox__block__1" v-model="settings.rodsTypes" value="22" type="checkbox"/>
              <label class="checkbox__block__label__1">22</label>
            </div>

            <div class="title__block__pump__1">
              <input class="checkbox__block__1" v-model="settings.rodsTypes" value="25" type="checkbox"/>
              <label class="checkbox__block__label__1">25</label>
            </div>

            <div class="title__block__pump__1">
              <input class="checkbox__block__1" v-model="settings.rodsTypes" value="29" type="checkbox"/>
              <label class="checkbox__block__label__1">29</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="flex__item__block__1">
      <div class="title__block"><u>{{ trans('pgno.marki_stali_shtang') }}</u>
        <img @click="onClickI1()" src="../../../images/info-shgn.svg" alt="">
      </div>
      <div class="title__block__pump kpod-multiselect" style="display: flex;">

        <div v-if="steelMarks.length > 0" class="title-multi-select">Выбрано {{ settings.steelMark.length }} опции</div>
        <div v-else class="title-multi-select">Выберите опции</div>

        <b-dropdown ref="dropdown" toggle-class="drop-filter-custom">
          <b-dropdown-form class="li-multiselect">

            <template class="li-multiselect">
              <div style="color: black;">
                <b-form-group v-slot="{ ariaDescribedby }" class="li-multiselect">
                  <b-form-checkbox-group
                      style="color: black;"
                      id="checkbox-group-1"
                      v-model="settings.steelMark"
                      :options="steelMarks"
                      :aria-describedby="ariaDescribedby"
                      name="flavour-1"
                  ></b-form-checkbox-group>
                </b-form-group>
              </div>
            </template>

          </b-dropdown-form>
        </b-dropdown>

      </div>
    </div>

    <div class="flex__item__block__1__koroz">
      <div class="title__block__koroz">
        <u>{{ trans('pgno.korozinost_dob_prod') }}</u>
        <img @click="onClickI2()" src="../../../images/info-shgn.svg" alt="">
      </div>
      <div class="title__block__koroz__checkbox">
        <input class="checkbox__block__1" value="antiCorrosion" type="radio" name="korprod1"
               v-model="settings.corrosion" @change="onChangeCorrosion($event)"/>
        <label class="checkbox__block__label__1">{{ trans('pgno.nekorozionnaya') }}</label>
      </div>

      <div class="title__block__koroz__checkbox__2">
        <input class="checkbox__block__1" value="mediumCorrosion" type="radio" name="korprod1"
               v-model="settings.corrosion" @change="onChangeCorrosion($event)"/>
        <label for="" class="checkbox__block__label__1">{{ trans('pgno.srenekorozionnaya') }}</label>
      </div>

      <div class="title__block__koroz__checkbox__3">
        <input class="checkbox__block__1" value="highCorrosion" type="radio" name="korprod1"
               v-model="settings.corrosion" @change="onChangeCorrosion($event)"/>
        <label for="" class="checkbox__block__label__1">{{ trans('pgno.visokorozionnaya') }}</label>
      </div>

      <div class="title__block__koroz__checkbox__4">
        <input v-model="settings.h2s" class="checkbox__block__1" type="checkbox" name="korprod1"/>
        <label for="" class="checkbox__block__label__1">{{ trans('pgno.h2s') }}</label>
      </div>


    </div>

    <div class="flex__item__block__1__koroz">
      <div class="title__block__koroz">{{ trans('pgno.pot_rezhim') }}</div>
      <div class="flex__item__block__sixth__block">
        <div class="block__text__5">{{ trans('pgno.dav_nasos_minim') }}</div>
        <input v-model="settings.pintakeMin" class="shgn-input block__6__input" type="text">
        <div class="measurements-shgn-1">{{ trans('measurements.atm') }}</div>
        <div class="block__text__6">{{ trans('pgno.gs_nasos_maks') }}</div>
        <input v-model="settings.gasMax" class="shgn-input block__7__input" type="text">
        <div class="measurements-shgn-2">{{ trans('measurements.percent') }}</div>
      </div>

    </div>

		<div class="flex__item__block__1_incl" >
			<div class="title__block">{{trans('pgno.podbor_glubiny_spuska')}}</div>
			<div class="title__block__min__1"><span>{{trans('pgno.dlina_polki')}}</span>
			<input v-model="settings.inclStep" class="shgn-input block__1__input" type="text"></div>
      <div class="measurements-shgn-3">{{ trans('measurements.m')}}</div>
    </div>
				<button type="button" class="submit_button" @click="onSubmitParams('getDefault')">
                        {{trans('pgno.primenit_default')}}
                </button>

  <button type="button" class="submit_button" @click="onSubmitParams('getTemp')">
    {{ trans('pgno.primenit_korrektirovki') }}
  </button>
  <modal name="modalTable" :draggable="true" :width="1000" :height="550"
         :adaptive="true">
    <div class="modal-bign modal-bign-container">
      <div class="modal-bign-header">
        <div class="modal-bign-title">

        </div>

        <button type="button" class="modal-bign-button" @click="closeModal('modalTable')">
          {{ trans('pgno.zakrit') }}
        </button>
      </div>

      <div>

        <div class="nno-modal-button-wrapper">
          <div class="nno-modal-buttons-container">
            <div class="title__table__1">{{ trans('pgno.tablica8') }}</div>
            <table class="table__1">
              <tr style="color: white;">
                <th class="table__th__1">{{ trans('pgno.group_posadka') }}, {{ trans('measurements.mm') }}</th>
                <th class="table__th__1">{{ trans('pgno.min_zazor') }}, {{ trans('measurements.mm') }}</th>
                <th class="table__th__1" style="width: 60%;">{{ trans('pgno.max_zazor') }},
                  {{ trans('measurements.mm') }}
                </th>
              </tr>
              <tr>
                <td class="table__td__1">1</td>
                <td class="table__td__1">0.00</td>
                <td class="table__td__1">0.063</td>
              </tr>
              <tr class="highlight__tr__1">
                <td class="table__td__1">2</td>
                <td class="table__td__1">0,025</td>
                <td class="table__td__1">0,088</td>
              </tr>
              <tr>
                <td class="table__td__1">3</td>
                <td class="table__td__1">0,050</td>
                <td class="table__td__1">0,113</td>
              </tr>
              <tr class="highlight__tr__1">
                <td class="table__td__1">4</td>
                <td class="table__td__1">0,075</td>
                <td class="table__td__1">0,138</td>
              </tr>

              <tr>
                <td class="table__td__1">5</td>
                <td class="table__td__1">0,100</td>
                <td class="table__td__1">0,163</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </modal>

  <modal name="modalTable3" :draggable="true" :width="900" :height="640"
         :adaptive="true">
    <div class="modal-bign modal-bign-container">
      <div class="modal-bign-header">
        <div class="modal-bign-title"></div>
        <button type="button" class="modal-bign-button" @click="closeModal('modalTable3')">
          {{ trans('pgno.zakrit') }}
        </button>
      </div>
      <div>
        <div class="nno-modal-button-wrapper">
          <div class="svg__image">
            <img :src="svgTableN1"/>
          </div>
        </div>
      </div>
    </div>
  </modal>

  <modal name="modalTable2" :draggable="true" :width="1050" :height="650"
         :adaptive="true">
    <div class="modal-bign modal-bign-container">
      <div class="modal-bign-header">
        <div class="modal-bign-title"></div>
        <button type="button" class="modal-bign-button" @click="closeModal('modalTable2')">
          {{ trans('pgno.zakrit') }}
        </button>
      </div>
      <div>
        <div class="nno-modal-button-wrapper" style="overflow: auto;">
          <div class="svg__image">
            <img :src="svgTableN2"/>
          </div>
        </div>
      </div>
    </div>
  </modal>
  </div>

</template>
<script src="./js/Shgn.js"></script>