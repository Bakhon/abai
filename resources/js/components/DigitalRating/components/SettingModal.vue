<template>
  <b-modal
    size="xl"
    header-bg-variant="main1"
    body-bg-variant="main1"
    header-text-variant="light"
    footer-bg-variant="main1"
    centered
    id="modalSetting"
    :ok-only="true"
  >
    <template #modal-header="{ close }">
      <div class="d-flex justify-content-between w-100">
        <div class="modal-bign-title">
          <i class="fas fa-cog" style="font-size: 20px;"/>
          {{ trans('profile.tabs.settings') }}
        </div>
        <button type="button" class="modal-bign-button" @click="close">
          {{ trans('pgno.zakrit') }}
        </button>
      </div>
    </template>
    <div class="text-white">
      <form>
        <div class="d-flex justify-content-between mb-20px">
          <div class="setting-form__select">
            <div class="setting-form__select-header">
              {{ trans('digital_rating.field') }}
            </div>
            <div class="setting-form__select-area">
              <div class="radio-group">
                <div class="radio-group__item"
                  v-for="(item, index) in fields" :key="index">
                  <input type="radio" :id="`field${index}`" :value="item" v-model="selectedField">
                  <label :for="`field${index}`">{{ item }}</label>
                </div>
              </div>
            </div>
          </div>
          <div class="setting-form__select">
            <div class="setting-form__select-header">
              {{ trans('digital_rating.sectorSize') }}
            </div>
            <div class="setting-form__select-area">
              <div class="radio-group">
                <div class="radio-group__item"
                  v-for="(item, index) in sectors" :key="index">
                  <input type="radio" :id="`sector${index}`" :value="item" v-model="selectedSector">
                  <label :for="`sector${index}`">{{ item }}</label>
                </div>
              </div>
            </div>
          </div>
          <div class="setting-form__select">
            <div class="setting-form__select-header">
              {{ trans('digital_rating.forecastingAlgorithm') }}
            </div>
            <div class="setting-form__select-area">
              <div class="radio-group">
                <div class="radio-group__item"
                  v-for="(item, index) in algorithms" :key="index">
                  <input type="radio" :id="`algorithm${index}`" :value="item" v-model="selectedAlgorithm">
                  <label :for="`algorithm${index}`">{{ item }}</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="setting-form mb-20px">
          <div class="setting-form__label">
            {{ trans('digital_rating.limitValueSector') }}
          </div>
          <input
            type="text"
            class="setting-form__input"
            v-model="form.limitValue"
          />
        </div>
        <div class="setting-form mb-20px">
          <div class="setting-form__label">
            {{ trans('digital_rating.radiusEnvironment') }}
          </div>
          <input
            type="text"
            class="setting-form__input"
            v-model="form.radius"
          />
        </div>
        <div class="setting-form">
          <div class="setting-form__label">
            {{ trans('digital_rating.dateAnalysis') }}
          </div>
          <datetime
            type="date"
            v-model="form.date"
            input-class="setting-form__input"
            format="dd.MM.yyyy"
            auto
            :flow="['date']"
            :clearable="true"
            :phrases="{ ok: '', cancel: '' }"
          >
            <div slot="after" class="remove" v-if="form.date">
              <i class="fas fa-times" @click="form.date = null"/>
            </div>
          </datetime>
        </div>
      </form>
    </div>
    <template #modal-footer>
      <div class="modal__footer">
        <button type="button" class="btn-button btn-button--thm-blue mr-20px minw-300">
          {{ trans('digital_rating.applyDefault') }}
        </button>
        <button type="button" class="btn-button btn-button--thm-blue minw-300">
          {{ trans('digital_rating.applyCorrectionsMade') }}
        </button>
      </div>
    </template>
  </b-modal>
</template>

<script>
export default {
  name: "SettingModal",
  data() {
    return {
      form: {
        limitValue: null,
        radius: null,
        date: null,
      },
      selectedField: 'Узень',
      selectedSector: '100x100',
      selectedAlgorithm: 'Утвержденная методика',
      fields: ['Узень', 'Карамандыбас', 'Жетыбай'],
      sectors: ['100x100','150x150', '200x200'],
      algorithms: ['Утвержденная методика', 'С учетом возвратных объектов'],
    }
  },

  methods: {
    close() {
      this.$emit('close');
    },
  }
}
</script>
<style lang="scss">
.vdatetime {
  position: relative;
}
.vdatetime-input.setting-form__input {
  background: #1F2142;
  border: none;
  outline: none;
  padding: 5px 15px;
  color: #fff;
}
</style>
<style scoped lang="scss">
.setting-form {
  display: flex;
  align-items: center;
  font-size: 16px;

  &__label {
    padding: 5px 20px;
    background: #323370;
    width: 50%;
  }

  &__input {
    background: #1F2142;
    border: none;
    outline: none;
    padding: 5px 15px;
    color: #fff;

    &.datepicker {
      width: 16.6%;
      padding: 0;
    }
  }

  &__select {
    width: 300px;
    font-size: 16px;

    &-header {
      background-color: #323370;
      padding: 6px 0;
      text-align: center;
    }

    &-area {
      border: 2px solid #323370;
      border-top: none;
      padding: 10px;
      background-color: #1F2142;

      ul {
        list-style: none;
      }
    }
  }

  .remove {
    position: absolute;
    top: 5px;
    right: 10px;
    cursor: pointer;
  }
}

.radio-group input[type="radio"]{
  display: none;
}

.radio-group input[type="radio"]:checked + label,
.radio-group input[type="radio"]:not(:checked) + label
{
  position: relative;
  padding-left: 28px;
  cursor: pointer;
  line-height: 20px;
  display: inline-block;
    -webkit-transition: all 0.1s ease-in-out;
    transition: all 0.1s ease-in-out;
}
.radio-group input[type="radio"]:checked + label:before,
.radio-group input[type="radio"]:not(:checked) + label:before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 18px;
  height: 18px;
  border: 3px solid #2E50E9;
  border-radius: 50%;
  -webkit-transition: all .1s ease;
  transition: all .3s ease;
  background: transparent;
}
.radio-group input[type="radio"]:checked + label:after,
.radio-group input[type="radio"]:not(:checked) + label:after {
  content: '';
  width: 11px;
  height: 10px;
  background: #fff;
  position: absolute;
  top: 4px;
  left: 4px;
  border-radius: 50%;
  -webkit-transition: all 0.1s ease;
  transition: all 0.3s ease;
}
.radio-group input[type="radio"]:not(:checked) + label:after {
  opacity: 0;
  -webkit-transform: scale(0);
  transform: scale(0);
}
.radio-group input[type="radio"]:checked + label:after {
  opacity: 1;
  -webkit-transform: scale(1);
  transform: scale(1);
}
#modalSetting___BV_modal_outer_ {
  z-index: 4002 !important;
}
</style>
