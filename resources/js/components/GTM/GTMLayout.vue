<template>
    <div>
        <gtm-main-menu
            :parentType="this.parentType"
            :mainMenu="menu"
            @menuClick="menuClick"
            @closeTree="closeTree"
        />
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

import {paegtmMapState, paegtmMapActions} from '@store/helpers';
import mainMenu from './mock-data/main_menu.json'

export default {
    data: function () {
        this.changeDisplayShadowBlock(false);
        return {
            mainContent: {
                name: "main-component",
                template: "<div><gtm-main-page></gtm-main-page></div>",
                parentType: "aegtm-main"
            },
            parentType: '',
            menu: mainMenu,
        };
    },
    computed: {
        ...paegtmMapState([
            'isShadowBlockShow',
        ]),
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
          if (data?.url && this.isExternalLink(data)) {
            window.location.href = this.localeUrl(data.url);
          } else {
            this.mainContent = data.component;
            this.parentType = data.parentType;
          }
        },
        isExternalLink(data) {
          return data?.component?.parentType === 'digitalRating';
        },
        closeTree () {
            this.changeDisplayShadowBlock(false);
            this.changeTreeSettingComponent(null);
            this.changeTreeChildrenComponent(null);
            this.changeDisplayMainComponent(false);
        },
    },
}
</script>
