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
          <btn-dropdown :list="horizonList" @select="handleSelectHorizon" class="mr-10px">
            <template #title>
              {{ trans('digital_rating.horizon') }}
            </template>
            <template v-for="(object, objectIdx) in horizonList">
              <span class="dropdown-item" :key="objectIdx" :class="{'submenu': getChildren(object)}">
                {{ object.title }}
              </span>
              <div v-if="getChildren(object)" class="dropdown-menu">
                <template v-for="(horizon, horizonIdx) in object.children">
                  <span
                    class="dropdown-item"
                    :key="horizonIdx"
                    :class="{'submenu': getChildren(horizon)}"
                  >
                    {{ horizon.title }}
                  </span>
                  <div v-if="getChildren(horizon)" class="dropdown-menu">
                    <span
                      class="dropdown-item"
                      v-for="(item, itemIdx) in horizon.children"
                      :key="itemIdx"
                    >
                      {{ item.title }}
                    </span>
                  </div>
                </template>
              </div>
            </template>
          </btn-dropdown>
          <btn-dropdown :list="getYearList" @select="handleSelectYear" class="mr-10px">
            <template #title>
              {{ trans('digital_rating.year') }}
            </template>
          </btn-dropdown>
          <btn-dropdown :list="coincidences" class="mr-10px">
            <template #title>
              {{ trans('digital_rating.coincidencePlannedWellsWithin') }}
            </template>
          </btn-dropdown>
          <btn-dropdown :list="actualIndicators" @select="handleSelectIndicator">
            <template #title>
              {{ trans('digital_rating.comparisonDesignActualIndicators') }}
            </template>
          </btn-dropdown>
        </div>
      </div>
      <div class="rating-compare__wrapper">
        <div class="rating-compare__wrapper-maps">
          <h5>{{ trans('digital_rating.map') }}</h5>
          <div class="rating-content__wrapper">
            <div id="wellMap"></div>
          </div>
          <div class="d-flex">
            <div
              v-if="['oil_production', 'liquid_val', 'avg_debit'].includes(type)"
              class="rating-compare__chart" style="width: 100%;"
            >
              <p>{{ indicatorTitle }}</p>
              <apexchart
                :height="300"
                type="area"
                :series="diagramData"
                :options="chartOptionsArea"
              />
            </div>
            <div
              v-if="['water_inj', 'drilling_unit', 'fds_operational_unit'].includes(type)"
              class="rating-compare__chart" style="width: 100%;"
            >
              <p>{{ indicatorTitle }}</p>
              <apexchart
                :height="300"
                type="bar"
                :series="diagramData"
                :options="chartOptions"
              />
            </div>
          </div>
        </div>
        <div class="rating-compare__wrapper-table">
          <table class="table text-center text-white rating-table mb-0">
            <thead>
              <tr>
                <th class="align-middle" style="width: 50%">{{ trans('digital_rating.object') }}</th>
                <th colspan="3" class="align-middle">{{ horizon }} горизонт Северо-Западного купола</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in rowsHorizon" :key="index">
                <td style="width: 50%">{{ item['key'] }}</td>
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
                  {{ indicatorTitle }}, {{ trans('digital_rating.thousandTons') }}
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
                <td>{{ item.actual }}</td>
                <td :class="Number(item.total) ? '' : 'alert'">{{ item.total }}</td>
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
      width: 50%;
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
  background: transparent;
}

.rating-content__wrapper {
  height: calc(100% - 200px);
}

.leaflet-pane {
  z-index: 90;
}

.dropdown-menu .dropdown-menu {
  top: auto;
  left: 100%;
  transform: translateY(-2rem);
}
.dropdown-item + .dropdown-menu {
  display: none;
}
.dropdown-item.submenu::after {
  content: '▸';
  margin-left: 6rem;
}
.dropdown-item:hover + .dropdown-menu,
.dropdown-menu:hover {
  display: block;
}
.dropdown-item:hover, .dropdown-item:focus {
  color: #fff;
  background: #4b4c66;
  cursor: pointer;
  border-radius: 4px;
}
.dropdown-item {
  padding: 8px;
  color: #fff;
}
.dropdown-menu {
  background-color: #5D5F7F;
  padding: 0;
}

.legend span {
  position: relative;
  bottom: 3px;
}

.legend i {
  width: 14px;
  height: 14px;
  float: left;
  margin: 0 8px 0 0;
  opacity: 0.7;
}
</style>