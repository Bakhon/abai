<template>
  <div>
    <subtitle font-size="20" class="mb-3" style="line-height: 26px">
      Потери добычи от остановок за май-октябрь 2020 г.
    </subtitle>

    <div class="d-flex">
      <div v-for="(block, index) in blocks"
           :key="block.name"
           :class="index ? 'ml-3' : ''"
           class="bg-light-blue text-center flex-grow-1">
        <div class="bg-blue border-grey p-2 font-weight-600">
          {{ block.name }}
        </div>

        <div class="bg-blue d-flex font-weight-600">
          <div class="border-grey flex-40 px-2 py-1">
            Скважина
          </div>

          <div class="border-grey flex-20 px-2 py-1">
            Q ж, м3
          </div>

          <div class="border-grey flex-20 px-2 py-1">
            Q н, т
          </div>

          <div class="border-grey flex-20 px-2 py-1">
            %
          </div>
        </div>

        <div v-for="i in 4" class="d-flex">
          <div class="border-grey flex-40 px-2 py-1">
            {{ i * 10 }}
          </div>

          <div class="border-grey flex-20 px-2 py-1">
            {{ i * 15 }}
          </div>

          <div class="border-grey flex-20 px-2 py-1">
            {{ i * 20 }}
          </div>

          <div class="border-grey flex-20 px-2 py-1">
            {{ i * 25 }}
          </div>
        </div>

        <div class="d-flex">
          <div class="border-grey flex-40 px-2 py-1">
            {{ i * 10 }}
          </div>

          <div class="border-grey flex-20 px-2 py-1">
            {{ i * 15 }}
          </div>

          <div class="border-grey flex-20 px-2 py-1">
            {{ i * 20 }}
          </div>

          <div class="border-grey flex-20 px-2 py-1">
            {{ i * 25 }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "../Subtitle";

export default {
  name: "TableProductionLoss",
  components: {
    Subtitle
  },
  computed: {
    blocks() {
      return [
        {
          name: 'Остановка ЧРФ'
        },
        {
          name: 'Остановка ОПЕК+'
        },
        {
          name: 'Всего:'
        }
      ]
    }
  }
}
</script>

<style scoped>
.bg-blue {
  background: #333975;
}

.bg-light-blue {
  background: #2B2E5E;
}

.border-grey {
  border: 1px solid #454D7D
}

.flex-40 {
  flex: 1 0 40%;
}

.flex-20 {
  flex: 1 0 20%;
}

.font-weight-600 {
  font-weight: 600;
}
</style>