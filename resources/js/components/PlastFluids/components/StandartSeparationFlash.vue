<template>
  <div class="wrapper">
    <div class="top_wrapper">
      <div class="select_wrapper_left">
        <img
          src="/img/plastFluids/downloadsMonitoring.svg"
          alt="downloads monitoring"
        />
        <select class="select_left">
          <option>{{ trans("plast_fluids.downloads_monitoring") }}</option>
        </select>
      </div>
      <div class="select_wrapper_right">
        <img
          src="/img/plastFluids/createNewTemplate.svg"
          alt="create new download template"
        />
        <select class="select_right">
          <option>{{
            trans("plast_fluids.creating_new_download_templates")
          }}</option>
        </select>
      </div>
    </div>
    <div class="central_wrapper">
      <div class="menu_wrapper">
        <div class="sidebar-top d-flex align-items-start w-100">
          <button class="collapse-left__sidebar">
            <Icon name="arrowLeft" />
          </button>
          <div class="dropdown__sidebar w-100">
            <dropdown
              block
              class="w-100 mb-2"
              button-text="Недропользователь"
              :options="options"
            />
            <dropdown
              block
              class="w-100 mb-2"
              button-text="Месторождения"
              :options="options"
            />
            <dropdown
              block
              class="w-100 mb-2"
              button-text="Горизонт"
              :options="options"
            />
          </div>
        </div>
        <div class="sectors">
          <div class="sectors-svg">
            <img src="/img/plastFluids/sections" alt="template sections" />
            {{ trans("plast_fluids.sections") }}
          </div>
          <div class="tree-box box-border">
            <ul class="trees">
              <li class="has-child">
                <input id="tree-controll1" type="checkbox" checked /><span
                  class="tree-control"
                ></span>
                <label>
                  <i style="color: #3366FF" class="fa fa-folder light-blue"></i>
                  PVT пластовой нефти
                </label>
                <ul>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i>
                      Стандартная сепарация Flash
                    </label>
                  </li>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i> Диф.
                      разгазирование DLE
                    </label>
                  </li>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i>
                      Ступенчатая сепарация SEP
                    </label>
                  </li>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i> При
                      постоянном составе CCE
                    </label>
                  </li>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i>
                      Зависимость вязкости P и T
                    </label>
                  </li>
                </ul>
              </li>
              <li class="has-child">
                <input type="checkbox" checked /><span
                  class="tree-control"
                ></span>
                <label>
                  <i style="color: #3366FF" class="fa fa-folder orange"></i> PVT
                  пластового газа (ГК)
                </label>
                <ul>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i> Шаблон
                      пластовый газ
                    </label>
                  </li>
                </ul>
              </li>
              <li class="has-child">
                <input id="tree-controll1" type="checkbox" checked /><span
                  class="tree-control"
                ></span>
                <label>
                  <i style="color: #3366FF" class="fa fa-folder light-blue"></i>
                  Свойства устьевых проб
                </label>
                <ul>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i> ФХА
                      нефти (конденсата)
                    </label>
                  </li>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i>
                      Разгонка ИТК
                    </label>
                  </li>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i> Состав
                      устьевых проб газа
                    </label>
                  </li>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i> ФХА
                      воды
                    </label>
                  </li>
                </ul>
              </li>
              <li class="has-child">
                <input id="tree-controll1" type="checkbox" checked /><span
                  class="tree-control"
                ></span>
                <label>
                  <i style="color: #3366FF" class="fa fa-folder light-blue"></i>
                  Свойства флюидов по горизонтам
                </label>
                <ul>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i>
                      Пластовая нефть
                    </label>
                  </li>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i>
                      Пластовый газ ГК
                    </label>
                  </li>
                  <li>
                    <label>
                      <i style="color: #999DC0" class="fa fa-file "></i>
                      Пластовая вода
                    </label>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <div class="menu"></div>
      </div>
      <div class="monitoring_wrapper">
        <div class="monitoring_select">
          <div>
            <img src="/img/plastFluids/backArrow.svg" alt="go back" />
            {{ trans("plast_fluids.downloads_monitoring") }}
          </div>
        </div>
        <div class="service_wrapper">
          <div class="table_div">
            <b-table
              bordered
              striped
              :items="items"
              :fields="fields"
              :current-page="currentPage"
              :per-page="perPage"
              style="color: #fff"
            ></b-table>
            <b-row>
              <b-col sm="5" md="6" class="my-1">
                <b-form-group
                  label="Показать первые"
                  label-for="per-page-select"
                  label-cols-sm="6"
                  label-cols-md="4"
                  label-cols-lg="4"
                  label-align-sm="right"
                  label-size="sm"
                  class="mb-0"
                >
                  <b-form-select
                    id="per-page-select"
                    v-model="perPage"
                    :options="pageOptions"
                    size="sm"
                  ></b-form-select>
                </b-form-group>
              </b-col>
              <div style="margin-left: 180px;" class="pagination">
                <a href="#">&laquo;</a>
                <a href="#">1</a>
                <a class="active" href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">&raquo;</a>
              </div>
            </b-row>
          </div>
        </div>
        <div class="create_pattern">
          <div>
            {{ trans("plast_fluids.downloads_monitoring") }}
          </div>
          <div class="tables_wrapper">
            <div class="ready_patterns">
              <p>
                {{ trans("plast_fluids.ready_templates") }}: Стандартная
                сепарация Flash
              </p>
              <table class="table">
                <tr>
                  <th>Поле 1</th>
                </tr>
                <tr>
                  <td>Поле 2</td>
                </tr>
                <tr>
                  <td>Поле 3</td>
                </tr>
                <tr>
                  <td>Поле 4</td>
                </tr>
                <tr>
                  <td>Поле 5</td>
                </tr>
              </table>
            </div>
            <div class="arrows">
              <div class="right_arrow">
                <img
                  src="/img/plastFluids/nextArrow.svg"
                  alt="create custom template"
                />
              </div>
              <div class="left_arrow">
                <img src="/img/plastFluids/backArrow.svg" alt="back" />
              </div>
            </div>
            <div class="arbitrary_pattern">
              <p>{{ trans("plast_fluids.custom_templates") }}</p>
              <table class="table">
                <tr>
                  <th>Поле 1</th>
                </tr>
                <tr>
                  <td>Поле 2</td>
                </tr>
                <tr>
                  <td>Поле 3</td>
                </tr>
                <tr>
                  <td>Поле 4</td>
                </tr>
                <tr>
                  <td>Поле 5</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import dropdown from "../../geology/components/dropdowns/dropdown";
import Button from "../../geology/components/buttons/Button";
import Icon from "../../geology/components/icons/AwIcon";
import tableData from "../tempData.json";

export default {
  name: "UploadMonitoring",
  components: {
    dropdown,
    Button,
    Icon,
  },
  data() {
    return {
      info: null,
      options: [
        { label: "option 1", value: 1 },
        { label: "option 2", value: 2 },
        { label: "option 3", value: 3 },
      ],
      fields: tableData.standartSeparation.tableHeader,
      items: tableData.standartSeparation.tableBody,
      currentPage: 1,
      perPage: 15,
      pageOptions: [15, 20, 25, { value: 100, text: "Показать больше" }],
    };
  },
};
</script>

<style lang="scss" scoped src="./StandartSeparationFlashStyles.scss"></style>
