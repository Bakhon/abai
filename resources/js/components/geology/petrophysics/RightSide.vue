<template>
  <PageSide direction="right">
    <template #top>
      <dropdown block class="w-100 mb-2" :selected-value.sync="components.activeComponent" button-text="Выбор методов"
                :options="[
              {label: 'Autocorrelation', value: 'SecondComponent'},
              {label: 'Interpretation', value: 'StandardInterpretation'},
            ]" />

    </template>
    <component v-bind="components.options[components.activeComponent]"
               :is="components.options[components.activeComponent].is" />
  </PageSide>
</template>

<script>
import dropdown from "../components/dropdowns/dropdown";
import PageSide from "../components/pageSide/PageSide";

import SecondComponent from "./RightSideComponents/SecondComponent";
import StandardInterpretation from "./RightSideComponents/StandardInterpretation";

export default {
  name: "Geology-RSide",
  data() {
    return {
      components: {
        activeComponent: "SecondComponent",
        options: {
          SecondComponent: {
            is: SecondComponent
          },
          StandardInterpretation: {
            is: StandardInterpretation
          },
        }
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
