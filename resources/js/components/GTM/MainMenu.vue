<template>
    <div class="col m-0 p-0">
        <div
            :class="[
                menuType === 'big' ? 'paegtm-main' : ''
            ]"
        >
            <div
                class="row m-0 text-left"
            >
                <div class="col-4 p-1" v-for="menuItem in menu">
                    <div
                        class="rounded menu-item-bg"
                        :class="[
                            menuType === 'big' ? 'main-category m-1' : 'mini-category',
                            menuType !== 'big' && parentType === menuItem.parentType ? 'menu-item-active' : '',
                        ]"
                    >
                        <img
                            :src="menuItem.icon"
                            :width="[
                                menuType === 'big' ? '48' : '24'
                            ]"
                            :height="[
                                menuType === 'big' ? '48' : '24'
                            ]"
                        >
                        <span class="ml-2"><a href="/ru/paegtm" class="menu-item">{{ menuItem.name }}</a></span>
                    </div>
                    <div
                        class="p-0 pl-1 pr-1"
                        :class="{'d-none': menuType !== 'big'}"
                    >
                        <div class="main-menu-font text-left dark-bg menu-border" style="height: 65vh;">
                            <div class="p-2 p-lg-3" v-for="child in menuItem.children">
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
        menuType: String,
        parentType: String,
    },
    data: function () {
        return {
            menu: mainMenu
        };
    },
    methods: {
        menuClick (childComponent) {
            this.$emit('menuClick', childComponent);
        }
    },
}
</script>