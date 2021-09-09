<template>
  <div>
    <div class="row">
      <div class="col-4">
        <div>
          <select class="input-selection-options w-170" v-model="settings.option1.name" @change="checkCase(1)">
            <option v-for="opt in this.options" :value="opt.value" :key="opt.id">
              {{ opt.text }}
            </option>
          </select>
          <div class="row pt-3 pl-3" style="flex-direction: column;">
            <div class="row" style="flex-direction: wrap;">
              <div style="margin-left:15px">
                Вариант 1
              </div>
              <div style="margin-left:10px">
                <input v-model="settings.option1.value1" type="text" class="curve-settings-input w-80"  :disabled="!settings.option1.name"/>
              </div>
              <div style="margin-left:5px">
                {{ getUnit(settings.option1.name) }}
              </div>
            </div>
            <div class="row" style="flex-direction: wrap;">
              <div style="margin-left:15px">
                Вариант 2
              </div>
              <div style="margin-left:10px">
                <input v-model="settings.option1.value2" type="text" class="curve-settings-input w-80"  :disabled="!settings.option1.name"/>
              </div>
              <div style="margin-left:5px">
                {{ getUnit(settings.option1.name) }}
              </div>
            </div>
            <div class="row" style="flex-direction: wrap;">
              <div style="margin-left:15px">
                Вариант 3
              </div>
              <div style="margin-left:10px">
                <input v-model="settings.option1.value3" type="text" class="curve-settings-input w-80"  :disabled="!settings.option1.name"/>
              </div>
              <div style="margin-left:5px">
                {{ getUnit(settings.option1.name) }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-4">
        <div>
          <select class="input-selection-options w-170" v-model="settings.option2.name" :disabled="!settings.option1.name" @change="checkCase(2)">
            <option v-for="opt in filterFirstOptions" :value="opt.value">
              {{ opt.text }}
            </option> 
          </select>
          <div class="row pt-3 pl-3" style="flex-direction: column;">
            <div class="row" style="flex-direction: wrap;">
              <div style="margin-left:15px">
                Вариант 1
              </div>
              <div style="margin-left:10px">
                <input v-model="settings.option2.value1" type="text" class="curve-settings-input w-80" :disabled="!settings.option2.name || !settings.option1.name"/>
              </div>
              <div style="margin-left:5px">
                {{ getUnit(settings.option2.name) }}
              </div>
            </div>
            <div class="row" style="flex-direction: wrap;">
              <div style="margin-left:15px">
                Вариант 2
              </div>
              <div style="margin-left:10px">
                <input v-model="settings.option2.value2" type="text" class="curve-settings-input w-80" :disabled="!settings.option2.name  || !settings.option1.name"/>
              </div>
              <div style="margin-left:5px">
                {{ getUnit(settings.option2.name) }}
              </div>
            </div>
            <div class="row" style="flex-direction: wrap;">
              <div style="margin-left:15px">
                Вариант 3
              </div>
              <div style="margin-left:10px">
                <input v-model="settings.option2.value3" type="text" class="curve-settings-input w-80" :disabled="!settings.option2.name || !settings.option1.name"/>
              </div>
              <div style="margin-left:5px">
                {{ getUnit(settings.option2.name) }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-4">
        <div>
          <select class="input-selection-options w-170" v-model="settings.option3.name" :disabled="!settings.option2.name || !settings.option1.name" @change="checkCase(3)">
            <option v-for="opt in filterSecondOptions" :value="opt.value">
              {{ opt.text }}
            </option>
          </select>
          <div class="row pt-3 pl-3" style="flex-direction: column;">
            <div class="row" style="flex-direction: wrap;">
              <div style="margin-left:15px">
                Вариант 1
              </div>
              <div style="margin-left:10px">
                <input v-model="settings.option3.value1" type="text" class="curve-settings-input w-80" 
                :disabled="!settings.option3.name || !settings.option2.name || !settings.option1.name"/>
              </div>
              <div style="margin-left:5px">
                {{ getUnit(settings.option3.name) }}
              </div>
            </div>
            <div class="row" style="flex-direction: wrap;">
              <div style="margin-left:15px">
                Вариант 2
              </div>
              <div style="margin-left:10px">
                <input v-model="settings.option3.value2" type="text" class="curve-settings-input w-80" 
                :disabled="!settings.option3.name || !settings.option2.name || !settings.option1.name"/>
              </div>
              <div style="margin-left:5px">
                {{ getUnit(settings.option3.name) }}
              </div>
            </div>
            <div class="row" style="flex-direction: wrap;">
              <div style="margin-left:15px">
                Вариант 3
              </div>
              <div style="margin-left:10px">
                <input v-model="settings.option3.value3" type="text" class="curve-settings-input w-80" 
                :disabled="!settings.option3.name || !settings.option2.name || !settings.option1.name"/>
              </div>
              <div style="margin-left:5px">
                {{ getUnit(settings.option3.name) }}
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="row">
      <div class="col-12">
        <button class="sensitivity-analysis-settings-button" @click="postSelectedValues(settings)">Применить выбранное
        </button>
      </div>
    </div>
  </div>
</template>
<script src="./js/SensitiveSettings.js"></script>