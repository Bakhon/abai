<template>
  <div>
    <ToolBlock title="Выбор кривых" class="mb-2">
      <div class="p-2">
        <div class="buttons-grid">
          <Button @click="selectCurve('GR')" :color="activeColor('GR')" align="center">GR</Button>
          <Button @click="selectCurve('NPHI')" :color="activeColor('NPHI')" align="center">NPHI</Button>
          <Button @click="selectCurve('SP')" :color="activeColor('SP')" align="center">SP</Button>
          <Button @click="selectCurve('RHOB')" :color="activeColor('RHOB')" align="center">RHOB</Button>
          <Button @click="selectCurve('LLD')" :color="activeColor('LLD')" align="center">LLD</Button>
          <Button @click="selectCurve('SONIC')" :color="activeColor('SONIC')" align="center">SONIC</Button>
        </div>
      </div>
    </ToolBlock>
    <ToolBlock color="danger" title="Ошибка" v-show="validation" class="mb-2">
      <ul class="mb-0 ml-3 p-2">
        <li v-if="!this.well">Нужно выбрать скважину</li>
        <li v-if="this.well&&!this.getHorizon.length">У скважины {{ well }} нет горизонтов.</li>
      </ul>
    </ToolBlock>

    <ToolBlock color="warning" v-show="getTimer.isActive" class="mb-2">
      <p class="p-3 m-0">
        Не обновляйте страницу...
      </p>
    </ToolBlock>
    <Button v-show="!getTimer.isActive" :disabled="getTimer.isActive||validation" class="mb-2 w-100" color="accent" align="center" @click="demoModal = true">Константы</Button>
    <Button :loading="startButtonLoading" @click="start" :disabled="getTimer.isActive||validation" class="mb-2 w-100" color="primary" align="center" v-if="!getTimer.isActive">Старт</Button>
    <Button class="mb-2 w-100" color="danger" align="center" v-else>Ожидание ответа | {{getTimer.scoreboard}}</Button>
    <dropdown :disabled="getTimer.isActive" multiple :selected-value.sync="multipleSelect" block class="w-100 mb-2" button-text="Результаты"
              :options="[]" />
    <AwModal is-confirm position="top" size="xl" title="Константы" :is-show.sync="demoModal">
      <div class="scroll-table">
        <table class="aw-table w-100 no-padding center">
          <thead>
          <tr>
            <th rowspan="2">Well</th>
            <th rowspan="2">Горизонты</th>
            <th>DTPGL</th>
            <th>RHOBGL</th>
            <th rowspan="2">Oxf_ngld</th>
            <th rowspan="2">Val_ngld</th>
            <th rowspan="2">x</th>
            <th rowspan="2">y</th>
            <th>RW</th>
            <th>PHIE_cut</th>
            <th>VSH_fin_cut</th>
            <th>GR_max</th>
            <th>GR_min</th>
            <th>SP_max</th>
            <th>SP_min</th>
          </tr>
          <tr>
            <th>us/m</th>
            <th>g/cm3</th>
            <th>ohmm</th>
            <th>v/v</th>
            <th>v/v</th>
            <th>gapi</th>
            <th>gapi</th>
            <th>mV</th>
            <th>mV</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="horizon in getHorizon">
            <td>{{ well }}</td>
            <td>{{ horizon.code < 11 ? "Val" : horizon.code }}</td>
            <td>{{ getConstWithCode(horizon.code, 'DTPGL') }}</td>
            <td>{{ getConstWithCode(horizon.code, 'RHOBGL') }}</td>
            <td>{{ getConstWithCode(horizon.code, 'Oxf_ngld') }}</td>
            <td>{{ getConstWithCode(horizon.code, 'Val_ngld') }}</td>
            <td>{{ getConstWithCode(horizon.code, 'x') }}</td>
            <td>{{ getConstWithCode(horizon.code, 'y') }}</td>
            <td>{{ getConstWithCode(horizon.code, 'RW') }}</td>
            <td>{{ getConstWithCode(horizon.code, 'PHIE_cut') }}</td>
            <td>{{ getConstWithCode(horizon.code, 'VSH_fin_cut') }}</td>
            <td>
              <AwInput @change="editConstWithCode(horizon.code, 'GR_max', $event)" :value="getConstWithCode(horizon.code, 'GR_max')" />
            </td>
            <td>
              <AwInput @change="editConstWithCode(horizon.code, 'GR_min', $event)" :value="getConstWithCode(horizon.code, 'GR_min')" />
            </td>
            <td>
              <AwInput @change="editConstWithCode(horizon.code, 'SP_max', $event)" :value="getConstWithCode(horizon.code, 'SP_max')" />
            </td>
            <td>
              <AwInput @change="editConstWithCode(horizon.code, 'SP_min', $event)" :value="getConstWithCode(horizon.code, 'SP_min')" />
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </AwModal>
  </div>
