<template>
    <div class="col m-0 p-0">
        <div>
            <div class="row m-0 text-left">
                <div class="col-4 p-1" v-for="menuItem in menu"
                     :class="menuItem.parentType"
                     @mouseover.prevent.stop="menuItemMouseOver(menuItem.parentType)"
                     @mouseout.prevent.stop="menuItemMouseLeave">
                    <div class="position-absolute w-100 pr-2 z-index-1">
                        <div class="menu-item-bg rounded p-1 pl-2 " :class="[parentType === menuItem.parentType ? 'menu-item-active' : '']">
                            <img :src="menuItem.icon" width="24" height="24">
                            <span class="ml-2 menu-item">
                                {{ menuItem.name }}
                            </span>
                        </div>
                    </div>
                    <div class="position-absolute w-100 p-0 pr-2 pt-5 z-index-1 menu-list d-none">
                        <div class="main-menu-font text-left menu-item-bg menu-border rounded">
                            <div class="p-2 pl-3 menu-item-bottom-border" v-for="child in menuItem.children">
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
        };
    },
    methods: {
        menuClick (childComponent) {
            this.$emit('menuClick', childComponent);
            this.menuItemMouseLeave();
        },
        menuItemMouseOver (type) {
            let menuList = this.$el.querySelector('.' + type + ' .menu-list')
            $(menuList).removeClass('d-none');
            this.$emit('closeTree');
            this.$store.commit('changeIsShadowBlockShow', true);
        },
        menuItemMouseLeave () {
            let allMenuLists = $('.menu-list');
            allMenuLists.addClass('d-none');
            this.$store.commit('changeIsShadowBlockShow', false);
        },
    },
}
</script>