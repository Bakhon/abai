<template>
  <button type="button"
          class="btn report-btn-bd"
          :class="{'selected': selectedReport && selectedReport.tag === report.tag, 'disabled': !report.is_active}"
          @click="click()">
    <div class="report-btn-bd-content">
      <span class="r-txt" v-html="report.icon"></span>
      <div class="font-size report-btn-bd-title">
        {{ report.title }}
      </div>
      <span class="r-txt f-right">
        <svg width="8" height="16" viewBox="0 0 8 16" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="M0.888015 16.001C1.01426 16.0008 1.13902 15.9737 1.254 15.9215C1.36898 15.8693 1.47155 15.7932 1.55487 15.6982L7.77884 8.57414C7.92139 8.41163 8 8.20272 8 7.98641C8 7.7701 7.92139 7.56118 7.77884 7.39867L1.55487 0.27461C1.39616 0.109125 1.1798 0.0113815 0.950901 0.00176043C0.721998 -0.00786062 0.49822 0.0713829 0.326229 0.222969C0.154237 0.374554 0.047307 0.586782 0.0277324 0.8154C0.00815725 1.04402 0.0774493 1.27138 0.221161 1.45008L5.92943 7.98641L0.221161 14.5227C0.108386 14.6513 0.0349884 14.8097 0.00975227 14.9789C-0.0154839 15.1482 0.00850964 15.3212 0.0788636 15.4771C0.149217 15.6331 0.262951 15.7654 0.406452 15.8583C0.549953 15.9512 0.717143 16.0008 0.888015 16.001Z"
                fill="#9EA4C9"/>
        </svg>
      </span>
    </div>
  </button>
</template>

<script>
export default {
  props: {
    report: {
      type: Object,
      required: true
    },
    selectedReport: {
      type: Object,
      required: true
    }
  },
  methods: {
    click() {
      this.$emit('click');
    }
  }
}
</script>