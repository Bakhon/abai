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
    </div>
</template>
<script>
export default {
    data: function () {
        return {
            mainContent: null,
            menuType: 'big',
            parentType: ''
        };
    },
    methods: {
        menuClick (data) {
            this.mainContent = data
            this.parentType = data.parentType
            this.menuType = 'small'
        }
    },
}
</script>