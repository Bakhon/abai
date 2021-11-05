<template>
  <div class="main-border-block">
    <div class="monitoring-container">
      <div class="top-block">
          <div class="plan-block">
            <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
              <div>
                {{ this.trans("prod-plan.plan-block-title") }}
              </div>
              <div class="d-flex">
                <div class="pr-3 pb-1">
                  <img src="/img/GTM/download.svg" alt="">
                </div>
                <div class="pr-3 pb-1">
                  <img src="/img/GTM/full-screen.svg" alt="">
                </div>
              </div>
            </div>
            <div class="border-block-out">
              <div class="border-block-in">
                <div class="p-3 data-block">
                  {{ this.trans("paegtm.empty-well-chart") }}
                </div>
              </div>
            </div>
          </div>

          <div class="factor-plan-block">
            <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
              <div>
                {{ this.trans("prod-plan.factor-plan-title") }}
              </div>
              <div class="d-flex">
                <div class="pr-3 pb-1">
                  <img src="/img/GTM/download.svg" alt="">
                </div>
                <div class="pr-3 pb-1">
                  <img src="/img/GTM/full-screen.svg" alt="">
                </div>
              </div>
            </div>
            <div class="border-block-out">
              <div class="border-block-in">
                <div class="p-3 data-block">
                  {{ this.trans("paegtm.empty-well-chart") }}
                </div>
              </div>
            </div>
          </div>
      </div>

      <div class="bottom-block">
        <div class="debit-plan-block">
          <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
            <div>
              {{ this.trans("prod-plan.debit-plan-title") }}
            </div>
            <div class="d-flex">
              <div class="pr-3 pb-1">
                <img src="/img/GTM/download.svg" alt="">
              </div>
              <div class="pr-3 pb-1">
                <img src="/img/GTM/full-screen.svg" alt="">
              </div>
            </div>
          </div>
          <div class="border-block-out">
            <div class="border-block-in">
              <div class="p-3 data-block">
                {{ this.trans("paegtm.empty-well-chart") }}
              </div>
            </div>
          </div>
        </div>

        <div class="gtm-vns-block">
          <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
            <div>
              {{ this.trans("prod-plan.gtm-vns-title") }}
            </div>
            <div class="d-flex">
              <div class="pr-3 pb-1">
                <img src="/img/GTM/download.svg" alt="">
              </div>
              <div class="pr-3 pb-1">
                <img src="/img/GTM/full-screen.svg" alt="">
              </div>
            </div>
          </div>
          <div class="border-block-out">
            <div class="border-block-in">
              <div class="p-3 data-block">
                {{ this.trans("paegtm.empty-well-chart") }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'monitoring-plan-fact',
  data: function() {
    return{

    }
  },
  onChangePage(e) {
    console.log(e)
  }
}
</script>
<style scoped>
.monitoring-container {
  display: flex;
  flex-direction: column;
  flex: 100%;
  gap: 6px;
}

.main-border-block {
  display: flex;
  width: 100%;
  height: 100%;
  border: 6px solid #272953;
  padding: 4px;
}

.top-block {
  display: flex;
  flex: 100%;
  gap: 6px;
}

.bottom-block {
  display: flex;
  flex: 100%;
  gap: 6px;
}
/**/
.plan-block {
  flex: 50%;
  background-color: #1A214A;
}

.factor-plan-block {
  flex: 50%;
  background-color: #1A214A;
}

.debit-plan-block {
  flex: 50%;
  background-color: #1A214A;
}

.gtm-vns-block {
  flex: 50%;
  background-color: #1A214A;
}
/* block-of-forth */
.block-header {
  height: 8%;
}

.border-block-out {
  height: 92%;
  border: 8px solid #363B68;
}

.border-block-in {
  height: 100%;
  border: 8px solid #1A214A;
}

.border-color {
  background-color: #323370
}

.data-block {
  height: 100%;
}

/**/
</style>