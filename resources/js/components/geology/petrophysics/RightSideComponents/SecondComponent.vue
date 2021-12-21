<template>
  <div>
    <Switcher @click="switcher" :active.sync="postData.switcherActive" :items="[
        {label: 'DTW'},
        {label: 'PCA'},
    ]" class="switcher mb-2" />

    <dropdown block class="w-100 mb-2" @change="postData.multipleSelect = []"
              :selected-value.sync="postData.referenceWell" button-text="Опорная скважина" :options="getWellsList" />

    <dropdown block class="w-100 mb-2" :selected-value.sync="postData.stratigraphy" button-text="Выбор отбивок"
              :options="getHorizon" />

    <dropdown multiple :selected-value.sync="postData.multipleSelect" block class="w-100 mb-2"
              button-text="Корреляционные скважины"
              :options="getWellsList.filter((item)=>(item.value !== postData.referenceWell))" />

    <ToolBlock title="Выбор кривых">
      <div class="p-2">
        <div class="buttons-grid">
          <Button @click="selectCurve('GR')" :color="postData.curves.GR?'accent-400':'accent'" align="center">GR
          </Button>
          <Button :disabled="postData.switcherActive === 'PCA'" @click="selectCurve('NPHI')"
                  :color="postData.curves.NPHI?'accent-400':'accent'" align="center">NPHI
          </Button>
          <Button @click="selectCurve('SP')" :color="postData.curves.SP?'accent-400':'accent'" align="center">SP
          </Button>
          <Button :disabled="postData.switcherActive === 'PCA'" @click="selectCurve('RHOB')"
                  :color="postData.curves.RHOB?'accent-400':'accent'" align="center">RHOB
          </Button>
        </div>
      </div>
    </ToolBlock>

    <ToolBlock class="mb-2">
      <div class="p-2 grid__inputs">
        <AwInput v-model="postData.searchInterval" min="29" :disabled="postData.switcherActive === 'DTW'" type="number"
                 class="curve-inputs mb-2" label-direction="row" label="Интервал поиска" />
        <AwInput v-model="postData.searchBox" min="30" :disabled="postData.switcherActive === 'DTW'" type="number" class="curve-inputs"
                 label-direction="row" label="Окно поиска" />
      </div>
    </ToolBlock>

    <Button :disabled="validationPostData" class="mb-2 w-100" color="primary" align="center">Старт</Button>

    <dropdown multiple :selected-value.sync="postData.multipleSelect" block class="w-100 mb-2" button-text="Результаты"
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
        switcherActive: "DTW",
        multipleSelect: [],
        referenceWell: null,
        stratigraphy: null,
        searchInterval: 29,
        searchBox: 30,
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
        (this.postData.switcherActive === "DTW" || this.postData.switcherActive === "PCA"),
        this.postData.multipleSelect.length,
        this.postData.referenceWell !== null,
        Object.values(this.postData.curves).some((c) => c),
          this.postData.searchBox>=30,
          this.postData.searchInterval>=29
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
    this.switcher(this.postData.switcherActive);
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
      if (this.switcherActive === "PCA") {
        this.postData.curves.GR = true;
        this.postData.curves.SP = true;
        return;
      }
      this.postData.curves[name] = !this.postData.curves[name];
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
