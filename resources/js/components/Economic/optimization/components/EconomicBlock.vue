<template>
  <div class="d-flex bg-main1 text-white text-wrap px-3 py-2">
    <div
        v-for="(subBlock, subBlockIndex) in block"
        :key="subBlock.title"
        :class="subBlockIndex % 2 === 1 ? '' : 'pl-0 pr-2'"
        class="col-6 d-flex flex-column position-relative">
      <divider v-if="subBlockIndex % 2 === 1"/>

      <div class="d-flex align-items-center font-size-26px text-nowrap">
        <img :src="`/img/economic/${subBlock.icon}`" alt="">

        <div class="ml-2 d-flex align-items-center">
          <span class="font-weight-bold">
            {{ subBlock.value }}
          </span>

          <span class="ml-2 text-blue font-size-14px line-height-16px">
            <span>{{ subBlock.dimension }}</span>

            <span v-if="subBlock.dimensionSuffix">
              {{ subBlock.dimensionSuffix }}
            </span>
          </span>
        </div>
      </div>

      <div class="flex-grow-1 mt-2 font-weight-bold font-size-16px line-height-18px">
        {{ subBlock.title }}
      </div>

      <percent-progress :percent="calcPercent(+subBlock.value, +subBlock.originalValue)"/>

      <div class="d-flex font-size-12px line-height-14px mb-2">
        <div class="flex-grow-1 text-blue">
          {{ (100 + calcPercent(+subBlock.value, +subBlock.originalValue)).toFixed(2) }} %
        </div>

        <div>
          {{ subBlock.originalValue }}
        </div>
      </div>

      <div v-if="form.scenario_id"
           class="d-flex align-items-center font-size-12px line-height-14px text-nowrap">
        <percent-badge-icon
            :percent="subBlock.reversePercent ? -subBlock.percent : subBlock.percent"
            :reverse="subBlock.reverse"
            class="font-size-16px line-height-18px mr-1"/>

        <span class="font-size-16px line-height-18px font-weight-bold">
            {{ Math.abs(+subBlock.percent) }}
        </span>

        <span class="ml-2 font-size-12px line-height-12px">
           <span>{{ subBlock.percentDimension || subBlock.dimension }}</span>

           <span v-if="subBlock.dimensionSuffix">
             {{ subBlock.dimensionSuffix }}
           </span>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
import Divider from "../../components/Divider";
import PercentBadgeIcon from "../../components/PercentBadgeIcon";
import PercentProgress from "../../components/PercentProgress";

import {calcPercentMixin} from "../../mixins/percentMixin";

export default {
  name: "EconomicBlock",
  components: {
    Divider,
    PercentBadgeIcon,
    PercentProgress,
  },
  mixins: [
    calcPercentMixin
  ],
  props: {
    form: {
      required: true,
      type: Object
    },
    block: {
      required: true,
      type: Array
    },
    index: {
      required: true,
      type: Number
    }
  }
}
</script>

<style scoped>
.font-size-12px {
  font-size: 12px;
}

.font-size-14px {
  font-size: 14px;
}

.font-size-16px {
  font-size: 16px;
}

.font-size-20px {
  font-size: 24px;
}

.font-size-26px {
  font-size: 26px;
}

.line-height-12px {
  line-height: 12px;
}

.line-height-14px {
  line-height: 14px;
}

.line-height-16px {
  line-height: 16px;
}

.line-height-18px {
  line-height: 18px;
}

.line-height-28px {
  line-height: 28px;
}

.text-blue {
  color: #82BAFF;
}

.text-grey {
  color: #656A8A
}
</style>