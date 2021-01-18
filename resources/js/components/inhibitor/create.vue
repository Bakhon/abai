<template>
    <div class="col-xs-12 col-sm-12 col-md-12 row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>{{ trans('monitoring.inhibitor.fields.title') }}</label>
            <div class="form-label-group">
                <input v-model="formFields.name" type="text" name="name" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>{{ trans('monitoring.inhibitor.fields.price') }}</label>
            <div class="form-label-group">
                <input
                    v-model="formFields.price"
                    type="number"
                    step="0.01"
                    :min="validationParams.price.min"
                    :max="validationParams.price.max"
                    name="price"
                    class="form-control"
                >
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>{{ trans('monitoring.inhibitor.fields.density') }}</label>
            <div class="form-label-group">
                <input
                    v-model="formFields.price"
                    type="number"
                    step="0.01"
                    :min="validationParams.price.min"
                    :max="validationParams.price.max"
                    name="price"
                    class="form-control"
                >
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" :disabled="!valid" class="btn btn-success">{{ trans('app.save') }}</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "inhibitor-create",
    props: [
        'validationParams'
    ],
    data: function () {
        return {
            formFields: {
                name: null,
                price: null,
            },
            requiredFields: [
                'name',
                'price',
            ]
        }
    },
    computed: {
        valid() {
            let valid = true
            this.requiredFields.forEach(field => {
                if(!this.formFields[field]) {
                    valid = false
                }
            })
            return valid
        }
    },
};
</script>
<style scoped>
.form-label-group {
    padding-bottom: 30px;
}
</style>
