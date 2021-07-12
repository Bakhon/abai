<template>
  <form :action="action">
    <slot />
  </form>
</template>

<script>
export default {
  name: "AwForm",
  props: {
    action: String
  }
}
</script>
