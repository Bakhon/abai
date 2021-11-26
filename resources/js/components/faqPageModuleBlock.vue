<template>
  <div class="faq-page-module-block">
    <div class="faq-question" @click="getId(block.id)">
      {{ block.question }}
    </div>
    <div class="faq-ansver" v-if="block.id == clickedId">
      {{ block.answer }}
    </div>
  </div>
</template>

<script>
export default {
  name: "MainPageModuleBlock",
  props: {
    block: Object,
  },
  data() {
    return {
      clickedId: 0,
    };
  },
  methods: {
    getId(id) {
      this.clickedId = id;
    },
  },
};
</script>
