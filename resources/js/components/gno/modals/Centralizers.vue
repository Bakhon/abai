<template>
  <div>
  <div class="flex-contain">
      <div class="inner-container">
        <div class="pt-1 pl-2">
          <label>
            <input class="checkbox3" v-model="centralizers.hasRotarTableElevation" @change="calculateRods" checked="true" type="checkbox"/>
            {{ trans('pgno.rotor_table_over') }}
          </label>
        </div>
        <div class="pl-2">
          <input type="number" class="centralizers-input-big pl-2" @change="calculateRods" v-model="centralizers.rotarTableElevation" :disabled="!centralizers.hasRotarTableElevation"/>
          {{ trans('measurements.m') }}
        </div>
      </div>
      <div class="block">
        <div class="pt-1 pl-2">
          <label class="label-block">
            <input class="checkbox3" v-model="centralizers.hasLowerRod" @change="calculateRods" checked="true" type="checkbox"/>
            {{ trans('pgno.lower_shaft') }}
          </label>
          <label class="pl-4">
            <input class="checkbox3" v-model="centralizers.hasCentralizer" @change="calculateRods" :disabled="!centralizers.hasLowerRod" value="true" type="radio"/>
            {{ trans('pgno.with_centralizer') }}
          </label>
        </div>
        <div class="pl-2">
          Ø  <select class="select-well-centrators" v-model="centralizers.lowerRod" @change="calculateRods" :disabled="!centralizers.hasLowerRod">
            <option v-for="value in this.nkt_choose" :value="value">{{value}}</option>
          </select>
          {{ trans('measurements.mm') }}
            <label class="pl-63">
              <input class="checkbox3" v-model="centralizers.hasCentralizer" @change="calculateRods" :disabled="!centralizers.hasLowerRod" value="false" type="radio"/>
              {{ trans('pgno.without_centralizer') }}
            </label>
        </div>
      </div>
        <div class="block-2">
          <div class="pt-1 pl-2">
            <label>
              <input class="checkbox3" v-model="centralizers.hasRequiredIntervals" @change="calculateRods" :disabled="requiredRanges.length===0" type="checkbox"/>
              {{ trans('pgno.installation_intervals') }}, {{ trans('measurements.m') }}
            </label>
          </div>
          <div class="pl-1">
            <div class="title-multi-select pl-12" >
              <dropdownMultiselect :class="{ disabled: !centralizers.hasRequiredIntervals }" :options="requiredRanges" :selected="centralizers.requiredRanges" @closeDropdown="onClickRequiredRanges($event)" />
            </div>
          </div>
        </div>
        <div class="block-2-1">
          <div class="pt-1 pl-2">
            <label>
              <input class="checkbox3" v-model="centralizers.hasRecommendedIntervals" @change="calculateRods" :disabled="recommendedRanges.length===0" type="checkbox"/>
              {{ trans('pgno.recomended_intervals') }}, {{ trans('measurements.m') }}
            </label>
          </div>
          <div class="title-multi-select pl-12">
              <dropdownMultiselect :class="{ disabled: !centralizers.hasRecommendedIntervals }" :options="recommendedRanges" :selected="centralizers.recommendedRanges" @closeDropdown="onClickRecommendedRanges($event)" />
          </div>
        </div>
        <div class="block-3">
          <div class="pt-1 pl-2 pb-3">
          <label>
            <input class="checkbox3" v-model="centralizers.hasAbrasionIntervals" @change="calculateRods" checked="true" type="checkbox"/>
            {{ trans('pgno.intervals_lifting_GNO') }}, {{ trans('measurements.m') }}
          </label>
          </div>
          <div class="flex-group-input justify-content-center">
            <div>
              <div class="pl-1">
                <input type="number" class="centralizers-input-small" v-model="centralizers.abrasionIntervals.row1.value1" :disabled="!centralizers.hasAbrasionIntervals"/>
              </div>
              <div class="pl-1">
                <input type="number" class="centralizers-input-small" v-model="centralizers.abrasionIntervals.row2.value1" :disabled="!centralizers.hasAbrasionIntervals"/>
              </div>
              <div class="pl-1">
                <input type="number" class="centralizers-input-small" v-model="centralizers.abrasionIntervals.row3.value1" :disabled="!centralizers.hasAbrasionIntervals"/>
              </div>
              <div class="pl-1">
                <input type="number" class="centralizers-input-small" v-model="centralizers.abrasionIntervals.row4.value1" :disabled="!centralizers.hasAbrasionIntervals"/>
              </div>
              <div class="pl-1">
                <input type="number" class="centralizers-input-small" v-model="centralizers.abrasionIntervals.row5.value1" :disabled="!centralizers.hasAbrasionIntervals"/>
              </div>
            </div>
            <div>
              <div>
                <input type="number" class="centralizers-input-small" v-model="centralizers.abrasionIntervals.row1.value2" 
                @change="calculateRods"
                :disabled="!centralizers.abrasionIntervals.row1.value1 || !centralizers.hasAbrasionIntervals"/>
              </div>
              <div>
                <input type="number" class="centralizers-input-small" v-model="centralizers.abrasionIntervals.row2.value2"
                @change="calculateRods"
                :disabled="!centralizers.abrasionIntervals.row2.value1 || !centralizers.hasAbrasionIntervals"/>
              </div>
              <div>
                <input type="number" class="centralizers-input-small" v-model="centralizers.abrasionIntervals.row3.value2"
                @change="calculateRods"
                :disabled="!centralizers.abrasionIntervals.row3.value1 || !centralizers.hasAbrasionIntervals"/>
              </div>
              <div>
                <input type="number" class="centralizers-input-small" v-model="centralizers.abrasionIntervals.row4.value2"
                @change="calculateRods"
                :disabled="!centralizers.abrasionIntervals.row4.value1 || !centralizers.hasAbrasionIntervals"/>
              </div>
              <div>
                <input type="number" class="centralizers-input-small" v-model="centralizers.abrasionIntervals.row5.value2"
                @change="calculateRods"
                :disabled="!centralizers.abrasionIntervals.row5.value1 || !centralizers.hasAbrasionIntervals"/>
              </div>
            </div>
          </div>
        </div>
    <div>
      <div class="block-4">
        <div class="title-block-centrators pl-1 pt-1">
          <b class="title-centrator">{{ trans('pgno.calc_rods') }}, {{ trans('measurements.unit') }}</b>
        </div>
        <table class="table-small">
          <tr v-for="row in centralizersResult">
            <th class="table-td">{{ row[0] }}</th>
            <th class="table-td">{{ row[1] }}</th>
            <th class="table-td">{{ row[2] }}</th>
            <th class="table-td">{{ row[3] }}</th>
          </tr>
        </table>
      </div>

      <div class="block-4-1">
        <div  class="title-block-centrators pl-1 pt-1">
          <b class="title-centrator">{{ trans('pgno.optimizing_centralizers') }}</b>
        </div>
        <div class="d-flex justify-content-start">
          <div class="optimized">
            {{ trans('pgno.accuracy_of_pump') }}
          </div>
          <div class="optimized pr-1">
            <input type="number" class="small-input" @change="calculateRods" v-model="centralizers.pumpAccuracy"/>
          </div>
          <div class="pt-3">
            {{ trans('measurements.m') }}
          </div>
        </div>

        <div class="d-flex pb-2 justify-content-start">
          <div class="optimized pr-1">
            {{ trans('pgno.combining_intervals_across') }}
          </div>
          <div class="optimized pr-1">
            <input type="number" class="small-input"  @change="calculateRods" v-model="centralizers.intervalCombining"/>
          </div>
          <div class="pt-3">
            {{ trans('measurements.rods') }}
          </div>
        </div>

      </div>
    </div>

    </div>
    <div class="d-flex justify-content-around">
      <button class="button pt-1" @click="closeModal">
        <b>Применить выполненные установки</b>
      </button>
    </div>

  </div>
