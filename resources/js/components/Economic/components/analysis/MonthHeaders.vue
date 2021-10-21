<template>
  <div class="bg-main1 text-white text-wrap mb-10px">
    <div v-for="(header, index) in headers"
         :key="header.name"
         :class="index ? 'border-grey-top' : ''"
         class="d-flex font-size-14px line-height-16px">
      <div class="pl-3 py-2 flex-150px text-wrap">
        {{ header.name }}
      </div>

      <div class="mx-2 p-2 bg-grey flex-120px">
        {{ header.dimension }}
      </div>

      <div class="p-2 flex-120px">
        {{ header.value }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "MonthHeaders",
  props: {
    headers: {
      required: true,
      type: Array
    }
  }
}
</script>

<style scoped>
.bg-grey {
  background: #313560;
}

.border-grey-top {
  border-top: 1px solid #454D7D;
}

.font-size-14px {
  font-size: 12px;
}

.line-height-16px {
  line-height: 16px;
}

.flex-120px {
  flex: 1 0 120px;
}

.flex-150px {
  flex: 1 0 150px;
}
</style>