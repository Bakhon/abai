<template>
  <div class="db-container">
    <div
        :class="{'hide': !isSidebarOpen}"
        class="asside-db"
    >
      <div class="asside-db-tab-top">
        <div
            :class="{'active': selector === 'org'}"
            class="asside-db-tab_item"
            @click="selector = 'org'"
        >
          {{ trans('bd.org_structure') }}
        </div>
        <div
            :class="{'active': selector === 'form'}"
            class="asside-db-tab_item"
            @click="selector = 'form'"
        >
          {{ trans('bd.input_form') }}
        </div>
      </div>
      <form action="" class="search-bd">
        <button class="search-btn-bd">
          <svg fill="none" height="11" viewBox="0 0 11 11" width="11" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd"
                  d="M4.34556 0C5.5525 0 6.57894 0.422504 7.42353 1.26751C8.26857 2.11206 8.69107 3.13846 8.69107 4.34536C8.69107 5.19036 8.46488 5.95982 8.0125 6.65419L11 9.64157L9.6415 11L6.654 8.01217C5.92975 8.46453 5.16029 8.69116 4.34556 8.69116C3.13816 8.69116 2.11262 8.26866 1.26758 7.42365C0.42209 6.57865 0 5.5527 0 4.34536C0 3.13846 0.42209 2.11206 1.26758 1.26751C2.11262 0.422504 3.13816 0 4.34556 0ZM4.34556 1.9465C3.68147 1.9465 3.11553 2.18037 2.64777 2.64811C2.18002 3.11585 1.94615 3.68175 1.94615 4.34536C1.94615 5.00942 2.18002 5.57486 2.64777 6.0426C3.11553 6.51079 3.68147 6.74466 4.34556 6.74466C5.00919 6.74466 5.57509 6.51079 6.04285 6.0426C6.51106 5.57486 6.74448 5.00942 6.74448 4.34536C6.74448 3.68175 6.51106 3.11585 6.04285 2.64811C5.57509 2.18037 5.00919 1.9465 4.34556 1.9465Z"
                  fill="#9EA4C9"
                  fill-rule="evenodd"/>
          </svg>
        </button>
        <input v-show="selector === 'org'" v-model="searchOrgQuery" class="search-input-bd" placeholder="Поиск"
               type="text">
        <input v-show="selector === 'form'" v-model="searchFormQuery" class="search-input-bd" placeholder="Поиск"
               type="text">
      </form>
      <div class="asside-db-tab-content">
        <div v-show="selector === 'org'" class="asside-db-tab-content__item asside-db-tab-content__item--org">
          <bigdata-org-select-tree
              :currentWellId="orgTech.id"
              :query="searchOrgQuery"
              @idChange="idChange">
          </bigdata-org-select-tree>
        </div>

        <div v-show="selector === 'form'" class="asside-db-tab-content__item asside-db-tab-content__item--form">
          <div class="asside-db-form">
            <bigdata-form-selector
                :query="searchFormQuery"
                @selected="onFormSelected"
            >
            </bigdata-form-selector>
          </div>
        </div>
      </div>
      <div class="arrow-hide" @click="toggleSidebar">
        <svg fill="none" height="13" viewBox="0 0 7 13" width="7" xmlns="http://www.w3.org/2000/svg">
          <path d="M6 12L1.03149 6.58081C0.989503 6.53506 0.989503 6.46488 1.03149 6.41881L6 1" stroke="white"
                stroke-linecap="round" stroke-miterlimit="22.9256" stroke-width="2"/>
        </svg>
      </div>
    </div>
    <div class="content-db ">
      <div class="content-db__tab_head">
        <template
            v-for="(group, id) in tabGroups"
        >
          <div
              :title="group.fullName"
              class="tab-head-title"
          >
            {{ group.name }}
          </div>
          <div
              v-for="(tab, index)  in group.items"
              :key="`tab_${id}_${index}`"
              :class="{'active': selectedTab === tab}"
              class="content-db__tab_head__item"
              @click="selectedTab = tab"
          >
            {{ tab.form.name }}
            <span
                class="content-db__tab_head__item__close"
                @click.stop="closeTab(tab)"
            ></span>
          </div>
        </template>
      </div>
      <div class="content-db-container">
        <bigdata-form
            v-for="tab in tabs"
            v-show="isTabSelected(tab)"
            :id="tab.orgTech.id"
            :key="`form_${tab.orgTech.id}_${tab.orgTech.type}_${tab.form.code}`"
            :form="tab.form"
            :type="tab.orgTech.type"
        >
        </bigdata-form>
      </div>
      <div class="content-db-bottom">
        <span class="db_button">Сохранить</span>
        <span class="db_button gray">Отмена</span>
      </div>
      <!-- <div class="org-select-info">
          <div class="org-select-info__icon">
              <img src="/img/bd/org_icon.svg" alt="">
          </div>
          <div class="org-select-info__text  ">
              Выберите оргструктуру
          </div>
      </div> -->
    </div>

  </div>
