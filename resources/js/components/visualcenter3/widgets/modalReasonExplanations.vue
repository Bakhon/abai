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
            <div class="modal-bign modal-bign-container reason-container">
                <div class="modal-bign-header">
                    <div class="modal-bign-title modal_header">{{ trans('visualcenter.reasonExplanations') }}</div>
                    <div class="btn-toolbar">
                        <button type="button" class="modal-bign-button" @click="$modal.hide('modalReasonExplanations')">
                            {{trans('pgno.zakrit')}}
                        </button>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row p-2 reason-header">
                        <span class="col-3">{{ trans("visualcenter.dzo") }}</span>
                        <span class="col-9">{{ trans("visualcenter.importForm.reason") }}</span>
                    </div>
                    <div>
                        <div
                                class="row"
                                v-for="(item, index) in reasons"
                        >
                            <div class="col-12 d-flex p-2 reason-description" v-for="reason in item">
                                <span class="col-3 font-weight-bold">{{index}}</span>
                                <span class="col-9">{{reason}}</span>
                            </div>
                        </div>
                    </div>
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
.reason-container {
    overflow-y: auto;
}
.reason-header {
    background: #2E50E9;
    span:first-child {
        border-right: 1px solid #272953;
    }
}
.reason-description {
    border-bottom: 1px solid #4C537E;
}
</style>