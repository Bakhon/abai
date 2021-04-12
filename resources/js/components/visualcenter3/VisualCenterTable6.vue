<template>
  <div class="row visualcenter-page-container">
    <div class="col-lg-10 middle-block-columns pr-2">
      <horizontal-indicators
        v-bind:dateStart="dateStart"
        v-bind:dateEnd="dateEnd"
      ></horizontal-indicators>
      <div class="vc-central-block">
        <div class="d-flex flex-row mb-2">
          <div class="flex-grow-1 first-string">
            <div
              class="d-flex flex-column flex-sm-row justify-content-between align-items-center p-2"
            >
              <h5 class="font-weight-bold m-0">
                <!-- КПД Блока стратегии -->{{
                  trans("visualcenter.strategyKPI")
                }}
              </h5>
              <div class="w-75">
                <div class="progress2">
                  <div
                    class="progress-bar"
                    role="progressbar"
                    :style="{ width: tSum + '%' }"
                    :aria-valuenow="tSum"
                    aria-valuemin="0"
                    :aria-valuemax="100"
                  >
                    <div v-if="tSum">{{ tSum.toFixed(1) }}%</div>
                  </div>
                </div>
              </div>
              <div class="close2 d-none d-sm-block">
                <!-- Закрыть -->{{ trans("visualcenter.close") }}
              </div>
            </div>
          </div>
        </div>
        <div
          class="d-flex flex-column flex-sm-row mb-sm-3 vc-speedometer-line"
          v-if="isEnableSpeedometers"
        >
          <vc-speedometer-block
            v-bind:title="trans('visualcenter.KPIstrategy1')"
            v-bind:mainValue="t1"
            v-bind:units="trans('visualcenter.projectAmount')"
            v-bind:planWeight="'20'"
          ></vc-speedometer-block>
          <vc-speedometer-block
            v-bind:title="trans('visualcenter.KPIstrategy2')"
            v-bind:mainValue="t2"
            v-bind:units="trans('visualcenter.projectAmount')"
            v-bind:planWeight="'20'"
          ></vc-speedometer-block>
          <vc-speedometer-block
            v-bind:title="trans('visualcenter.ESGrating')"
            v-bind:mainValue="t3"
            v-bind:units="'%'"
            v-bind:isLastBlock="true"
            v-bind:planWeight="'10'"
          ></vc-speedometer-block>
        </div>
        <div
          class="d-flex flex-column flex-sm-row mb-1 mb-sm-2 vc-speedometer-line"
          v-if="isEnableSpeedometers"
        >
          <vc-speedometer-block
            v-bind:title="trans('visualcenter.KPIstrategy4')"
            v-bind:mainTitle="trans('visualcenter.October')"
            v-bind:mainValue="t4"
            v-bind:toolTipPorog="trans('visualcenter.November')"
            v-bind:toolTipAim="trans('visualcenter.October')"
            v-bind:toolTipVizov="trans('visualcenter.September')"
            v-bind:units="trans('visualcenter.date2')"
            v-bind:planWeight="'25'"
          ></vc-speedometer-block>
          <vc-speedometer-block
            v-bind:title="trans('visualcenter.KPIstrategy5')"
            v-bind:mainValue="t5"
            v-bind:units="'%'"
            v-bind:planWeight="'20'"
          ></vc-speedometer-block>
          <vc-speedometer-block
            v-bind:title="trans('visualcenter.KPIstrategy6')"
            v-bind:mainTitle="trans('visualcenter.December')"
            v-bind:toolTipPorog="'-'"
            v-bind:toolTipAim="trans('visualcenter.December')"
            v-bind:toolTipVizov="'-'"
            v-bind:mainValue="t6"
            v-bind:units="trans('visualcenter.date2')"
            v-bind:isLastBlock="true"
            v-bind:planWeight="'5'"
          ></vc-speedometer-block>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-2 middle-block-columns" v-if="dateStart">
      <div class="second-column-container">
        <vertical-indicators
          v-bind:dateStart="dateStart"
          v-bind:dateEnd="dateEnd"
        ></vertical-indicators>
      </div>
    </div>
    <cat-loader />
  </div>
</template>
<script src="./VisualCenterTable6.js"></script>
<style scoped lang="scss">
.visualcenter-page-container {
  flex-wrap: wrap;
  margin: 0 !important;
  color: #fff;
}

.middle-block-columns {
  padding-left: 0 !important;
  padding-right: 0 !important;
}

.right-side2 {
  overflow: hidden;
}

.second-column-container {
  padding-left: 10px;
  padding-right: 0;
}
</style>
