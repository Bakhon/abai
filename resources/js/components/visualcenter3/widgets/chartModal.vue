<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="chartModal"
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
                        <button type="button" class="modal-bign-button" @click="$modal.hide('chartModal')">
                            {{trans('pgno.zakrit')}}
                        </button>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="reason-container row p-2">
                        <div
                                class="row col-12 p-0"
                                v-for="(item, index) in reasons"
                        >
                            <div class="col-12 p-2 text-center reason-header">{{getDzoName(index)}}</div>
                            <hr>
                            <div class="col-12 d-flex reason-description_item p-0">
                                <div class="col-1">№</div>
                                <div class="col-9">{{trans('visualcenter.importForm.reason')}}</div>
                                <div class="col-2 pr-0">{{trans('visualcenter.losses')}} (т)</div>
                            </div>
                            <div class="col-12 row m-0 p-0" v-for="(reason,reasonIndex) in item">
                                <div class="col-12 d-flex reason-description_item p-0">
                                    <div class="col-1">{{reasonIndex+1}}</div>
                                    <div class="col-9">{{reason[0]}}</div>
                                    <div class="col-2 pr-0">{{reason[1]}}</div>
                                </div>
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
    background: #3B406F;
}
.reason-description_item div {
    border-bottom: 1px solid #4C537E;
    border-right: 1px solid #4C537E;
    &:last-child {
        border-right: none;
    }
}
</style>