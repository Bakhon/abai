<template>
  <b-modal
    size="xl"
    header-bg-variant="main1"
    body-bg-variant="main1"
    header-text-variant="light"
    footer-bg-variant="main1"
    centered
    modal-class="long-modal"
    id="modalAtlas"
    :ok-only="true"
    @hide="close"
  >
    <template #modal-header="{close}">
      <div class="d-flex justify-content-end w-100">
        <button type="button" class="modal-bign-button" @click="close">
          {{ trans('pgno.zakrit') }}
        </button>
      </div>
    </template>
    <div class="text-white">
      <div class="rating-tabs">
        <template v-for="(tab, tabIdx) in tabs">
          <div
            :key="tabIdx"
            class="rating-tabs__item"
            :class="{
              'is-active': tab.name === currentTab
            }"
            @click="handleSelectTab(tab.name)"
          >
            <span>{{ trans(tab.title) }}</span>
          </div>
        </template>
      </div>
      <div class="content">
        <div class="sector-form">
          <div class="sector-form__item">
            <div class="sector-form__label">
              {{ trans('digital_rating.sector') }}
            </div>
            <input
              type="text"
              class="sector-form__input"
              v-model="sector"
              @blur="handleBlur"
              @keypress="restrictChars($event)"
            />
          </div>
          <div class="sector-form__item">
            <div class="sector-form__label">
              {{ trans('digital_rating.horizon') }}
            </div>
            <input
              type="text"
              class="sector-form__input"
              v-model="horizon"
              @blur="handleBlur"
              @keypress="restrictChars($event)"
            />
          </div>
        </div>
        <component :is="currentTabComponent"></component>
      </div>
    </div>
    <template #modal-footer>
      <div class="modal__footer mb-10px">
        <button type="button" class="btn-button btn-button--thm-blue mr-20px minw-200">
          <span>{{ trans('digital_rating.markCandidate') }}</span>
        </button>
        <button type="button" class="btn-button btn-button--thm-green minw-200">
          <span>{{ trans('digital_rating.agreeCandidate') }}</span>
        </button>
      </div>
    </template>
  </b-modal>
</template>

<script>
import Overview from './Overview';
import Maps from './Maps';
import Scheme from "./Scheme";
import Indicators from "./Indicators";
import History from "./History";
import { digitalRatingState, digitalRatingMutations, digitalRatingActions } from "@store/helpers";
import Restricts from '../../../mixins/restricts';

export default {
  name: "WellAtlasModal",

  components: {
    Overview,
    Maps,
    Scheme,
    Indicators,
    History,
  },

  mixins: [Restricts],

  data() {
    return {
      currentTab: 'overview',
      isVisibleAtlas: false,
      tabs: [
        {
          title: 'digital_rating.overview',
          name: 'overview'
        },
        {
          title: 'digital_rating.developmentMaps',
          name: 'maps'
        },
        {
          title: 'digital_rating.correlationScheme',
          name: 'scheme'
        },
        {
          title: 'digital_rating.environmentIndicators',
          name: 'indicators'
        },
        {
          title: 'digital_rating.matchingHistory',
          name: 'history'
        }
      ],
    }
  },

  computed: {
    ...digitalRatingState([
      'sectorNumber',
      'horizonNumber'
    ]),
    sector: {
      get() {
        return this.sectorNumber;
      },
      set(val) {
        this.SET_SECTOR(val);
      }
    },
    horizon: {
      get() {
        return this.horizonNumber;
      },
      set(val) {
        this.SET_HORIZON(val);
      },
    },
    currentTabComponent() {
      return this.currentTab.toLowerCase();
    }
  },

  methods: {
    ...digitalRatingActions([
      'fetchIndicators'
    ]),
    ...digitalRatingMutations([
      'SET_SECTOR',
      'SET_HORIZON',
      'CLEAR_ATLAS'
    ]),
    fetchData() {
      this.fetchIndicators({});
    },
    handleSelectTab(tab) {
      this.currentTab = tab;
    },
    close() {
      this.currentTab = 'overview';
      this.CLEAR_ATLAS();
      this.$emit('close');
    },
    handleBlur() {
      this.fetchData();
    }
  }
}
</script>

<style scoped lang="scss">
.content {
  background: #363B68;
  border: 1px solid #545580;
  padding: 10px;
  border-top: none;
  overflow: auto;
  height: calc(100% - 75px);
}
.sector-form {
  display: flex;
  align-items: center;
  font-size: 16px;
  margin: 10px 0 20px 0;

  &__item {
    display: flex;
    align-items: center;
    margin-right: 20px;
  }

  &__label {
    padding: 5px 30px;
    background: #323370;
  }

  &__input {
    background: #1F2142;
    border: none;
    padding: 5px 10px;
    color: #fff;
    width: 100px;
    &:focus {
      outline: 1px solid #6c72ad;
    }
  }
}
</style>