</template>
<script src="./js/Centralizers.js"></script>
<style scoped>
.disabled {
  pointer-events: none;
  opacity: 0.5;
  background: #CCC;
  width: fit-content;
}

.flex-contain {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  align-content: center;
  width: 920px;
  font-size: 13px;
}

.small-input {
  width: 30px;
  height: 30px;
  background: rgba(31, 33, 66, 0.8);
  border: 1px solid #454FA1;
  border-radius: 4px;
  color: white;
  outline: none;
  padding-left: 5px;
}

.centralizers-input-small[type="number"]:disabled {
  color: #928f8f;
  background: #353e70;
}

.centralizers-input-big[type="number"]:disabled {
  color: #928f8f;
  background: #353e70;
}

.w-295 {
  width: 295px;
}

.optimized {
  height: 45px;
  padding-top: 15px;
  padding-left: 5px;
}

.title-block-centrators {
  background: #323370;
  height: 32px;
}

.title-centrator {
  font-size: 15px;
}

.button {
  width: 280px;
  height: 32px;
  cursor: pointer;
  background: #293688;
  box-shadow: 0px 2px 14px rgba(0, 0, 0, 0.14);
  border-radius: 4px;
  text-align: center;
  margin-top: 20px;
  color: white;
  border: none;
}

.button:active {
  background-color: #144079;
  box-shadow: 0 2px #666;
  transform: translateY(0.02px);
  filter: blur(0.3px);
}

