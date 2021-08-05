<template>
  <div class="col m-0 p-0">
      <div class="row m-0 text-left">
        <div class="col-4 col-md-12 col-lg-4 p-1" v-for="(menuItem, i) in menu">
          <div class="w-100 menu__cursor"
               @click="menuClick(menuItem.component)">
            <div class="menu-item-bg rounded p-1 pl-2 d-flex" >
              <div class="menu-title mr-auto">
                <img class="my-auto" :src="menuItem.icon" width="24" height="24">
                <span class="ml-2 menu-item my-auto">
                  {{ trans(menuItem.name) }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</template>
<script>
import mainMenu from './main_menu.json'
export default {
  data: function () {
    return {
      menu: mainMenu,
    };
  },
  methods: {
    menuClick (childComponent) {
      this.$emit('menuClick', childComponent);
    }
  }
}
</script>
<style scoped>
.menu__cursor{
  cursor: pointer;
}
</style>