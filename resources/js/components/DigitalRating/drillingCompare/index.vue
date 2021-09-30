<template>
  <div>
    <gtm-main-menu
      :parentType="this.parentType"
      :mainMenu="menu"
      @menuClick="menuClick"
    />
    <div class="rating-compare">
      <div class="rating-compare__title">
        <span>Сравнение фактических точек бурения с ПТД</span>
        <div class="d-flex align-items-center">
          <btn-dropdown :list="horizonList" class="mr-10px">
            <template #title>
              {{ trans('digital_rating.horizon') }}
            </template>
          </btn-dropdown>
          <btn-dropdown :list="yearList" class="mr-10px">
            <template #title>
              {{ trans('Год') }}
            </template>
          </btn-dropdown>
          <btn-dropdown :list="['Test1', 'Test2']" class="mr-10px">
            <template #title>
              Совпадение проектных скважин в пределах
            </template>
          </btn-dropdown>
          <btn-dropdown :list="['Test1', 'Test2']">
            <template #title>
              Сравнение проектных и фактических показателей
            </template>
          </btn-dropdown>
        </div>
      </div>
      <div class="rating-compare__wrapper">
        <div class="rating-compare__wrapper-maps">
          <h5>Карта</h5>
          <img src="/img/digital-rating/compare-maps.svg" alt="">
        </div>
        <div class="rating-compare__wrapper-table">

        </div>
        <div class="rating-compare__wrapper-table">

        </div>
      </div>
    </div>
  </div>
</template>

<script src="./compareDrilling.js"></script>

<style scoped lang="scss">
.rating-compare {
  height: calc(100vh - 160px);
  color: #fff;
  margin-top: 3rem;

  &__wrapper {
    position: relative;
    background: #1A214A;
    border: 1px solid #545580;
    box-sizing: border-box;

    &-maps {
      display: flex;
      width: 50%;
      flex-direction: column;

      h5 {
        padding: 8px;
        background: #323370;
        border: 1px solid #545580;
        box-sizing: border-box;
        margin: 0;
      }
    }
  }

  &__title {
    padding: 6px 12px;
    background: #323370;
    border: 1px solid #545580;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
}
</style>