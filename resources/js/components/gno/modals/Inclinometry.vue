<template>
  <div>
    <div class="row no-margin col-12 no-padding pos-rel gno-incl-content-wrapper">
      <div class="col-6 no-padding no-scrollbar incl-modal-table">
        <perfect-scrollbar>
          <table
              border="1"
              cellpadding="0"
              cellspacing="0"
              width="525"
              class="gno-table-with-header incl"
          >
            <thead>
            <tr height="80" style="height: 60pt;">
              <td
                  height="80"
                  class="xl6321650"
                  width="64"
                  style="height: 60pt; width: 48pt;"
              >
                {{trans('pgno.md')}},м
              </td>
              <td
                  class="xl6321650"
                  width="64"
                  style="border-left: none; width: 48pt;"
              >
                {{trans('pgno.tvd')}}, м
              </td>
              <td
                  class="xl6321650"
                  width="64"
                  style="border-left: none; width: 48pt;"
              >
                {{trans('pgno.udl')}},м
              </td>
              <td
                  class="xl6321650"
                  width="88"
                  style="border-left: none; width: 66pt;"
              >
                {{trans('pgno.zenitnii_ugol')}}, гр
              </td>
              <td
                  class="xl6321650"
                  width="95"
                  style="border-left: none; width: 71pt;"
              >
                {{trans('pgno.azimut')}}, гр
              </td>
              <td
                  class="xl6321650"
                  width="160"
                  style="border-left: none; width: 120pt;"
              >
                {{trans('pgno.temp_nabora_krivizni')}} (DLS), гр/10м
              </td>
            </tr>
            </thead>

            <tbody>
            <tr height="20" style="height: 15pt;" v-for="row in this.inclinometry">
              <td
                  height="20"
                  class="xl6621650"
                  style="height: 15pt; border-top: none;"
              >
                {{ row["md"] }}
              </td>
              <td
                  height="20"
                  class="xl6621650"
                  style="height: 15pt; border-top: none;"
              >
                {{ row["tvd"] }}
              </td>
              <td
                  height="20"
                  class="xl6621650"
                  style="height: 15pt; border-top: none;"
              >
                {{ row["ext"] }}
              </td>
              <td
                  height="20"
                  class="xl6621650"
                  style="height: 15pt; border-top: none;"
              >
                {{ row["incl"] }}
              </td>
              <td
                  height="20"
                  class="xl6621650"
                  style="height: 15pt; border-top: none;"
              >
                {{ row["azim"] }}
              </td>

              <td
                  height="20"
                  class="xl6621650"
                  style="height: 15pt; border-top: none;"
              >
                {{ row["dls"] }}
              </td>
            </tr>
            </tbody>
          </table>
        </perfect-scrollbar>
      </div>

      <div class="col-6 gno-plotly-graph">
        <Plotly :data="chart" :layout="layout" :display-mode-bar="false"></Plotly>
        <div class="hpump-input col-12">
          <div class="hpump-input-block col-6">{{trans('pgno.vibor_glubin_hpump')}} {{ well.expChoosen }} <br> Нсп
            <input v-model="hPump" @change="buildModel()" type="text" onfocus="this.value=''" class="input-box-gno-incl podbor"/>
          </div>
          <button type="button col-6" class="old_well_button_incl" @click="onClickHpump">{{trans('pgno.primenit_hpump')}}</button>
        </div>
        <div class="text-incl-block col-12">
          <div class="zenit-block col-12">
            <b>{{trans('pgno.temp_nabora_krivizni')}}</b> <br> {{trans('pgno.v_meste_ustanovki')}}
            <input v-model="this.centralizer[0]" :disabled="this.centralizer[0]" type="text" onfocus="this.value=''" class="input-box-gno-incl podbor" /> {{trans('pgno.v_inter_glubin')}}
            <input v-model="this.centralizer[1]" :disabled="this.centralizer[1]" type="text" onfocus="this.value=''" class="input-box-gno-incl podbor"/>

          </div>
        </div>
        <div class="text-incl-block col-12">
          <div class="zenit-block col-12">
            <b>{{trans('pgno.maks_zenit_ugol')}}</b>  <br> {{trans('pgno.v_meste_ustanovki')}}

            <input v-model="this.centralizer[2]" :disabled="this.centralizer[2]" type="text" onfocus="this.value=''" class="input-box-gno-incl podbor" /> {{trans('pgno.v_inter_glubin')}}
            <input v-model="this.centralizer[3]" :disabled="this.centralizer[3]" type="text" onfocus="this.value=''" class="input-box-gno-incl podbor"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="./js/Inclinometry.js">
</script>
<style scoped>
.old_well_button_incl {
  width: 200px;
  height: 45px;
  background: #293688;
  border-radius: 8px;
  display: block;
  cursor: pointer;
  color: #ffffff;
  font-weight: bold;
  font-size: 14px;
  text-align: center;
  outline: none !important;
  box-shadow: none;
  border: none;
  margin-top: 7px;
  margin-left: 10px;
  line-height: 14px;
}

.old_well_button_incl:hover {
  background: #222d74;
}

.old_well_button_incl:active {
  outline: none !important;
  background: #1a225e;
}

.input-box-gno-incl {
  background: #494AA5;
  border: 1px solid #272953;
  outline: none;
  width: 60px;
  height: 22px;
  color: white;
  box-sizing: border-box;
  border-radius: 2px;
  line-height: 25px !important;
  padding-right: 5px;
  padding-left: 5px;
}
.square-incl {
  background: #494AA5;
  border: 1px solid #272953;
  outline: none;
  width: 100%;
  height: 22px;
  color: white;
  box-sizing: border-box;
  border-radius: 2px;
  line-height: 25px !important;
  padding-right: 5px;
  padding-left: 5px;
}
.square-incl:focus {
  background: #5657c7;
}
.input-box-gno-incl:disabled {
  color: #928f8f;
  background: #353e70;
}

.incl-modal-table {
  height: 100%;
  overflow-y: auto;
}

.text-incl-block {
  padding-bottom: 10px;
}

.gno-plotly-graph {
  background-color: #2b2e5e;
}

.hpump-input {
  padding-bottom: 10px;
}

.hpump-input-block {
  float: left;
  text-align: left;
  color: white;
  font-weight: bold;
}

.zenit-block {
  font-size: 14px;
  text-align: left;
  color: white;
  float: left;
}
</style>