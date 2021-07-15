<template>
  <li>
    <p @click.stop="isDirOpened = !isDirOpened">
      <img
          src="/img/bd/arrow.svg"
          :class="{'arrow-right': !isDirOpened}"
      >
      <span class="dir" v-html="data.name"></span>
    </p>
    <div v-if="data.children || data.forms" class="directory">
      <div class="custom-directory">
        <ul id="myUL" v-if="isDirOpened">
          <well-cart-tree
              v-for="(child, index) in data.children"
              :data="child"
              :key="`dir_${index}`"
              :activeFormCode="activeFormCode"
              :switch-form-by-code="switchFormByCode">
          </well-cart-tree>
          <li
              v-for="(form, index) in data.forms"
              :key="`form_${index}`"
              :class="{'selected': activeFormCode === form.code}"
          >
            <p @click.stop="switchFormByCode(form)">
              <span class="file cursor-pointer" v-html="form.name"></span>
            </p>
          </li>
        </ul>
      </div>
    </div>
  </li>
</template>

<script>
export default {
  name: "well-cart-tree",
  props: {
    data: Object,
    activeFormCode: String,
    switchFormByCode: Function
  },
  data() {
    return {
      isDirOpened: true,
    }
  },
}
</script>

<style scoped lang="scss">
.custom-directory {
  img {
    padding-bottom: 5px;
  }

  ul, li {
    color: white;
    list-style: none;
    margin: 0;
    padding: 0;
  }

  ul .nested {
    border-top: 1px dashed #555BA6;
    border-left: 0;
  }

  ul {
    padding-left: 1em;
    border: 0;
  }

  li {
    border: 1px dashed #555BA6;
    padding-left: 1em;
    border-width: 0 0 1px 1px;

  &.selected {
     font-weight: bold;
   }
  }

  li p {
    margin: 0;
    background: #272953;
    position: relative;
    bottom: 0.6em;
  }

  li ul {
    margin-left: -1em;
    padding-left: 2em;
  }

  ul li:last-child ul {
    border-bottom: 0;
    margin-left: -17px;
  }

  li:last-child {
    border-bottom: 0
  }

  ul, #myUL {
    list-style-type: none;
  }

  .caret {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    margin-right: auto;
  }

  .file {
    padding-left: 0;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    margin-right: auto;
  }

  .caret::before {
    content: URL(/img/bd/folder.svg);
    color: white;
    display: inline-block;
    padding-right: 10px;
  }

  .caret-down::before {
    color: white;
    background: white;
  }

  .nested {
    display: block;
  }

  .active {
    display: block;
  }
}

.arrow {
  position: absolute;
  left: 5.26%;
  right: 92.56%;
  top: 0.73%;
  bottom: 98.93%;

  background: #FFFFFF;
  transform: matrix(1, 0, 0, -1, 0, 0);
}

.file::before {
  content: URL(/img/bd/file.svg);
  color: white;
  display: inline-block;
  padding-right: 10px;
}

.dir::before {
  content: URL(/img/bd/dir.svg);
  color: white;
  display: inline-block;
  padding-right: 10px;
}

.arrow-right {
  transform: rotate(-90deg);
}
</style>