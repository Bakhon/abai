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
                <div class="container-fluid">
                    <div class="row p-2 reason-header">
                        <span class="col-5">{{ trans("visualcenter.dzo") }}</span>
                        <span class="col-7">{{ trans("visualcenter.importForm.reason") }}</span>
                    </div>
                    <div class="reason-container row p-2">
                        <div
                                class="row col-12 p-0"
                                v-for="(item, index) in reasons"
                        >
                            <div class="col-12 d-flex p-2 reason-description" v-for="reason in item">
                                <span class="col-5 font-weight-bold">{{getDzoName(index)}}</span>
                                <span class="col-7">{{reason}}</span>
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
            dzo: {
                'ОМГ': this.trans("visualcenter.omg"),
                'ЭМГ': this.trans("visualcenter.emg"),
                'КБМ': this.trans("visualcenter.kbm"),
                'КГМ': this.trans("visualcenter.kgm"),
                'ТШ': this.trans("visualcenter.tsho"),
                'ТШО': this.trans("visualcenter.tsho"),
                'ММГ': this.trans("visualcenter.mmg"),
                'КТМ': this.trans("visualcenter.ktm"),
                'КОА': this.trans("visualcenter.koa"),
                'ПКИ': this.trans("visualcenter.pki"),
                'АМГ': this.trans("visualcenter.ag"),
                'АГ': this.trans("visualcenter.ag"),
                'КПО': this.trans("visualcenter.kpo"),
                'НКО': this.trans("visualcenter.nko"),
                'ТП': this.trans("visualcenter.tp"),
                'УО': this.trans("visualcenter.uo"),
                'ПКК': this.trans("visualcenter.pkk"),
                'КГМКМГ': this.trans("visualcenter.kgm"),
                'ПККР': this.trans("visualcenter.pkk"),
            }
        };
    },
    methods: {
        getDzoName(dzoTicker) {
            return this.dzo[dzoTicker];
        },
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
    overflow-x: hidden;
    max-height: 300px;
    &::-webkit-scrollbar {
        width: 3px;
    }

    &::-webkit-scrollbar-track {
        background: #333975;
    }

    &::-webkit-scrollbar-thumb {
        background: #1f213e;
    }

    &::-webkit-scrollbar-thumb:hover {
        background: #1f213e;
    }

    &::-webkit-scrollbar-corner {
        background: #333975;
    }
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