<template>
  <div class="bd-main-block">
    <notifications position="top"></notifications>
    <div class="bd-main-block__header">
      <div>
        <p v-if="well" class="bd-main-block__header-title">Скважина {{ well.uwi }}</p>
        <p class="bd-main-block__header-title">{{ params.title }}</p>
      </div>
    </div>
    <BigdataPlainForm v-if="isFormShowed" :params="params" :values="formValues" :well-id="wellId"></BigdataPlainForm>
    <BigdataPlainFormResults
        v-else
        :params="params"
        :code="params.code"
        :well-id="wellId"
        @edit="openEditForm"
    >
    </BigdataPlainFormResults>
  </div>
</template>

<script>
import BigdataPlainForm from './PlainForm'
import BigdataPlainFormResults from './PlainFormResults'

export default {
  name: "BigDataPlainFormWrapper",
  components: {
    BigdataPlainForm,
    BigdataPlainFormResults
  },
  props: {
    params: {
      type: Object,
      required: true
    },
    wellId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      well: null,
      isFormShowed: false,
      formValues: null
    }
  },
  watch: {
    params() {
      this.isFormShowed = false
    }
  },
  mounted() {
    this.axios.get(this.localeUrl(`/api/bigdata/wells/${this.wellId}`)).then(({data}) => {
      this.well = data.well
    })
  },
  methods: {
    openCreateForm(values) {
      this.isFormShowed = true
      this.formValues = null
    },
    openEditForm(values) {
      this.isFormShowed = true
      this.formValues = values
    }
  }
};
</script>
<style lang="scss" scoped>
.bd-main-block {
  max-width: 1340px;
  margin: 0 auto;

  &__header {
    align-items: center;
    display: flex;
    justify-content: space-between;
    margin: 16px 0 20px;

    &-title {
      color: #fff;
      font-weight: bold;
      font-size: 20px;
      line-height: 24px;
      margin: 0;
    }
  }
}
</style>