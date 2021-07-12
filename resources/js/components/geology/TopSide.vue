<template>
  <div class="d-flex align-items-center">
    <LinkButton has-check-active href="/geology/petrophysics" color="accent" icon="moleqq" class="flex-grow-1 mr-3" align="center">
      Корреляция ГИС
    </LinkButton>
    <LinkButton has-check-active href="/geology/core" color="accent" icon="kern" class="flex-grow-1 mr-3" align="center">
      Керн
    </LinkButton>
    <LinkButton has-check-active href="/geology/visualization" color="accent" icon="d3" class="flex-grow-1 mr-3" align="center">
      2D - 3D
    </LinkButton>
    <LinkButton has-check-active href="/geology/geophysics" color="accent" icon="geoPh" class="flex-grow-1" align="center">
      Геофизика
    </LinkButton>
  </div>
</template>

<script>
import LinkButton from "./components/buttons/LinkButton";
export default {
  name: "Geology-TSide",
  components: {
    LinkButton
  }
}
</script>
