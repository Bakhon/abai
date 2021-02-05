<template>
  <div>
    <template v-if="['text', 'numeric'].indexOf(item.type) > -1">
      <input
          :type="item.type === 'numeric' ? 'number' : 'text'"
          :name="item.code"
          v-bind:value="value"
          v-on:input="$emit('input', $event.target.value)"
          class="form-control"
          :class="{'error': error}"
          placeholder=""
          :required="item.required"
      >
    </template>
    <template v-else-if="item.type === 'list'">
      <select
          class="form-control"
          :class="{'error': error}"
          :name="item.code"
          v-bind:value="value"
          v-on:input="$emit('input', $event.target.value)"
          :required="item.required"
      >
        <option v-for="value in item.values" v-bind:value="value">{{ value }}</option>
      </select>
    </template>
    <template v-else-if="item.type === 'radio'">
      <template v-for="value in item.values">
        <input
            :name="item.code"
            v-bind:value="value"
            v-on:input="$emit('input', $event.target.value)"
            type="radio"
            :id="`${item.code}_${value}`"
            :required="item.required"
        >
        <label :for="`${item.code}_${value}`">{{ value }}</label>
      </template>
    </template>
    <template v-else-if="item.type === 'dict'">
      <select
          class="form-control"
          :class="{'error': error}"
          :name="item.code"
          v-bind:value="value"
          v-on:input="$emit('input', $event.target.value)"
          :required="item.required"
      >
        <option v-for="row in dict" v-bind:value="row.id">{{ row.name }}</option>
      </select>
    </template>
    <template v-else-if="item.type === 'date'">
      <input
          type="date"
          :name="item.code"
          v-bind:value="value"
          v-on:input="$emit('input', $event.target.value)"
          class="form-control"
          :class="{'error': error}"
          placeholder=""
          :required="item.required"
      >
    </template>
    <div class="text-danger error" v-if="error">{{showError(error)}}</div>
  </div>
</template>

<script>

export default {
  name: "BigdataFormField",
  props: [
      'item',
      'value',
      'error'
  ],
  data: function () {
    return {
      dict: []
    }
  },
  mounted() {
    if(this.item.type === 'dict') {
      this.loadDict()
    }
  },
  methods: {
    loadDict() {
      this.axios.get(this.localeUrl('/bigdata/dict/'+this.item.dict)).then(data => {
        this.dict = data.data
      })
    },
    showError(err) {
      return err.join('<br>')
    }
  },
};
</script>