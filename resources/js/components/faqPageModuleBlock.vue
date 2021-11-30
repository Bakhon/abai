<template>
  <div>
    <div v-for="(block, index) in filteredBlocks" :key="index">
      <div class="faq-page-module-block col-12">
        <div class="faq-question row" @click="getId(block.id)">
          <div class="col-11">
            {{ block.question }}
          </div>
          <div class="col-1">
            <div
              v-if="block.id == clickedId"
              class="faq-question_down mt-2"
            ></div>
            <div v-else class="faq-question_up mt-2"></div>
          </div>
        </div>
        <div class="faq-ansver row" v-if="block.id == clickedId">
          {{ block.answer }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "MainPageModuleBlock",
  props: ["query", "faqData"],
  data() {
    return {
      clickedId: 0,
      blocks: this.faqData,
    };
  },
  computed: {
    filteredBlocks() {
      if (this.query.length > 0) {
        return this.blocks.filter((block) => {
          return (
            block.question.toLowerCase().indexOf(this.query.toLowerCase()) > -1
          );
        });
      }

      return this.blocks;
    },
  },
  methods: {
    getId(id) {
      if (this.clickedId > 0 && id == this.clickedId) {
        this.clickedId = 0;
      } else {
        this.clickedId = id;
      }
    },
  },
};
</script>
