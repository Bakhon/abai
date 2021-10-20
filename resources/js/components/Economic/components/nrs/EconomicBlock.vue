<template>
  <div class="d-flex bg-main1 text-white text-wrap px-3 py-2">
    <div
        v-for="(subBlock, subBlockIndex) in block"
        :key="subBlock.title"
        :class="subBlockIndex % 2 === 0 ? 'pl-0' : ''"
        class="col-6 d-flex flex-column position-relative">
      <divider v-if="subBlockIndex % 2 === 1"/>

      <div class="font-weight-bold font-size-26px">
        {{ formatValue(subBlock.value.last).value.toFixed(2) }}
      </div>

      <div class="text-blue font-size-12px line-height-14px">
        {{ formatValue(subBlock.value.last).dimension }}
      </div>

      <div class="flex-grow-1 mt-2 font-weight-bold font-size-14px line-height-18px">
        {{ subBlock.title }}
      </div>

      <percent-progress :percent="+subBlock.percent"/>

      <div class="d-flex font-size-12px line-height-14px mb-2">
        <div class="flex-grow-1 text-blue">
          {{ (100 + +subBlock.percent) }} %
        </div>

        <div>{{ formatValue(subBlock.value.prev).value.toFixed(2) }}</div>
      </div>

      <percent-badge
          :percent="subBlock.reversePercent ? -subBlock.percent : subBlock.percent"
          :reverse="subBlock.reverse"
          class="font-size-16px line-height-18px"/>
    </div>
  </div>
</template>

<script>
import {formatValueMixin} from "../../mixins/formatMixin";

import Divider from "../Divider";
import PercentProgress from "../PercentProgress";
import PercentBadge from "../PercentBadge";

export default {
  name: "EconomicBlock",
  components: {
    Divider,
    PercentProgress,
    PercentBadge,
  },
  mixins: [
    formatValueMixin
  ],
  props: {
    block: {
      required: true,
      type: Object
    }
  }
}
</script>

<style scoped>
.font-size-12px {
  font-size: 12px;
}

.font-size-16px {
  font-size: 16px;
}

.font-size-26px {
  font-size: 26px;
}

.line-height-14px {
  line-height: 14px;
}

.line-height-18px {
  line-height: 18px;
}

.text-blue {
  color: #82BAFF;
}
</style>