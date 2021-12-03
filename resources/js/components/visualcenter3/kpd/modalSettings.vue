<template>
    <div>
        <modal
                class="modal-bign-wrapper"
                name="modalSettings"
                draggable=".modal-bign-header"
                :width="1500"
                :height="800"
                style="background: transparent;"
                :adaptive="true"
        >
            <div class="modal-bign modal-bign-container">
                <div class="modal-bign-header">
                    <div class="modal-bign-title modal_header">Настройки</div>
                    <div class="btn-toolbar">
                        <button type="button" class="modal-bign-button" @click="$modal.hide('modalSettings')">
                            {{trans('pgno.zakrit')}}
                        </button>
                    </div>
                </div>
                <div class="row text-left">
                    <div class="col-12 row p-2 pl-5">
                        <div class="col-3">Раздел "Генеральный директор"</div>
                        <button type="button" class="modal-button_add col-2" @click="$modal.show('modalCorporateManager')">
                            Управление
                        </button>
                    </div>
                    <div class="col-12 row p-2 pl-5">
                        <div class="col-3">Раздел "Члены Правления"</div>
                        <button type="button" class="modal-button_add col-2" @click="$modal.show('modalManagers')">
                            Управление
                        </button>
                    </div>
                </div>
            </div>
        </modal>

    </div>
</template>

<script>
export default {
    data: function () {
        return {

        };
    },
}


</script>
<style scoped lang="scss">
.modal_header {
    margin: 0 auto;
}
.modal-button_add {
    border: none;
    background: #2d995b;
    color: white;
    border-radius: 8px;
}
.button__disabled {
    pointer-events: none;
    opacity: 0.4;
}
</style>