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

import {paegtmMapActions} from '@store/helpers';

export default {
    data: function () {
        this.changeDisplayShadowBlock(false);
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
        ...paegtmMapActions([
            'changeDisplayShadowBlock',
            'changeDisplayMainComponent',
            'changeTreeSettingComponent',
            'changeTreeChildrenComponent',
            'changeDateStart',
            'changeDateEnd',
        ]),
        menuClick (data) {
            this.mainContent = data;
            this.parentType = data.parentType;
        },
        closeTree () {
            this.changeDisplayShadowBlock(false);
            this.changeTreeSettingComponent(null);
            this.changeTreeChildrenComponent(null);
            this.changeDisplayMainComponent(false);
        },
    },
    computed: {
        isShadowBlockShow() {
            return this.$store.state.isShadowBlockShow;
        },
    },
}
</script>