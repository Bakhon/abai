<template>
  <div>
    <!-- Button trigger modal -->
    <button
        type="button"
        data-toggle="modal"
        data-target="#excludeUwis"
        class="btn text-white bg-dark-blue">
      <i class="fas fa-cogs cursor-pointer"></i>
    </button>

    <!-- Modal -->
    <div class="modal fade"
         id="excludeUwis"
         tabindex="-1"
         role="dialog"
         aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            ...
          </div>

          <div class="modal-footer">
            <button type="button"
                    data-dismiss="modal"
                    class="btn btn-secondary">
              Close
            </button>
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