<template>
  <div>
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container dark-bg">
          <div class="d-flex justify-content-end">
            <div class="modal-default-button text-white cursor-pointer p-1 px-2" @click="$emit('close')">
              X
            </div>
          </div>
          <div class="modal-body">
            <div class="col-12 text-center">
              <h4>Выберите скважину:</h4>
              <ul class="wells-selector-ul">
                  <li v-for="item in wellsSelectorData"
                      id="${item.uwi.id}"
                      @click="$emit('wellIdChange', item.uwi.id)"
                      class="cursor-pointer">
                    {{ item.uwi.name }}
                  </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    wellsSelectorData: Array
  },
}

</script>

<style>
.wells-selector-ul {
  list-style: none;
  color: #fff;
}

.modal-container {
  width: 30vw;
  padding: 1rem;
}

.dark-bg {
  background-color: #272953 !important;
}
</style>