<template>
  <div>
    <button
        type="button"
        data-toggle="modal"
        data-target="#excludeUwis"
        class="btn text-white bg-dark-blue h-100">
      <i class="fas fa-cogs cursor-pointer"></i>
    </button>

    <div class="modal fade"
         id="excludeUwis"
         tabindex="-1"
         role="dialog"
         aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark-blue">
          <div class="modal-header">
            <h5 class="modal-title pb-0">
              {{ trans('economic_reference.input_exclude_uwis') }}
            </h5>

            <button type="button"
                    class="close"
                    data-dismiss="modal">
              <i class="fas fa-times cursor-pointer"></i>
            </button>
          </div>

          <div class="modal-body">
            <div class="form-group mb-0">
              <textarea
                  v-model="form.exclude_uwis"
                  class="form-control bg-dark-blue text-white"
                  rows="5"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "InputExcludeUwis",
  props: {
    form: {
      required: true,
      type: Object
    }
  }
}
</script>

<style scoped>
.bg-dark-blue {
  background-color: #333975;
}
</style>