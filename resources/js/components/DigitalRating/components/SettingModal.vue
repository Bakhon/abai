<template>
  <modal
    class="modal-bign-wrapper"
    name="modalSetting"
    :draggable="false"
    :width="1000"
    :height="500"
    :adaptive="true">
    <div class="modal-bign-container p-20px">
      <div class="modal-bign-header mb-20px">
        <div class="modal-bign-title">
          <i class="fas fa-cog"
             style="font-size: 20px;"
          />
          {{ trans('profile.tabs.settings') }}
        </div>
        <button type="button" class="modal-bign-button" @click="$emit('close')">
          {{ trans('pgno.zakrit') }}
        </button>
      </div>
      <form>
        <div class="d-flex justify-content-between mb-20px">
          <div class="setting-form__select">
            <div class="setting-form__select-header">
              {{ trans('digital_rating.field') }}
            </div>
            <div class="setting-form__select-area">
              <ul>
                <li v-for="item in fields" :key="item">
                  {{ item }}
                </li>
              </ul>
            </div>
          </div>
          <div class="setting-form__select">
            <div class="setting-form__select-header">
              {{ trans('digital_rating.sectorSize') }}
            </div>
            <div class="setting-form__select-area">
              <ul>
                <li v-for="item in sectors" :key="item">
                  {{ item }}
                </li>
              </ul>
            </div>
          </div>
          <div class="setting-form__select">
            <div class="setting-form__select-header">
              {{ trans('digital_rating.forecastingAlgorithm') }}
            </div>
            <div class="setting-form__select-area">
              <ul>
                <li v-for="item in algorithms">
                  {{ item }}
                </li>
              </ul>
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
        <div class="setting-form">
          <div class="setting-form__label">
            {{ trans('digital_rating.radiusEnvironment') }}
          </div>
          <input
            type="text"
            class="setting-form__input"
            v-model="form.radius"
          />
        </div>
      </form>
      <div class="modal__footer">
        <button type="button" class="btn-button btn-button--thm-blue mr-20px minw-400">
          {{ trans('digital_rating.applyDefault') }}
        </button>
        <button type="button" class="btn-button btn-button--thm-blue minw-400">
          {{ trans('digital_rating.applyCorrectionsMade') }}
        </button>
      </div>
    </div>
  </modal>
</template>

<script>
export default {
  name: "SettingModal",

  data() {
    return {
      form: {
        limitValue: null,
        radius: null,
      },
      fields: ['Узень', 'Карамандыбас', 'Жетыбай'],
      sectors: ['100x100','150x150', '200x200'],
      algorithms: ['Утвержденная методика', 'С учетом возвратных объектов'],
    }
  }
}
</script>

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
    padding: 5px 10px;
    color: #fff;
    font-size: 18px;
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
}
</style>