</template>

<script>
import Button from "../../components/buttons/Button";
import ToolBlock from "../../components/toolBlock/ToolBlock";
import dropdown from "../../components/dropdowns/dropdown";
import AwInput from "../../components/form/AwInput";
import AwModal from "../../components/notifications/awModal/AwModal";
import {
  POST_INTERPRETATION,
  RUN_TIMER,
  STRATIGRAPHY_CONSTANTS_WITH_CODE
} from "../../../../store/modules/geologyGis.const";

export default {
  name: "StandardAlgorithm",
  components: {
    ToolBlock,
    dropdown,
    AwInput,
    Button,
    AwModal
  },
  props: {
    well: String
  },
  data() {
    return {
      STRATIGRAPHY_CONSTANTS_WITH_CODE:JSON.parse(JSON.stringify(STRATIGRAPHY_CONSTANTS_WITH_CODE)),
      multipleSelect: [],
      demoModal: false,
      startButtonLoading: false,
      curve: {
        GR: true,
        NPHI: false,
        SP: false,
        RHOB: false,
        LLD: false,
        SONIC: false,
      }
    }
  },
  mounted() {
    this.$store.dispatch(RUN_TIMER);
  },
  computed: {
    getTimer(){
      return this.$store.state.geologyGis.autoInterpretation
    },
    validation() {
      return [
        this.well,
        (this.well && this.getHorizon.length !== 0)
      ].some((m) => !m);
    },
    getHorizon() {
      return (this.$store.state.geologyGis.WELLS_HORIZONS_ELEMENTS.filter((h) => (h.wells.includes(this.well) && !h.name.match(/_(PCA|DTW)$/))) || [])
    },
  },
  methods: {
    editConstWithCode(code, property, value) {
      if (this.STRATIGRAPHY_CONSTANTS_WITH_CODE.hasOwnProperty(code) && this.STRATIGRAPHY_CONSTANTS_WITH_CODE[code].hasOwnProperty(property)) {
        return this.STRATIGRAPHY_CONSTANTS_WITH_CODE[code][property] = value;
      }
    },
    getConstWithCode(code, property) {
      if (this.STRATIGRAPHY_CONSTANTS_WITH_CODE.hasOwnProperty(code) && this.STRATIGRAPHY_CONSTANTS_WITH_CODE[code].hasOwnProperty(property)) {
        return this.STRATIGRAPHY_CONSTANTS_WITH_CODE[code][property];
      }
    },
    selectCurve(curve) {
      this.curve[curve] = !this.curve[curve];
    },
    activeColor(curve) {
      return this.curve[curve] ? 'primary' : 'accent';
    },
    async start() {
      let data = {
        "well": this.well,
        "config": this.getHorizon.map(({code}) => {
          return {
            code,
            mnemonics: [
              {
                name: "GR",
                min: +this.getConstWithCode(code, "GR_min"),
                max: +this.getConstWithCode(code, "GR_max"),
              },
              {
                name: "SP",
                min: +this.getConstWithCode(code, "SP_min"),
                max: +this.getConstWithCode(code, "SP_max"),
              }
            ]
          }
        })
      }
      this.startButtonLoading = true;
      await this.$store.dispatch(POST_INTERPRETATION, data);
      this.startButtonLoading = false;
    }
  }
}
</script>

<style scoped lang="scss">
.buttons-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-gap: 10px;
}
</style>
