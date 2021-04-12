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

export default {
    data: function () {
        this.$store.commit('changeIsShadowBlockShow',false);
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
            this.menuType = 'small';},
        closeTree () {
            this.$store.commit('changeIsShadowBlockShow',false);
            this.$store.commit('changeTreeSettingComponent',null);
            this.$store.commit('changeTreeChildrenComponent',null);
        },
    },
    computed: {
        isShadowBlockShow() {
            return this.$store.state.isShadowBlockShow;
        },
    },
    mounted () {
        this.$store.commit('globalloading/SET_LOADING', false);
    }
}
</script>