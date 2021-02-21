<template>
    <div>
        <div class="col no-margin">
            <div class="gtm-dark row text-center gtm-menu">
                <div
                    v-bind:class="[{active: visibleBlock === 0}, 'col-4']"
                    @click="visibleBlock = 0">
                    АЭГТМ
                </div>
                <div
                    v-bind:class="[{active: visibleBlock === 1}, 'col-4']"
                    @click="visibleBlock = 1">
                    Подбор ГТМ
                </div>
                <div
                    v-bind:class="[{active: visibleBlock === 2}, 'col-4']"
                    @click="visibleBlock = 2">
                    Экономическая+технологическая успешность
                </div>
            </div>
        </div>
        <gtm-aegtm v-if="visibleBlock === 0"></gtm-aegtm>
        <gtm-podbor-gtm v-if="visibleBlock === 1"></gtm-podbor-gtm>
        <gtm-etu v-if="visibleBlock === 2"></gtm-etu>
    </div>
</template>
<script>
export default {
    data: function () {
        return {
            visibleBlock: 1,
        };
    }
}
</script>