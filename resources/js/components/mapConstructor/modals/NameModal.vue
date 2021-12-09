<template>
    <div class="p-4 d-flex flex-column align-items-center h-100" style="background-color: #333975">
        <div class="input-group mb-3 my-auto">
            <div class="input-group-prepend">
                <span class="input-group-text" style="background-color: rgb(0, 121, 255); color: white;">Название:</span>
            </div>
            <input type="text" class="form-control" v-model="name" ref="mameInput"
                    placeholder="Проект 1" aria-label="Проект 1" aria-describedby="basic-addon1">
        </div>
        <div class="my-1">
            <button type="button" class="btn btn-primary" @click="save(name)" data-dismiss="modal">
                {{ trans('map_constructor.save') }}
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="$emit('close')">
                {{ trans('map_constructor.cancel') }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        oldName: '',
        index: 0,
        save: Function,
    },
    data() {
        return {
            name: '',
        }
    },
    mounted() {
        this.name = this.oldName;
        this.$refs.mameInput.focus();
    }
}
</script>