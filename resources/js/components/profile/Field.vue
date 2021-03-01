<template>
  <div class="user-profile__tab-field-item">
    <p class="user-profile__tab-field-title">
      <span v-html="field.ico"></span>
      <span>{{ trans(field.name) }}:</span>
    </p>
    <p class="user-profile__tab-field-value">{{ value }}</p>
  </div>
</template>
<script>
export default {
  name: 'ProfileField',
  props: {
    field: {
      type: Object,
      required: true
    },
    value: {
      type: String,
      required: false
    },
  }
}
</script>