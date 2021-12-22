<template>
  <div>
    <Switcher @click="switcher" :active.sync="postData.method" :items="[
        {label: 'DTW'},
        {label: 'PCA'},
    ]" class="switcher mb-2" />

    <dropdown block class="w-100 mb-2" @change="postData.correlated_wells = []"
              :selected-value.sync="postData.reference_well" button-text="Опорная скважина" :options="getWellsList" />

    <dropdown block class="w-100 mb-2" :selected-value.sync="postData.horizons" button-text="Выбор отбивок"
              :options="getHorizon" />

    <dropdown multiple :selected-value.sync="postData.correlated_wells" block class="w-100 mb-2"
              button-text="Корреляционные скважины"
              :options="getWellsList.filter((item)=>(item.value !== postData.reference_well))" />

    <ToolBlock title="Выбор кривых">
      <div class="p-2">
        <div class="buttons-grid">
          <Button @click="selectCurve('GR')" :color="postData.curves.GR?'accent-400':'accent'" align="center">GR
          </Button>
          <Button :disabled="postData.method === 'PCA'" @click="selectCurve('NPHI')"
                  :color="postData.curves.NPHI?'accent-400':'accent'" align="center">NPHI
          </Button>
          <Button @click="selectCurve('SP')" :color="postData.curves.SP?'accent-400':'accent'" align="center">SP
          </Button>
          <Button :disabled="postData.method === 'PCA'" @click="selectCurve('RHOB')"
                  :color="postData.curves.RHOB?'accent-400':'accent'" align="center">RHOB
          </Button>
        </div>
      </div>
    </ToolBlock>

    <ToolBlock class="mb-2">
      <div class="p-2 grid__inputs">
        <AwInput v-model="postData.method_params.pca_search_interval" min="30" :disabled="postData.method === 'DTW'" type="number"
                 class="curve-inputs mb-2" label-direction="row" label="Интервал поиска" />
        <AwInput v-model="postData.method_params.pca_search_window_size" min="29" :disabled="postData.method === 'DTW'" type="number" class="curve-inputs"
                 label-direction="row" label="Окно поиска" />
      </div>
    </ToolBlock>

    <Button @click="post" :disabled="validationPostData" class="mb-2 w-100" color="primary" align="center">Старт</Button>

    <dropdown multiple :selected-value.sync="postData.correlated_wells" block class="w-100 mb-2" button-text="Результаты"
              :options="[
        {label: 'Option 0'},
        {label: 'Option 1'},
        {label: 'Option 2'},
        {label: 'Option 3'},
    ]" />

    <div class="buttons-grid">
      <Button color="accent-100" align="center">Сохранить</Button>
      <Button color="gray" align="center">Отмена</Button>
    </div>

  </div>
</template>

<script>
import Button from "../../components/buttons/Button";
import Switcher from "../../components/switcher/Switcher";
import ToolBlock from "../../components/toolBlock/ToolBlock";
import dropdown from "../../components/dropdowns/dropdown";
import AwInput from "../../components/form/AwInput";
import {Fetch_Autocorrelation} from "../../api/autocorrelation.api";

export default {
  name: "SecondComponent",
  components: {
    Button,
    Switcher,
    ToolBlock,
    dropdown,
    AwInput
  },
  data() {
    return {
      postData: {
        method: "DTW",
        correlated_wells: [],
        reference_well: null,
        horizons: null,
        method_params:{
          pca_search_window_size: 29,
          pca_search_interval: 30
        },
        curves: {
          GR: false,
          NPHI: false,
          SP: false,
          RHOB: false
        }
      },
    }
  },
  computed: {
    validationPostData() {
      return [
        (this.postData.method === "DTW" || this.postData.method === "PCA"),
        this.postData.correlated_wells.length,
        this.postData.reference_well !== null,
        this.postData.horizons !== null&&this.postData.horizons.length,
        Object.values(this.postData.curves).some((c) => c),
          this.postData.method_params.pca_search_window_size>=29,
          this.postData.method_params.pca_search_interval>=30
      ].some((el) => !el);
    },
    getHorizon() {
      return this.$store.state.geologyGis.WELLS_HORIZONS_ELEMENTS.filter((h) => {
        return this.$store.state.geologyGis.gisWells.some((w) => {
          return h.wells.includes(w.name);
        })
      }).map((item) => ({value: item.name}));
    },
    getWellsList() {
      return (this.$store.state.geologyGis.gisWells || []).map((item) => ({value: item.name}));
    }
  },
  mounted() {
    this.switcher(this.postData.method);
  },
  methods: {
    resetCurves() {
      this.postData.curves.NPHI = false;
      this.postData.curves.RHOB = false;
      this.postData.curves.GR = false;
      this.postData.curves.SP = false;
    },
    switcher(val) {
      if (val === "DTW") {
        this.postData.curves.GR = false;
        this.postData.curves.SP = false;
        return;
      }
      if (val === "PCA") {
        this.postData.curves.NPHI = false;
        this.postData.curves.RHOB = false;
        this.postData.curves.GR = true;
        this.postData.curves.SP = true;
      }
    },
    selectCurve(name) {
      this.resetCurves();
      if (this.postData.method === "PCA") {
        this.postData.curves.GR = true;
        this.postData.curves.SP = true;
        return;
      }
      this.postData.curves[name] = !this.postData.curves[name];
    },
    async post(){
      let data = JSON.parse(JSON.stringify(this.postData));

      data.mnemonics = Object.entries(data.curves).reduce((acc, [name, bool])=>{
        if(bool) acc.push(name);
        return acc
      }, []).join('_');

      data.horizons = [data.horizons];
      data.correlated_wells = data.correlated_wells.map(({value})=>value);
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

.grid__inputs {
  .curve-inputs {
    display: grid;
    grid-template-columns: auto 130px;
  }
}
</style>
