<template>
  <div class="params">
    <b-button v-b-toggle.params variant="main2">{{trans('monitoring.map-params')}}</b-button>
    <b-collapse id="params" class="mt-2">
      <b-card class="bg-main1 text-light">
        <div class="params-item" v-for="(param, index) in mapParams" :key="index">
          <b-form-checkbox
              v-model="param.value"
              :name="param.name"
              @change="$emit('mapRedraw')"
          >
            {{param.title}}
          </b-form-checkbox>
        </div>
      </b-card>
    </b-collapse>
  </div>
</template>

<script>

export default {
  name: "mapParams",
  props: {
    mapParams: Object,
  },
  methods: {

  }
}
</script>

<style scoped lang="scss">
.params {
  position: relative;
  z-index: 10;
  max-width: 275px;
  padding: 15px 0 0 15px;

  .btn {
    width: 100%;
    border: 1px solid rgba(60, 60, 60, .26);
    border-radius: 5px;
    height: 40px;
  }

  .params-item {
    display: flex;
    margin-bottom: 15px;

    &:last-child {
      margin-bottom: 0px;
    }
  }


}
</style>