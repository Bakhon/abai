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
  el: "#app",
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

<style scoped>
:root {
  box-sizing: border-box;
}
*,
::before,
::after {
  box-sizing: inherit;
}
a {
  text-decoration: none;
  color: #fff;
}
.wrapper {
  margin: 0px;
  padding: 0px;
  width: 100%;
  height: 100%;
  border: none;
}
.top_wrapper {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  width: 100%;
}

.select_wrapper_left {
  width: 100%;
  height: 40px;
  border-radius: 4px;
  margin-bottom: 15px;
  margin-right: 7.5px;
  display: flex;
  align-items: center;
  flex-direction: row;
  padding: 0px 25px;
  background-color: #2e50e9;
}
.select_wrapper_right {
  width: 100%;
  height: 40px;
  border-radius: 4px;
  margin-bottom: 15px;
  margin-left: 7.5px;
  display: flex;
  align-items: center;
  padding: 0px 25px;
  flex-direction: row;
  background-color: #333975;
}
.top_wrapper select {
  font-size: 16px;
  font-style: normal;
  font-weight: 700;
  line-height: 19px;
  letter-spacing: 0em;
  text-align: left;
  width: 100%;
  height: 100%;
  color: aliceblue;
  border: none;
}
.select_left {
  background-color: #2e50e9;
}
.select_right {
  background-color: #333975;
}
.central_wrapper {
  display: flex;
  flex-direction: row;
  width: 100%;
  height: calc(100% - 55px);
}
.menu_wrapper {
  width: calc((350 / (1457+15+350) * 100%));
  background-color: #272953;
  margin-right: 15px;
}

.collapse-left__sidebar {
  border: none;
  background: var(--a-accent);
  padding: 14px 6px;
  border-radius: 0 10px 10px 0;
}

.dropdown__sidebar {
  margin: 10px;
}

.sectors > div {
  height: 50px;
  font-size: 16px;
  font-style: normal;
  font-weight: 400;
  line-height: 19px;
  letter-spacing: 0em;
  text-align: left;
  color: white;
  padding-top: 15px;
  padding-left: 15px;
}
.sectors-svg > svg {
  margin-right: 5px;
}

ul,
li {
  list-style: none;
  margin: 0;
  padding: 0;
}
label {
  font-weight: normal;
}

.trees {
  margin-left: 10px;
}

.trees li {
  border-left: dotted 1px #bcbec0;
  padding: 1px 0 1px 25px;
  position: relative;
}

.trees li > label {
  position: relative;
  left: -11px;
}

.trees li:before {
  content: "";
  width: 13px;
  height: 1px;
  border-bottom: dotted 1px #bcbec0;
  position: absolute;
  top: 10px;
  left: 0;
}

.trees li:last-child:after {
  position: absolute;
  width: 2px;
  height: 13px;
  background: #fff;
  left: -1px;
  bottom: 0px;
}

.trees li input {
  margin-right: 5px;
  margin-left: 5px;
}

.trees li.has-child > ul {
  display: none;
}

.trees li.has-child > input {
  opacity: 0;
  position: absolute;
  left: -14px;
  z-index: 9999;
  width: 22px;
  height: 22px;
  top: -5px;
}

.trees li.has-child > input + .tree-control {
  position: absolute;
  left: -4px;
  top: 6px;
  width: 8px;
  height: 8px;
  line-height: 8px;
  z-index: 2;
  display: inline-block;
  color: #fff;
  border-radius: 3px;
}

.trees li.has-child > input + .tree-control:after {
  font-family: "FontAwesome";
  content: "";
  font-size: 8px;
  color: #183955;
  position: absolute;
  left: 1px;
}

.trees li.has-child > input:checked + .tree-control:after {
  font-family: "FontAwesome";
  content: "";
  font-size: 8px;
  color: #183955;
  position: absolute;
  left: 1px;
}

.trees li.has-child > input:checked ~ ul {
  display: block;
}

.trees ul li.has-child:last-child {
  border-left: none;
}

