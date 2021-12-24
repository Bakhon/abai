<template>
  <div>
    <dropdown block class="w-100 mb-2" :selected-value.sync="components.activeComponent" button-text="Выбор алгоритмов"
              :options="[
              {label: 'Стандартный алгоритм', value: 'standardAlgorithm'},
              {label: 'Нейронная модель', value: 'neuralModel'},
            ]" />
    <dropdown :selected-value.sync="well" block class="w-100 mb-2" button-text="Скважина" :options="getWellsList" />
    <component :well="well" v-bind="components.options[components.activeComponent]" :is="components.options[components.activeComponent].is" />
  </div>
</template>

<script>
import Button from "../../components/buttons/Button";
import Switcher from "../../components/switcher/Switcher";
import ToolBlock from "../../components/toolBlock/ToolBlock";
import dropdown from "../../components/dropdowns/dropdown";
import AwInput from "../../components/form/AwInput";

import NeuralModel from "./NeuralModel";
import StandardAlgorithm from "./StandardAlgorithm";
export default {
  name: "StandardInterpretation",
  components: {
    Button,
    Switcher,
    ToolBlock,
    dropdown,
    AwInput,
  },
  data() {
    return {
      well: null,
      components: {
        activeComponent: "standardAlgorithm",
        options:{
          neuralModel:{
            is:NeuralModel
          },
          standardAlgorithm:{
            is:StandardAlgorithm
          }
        }
      }
    }
  },
  computed:{
    getWellsList() {
      return (this.$store.state.geologyGis.gisWells || []).map((item) => ({value: item.name}));
    },
  }
}
</script>
