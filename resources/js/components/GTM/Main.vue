<template>
    <div>
        <gtm-main-menu
            :menuType="this.menuType"
            :parentType="this.parentType"
            @menuClick="menuClick"
        ></gtm-main-menu>
        <div
            v-bind:is="mainContent"
        ></div>
        <div
            class="shadow-block"
            v-if="isShadowBlockShow"
            @click.stop="closeTree"
        ></div>
    </div>
</template>
<script>
import Vuex from 'vuex'

Vue.use(Vuex)
const store = new Vuex.Store({
    state: {
        isShadowBlockShow: false,
        treeChildrenComponent: Object,
        treeSettingComponent: Object,
    },
    mutations: {
        changeIsShadowBlockShow (state, value) {
            this.state.isShadowBlockShow = value;
        },
        changeTreeSettingComponent (state, value) {
            this.state.treeSettingComponent = value;
        },
        changeTreeChildrenComponent (state, value) {
            this.state.treeChildrenComponent = value;
        },
    }
});

export default {
    store,
    data: function () {
        return {
            mainContent: null,
            menuType: 'big',
            parentType: ''
        };
    },
    methods: {
        menuClick (data) {
            this.mainContent = data;
            this.parentType = data.parentType;
            this.menuType = 'small';
        },
        closeTree () {
            this.$store.commit('changeIsShadowBlockShow',false);
            this.$store.commit('changeTreeSettingComponent',null);
            this.$store.commit('changeTreeChildrenComponent',null);
        },
    },
    computed: {
        isShadowBlockShow() {
            return store.state.isShadowBlockShow;
        },
    },
}
</script>