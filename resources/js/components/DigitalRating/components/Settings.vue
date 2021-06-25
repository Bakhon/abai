<template>
  <div class="rating-settings">
    <div class="rating-content">
      <div class="rating-content__title">
        <div>Диаграмма</div>
        <img src="/img/icons/link.svg" alt="">
      </div>
      <div class="rating-content__wrapper">
        <el-divider direction="vertical"></el-divider>
        <el-divider direction="vertical"></el-divider>
        <el-divider direction="vertical"></el-divider>
      </div>
      <button class="btn-button btn-button--thm-green ol-w-100 mb-10px">
        Построить карту
      </button>
    </div>
    <div class="rating-panel">
      <div class="rating-dropdown">
        <div class="rating-dropdown__header">
          <div class="rating-dropdown__title">Месторождение</div>
          <div class="rating-dropdown__icon"></div>
        </div>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': isOpen }"
      >
        <div class="rating-dropdown__header" @click="handleToggle">
          <div class="rating-dropdown__title">Размер сектора</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition name="fade">
          <div v-if="isOpen" class="rating-dropdown__body">
            <ul class="list">
              <li>100x100</li>
              <li>150x150</li>
              <li>200x200</li>
            </ul>
          </div>
        </transition>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': isOpen }"
      >
        <div class="rating-dropdown__header" @click="handleToggle">
          <div class="rating-dropdown__title">Фонд</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition name="fade">
          <div v-if="isOpen" class="rating-dropdown__body">
            <ul class="list">
              <li>100x100</li>
              <li>150x150</li>
              <li>200x200</li>
            </ul>
          </div>
        </transition>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': isOpen }"
      >
        <div class="rating-dropdown__header" @click="handleToggle">
          <div class="rating-dropdown__title">Сценарий ранжирования</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition name="fade">
          <div v-if="isOpen" class="rating-dropdown__body">
            <ul class="list">
              <li>100x100</li>
              <li>150x150</li>
              <li>200x200</li>
            </ul>
          </div>
        </transition>
      </div>
      <div
        class="rating-dropdown"
        :class="{ 'is-active': isOpen }"
      >
        <div class="rating-dropdown__header" @click="handleToggle">
          <div class="rating-dropdown__title">Выработка</div>
          <div class="rating-dropdown__icon"></div>
        </div>
        <transition name="fade">
          <div v-if="isOpen" class="rating-dropdown__body">
            <ul class="list">
              <li>100x100</li>
              <li>150x150</li>
              <li>200x200</li>
            </ul>
          </div>
        </transition>
      </div>
      <button class="btn-button btn-button--thm-blue ol-w-100 mb-10px">
        Принять настройки
      </button>
      <button class="btn-button btn-button--thm-blue ol-w-100 mb-10px">
        Сохранить настройки
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "Settings",

  data() {
    return {
      isOpen: false,
    }
  },

  methods: {
    handleToggle() {
      this.isOpen = !this.isOpen;
    }
  }
}
</script>

<style scoped lang="scss">
.rating-settings {
  color: #fff;
  display: flex;
}

.rating-panel {
  width: 100%;
  max-width: 357px;
}

</style>
