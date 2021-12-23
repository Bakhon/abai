<template>
  <PageSide direction="right">
    <template #top>
      <dropdown block class="w-100 mb-2" :selected-value.sync="components.activeComponent" button-text="Выбор методов"
                :options="[
              {label: 'First Component Demo', value: 'FirstComponent'},
              {label: 'Second Component Demo', value: 'SecondComponent'},
              {label: 'Standard Interpretation Demo', value: 'StandardInterpretation'},
            ]" />

      <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Выбор алгоритмов"
                :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}
            ]" />

      <dropdown block class="w-100 mb-2" :selected-value.sync="dropdownValue.value" button-text="Данные по сважине"
                :options="[
              {label: 'option 1', value: 1},
              {label: 'option 2', value: 2},
              {label: 'option 3', value: 3}

            ]" />

    </template>
    <component v-bind="components.options[components.activeComponent]" :is="components.options[components.activeComponent].is" />
  </PageSide>
</template>

<script>
import dropdown from "../components/dropdowns/dropdown";
import PageSide from "../components/pageSide/PageSide";

import FirstComponent from "./RightSideComponents/FirstComponent";
import SecondComponent from "./RightSideComponents/SecondComponent";
import StandardInterpretation from "./RightSideComponents/StandardInterpretation";
export default {
  name: "Geology-RSide",
  data() {
    return {
      components: {
        activeComponent: "FirstComponent",
        options:{
          FirstComponent:{
            is: FirstComponent
          },
          SecondComponent:{
            is: SecondComponent
          },
          StandardInterpretation:{
            is: StandardInterpretation
          },
        }
      },
      dropdownValue: {
        value: null
      },
      listSelect: []
    }
  },
  components: {
    dropdown,
    PageSide
  },
  computed: {
    cListSelect() {
      return this.listSelect
    }
  },
  methods: {
    selectedHandle(item) {
      this.listSelect = [];
      this.listSelect.push(item.value);
    }
  }
}
</script>
