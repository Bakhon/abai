<template>
    <div class="col m-0 p-0">
        <div>
            <div class="row m-0 text-left">
                <div class="col-4 p-1" v-for="(menuItem, i) in menu"
                     :class="[menuItem.parentType]"
                     @mouseover.prevent.stop="menuItemMouseOver(i)"
                     @mouseout.prevent.stop="menuItemMouseLeave()">
                    <div class="position-absolute w-100 pr-2 z-index-1">
                        <div class="menu-item-bg rounded p-1 pl-2 d-flex" :class="[parentType === menuItem.parentType ? 'menu-item-active' : '']">
                            <div class="menu-title mr-auto">
                                <img class="my-auto" :src="menuItem.icon" width="24" height="24">
                                <span class="ml-2 menu-item my-auto">
                                {{ menuItem.name }}
                            </span>
                            </div>
                            <img class="menu-item-arrow m-2 my-auto" :src="currentItemId === i ? menuArrowUp : menuArrowDown" width="12" height="12">
                        </div>
                    </div>
                    <div
                        class="position-absolute w-100 p-0 pr-2 pt-5 z-index-1 menu-list"
                        :class="{'d-none': currentItemId !== i}"
                    >
                        <div class="main-menu-font text-left menu-item-bg menu-border d-flex pl-2" v-for="child in menuItem.children">
                            <img class="m-2 my-auto" :src="child.icon" width="18" height="18">
                            <div class="p-2 pl-1 menu-item-bottom-border ">
                                <a
                                    :class="[
                                        child.component ? 'cursor-pointer text-white' : 'text-not-link'
                                    ]"
                                    v-html="child.name"
                                    @click="menuClick(child.component)"
                                ></a>
                            </div>
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
    props: {
        parentType: String,
    },
    data: function () {
        return {
            menu: mainMenu,
            menuArrowUp: '/img/GTM/icon_menu_arrow_up.svg',
            menuArrowDown: '/img/GTM/icon_menu_arrow_down.svg',
            currentItemId: -1
        };
    },
    methods: {
        menuClick (childComponent) {
            this.$emit('menuClick', childComponent);
            this.menuItemMouseLeave();
        },
        menuItemMouseOver (id) {
            this.currentItemId = id;
            this.$emit('closeTree');
            this.$store.commit('changeTheDisplayShadowBlock', true);
        },
        menuItemMouseLeave () {
            this.currentItemId = -1;
            this.$store.commit('changeTheDisplayShadowBlock', false);
        },
    },
}
</script>