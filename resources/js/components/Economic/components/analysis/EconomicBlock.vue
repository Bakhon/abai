<template>
  <div class="d-flex bg-main1 text-white text-wrap px-3 py-2">
    <div
        v-for="(subBlock, subBlockIndex) in block"
        :key="subBlock.title"
        :class="subBlockIndex % 2 === 1 ? '' : 'pl-0 pr-2'"
        class="col-6 d-flex flex-column position-relative">
      <divider v-if="subBlockIndex % 2 === 1"/>

      <div class="d-flex align-items-center font-size-26px text-nowrap">
        <div class="d-flex align-items-center">
          <span class="font-weight-bold">
            {{ subBlock.value }}
          </span>

          <span class="ml-2 d-flex flex-column text-blue font-size-14px line-height-16px">
            <div>{{ subBlock.dimension }}</div>

            <div v-if="subBlock.dimensionSuffix">
              {{ subBlock.dimensionSuffix }}
            </div>
          </span>
        </div>
      </div>

      <div class="text-grey font-size-12px line-height-14px font-weight-bold mb-3">
        Предлагаемый
      </div>

      <div class="mb-2">
        <percent-progress :percent="subBlock.percent"/>

        <div class="d-flex font-size-12px line-height-14px">
          <div class="flex-grow-1 text-blue">
            {{ (100 + subBlock.percent).toFixed(2) }} %
          </div>

          <div>{{ subBlock.value.toFixed(2) }}</div>
        </div>
      </div>

      <div class="d-flex align-items-center font-size-12px line-height-14px text-nowrap">
        <percent-badge-icon
            :percent="subBlock.reversePercent ? -subBlock.percent : subBlock.percent"
            :reverse="subBlock.reverse"
            class="font-size-18px line-height-20px mr-1"/>

        <span class="font-size-18px line-height-20px font-weight-bold">
            {{ Math.abs(+subBlock.percent) }}
        </span>

        <span class="ml-2 d-flex flex-column font-size-12px line-height-14px">
           <div>{{ subBlock.percentDimension || subBlock.dimension }}</div>

            <div v-if="subBlock.dimensionSuffix">
              {{ subBlock.dimensionSuffix }}
            </div>
        </span>

        <span class="ml-1 font-size-12px line-height-14px text-blue">
            vs факт
        </span>
      </div>

      <div class="flex-grow-1 mt-2 font-weight-bold font-size-16px line-height-18px">
        {{ subBlock.title }}
      </div>
    </div>
  </div>
</template>

<script>
import Divider from "../Divider";
import PercentBadgeIcon from "../PercentBadgeIcon";
import PercentProgress from "../PercentProgress";

export default {
  name: "EconomicBlock",
  components: {
    Divider,
    PercentBadgeIcon,
    PercentProgress
  },
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

.font-size-18px {
  font-size: 18px;
}

.font-size-26px {
  font-size: 26px;
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

.line-height-20px {
  line-height: 20px;
}

.text-blue {
  color: #82BAFF;
}

.text-grey {
  color: #656A8A
}
</style>