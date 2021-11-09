<template>
  <div>
    <gtm-main-menu
      :parentType="this.parentType"
      :mainMenu="menu"
      @menuClick="menuClick"
    />
    <div class="rating-analysis">
      <div class="rating-analysis__title">
        <span>{{ trans('Факторный анализ') }}</span>
        <div class="d-flex align-items-center">
          <btn-dropdown :list="analysis" @select="handleSelectAnalysis">
            <template #title>
              {{ trans('digital_rating.comparisonDesignActualIndicators') }}
            </template>
          </btn-dropdown>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="./factorAnalysis.js"></script>

<style scoped>

</style>