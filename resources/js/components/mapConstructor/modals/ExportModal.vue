<template>
    <div class="modal fade" id="exportModal" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="mb-4">Тип данных, карта, контур, полигон...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">
                      {{ trans('map_constructor.export') }}
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                      {{ trans('map_constructor.cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
