<template>
  <select
      v-model="form.author_id"
      class="form-control"
      @change="$emit('change')"
  >
    <option :value="null" disabled selected>
      {{ trans('economic_reference.select_user') }}
    </option>

    <option
        v-for="author in authors"
        :key="author.id"
        :value="author.id">
      {{ author.name }}
    </option>
  </select>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

export default {
  name: "SelectAuthor",
  props: {
    form: {
      required: true,
      type: Object
    },
    url: {
      required: true,
      type: String
    }
  },
  data: () => ({
    authors: []
  }),
  created() {
    this.getAuthors()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getAuthors() {
      this.SET_LOADING(true);

      const {data} = await this.axios.get(this.url)

      this.authors = data

      this.SET_LOADING(false);
    },
  }
}
</script>

<style scoped>
</style>