</template>

<script>

export default {
  data() {
    return {
      isSidebarOpen: true,
      tabs: [],
      selector: 'org',
      orgTech: {
        id: null,
        name: null,
        type: null
      },
      selectedTab: null,
      searchOrgQuery: '',
      searchFormQuery: '',
    }
  },
  computed: {
    tabGroups() {
      let result = {}
      this.tabs.forEach(tab => {
        if (!result[tab.orgTech.id]) {
          result[tab.orgTech.id] = {
            name: tab.orgTech.name,
            fullName: tab.orgTech.fullName,
            items: []
          }
        }
        result[tab.orgTech.id].items.push(tab)
      })
      return result
    }
  },
  mounted() {

  },
  methods: {
    idChange(node) {
      this.orgTech = node
    },
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen
    },
    onFormSelected(selectedForm) {
      if (this.orgTech.id) {
        let tab = {
          orgTech: this.orgTech,
          form: selectedForm
        }
        if (!this.tabs.find(tabItem => tabItem === tab)) {
          this.tabs.push(tab)
        }
        this.selectedTab = Object.assign({}, tab)
      } else {
        this.$notifyWarning('Выберите элемент оргструктуры')
      }
    },
    isTabSelected(tab) {
      return tab.orgTech === this.selectedTab.orgTech && tab.form.code === this.selectedTab.form.code
    },
    closeTab(tab) {
      this.tabs.splice(this.tabs.findIndex(tabItem => tabItem === tab), 1)
    }
  }
}
</script>

<style lang="scss">
.asside-db-form__list {
  list-style: none;
  margin-bottom: 5px;
}

.asside-db-form__title {
  font-weight: bold;
  font-size: 12px;
  line-height: 1.3;
  color: #FFFFFF;
  margin-left: 5px;
  margin-bottom: 7px;
}

.asside-db-form__list {
  list-style: none;
}

.asside-db-form__list li {
  padding: 5px 7px 7px 15px;
  background: #363B68;
  color: #fff;
  margin-bottom: 2px;
  position: relative;
  font-size: 11px;
  line-height: 1.4;
  color: #FFFFFF;
}

.asside-db-form__list li:after {
  content: '';
  width: 4px;
  height: 4px;
  background: #9EA4C9;
  position: absolute;
  left: 6px;
  top: 50%;
  transform: translateY(-50%);
  border-radius: 50%;
}

.asside-db-tab-content__item--form {
  padding: 10px 20px 10px 5px;
}

.arrow-hide {
  position: absolute;
  top: 0;
  right: 0;
  width: 13px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #2B3384;
  border-radius: 5px 0px 0px 5px;
  top: 50%;
  transform: translateY(-50%);
}

.arrow-hide:hover {
  background: #3366FF;
  cursor: pointer;
}

.db-container {
  display: flex;
  height: calc(100vh - 98px);
  justify-content: space-between;
}

.content-db {
  width: calc(100% - 305px);
  background: #181837;
}

.asside-db.hide + .content-db {
  width: calc(100% - 55px);
}

.content-db-container {
  height: calc(100vh - 177px);
  background: #000;
  overflow-y: auto;
}

.content-db-bottom {
  margin-top: 10px;
  text-align: center;
}

.content-db__tab_head {
  background: #272953;
  display: flex;
  font-size: 12px;
  overflow-y: auto;
  white-space: nowrap;
  width: 100%;
}

.content-db__tab_head::-webkit-scrollbar {
  height: 6px;
}

.content-db__tab_head::-webkit-scrollbar-thumb {
  background: #656A8A;
  border-radius: 10px;
  height: 2px !important;
  width: 2px !important;
}

.tab-head-title {
  padding: 6px;
  border: 1px solid #6D76AB;
  font-size: 12px;
  color: #A0A5CC;
  margin-right: 3px;
}

.content-db__tab_head__item {
  padding: 6px 20px 6px 13px;
  background: #363B68;
  color: #fff;
  cursor: pointer;
  position: relative;
  margin-right: 5px;

  &:hover {
    background: #2E50E9;
  }

  &.active {
    background: #2846cc;
  }
}

