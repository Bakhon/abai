<template>
  <li>
    <div class="direcotory_parent" @click.stop="isDirOpened = !isDirOpened">
      <img
          src="/img/bd/arrow_bottom_directory.svg"
          :class="{'arrow-right': !isDirOpened}"
      >
      <span class="dir" v-html="data.name"></span>
    </div>
    <div v-if="data.children || data.forms" class="directory">
      <div class="custom-directory">
        <ul id="myUL" v-if="isDirOpened">
          <well-card-tree
              v-for="(child, index) in data.children"
              :data="child"
              :key="`dir_${index}`"
              :activeFormCode="activeFormCode"
              :switch-form-by-code="switchFormByCode">
          </well-card-tree>
          <li
              v-for="(form, index) in data.forms"
              :key="`form_${index}`"
              :class="{'selected': activeFormCode === form.code}"
          >
            <p @click.stop="switchFormByCode(form)">
              <span class=" cursor-pointer" v-html="form.name"></span>
            </p>
          </li>
        </ul>
      </div>
    </div>
  </li>
</template>

<script>
export default {
  name: "well-card-tree",
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
.direcotory_parent {
    position: relative;
    font-weight: bold;
    font-size: 14px;
    line-height: 1.3;
    color: #FFFFFF;
    margin-left: 5px;
    margin-bottom: 7px;
    img {
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
    }
}
.custom-directory li p br {
    display: none;
}
.custom-directory {
  #myUL > li {
    margin-bottom: 3px;
  }
  
  ul, li {
    color: white;
    list-style: none;
    margin: 0;
    padding: 0;
  }


  li {
    &.selected {
      font-size: 105%;
      font-weight: bold;
    }
  }

  li p {
    margin: 0;
    position: relative;
    background: #B5D9ED;
    padding: 7px 14px;
    font-size: 14px;
    color: #000;
    font-weight: bold;
    &:after{
        content: '';
        width: 4px;
        height: 4px;
        background: #000;
        position: absolute;
        left: 6px;
        top: 50%;
        transform: translateY(-50%);
        border-radius: 50%;
    }
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

.direcotory_parent img.arrow-right {
  transform: rotate(-90deg);
}
</style>