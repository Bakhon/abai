<template>
  <div>
    <ToolBlock title="Выбор модели (готовая)" class="mb-2">
      <div class="p-2 buttons-grid">
        <Button :disabled="!well" :color="activeColor('4GIS')" @click="selectCurve('4GIS')">4 кривые GIS</Button>
        <Button :disabled="!well" :color="activeColor('6GIS')" @click="selectCurve('6GIS')">6 кривых GIS</Button>
      </div>
    </ToolBlock>

    <ToolBlock color="danger" :title="`Нет данных ${k}`" v-for="(val, k) in missingElements" :key="k" v-show="val.length" class="mb-2">
      <div class="d-flex align-items-center p-2 flex-wrap" v-if="val.length">
        <Button v-for="(el, key) in val" :key="key" class="mr-2 flex-grow-1 mb-2" color="danger" align="center">
          {{ el }}
        </Button>
      </div>
    </ToolBlock>

    <Button @click="post" :disabled="!getModelValidation" class="mt-4 w-100" color="primary" align="center">Запуск
    </Button>
  </div>
</template>

<script>
import ToolBlock from "../../components/toolBlock/ToolBlock";
import ToolBlockList from "../../components/toolBlock/ToolBlockList";
import Button from "../../components/buttons/Button";
import AwTextarea from "../../components/form/AwTextarea";
import {FETCH_FACIES_CLASSIFICATION} from "../../../../store/modules/geologyGis.const";
import {globalloadingMutations} from "@store/helpers";

export default {
  name: "NeuralModel",
  components: {
    ToolBlock,
    ToolBlockList,
    Button,
    AwTextarea
  },
  props: {
    well: [String, Array]
  },
  data() {
    return {
      listSelect: [],
      modelElements: {
        "4GIS": ['GR', 'PHIE', 'TNPH', 'VSH_GR'],
        "6GIS": ['ASP', 'GR', 'LLD', 'PHIE', 'TNPH', 'VSH_GR'],
      },
      model: {
        "4GIS": false,
        "6GIS": false,
      },
    }
  },
  computed: {
    getModelValidation() {
      return [
        Object.values(this.model).some((m) => m),
        Object.values(this.missingElements).some((m) => !m.length),
        this.well].every((m) => m);
    },
    missingElements() {
      let result = {};
      for (let [key, value] of Object.entries(this.model)) {
        if (!value) continue;
        result[key] = this.modelElements[key].filter(i => !this.$store.state.geologyGis.wellsElementsMap.get(this.well).includes(i))
      }
      return result;
    }
  },
  methods: {
    ...globalloadingMutations(["SET_LOADING"]),
    selectCurve(model) {
      this.model[model] = !this.model[model];
    },
    activeColor(model) {
      return this.model[model] ? 'primary' : 'accent';
    },
    async post() {
      if (this.getModelValidation) {
        this.SET_LOADING(true)
        let then = [];
        for (let [key, value] of Object.entries(this.model)) {
          if (!value) continue;
          then.push(this.$store.dispatch(FETCH_FACIES_CLASSIFICATION, [this.well, key]).catch((error) => this.showToast(error.message.detail, "Ошибка", error.color)));
        }
        Promise.all(then).then(() => {
          this.SET_LOADING(false);
        });
      }
    },
  },

}
</script>
