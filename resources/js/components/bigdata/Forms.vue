<template>
  <div v-if="form">
    <BigDataPlainFormWrapper v-if="form.type === 'plain' && type === 'well' && id" :params="form"
                             :well-id="id"></BigDataPlainFormWrapper>
    <BigDataTableFormWrapper v-else-if="form.type === 'table'"
                             :id="id" :params="form" :type="type"></BigDataTableFormWrapper>
  </div>
</template>

<script>
import BigDataPlainFormWrapper from './forms/PlainFormWrapper'
import BigDataTableFormWrapper from './forms/TableFormWrapper'

export default {
  props: {
    id: {
      type: Number,
      required: true
    },
    type: {
      type: String,
      required: true
    },
    form: {
      type: Object,
      required: true
    },
  },
  data() {
    return {
      activeForm: null
    }
  },
  components: {
    BigDataTableFormWrapper,
    BigDataPlainFormWrapper
  }
}
</script>