.content-db__tab_head__item:after {
  content: '';
  width: 4px;
  height: 4px;
  background: #9EA4C9;
  position: absolute;
  left: 3px;
  top: 50%;
  transform: translateY(-50%);
  border-radius: 50%;
}

.content-db__tab_head__item span {
  position: absolute;
  right: 0;
  top: 0;
  bottom: 0;
  background-image: url(/img/bd/close_tab.svg);
  width: 20px;
  background-repeat: no-repeat;
  background-position: center;
}

.org-select-info {
  display: inline-flex;
  height: 100px;
  font-size: 19px;
  line-height: 23px;
  color: #9EA4C9;
  text-align: center;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
}

.org-select-info__icon {
  width: 100%;
}

.empty {
  display: flex;
  align-items: center;
  justify-content: center;
}

.asside-db {
  width: 300px;
  height: 100%;
  position: relative;
}

.asside-db-tab-top {
  margin-bottom: 2px;
  display: flex;
  justify-content: space-between;
}

.asside-db-tab_item {
  background: #181837;
  border: 1px solid #2E325C;
  box-sizing: border-box;
  width: 49%;
  font-weight: 500;
  font-size: 12px;
  line-height: 15px;
  text-align: center;
  padding: 5px 0 6px;
  color: #fff;
}

.asside-db-tab_item.active, .asside-db-tab_item:hover {
  border-color: #3366FF;
  cursor: pointer;
}

.search-bd {
  display: flex;
  background: #121227;
  border: 1px solid #363B68;
  margin-bottom: 2px;
}

.search-btn-bd {
  border: none;
  background: none;
  width: 27px;
  height: 27px;
}

.search-input-bd {
  width: calc(100% - 30px);
  border: none;
  background: #0000;
  border-left: 0.6px solid #363B68;
  padding: 0 6px;
  outline: none;
  color: #fff;
}

.search-input-bd::placeholder {
  color: #fff;
}

.asside-db.hide {
  background: #272953;
  width: 50px;
  overflow: hidden;
}

.asside-db.hide div, .asside-db.hide form {
  display: none;
}

.asside-db.hide .arrow-hide {
  display: flex;
  transform: translateY(-50%) rotate(180deg);
}

.content-db.hide {
  width: calc(100% - 60px);
}

.asside-db-tab-content {
  background: #272953;
  overflow-y: auto;
  height: calc(100% - 60px);
}

.asside-db-tab-content::-webkit-scrollbar {
  width: 4px;
  background-color: #143861;
}

.asside-db-tab-content__item--org {
  padding: 10px 7px;
}

.asside-db-list {
  list-style: none;
  margin: 0;
  padding: 0;
}

.asside-db-link-parent {
  font-weight: bold;
  font-size: 11px;
  line-height: 1.4;
  color: #FFFFFF;
  padding-left: 40px;
  position: relative;
  display: block;
  z-index: 1;
}

.asside-db-link-parent:before {
  content: '';
  width: 18px;
  height: 16px;
  background-image: url(/img/bd/folder_icon.svg);
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
}

.asside-db-link-file {
  font-size: 11px;
  line-height: 13px;
  color: #FFFFFF;
  position: relative;
  z-index: 1;
  padding-left: 40px;
  min-height: 18px;
  display: flex;
  align-items: center;

  &.selected {
    font-weight: bold;
    font-size: 13px;
  }
}

.asside-db-link-file:before {
  content: '';
  width: 14px;
  height: 18px;
  background-image: url(/img/bd/file.svg);
  position: absolute;
  left: 20px;
  top: 50%;
  transform: translateY(-50%);
}

.asside-db-list__item.asside-db-list__item-parent {
  position: relative;
  margin-bottom: 7px;
}

.asside-db-list__item .cursor-pointer {
  background: url(/img/bd/arrow-right.svg) center no-repeat;
  background-size: 5px;
  color: #fff;
  display: inline-block;
  left: -2px;
  margin-right: 0;
  position: absolute;
  height: 7px;
  padding: 8px;
  top: 1px;
  z-index: 10;
  width: 7px;
}

.asside-db-list__item.active > .cursor-pointer {
  transform: rotate(90deg);
}

.asside-db-list ul {
  list-style: none;
  padding-left: 20px;
  padding-top: 5px;
}

.asside-db-list__item.asside-db-list__item-parent:after {
  content: "";
  color: #Fff;
  display: inline-block;
  margin-right: 6px;
  position: absolute;
  background-image: url(/img/bd/dots.svg);
  left: 6px;
  width: 11px;
  height: 1px;
  z-index: 333333;
  top: 6.7px;
}


.asside-db-list__item.active > ul {
  display: block;
}
</style>