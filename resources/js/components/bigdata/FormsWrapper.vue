<template>
  <div class="db-container">
    <div
        :class="{'hide': !isSidebarOpen}"
        class="asside-db"
    >
      <div class="asside-db-tab-top">
        <div
            :class="{'active': selector === 'form'}"
            class="asside-db-tab_item"
            @click="selector = 'form'"
        >
          {{ trans('bd.input_form') }}
        </div>
        <div
            :class="{'active': selector === 'org'}"
            class="asside-db-tab_item"
            @click="selector = 'org'"
        >
          {{ trans('bd.org_structure') }}
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
              v-if="selectedForm"
              :key="`org_selector_${selectedForm.code}`"
              :currentWellId="orgTech.id"
              :query="searchOrgQuery"
              :structure-types="selectedForm.structure_types"
              @idChange="idChange">
          </bigdata-org-select-tree>
          <div v-else class="asside-db-tab-content-msg">
            <span>Выберите форму</span>
          </div>
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
              :key="tab.key"
              :class="{'active': selectedTab.orgTech === tab.orgTech && selectedTab.form.code === tab.form.code}"
              class="content-db__tab_head__item"
              @click="selectedTab = tab"
              :title="tab.orgTech.fullName"
          >
            {{ tab.orgTech.name }}
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
    </div>

  </div>
</template>

<script>

export default {
  data() {
    return {
      isSidebarOpen: true,
      tabs: [],
      selector: 'form',
      orgTech: {
        id: null,
        name: null,
        type: null
      },
      selectedForm: null,
      selectedTab: null,
      searchOrgQuery: '',
      searchFormQuery: '',
    }
  },
  computed: {
    tabGroups() {
      let result = {}
      this.tabs.forEach(tab => {
        if (!result[tab.form.code]) {
          result[tab.form.code] = {
            name: tab.form.name,
            items: []
          }
        }
        result[tab.form.code].items.push(tab)
      })
      return result
    }
  },
  mounted() {

  },
  methods: {
    idChange(node) {
      if (this.selectedForm) {
        let tab = {
          orgTech: node,
          form: this.selectedForm,
          key: `tab_${node.type}_${node.id}_${this.selectedForm.code}`
        }
        if (!this.tabs.find(tabItem => tabItem.key === tab.key)) {
          this.tabs.push(tab)
        }
        this.selectedTab = Object.assign({}, tab)
      } else {
        this.$notifyWarning('Выберите форму')
      }
    },
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen
    },
    onFormSelected(selectedForm) {
      this.selectedForm = selectedForm
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