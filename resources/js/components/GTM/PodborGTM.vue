<template>
  <div>
    <div class="row mx-0 mt-lg-2 gtm">
      <div class="gtm-dark col-lg-10 p-0" @click="closeTree()">
        <div class="row col-12 p-0 m-0">
          <div class="col-6 d-none d-lg-block p-0 pl-1">
            <div class="h-100">
              <div class="block-header pb-0 pl-2 pt-1">
                {{ trans("paegtm.wells-candidates") }}
              </div>
              <div class="p-1 pl-2">
                <table class="table text-center text-white podbor-middle-table">
                  <thead>
                  <tr>
                    <th class="align-middle" rowspan="2">{{ trans("paegtm.borehole_number") }}</th>
                    <th class="align-middle" rowspan="2">{{ trans("paegtm.gtmType") }}</th>
                    <th colspan="3">{{ trans("paegtm.forecast_indicators") }}</th>
                  </tr>
                  <tr>
                    <th>{{ trans("paegtm.q_liq") }}</th>
                    <th>{{ trans("paegtm.q_oil") }}</th>
                    <th>{{ trans("paegtm.water_cut") }} %</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="candidate in candidates">
                    <td>{{ candidate[0] }}</td>
                    <td>{{ candidate[1] }}</td>
                    <td>{{ candidate[2] }}</td>
                    <td>{{ candidate[3] }}</td>
                    <td>{{ candidate[4] }}</td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-6 d-none d-lg-block p-0">
            <div class="h-100">
              <div class="block-header pb-0 pl-2 pt-1">
                {{ trans("paegtm.current_qualifiers_map") }}
              </div>
              <div class="p-3">
                <img src="/img/GTM/map.svg" class="gtm-map-img">
              </div>
            </div>
          </div>
        </div>
        <div class="row col-12 p-0 m-0 pb-2">
          <div class="col-6 d-none d-lg-block p-0 pl-1">
            <div class="h-100">
              <div class="block-header pb-0 pl-2 pt-1">
                {{ trans("paegtm.well") }} 4931
              </div>
              <div class="p-1 pl-2 mh-370">
                <gtm-line-chart :chartdata="{labels: lineLabels, datasets: lineChartData}" :options="lineChartOptions" :height="360"></gtm-line-chart>
              </div>
            </div>
          </div>
          <div class="col-6 d-none d-lg-block p-0">
            <div class="h-100 pb-2">
              <div class="block-header pb-0 pl-2">
                {{ trans("paegtm.factor_analysis") }}, {{ trans("measurements.thousand_tons") }}
              </div>
              <div class="p-1 pl-2">
                <img class="demo-img" src="/img/GTM/podbo_demo_graph.svg" height="350">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-2 p-0 pl-2 pr-1">
        <div class="block-header gtm-dark p-2">
          <div class="block-header p-2">
            {{ trans("paegtm.period") }}
          </div>
          <div class="mt-2 row m-0">
            <gtm-date-picker @dateChanged="getData"></gtm-date-picker>
          </div>
        </div>

        <div class="block-header gtm-dark">
          <div class="gtm-dark gtm-filter mt-2 p-2">
            <v-select
                :options="dzosForFilter"
                label="name"
                :placeholder="this.trans('paegtm.select_dzo')"
            >
            </v-select>
            <v-select
                :options="oilFieldsForFilter"
                label="name"
                :placeholder="this.trans('paegtm.select_oil_field')"
            >
            </v-select>

            <v-select
                :options="objectsForFilter"
                label="name"
                :placeholder="this.trans('paegtm.select_object')"
            >
            </v-select>

            <v-select
                :options="structuresForFilter"
                label="name"
                :placeholder="this.trans('paegtm.select_structure')"
            >
            </v-select>

            <v-select
                :options="gusForFilter"
                label="name"
                :placeholder="this.trans('paegtm.select_gu')"
            >
            </v-select>

          </div>
        </div>

        <div class="gtm-dark mt-2">
          <div class="block-header p-2 text-center calc-button">
            {{ trans("paegtm.calc") }}
          </div>
        </div>

        <div class="gtm-dark mt-2 p-2">
          <div class="block-header p-2 d-flex">

            <div class="title-block-tree" @click="showBlock = 1">
              <img style="padding-right: 10px;" src="./img/potencial-icon.svg" alt="">
              {{ trans("paegtm.potentialSearch") }}
            </div>

            <img class="menu-item-arrow tabs-arrow m-2 my-auto"  :src="showBlock === 1 ? menuArrowUp : menuArrowDown" width="12" height="12" alt="">

          </div>
          <div class="table-border-gtm-top p-0" :class="{ 'display-none': showBlock === 2 }">
            <div class="position-absolute tree-setting-block d-flex">
              <keep-alive>
                <component v-bind:is="treeSettingComponent" class="gtm-dark table-border-gtm h-100"></component>
              </keep-alive>
              <keep-alive>
                <component v-bind:is="treeChildrenComponent" class="gtm-dark table-border-gtm ml-2 h-100"
                           @node-click="nodeClick"></component>
              </keep-alive>
            </div>
            <div class="gtm-dark">
              <gtm-tree
                  v-for="treeDataChild in treeData"
                  :treeData="treeDataChild"
                  :key="treeDataChild.name"
                  @node-click="nodeClick"
              ></gtm-tree>
            </div>
          </div>

        </div>
        <div class="gtm-dark mt-2 p-2">
          <div class="block-header p-2 d-flex">
            <div @click="showBlock = 2">
              {{ trans("paegtm.nearWells") }}
            </div>

            <img class="menu-item-arrow tabs-arrow m-2 my-auto"  :src="showBlock === 2 ? menuArrowUp : menuArrowDown" width="12" height="12" alt="">

          </div>

          <div class="table-border-gtm-top p-0" :class="{ 'display-none': showBlock === 1 }">
            <div class="gtm-dark mt-2 row m-0 p-2">
              <div class="col-1 text-right mt-1 mb-1 p-0">
                <img src="./img/lens.svg">
              </div>
              <div class="col-11 m-0 mt-1 mb-1 row p-0">
                <input class="search-input w-75" type="text" placeholder="Поиск по скважине">
                <button class="search-button pl-2 pr-2">{{ trans("paegtm.search") }}</button>
              </div>
              <div class="gtm-dark text-white pl-2" style="min-height: 213px;">
                {{ trans("paegtm.all_wells") }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import structureMain from './structure_main.json'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
export default {
    components: {
      vSelect
    },
    data: function () {
        return {
          showBlock: 2,
          menuArrowUp: '/img/GTM/icon_menu_arrow_up.svg',
          menuArrowDown: '/img/GTM/icon_menu_arrow_down.svg',
          dzosForFilter: [
            { name: 'АО "Озенмунайгаз"', code: 'omg'},
            { name: 'АО "ЭмбаМунайГаз"',code: 'emba'},
            { name: 'АО "Мангистаумунайгаз"',code: 'mmg'},
            { name: 'АО "Каражанбасмунай"',code: 'krm'},
            { name: 'ТОО "СП "Казгермунай"',code: 'kazger'},
            { name: 'ТОО "Казтуркмунай"',code: 'ktm'},
            { name: 'ТОО "Казахойл Актобе"',code: 'koa'},
          ],
          oilFieldsForFilter: [
            { name: 'Акшабулак', code: 'oil_1'},
            { name: 'Актобе', code: 'oil_2'},
            { name: 'Алтыколь', code: 'oil_3'},
            { name: 'Жетыбай', code: 'oil_4'},
            { name: 'Жыланды', code: 'oil_5'},
            { name: 'Жыланды', code: 'oil_6'},
            { name: 'Каламкас', code: 'oil_7'},
            { name: 'Каражанбас', code: 'oil_8'},
          ],
          objectsForFilter: [{ name: 'Вариант 1'}],
          structuresForFilter: [{ name: 'Вариант 1'}],
          gusForFilter: [{ name: 'Вариант 1'}],
            candidates: [
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
            ],
            treeData: structureMain.finder_model.children,
            lineLabels: ['Янв.', 'Фев.', 'Мар.', 'Апр.', 'Май', 'Июнь', 'Июль', 'Авг.', 'Сен.', 'Окт.', 'Ноя.', 'Дек.'],
            lineChartData: [
                {
                    label: 'Пласт',
                    borderColor: "rgba(242, 126, 49, 1)",
                    data: [1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500],
                    fill: false,
                    showLine: true,
                    pointRadius: 0,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: 'Обводненность',
                    borderColor: "rgba(57, 81, 206, 1)",
                    data: [3200, 4700, 1950, 2800, 2400, 3300, 800, 1100, 3100, 4400, 1000, 2700],
                    fill: false,
                    showLine: true,
                    pointRadius: 0,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: 'Qн (По МЭР), м3/сут',
                    borderColor: "rgba(239, 83, 80, 1)",
                    backgroundColor: 'rgba(239, 83, 80, 0.2)',
                    data: [500, 700, 900, 500, 1100, 1500, 1000, 560, 780, 1300, 2000, 1750],
                    fill: true,
                    showLine: true,
                    pointRadius: 0,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: 'Qж (По МЭР), м3/сут',
                    borderColor: "rgba(76, 175, 80, 1)",
                    backgroundColor: 'rgba(76, 175, 80, 0.2)',
                    data: [2800, 4700, 2400, 1000, 2400, 200, 2800, 3400, 2450, 2000, 1000, 800],
                    fill: true,
                    showLine: true,
                    pointRadius: 0,
                    pointBorderColor: "#FFFFFF",
                }
            ],
            lineChartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: '#3C4270',
                        },
                        ticks: {
                            display: false,
                        },
                    }],
                    xAxes: [{
                        gridLines: {
                            color: '#3C4270',
                        },
                        ticks: {
                            display: false,
                        },
                    }],
                }
            },
            treeSettingHeader: '',
            treeSettingBody: '',
          treeSettingComponent: null,
          treeChildrenComponent: null
        };
    },
    methods: {
        closeTree() {
          this.treeChildrenComponent = 0;
          this.treeSettingComponent = 0;
        },
        nodeClick (data) {
            this.$_setTreeChildrenComponent(data);
            this.treeSettingComponent = {
                name: 'gtm-tree-setting',
                data: function () {
                    return {
                        treeData: {
                            children: data.node.setting_model.children
                        },
                    }
                },
                template: '<div class="block-header text-center"><div>'+ data.node.name + '</div><gtm-tree :treeData="treeData"></gtm-tree></div>',
            };
        },
        $_setTreeChildrenComponent(data) {
            let node = data.node;
            console.log(node)
            if (node.ioi_finder_model === undefined) {
                if (data.hideIoiMenu) {
                    this.treeChildrenComponent = null;
                    return;
                } else {
                    return;
                }
            }
            this.treeChildrenComponent = {
                name: 'gtm-tree-setting',
                data: function () {
                    return {
                        treeData: {
                            children: node.ioi_finder_model.children
                        },
                    }
                },
                template: '<div>' +
                          '       <div class="block-header text-center">'+ data.node.name +
                                '</div><gtm-tree :treeData="treeData" @node-click="handleClick">' +
                                '</gtm-tree></div>',
                methods: {
                    handleClick (data) {
                      console.log(data.node.children)
                        this.$emit('node-click', {node: data.node, hideIoiMenu: false});
                    }
                }
            };
        },
        getData: function () {

        }
    },
}
</script>