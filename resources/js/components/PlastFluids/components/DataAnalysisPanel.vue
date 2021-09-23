<template>
  <div class="data-analysis-panel">
    <div class="data-analysis-panel__title">
      <i class="fas fa-sliders-h"/>
      <span>Выбор параметров</span>
    </div>
    <div class="data-analysis-panel__area">
      <dropdown title="Месторождение">
        <template #list>
          <ul class="list">
            <li v-for="(item, index) in fields" :key="index">
              <input type="checkbox" name="checkbox" v-model="item.checked" :id="`field_${index}`">
              <label :for="`field_${index}`">{{ item.name }}</label>
            </li>
          </ul>
        </template>
      </dropdown>
      <accordion title="Залежь">
        <template #list>
          <ul class="list">
            <li v-for="(item, index) in deposits" :key="index">
              <input type="checkbox" name="checkbox" v-model="item.checked" :id="`deposit_${index}`">
              <label :for="`deposit_${index}`">{{ item.name }}</label>
            </li>
          </ul>
        </template>
      </accordion>
      <accordion title="Скважины">
        <template #list>
          <ul class="list">
            <li v-for="(item, index) in wells" :key="index">
              <input type="checkbox" name="checkbox" v-model="item.checked" :id="`well_${index}`">
              <label :for="`well_${index}`">{{ item.name }}</label>
            </li>
          </ul>
        </template>
      </accordion>
    </div>
    <div class="data-analysis-panel__title">
      <i class="fas fa-cog"/>
      <span>Настройка</span>
    </div>
    <div class="data-analysis-panel__area">
      <div class="data-analysis-panel__area-setting">
        <span>Газосодержание</span>
      </div>
    </div>
    <div class="data-analysis-panel__title">
      <i class="fas fa-map-marked-alt"/>
      <span>Настройки карты свойств</span>
    </div>
    <div class="data-analysis-panel__area">
      <accordion title="Данные" :hideIcon="true">
        <template #list>
          <div class="item mb-10px">
            <span>Автор:</span>
            <span>mvmedmedova</span>
          </div>
          <div class="item mb-10px">
            <span>Алгоритм:</span>
            <span>По изолиниям</span>
          </div>
          <div class="item mb-10px">
            <span>Дата:</span>
            <span>30.12.1988</span>
          </div>
          <div class="item">
            <span>Значение бланка:</span>
            <span>1.701551615151</span>
          </div>
        </template>
      </accordion>
      <accordion title="Изолинии-Вид" :hideIcon="true">
        <template #list>
          <div class="d-flex align-items-center justify-content-between mb-10px">
            <span>Изолинии-Изменить</span>
            <i class="fas fa-pencil-alt"/>
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <span>Изолинии-Показать</span>
            <input type="checkbox">
          </div>
        </template>
      </accordion>
      <accordion title="Изолинии-Шрифт" :hideIcon="true">
        <template #list>
          <div class="d-flex align-items-center justify-content-between mb-10px">
            <span>Шрифт: </span>
            <el-select class="data-analysis__select" v-model="font" placeholder="Шрифт" size="small">
              <el-option
                  v-for="(item, index) in fontList"
                  :key="index"
                  :label="item"
                  :value="item">
              </el-option>
            </el-select>
          </div>
          <div class="d-flex align-items-center justify-content-between mb-10px">
            <span>Размер: </span>
            <el-select class="data-analysis__select" v-model="size" placeholder="Размер" size="small">
              <el-option
                  v-for="(item, index) in sizes"
                  :key="index"
                  :label="item"
                  :value="item">
              </el-option>
            </el-select>
          </div>
          <div class="d-flex align-items-center justify-content-between mb-10px">
            <span>Имя: </span>
            <input type="text" class="data-analysis__input" />
          </div>
          <div class="d-flex align-items-center justify-content-between">
            <span>Интерполлировать</span>
            <input type="checkbox">
          </div>
        </template>
      </accordion>
      <accordion title="Информация" :hideIcon="true">
        <template #list>
          <div class="d-flex align-items-center justify-content-between">
            <span>Линия сетки</span>
            <input type="checkbox">
          </div>
        </template>
      </accordion>
    </div>
    <div class="d-flex justify-content-around pb-10px">
      <button type="button" class="btn-button btn-button--thm-dark-blue">
        <i class="far fa-image pr-5px"/>
        <span>Сохранить .jpg</span>
      </button>
      <button type="button" class="btn-button btn-button--thm-dark-blue">
        <i class="fas fa-download pr-5px"/>
        <span>Выгрузить данные</span>
      </button>
    </div>
  </div>
</template>

<script>
import Accordion from "../components/Accordion";
import Dropdown from "../components/Dropdown";
import VSelect from 'vue-select';

export default {
  name: "DataAnalysisPanel",

  components: {
    Accordion,
    Dropdown,
    VSelect,
  },

  data() {
    return {
      fields: [
        {
          name: 'Кожасай',
          checked: true
        },
        {
          name: 'Алибекмола',
          checked: false
        },
        {
          name: 'Жетибай',
          checked: true
        }
      ],
      deposits: [
        {
          name: 'Гв',
          checked: true
        },
        {
          name: 'Гн',
          checked: false
        },
        {
          name: 'Дв',
          checked: false
        },
        {
          name: 'Дн',
          checked: true
        },
      ],
      wells: [
        {
          name: 2,
          checked: true
        },
        {
          name: 5,
          checked: false,
        },
        {
          name: 18,
          checked: true
        }
      ],
      font: 'Arial',
      fontList: ['Arial', 'New Times Roman', 'Helvetica'],
      sizes: [8,10,12,14,16],
      size: 14
    }
  }
}
</script>

<style scoped lang="scss">
.data-analysis-panel {
  background: #272953;
  width: 340px;
  margin-right: 10px;
}
.data-analysis-panel__title {
  font-size: 16px;
  padding: 15px;
  background: #323370;
  i {
    color: #868BB2;
    margin-right: 8px;
  }
  .fa-sliders-h {
    transform: rotate(90deg);
  }
}

.data-analysis-panel__area {
  padding: 8px;
}

.data-analysis-panel__area-setting {
  background: #363B68;
  padding: 8px;
}

input[type=checkbox] {
  transform: scale(1.4);
  cursor: pointer;
}

.list {
  margin-bottom: 0;
  li {
    display: flex;
    align-items: center;
    cursor: pointer;
    line-height: 2;
    label {
      margin-bottom: 0;
      margin-left: 10px;
      cursor: pointer;
    }
  }
}

.data-analysis__input {
  background: rgba(31, 33, 66, 0.4);
  border: 0.5px solid #454FA1;
  border-radius: 2px;
  outline: none;
  min-width: 186px;
  padding: 4px 8px;
  color: #fff;
}

</style>
