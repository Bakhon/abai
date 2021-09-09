<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalReasonExplanations"
                draggable=".modal-bign-header"
                :width="600"
                :height="400"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header">
                    <div class="modal-bign-title modal_header">{{ trans('visualcenter.reasonExplanations') }}</div>
                    <div class="btn-toolbar">
                        <button type="button" class="modal-bign-button" @click="$modal.hide('modalReasonExplanations')">
                            {{trans('pgno.zakrit')}}
                        </button>
                    </div>
                </div>
                <div v-for="(item, index) in reasons">
                    <div class="font-weight-bold">{{index}}:</div>
                    <div>{{item.join(',\n')}}</div>
                </div>
            </div>
        </modal>
        <kpd-modal-kpd-edit></kpd-modal-kpd-edit>
    </div>
</template>

<script>
export default {
    data: function () {
        return {

        };
    },
    props: ['reasons'],
}


</script>
<style scoped lang="scss">
.modal_header {
    margin: 0 auto;
}
</style>