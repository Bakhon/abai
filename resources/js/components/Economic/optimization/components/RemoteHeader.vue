<template>
  <div class="bg-blue-dark d-flex flex-column position-relative">
    <economic-title
        font-size="26"
        line-height="36"
        flex-grow="0"
        class="text-nowrap">
      <span> {{ header.value }} </span>

      <span class="font-size-16px line-height-20px text-blue">
            {{ header.dimension }}
      </span>
    </economic-title>

    <subtitle font-size="16" class="line-height-18px">
      {{ header.name }}
    </subtitle>

    <span class="text-grey font-size-12px line-height-14px flex-grow-1">
          {{ trans('economic_reference.current') }}
    </span>

    <div v-if="form.scenario_id" class="d-flex align-items-center">
      <div class="font-size-16px line-height-18px font-weight-bold text-nowrap">
        <percent-badge-icon :percent="header.percent" reverse/>

        <span>{{ header.percent }}</span>

        <span class="font-size-14px">{{ header.dimension }}</span>
      </div>

      <div class="flex-grow-1 text-blue font-size-12px line-height-14px text-right">
        {{ trans('economic_reference.vs_choice') }}
      </div>
    </div>

    <a :href="header.url" target="_blank" class="remote-link">
      <i class="fas fa-external-link-alt text-blue"> </i>
    </a>
  </div>
</template>

<script>
import EconomicTitle from "../../nrs/components/EconomicTitle";
import Subtitle from "../../components/Subtitle";
import PercentBadgeIcon from "../../components/PercentBadgeIcon";

export default {
  name: "RemoteHeader",
  components: {
    EconomicTitle,
    Subtitle,
    PercentBadgeIcon,
  },
  props: {
    header: {
      required: true,
      type: Object
    },
    form: {
      required: true,
      type: Object
    }
  }
}
</script>

<style scoped>
.bg-blue-dark {
  background: #2B2E5E;
}

.font-size-12px {
  font-size: 12px;
}

.font-size-16px {
  font-size: 16px;
}

.line-height-14px {
  line-height: 14px;
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

.remote-link {
  position: absolute;
  top: 5px;
  right: 5px;
}

</style>