<template>
  <div>
    <div class="d-flex main-block pt-2 pb-2">
      <div class="left-block d-flex flex-dir-column">
        <prod-plan-sidebar :activatedBlocks="activatedBlocks"/>
      </div>
      <div class="right-block">
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
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'monitoring-plan-fact',
  data: function () {
    return {
      activatedBlocks: {
        isIndexActive: true,
        isSearchWell: true,
        isIndicatorActive: true,
        isSearchWellButton: false
      },
    }
  },
}
</script>