.trees ul li.has-child:nth-last-child(2):after {
  content: "";
  width: 1px;
  height: 5px;
  border-left: dotted 1px #bcbec0;
  position: absolute;
  bottom: -5px;
  left: -1px;
}

.tree-alt li {
  padding: 4px 0;
}

.monitoring_wrapper {
  width: calc((1457 / (1457+15+350) * 100%));
  background-color: #272953;
  display: flex;
  flex-direction: column;
}
.service_wrapper {
  display: flex;
  flex-direction: row;
}
.upload_wrapper {
  display: flex;
  flex-direction: column;
  max-width: 445px;
  width: 445px;
  margin-top: 15px;
  margin-right: 15px;
}

.monitoring_select > div {
  padding-top: 20px;
  padding-left: 25px;
  font-size: 22px;
  font-style: normal;
  font-weight: 700;
  line-height: 26px;
  letter-spacing: 0em;
  text-align: left;
  color: aliceblue;
}

.monitoring_select > div > img {
  height: 24px;
  width: 24px;
}

.table_div {
  width: 100%;
  height: 100%;
  margin: 15px;
}
table,
th,
td {
  border: 1px solid #454d7d;
  background: #333975;
}
th,
td {
  padding: 15px;
}

.create_pattern {
  background: #272953;
  display: block;
  color: #fff;
  padding: 20px;
  font-size: 18px;
}

.tables_wrapper {
  background: rgba(31, 33, 66, 0.5);
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
}

.table {
  color: #fff;
  text-align: center;
  width: 100%;
}

.ready_patterns,
.arbitrary_pattern {
  width: 45%;
}

tr:nth-child(even) {
  background-color: #2b2e5e;
}

.right_arrow,
.left_arrow {
  background: #3a4280;
  padding: 20px;
  border-radius: 5px;
  margin-bottom: 15px;
}

.right_arrow > img,
.left_arrow > img {
  width: 10px;
  height: 18px;
}

#per-page-select {
  width: 20%;
  background: #1f2142;
  border-color: #454fa1;
  color: #fff;
}

.pagination {
  background: none;
}
.pagination > a {
  color: #fff;
  opacity: 0.5;
  padding: 6px 14px;
  float: right;
}

tr:nth-child(even) {
  background-color: #454d7d52;
}
.table_header {
  background-color: #333975;
  font-size: 12px;
  font-style: normal;
  font-weight: 700;
  line-height: 14px;
  letter-spacing: 0em;
  text-align: center;
  color: aliceblue;
}

.file_upload {
  background-color: #363b68;
  width: 445px;
  height: 333px;
}

.upload_status {
  background-color: #363b68;
  margin-top: 15px;
  width: 445px;
  height: 491px;
}

.file_upload_title {
  font-size: 20px;
  font-style: normal;
  font-weight: 700;
  line-height: 24px;
  letter-spacing: 0em;
  text-align: left;
  color: aliceblue;
  margin-left: 17px;
  margin-top: 25px;
}

.upload_status_title {
  font-size: 20px;
  font-style: normal;
  font-weight: 700;
  line-height: 24px;
  letter-spacing: 0em;
  text-align: left;
  color: aliceblue;
  margin-left: 17px;
  margin-top: 25px;
}

.file_service {
  margin-top: 11px;
  width: 422px;
  height: 260px;
  background-color: #272953;
}

.upload_border {
  width: 100%;
  height: 100%;
  border: 1px dashed;
  border-radius: 10px;
}

.log_status {
  margin-top: 11px;
  margin-left: 12px;
  width: 421px;
  height: 367px;
  background-color: #272953;
}

.btn-common {
  height: 32px;
  background-color: #3366ff;
  font-size: 14px;
  font-style: normal;
  font-weight: 600;
  line-height: 24px;
  letter-spacing: 0em;
  text-align: center;
  color: aliceblue;
  border-radius: 4px;
}
.upload_file {
  width: 132px;
  margin-top: 218px;
  margin-left: 74px;
}

.exchange_file {
  width: 132px;
  margin-top: 218px;
  margin-right: 74px;
}

.download_log {
  width: 183px;
  margin-top: 12px;
  margin-left: 131px;
}
</style>
