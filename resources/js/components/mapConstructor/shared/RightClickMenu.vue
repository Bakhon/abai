<template>
    <div>
        <ul class="right-click-menu" ref="right" id="right-click-menu" tabindex="-1"
            v-if="viewMenu"
            @blur="closeMenu"
            :style="{ top:top, left:left }">
            <li>{{ trans('map_constructor.add_shape') }}</li>
            <li>{{ trans('map_constructor.text') }}</li>
            <li>{{ trans('map_constructor.copy') }}</li>
            <li>{{ trans('map_constructor.delete') }}</li>
            <li>{{ trans('map_constructor.legend') }}</li>
            <li class="d-flex justify-content-between align-items-center" @click="openRightMap">{{ trans('map_constructor.settings') }} <i
                    class="fas fa-caret-right text-dark"></i></li>
            <div v-if="rightMap">
                <ul class="right-click-menu right-click-menu--dropdown">
                    <li>{{ trans('map_constructor.icon') }}</li>
                    <li>{{ trans('map_constructor.line') }}</li>
                    <li>{{ trans('map_constructor.color') }}</li>
                    <li>{{ trans('map_constructor.palette') }}</li>
                    <li>{{ trans('map_constructor.text') }}</li>
                    <li>{{ trans('map_constructor.size') }}</li>
                </ul>
            </div>

        </ul>
        <ul class="right-click-menu" ref="rightLayers" id="right-click-menu-layers" tabindex="-1"
            v-if="viewMenuLayers"
            @blur="closeMenuLayers"
            :style="{ top:top, left:left }">
            <li>{{ trans('map_constructor.rename') }}</li>
            <li>{{ trans('map_constructor.copy') }}</li>
            <li>{{ trans('map_constructor.delete') }}</li>
            <li>{{ trans('map_constructor.legend') }}</li>
            <li class="d-flex justify-content-between align-items-center" @click="openRightLayers">
              {{ trans('map_constructor.settings') }}
              <i class="fas fa-caret-right text-dark"></i></li>
            <div v-if="rightLayers">
                <ul class="right-click-menu right-click-menu--dropdown">
                    <li>{{ trans('map_constructor.icon') }}</li>
                    <li>{{ trans('map_constructor.line') }}</li>
                    <li>{{ trans('map_constructor.color') }}</li>
                    <li>{{ trans('map_constructor.palette') }}</li>
                    <li>{{ trans('map_constructor.text') }}</li>
                    <li>{{ trans('map_constructor.size') }}</li>
                    <li>{{ trans('map_constructor.map_name') }}</li>
                    <li>{{ trans('map_constructor.outline_labels') }}</li>
                    <li>{{ trans('map_constructor.legend_labels') }}</li>
                </ul>
            </div>
            <li>{{ trans('map_constructor.info') }}</li>
        </ul>
    </div>
</template>
<script>
    export default {
        props: ['viewMenu', 'viewMenuLayers', 'top', 'left', 'rightLayers', 'rightMap'],
        methods: {
            openRightLayers() {
                this.$emit('openRightLayers');
            },
            closeMenuLayers () {
                this.$emit('closeMenuLayers');
            },
            openRightMap() {
                this.$emit('openRightMap');
            },
            closeMenu () {
                this.$emit('closeMenu');
            }
        }
    }
</script>
