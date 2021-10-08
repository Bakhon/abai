<template>
  <div class="data-analysis-header">
    <MultiLevelDropdown
      v-for="heading in headerMenu"
      :class="{ activeLink: heading.activeKey === headingKey }"
      :key="heading.name"
      :item="heading"
      :hover="hover"
    />
  </div>
</template>

<script>
import MultiLevelDropdown from '../PlastFluids/components/MultiLevelDropdown.vue';

export default {
  name: "mainHeader",
  components: {
    MultiLevelDropdown,
  },

  data() {
    return {
      hover: "#2E50E9",
      headerMenu: [
        {
          name: this.trans('tkrs.monitoring'),
          imagePath: "/img/tkrs/eyes.svg",
          showArrow: true,
          activeKey: "reservoir-oil-samples-analysis",
          position: "bottom",
          children: [
            {
              name: this.trans('tkrs.brigades'),
              imagePath: "/img/tkrs/brigada_header.svg",
              showArrow: false,
              position: "right",
            },
          ],
        },
        
        {
          name: this.trans('tkrs.analytics'),
          imagePath: "/img/tkrs/analytic_header_icon.svg",
          showArrow: true,
          activeKey: "reservoir-oil-samples-analysis",
          position: "bottom",
          children: [
            {
              name: this.trans('tkrs.analysis_pv_npv'),
              imagePath: "/img/tkrs/search_header.svg",
              showArrow: false,
              position: "right",
            },
          ],
        },

        // name: this.trans('tkrs.documentation'),
        //   imagePath: "/img/tkrs/document_header.svg",
        {
          name: this.trans('tkrs.documentation'),
          imagePath: "/img/tkrs/document_header.svg",
          showArrow: true,
          activeKey: "reservoir-oil-samples-analysis",
          position: "bottom",
          children: [
            {
              name: this.trans('tkrs.daily_summary'),
              imagePath: "/img/tkrs/daily_summary.svg",
              showArrow: false,
              position: "right",
            },
            {
              name: this.trans('tkrs.por'),
              imagePath: "/img/tkrs/por.svg",
              showArrow: false,
              position: "right",
            },
          ],
        },

        {
          name: this.trans('tkrs.library'),
          imagePath: "/img/tkrs/library_header.svg",
          showArrow: true,
          activeKey: "reservoir-oil-samples-analysis",
          position: "bottom",
          children: [
            {
              name: this.trans('tkrs.daily_summary'),
              imagePath: "/img/tkrs/daily_summary.svg",
              showArrow: false,
              position: "right",
            },
          ],
        },
        
      ],
    };
  },
};
</script>

<style scoped>
.data-analysis-header {
  display: grid;
  column-gap: 10px;
  grid-template-columns: repeat(4, 1fr);
  margin: 0 0 5px 0;
}

.activeLink {
  background: #2e50e9;
  font-weight: 700;
}
</style>
