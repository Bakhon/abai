<template>
  <div class="bg-blue-dark d-flex flex-column position-relative">
    <economic-title
        :flex-grow="0"
        font-size="26"
        line-height="36"
        class="text-nowrap">
      <span>
          {{ +header.value.toFixed(2) }}
      </span>

      <span class="text-blue font-size-16px line-height-20px">
           {{ header.dimension }}
      </span>
    </economic-title>

    <subtitle
        font-size="14"
        class="line-height-18px flex-grow-1">
      {{ header.name }}
    </subtitle>

    <div class="d-flex border-grey-top position-relative pt-3">
      <divider class="w-100" style="height: 1px; top: 10px"/>

      <div v-for="(block, index) in header.blocks"
           :key="index"
           class="flex-grow-1">
        <subtitle font-size="18">
          {{ block.value }}
        </subtitle>

        <div class="font-size-14px line-height-20px text-blue font-weight-bold">
          {{ block.title }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Divider from "../Divider";
import EconomicTitle from "../EconomicTitle";
import Subtitle from "../Subtitle";

export default {
  name: "CalculatedHeader",
  components: {
    Divider,
    EconomicTitle,
    Subtitle
  },
  props: {
    header: {
      required: true,
      type: Object
    },
    index: {
      required: true,
      type: Number
    }
  }
}
</script>

<style scoped>
.bg-blue-dark {
  background: #2B2E5E;
}

.font-size-16px {
  font-size: 16px;
}

.line-height-18px {
  line-height: 18px;
}

.line-height-20px {
  line-height: 20px;
}

.text-blue {
  color: #82BAFF;
}
</style>