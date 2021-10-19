<template>
  <div>
    <gtm-main-menu
      :parentType="this.parentType"
      :mainMenu="menu"
      @menuClick="menuClick"
    />
    <div class="rating-compare">
      <div class="rating-compare__title">
        <span>{{ trans('digital_rating.comparisonActualDrillingPoints') }}</span>
        <div class="d-flex align-items-center">
          <btn-dropdown :list="horizonList" class="mr-10px">
            <template #title>
              {{ trans('digital_rating.horizon') }}
            </template>
          </btn-dropdown>
          <btn-dropdown :list="getYearList" class="mr-10px">
            <template #title>
              {{ trans('digital_rating.year') }}
            </template>
          </btn-dropdown>
          <btn-dropdown :list="coincidences" class="mr-10px">
            <template #title>
              {{ trans('digital_rating.coincidencePlannedWellsWithin') }}
            </template>
          </btn-dropdown>
          <btn-dropdown :list="actualIndicators">
            <template #title>
              {{ trans('digital_rating.comparisonDesignActualIndicators') }}
            </template>
          </btn-dropdown>
        </div>
      </div>
      <div class="rating-compare__wrapper">
        <div class="rating-compare__wrapper-maps">
          <h5>{{ trans('digital_rating.map') }}</h5>
          <div id="wellMap"></div>
          <div class="d-flex">
            <div class="rating-compare__chart mr-10px" style="width: 100%; ">
              <p>{{ trans('digital_rating.oilProduction') }}, {{ trans('digital_rating.thousandTons') }}</p>
              <apexchart
                :height="300"
                type="area"
                :series="seriesArea"
                :options="chartOptionsArea"
              />
            </div>
            <div class="rating-compare__chart" style="width: 100%;">
              <p>{{ trans('digital_rating.wellsCommissioningDrilling') }}</p>
              <apexchart
                :height="300"
                type="bar"
                :series="series"
                :options="chartOptions"
              />
            </div>
          </div>
        </div>
        <div class="rating-compare__wrapper-table">
          <table class="table text-center text-white rating-table mb-0">
            <thead>
              <tr>
                <th class="align-middle">{{ trans('digital_rating.horizon') }}</th>
                <th colspan="3" class="align-middle">{{ getSelectedHorizon }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in rowsHorizon" :key="index">
                <td>{{ item['key'] }}</td>
                <td colspan="3" v-if="item['value']">{{ item['value'] }}</td>
                <td v-if="item['value1']">{{ item['value1'] }}</td>
                <td v-if="item['value2']">{{ item['value2'] }}</td>
                <td v-if="item['value3']">{{ item['value3'] }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="rating-compare__wrapper-table">
          <table class="table text-center text-white rating-table mb-0">
            <thead>
              <tr>
                <th class="align-middle" rowspan="2">{{ trans('digital_rating.year') }}</th>
                <th class="align-middle" colspan="3">
                  {{ trans('digital_rating.oilProduction') }}, {{ trans('digital_rating.thousandTons') }}
                </th>
              </tr>
              <tr>
                <th class="align-middle">{{ trans('digital_rating.project') }}</th>
                <th class="align-middle">{{ trans('digital_rating.fact') }}</th>
                <th class="align-middle">{{ trans('digital_rating.deviation') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, itemIdx) in rowsOil" :key="itemIdx">
                <td>{{ item.year }}</td>
                <td>{{ item.project }}</td>
                <td>{{ item.fact }}</td>
                <td :class="Number(item.rejection) ? '' : 'alert'">{{ item.rejection }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="./compareDrilling.js"></script>

<style scoped lang="scss">
.rating-compare {
  height: 100%;
  color: #fff;
  margin-top: 3rem;
  background: #272953;
  padding: 6px;

  &__wrapper {
    position: relative;
    background: #1A214A;
    border: 1px solid #545580;
    box-sizing: border-box;
    padding: 6px;
    display: flex;

    &-maps {
      display: flex;
      width: 53%;
      flex-direction: column;

      h5 {
        padding: 8px;
        background: #323370;
        border: 1px solid #545580;
        box-sizing: border-box;
        margin: 0;
      }

      img {
        width: 100%;
        margin-bottom: 10px;
      }
    }

    &-table {
      margin-left: 10px;
      width: 25%;

      .rating-table {
        height: 100%;
        overflow: auto;
      }

      td.alert {
        background: rgba(227, 31, 37, 0.35);
        border-radius: 0;
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
    margin-bottom: 6px;
  }

  &__chart {
    p {
      background: #323370;
      border: 1px solid #545580;
      box-sizing: border-box;
      padding: 6px;
      margin: 0;
    }
    div {
      border: 3px solid #545580;
    }
  }
}

#wellMap {
  width: 100%;
  height: 100%;
}

.leaflet-container {
  background: #fff;
}
</style>