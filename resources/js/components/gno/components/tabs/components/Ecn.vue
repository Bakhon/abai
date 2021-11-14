<template>
  <div>
    <div class="flex-container">
      <div class="flex__item__block__1">
        <div class="title__block">{{ trans('pgno.current_frequency') }}</div>
        <div class="title__block__min__1">
          <span class="pr-17 pl-2">{{ trans('pgno.selection_to_perform_for') }}</span>
          <input class="shgn-input" v-model="settings.freq" type="text">
          {{ trans('measurements.gc') }}
        </div>
        <div class="title__block__max__1">

        </div>
      </div>

      <div class="flex__item__block__1">
        <div class="title__block">{{ trans('pgno.cabel') }}</div>
        <div class="title__block__min__1">
          <span class="pr-45 pl-2">{{ trans('pgno.selected') }} 0 {{ trans('pgno.options') }}</span>
          <select class="input-selection-options w-62">
            <option>
            </option>
          </select>
        </div>
        <div class="title__block__max__1">
          <span class="pr-8 pl-2">{{ trans('pgno.length_at_surface') }}</span>
          <input class="shgn-input" v-model="settings.lengthOnSurface" type="text"> {{ trans('measurements.mm') }}
        </div>
      </div>

      <div class="flex__item__block__1">
        <div class="title__block">{{ trans('pgno.prim_komponovka') }}</div>
        <div class="title__block__min__1">
          <input class="checkbox__block__1 pl-2" v-model="settings.paker" type="checkbox"/>
          <label class="label-kpod">{{ trans('pgno.paker_only') }}</label>
        </div>
        <div class="title__block__max__1">
        </div>
      </div>
    </div>
    <div class="flex-container-2">
      <div class="flex__item__block__2">
        <div class="title__block">{{ trans('pgno.pump') }}</div>
        <div class="title__block__min__1 b-b d-flex">
          <div class="">
            <span class="pl-2 pr-2">{{ trans('pgno.catalog') }} </span>
            <select class="input-selection-options w-177">
              <option>
              </option>
            </select>
          </div>

          <div class="pt-5px ml-61">
            <span class="pl-2"><u>{{ trans('pgno.wear_factor') }}</u> <img src="/img/gno/info-shgn.svg" alt=""></span>
            <input class="shgn-input" v-model="settings.pumpWear" type="text">
          </div>
        </div>
      </div>
    </div>

    <div class="flex-container-2">
      <div class="flex__item__block__2">
        <div class="title__block">{{ trans('pgno.engine') }}</div>
        <div class="title__block__min__1 b-b d-flex">
          <div class="">
            <span class="pl-2 pr-2">{{ trans('pgno.catalog') }} </span>
            <select class="input-selection-options w-177">
              <option>
              </option>
            </select>
          </div>

          <div class="pt-5px ml-61">
            <span class="pl-2"><u>{{ trans('pgno.safety_factor') }}</u> <img src="/img/gno/info-shgn.svg" alt=""></span>
            <input class="shgn-input" v-model="settings.engineSafety" type="text">
          </div>
        </div>
      </div>
    </div>

    <div class="flex-container-2">
      <div class="flex__item__block__2">
        <div class="title__block">{{ trans('pgno.pot_rezhim') }}</div>
        <div class="title__block__min__1 b-b d-flex">
          <div>
            <span class="pl-2 pr-2 pt-5px">{{ trans('pgno.minimum_pump_intake_pressure') }}</span>
            <input class="shgn-input" type="text">
            {{ trans('measurements.1/min') }}
          </div>
          <div class="pl-5">
            <span class="pl-2 pr-2 pt-5px">{{ trans('pgno.gs_nasos_maks') }}</span>
            <input class="shgn-input" type="text">
            {{ trans('measurements.1/min') }}
          </div>
        </div>
        <div>

        </div>
      </div>
    </div>

    <div class="flex-container-2">
      <div class="flex__item__block__2">
        <div class="title__block">{{ trans('pgno.pot_rezhim') }}</div>
        <div>
          <div class="title__block__min__1 b-b">
            <span class="pl-2 pr-2">{{ trans('pgno.dlina_polki') }}</span>
            <input class="shgn-input" type="text">
            {{ trans('measurements.m') }}
          </div>
        </div>
      </div>
    </div>

    <div class="flex-container-3 d-flex">
      <div class="button-ecn">
        Применить по умолчанию
      </div>
      <div class="button-ecn-accept">
        Применить по умолчанию
      </div>
    </div>


  </div>
</template>

<script src="./js/Ecn.js"></script>

<style scoped>
.flex-container-3 {
  justify-content: space-around;
  padding-top: 20px;
  padding-bottom: 20px;
}

.pr-8 {
  padding-right: 8px;
}

.input-selection-options {
  width: 90px;
}

.pr-45 {
  padding-right: 45px;
}

.w-177 {
  width: 177px;
}

.ml-61 {
  margin-left: 61px;
}

.button-ecn {
  color: white;
  width: 200px;
  background: #CF3630;
  box-shadow: 0px 2px 14px rgba(0, 0, 0, 0.14);
  border-radius: 8px;
  padding-top: 20px;
}

.button-ecn-accept {
  color: white;
  width: 200px;
  height: 60px;
  background: #293688;
  box-shadow: 0px 2px 14px rgba(0, 0, 0, 0.14);
  border-radius: 8px;
  padding-top: 20px;
}

.flex-container-2 {
  padding-inline: 22px;
  padding-top: 15px;
  color: white;
}

.flex-container {
  height: auto;
  color: white;
}

.pr-17 {
  padding-right: 17px;
}
</style>