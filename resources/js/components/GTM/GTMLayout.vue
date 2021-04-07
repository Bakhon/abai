<template>
    <div>
        <gtm-main-menu
            :parentType="this.parentType"
            @menuClick="menuClick"
            @closeTree="closeTree"
        ></gtm-main-menu>
        <div
            class="main-content-block"
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
            mainContent: {
                name: "main-component",
                template: "<div><gtm-main-page></gtm-main-page></div>",
                parentType: "aegtm-main"
            },
            parentType: ''
        };
    },
    methods: {
        menuClick (data) {
            this.mainContent = data;
            this.parentType = data.parentType;
        },
        closeTree () {
            this.$store.commit('changeIsShadowBlockShow',false);
            this.$store.commit('changeIsTreeMainComponentShow',false);
            this.$store.commit('changeTreeSettingComponent',null);
            this.$store.commit('changeTreeChildrenComponent',null);
        },
    },
    computed: {
        isShadowBlockShow() {
            return this.$store.state.isShadowBlockShow;
        },
    },
}
</script>