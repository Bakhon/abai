<template>
  <div class="faq-page">
    <div class="faq-page__inner">
      <div class="faq-page__search">
        <input :placeholder="trans('faq.describeTheProblem')" type="text" v-model="query" />
        <button>
          <div class="faq-page__search__img"></div>
        </button>
      </div>
      <div class="faq-blocks-holder">
        <faqPageModuleBlock :query="query" />
      </div>
    </div>
  </div>
</template>

<script>
import faqPageModuleBlock from "./faqPageModuleBlock";

export default {
  name: "main-page",
  components: {
    faqPageModuleBlock,
  },
  data() {
    return {
      query: "",
    };
  },
};
</script>