.button:hover {
  background-color: #484749;
}

.inner-container {
  width: 288px;
  background-color: #363B68;
  height: 76px;
  border: 0.5px solid #545580;
}

.centralizers-input-big {
  width: 258px;
  height: 30px;
  border-radius: 4px;
  outline: none;
  border: 1px solid #454FA1;
  background-color: rgba(31, 33, 66, 0.8);
  color: white
}

.flex-group-input {
  display: flex;
}

.centralizers-input-small {
  width: 110px;
  height: 24px;
  outline: none;
  border: 1px solid #454FA1;
  background-color: rgba(31, 33, 66, 0.8);
  color: white;
  padding-left: 5px;
}

.table-small {
  text-align: left;
  border-collapse: separate;
  width: 100%;
  height: auto;
  font-size: 13px;
}

th {
  color: white;
  padding-inline: 3px;
  padding-block: 3px;
  background-color: #293688;
}

.table-td {
  vertical-align: middle;
  background: #383d6d;
  width: auto;
  padding-inline: 3px;
  padding-block: 3px;
}
.bg-td {
  background-color: #323f8a;
}

.block {
  background-color: #363B68;
  width: 612px;
  height: 76px;
  border: 0.5px solid #545580;
}

.block-2 {
  width: 288px;
  background-color: #363B68;
  height: 69px;
  border: 0.5px solid #545580;
}

.block-2-1 {
  width: 315px;
  background-color: #363B68;
  height: 69px;
  border: 0.5px solid #545580;
}

.table-td:first-child {
  background: #3E4992;
}

.select-well-centrators {
  outline: none;
  width: 228px;
  height: 30px;
  color: white;
  box-sizing: border-box;
  -webkit-appearance: none;
  padding-left: 5px;
  background: #24264a url("data:image/svg+xml;utf8,<svg viewBox='0 0 140 140' width='14' height='14' xmlns='http://www.w3.org/2000/svg'><g><path d='m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z' fill='white'/></g></svg>") no-repeat right 5px top 50%;
  border-radius: 2px;
  border: 1px solid #454FA1;
}

.select-well-centrators[type="text"]:disabled {
  opacity: 0.5;
  background: #CCC;
}

.block-3 {
  width: 288px;
  background-color: #363B68;
  border: 0.5px solid #545580;
  height: 210px;
}

.pl-63 {
  padding-left: 63px;
}

.block-4 {
  width: 288px;
  border: 0.5px solid #545580;
  position: absolute;
  bottom: 88px;
  left: 16px;
}

.block-4-1 {
  width: 315px;
  border: 0.5px solid #545580;
  top: 220px;
  right: 316px;
  position: absolute;
}

.table-td {
  vertical-align: middle;
  background: #383d6d;
  width: auto;
  padding-inline: 3px;
  padding-block: 3px;
}
td {
  border: none !important;
  text-align: center;
  width: 80px;
  background: #0F1430;
  color: white;
}

.label-block {
  width: 302px;
}

.pl-12 {
  padding-left: 12px;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>