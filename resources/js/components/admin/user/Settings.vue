<template>
  <div class="x_panel">
    <h1>Настройка прав пользователя {{ user.username }}</h1>
    <a class="btn btn-primary float-left" href="/admin/users">
      <i class="fas fa-arrow-left"></i>
    </a>
    <form :action="user.urls.update" method="POST">
      <div class="row col-4">
        <div class="col-sm-12 mb-4">
          <h3>Компания</h3>
          <treeselect
              v-model="form.orgs"
              :auto-load-root-options="false"
              :loading="true"
              :multiple="true"
              :options="orgs"
              :placeholer="`${trans('app.select')}...`"
          />
        </div>
        <div class="col-sm-6">
          <h3>Список ролей</h3>
          <div v-for="role in roles" class="form-check">
            <input
                :id="`role_${role.id}`"
                v-model="form.roles"
                :checked="user.roles.includes(role.id)"
                :value="role.id"
                class="form-check-input"
                name="roles[]"
                type="checkbox"
            >
            <label :for="`role_${role.id}`" class="form-check-label">{{ role.fields.name }}</label>
          </div>
        </div>
        <div class="col-sm-6">
          <h3>Список Модулей</h3>
          <div v-for="module in modules" class="form-check">
            <input
                :id="`module_${module.id}`"
                v-model="form.modules"
                :checked="user.modules.includes(module.id)"
                :value="module.id"
                class="form-check-input"
                name="modules[]"
                type="checkbox"
            >
            <label :for="`module_${module.id}`" class="form-check-label">{{ module.name }}</label>
          </div>
        </div>
        <div class="col-sm-12 mt-4">
          <button class="btn btn-success" @click.prevent="submit">Сохранить</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import Treeselect from '@riophae/vue-treeselect'

export default {
  data() {
    return {
      orgs: [],
      roles: [],
      modules: [],
      form: {
        orgs: [],
        roles: [],
        modules: []
      }
    }
  },
  components: {
    Treeselect
  },
  props: {
    user: {
      required: true,
      type: Object,
    },
  },
  mounted() {
    this.getOrgs()
    this.getRoles()
    this.getModules()

    this.form = {
      orgs: this.user.orgs,
      roles: this.user.roles,
      modules: this.user.modules
    }

  },
  methods: {
    getOrgs() {
      this.axios.get('/admin/api/orgs').then(({data}) => {
        this.orgs = data.orgs
      })
    },
    getRoles() {
      this.axios.get('/admin/api/roles').then(({data}) => {
        this.roles = data.roles
      })
    },
    getModules() {
      this.axios.get('/admin/api/modules').then(({data}) => {
        this.modules = data.modules
      })
    },
    submit() {
      this.axios.patch(`/admin/api/users/${this.user.id}`, this.form).then(response => {
        console.log(response)
      })
    }
  }
}
</script>
<style lang="scss">
.x_panel {
  .vue-treeselect {
    &__control {
      background: #334296;
      border: none;
      height: 28px;
    }

    &__input {
      color: #fff;
    }

    &__menu {
      background: #40467E;
      border: none !important;

      &::-webkit-scrollbar {
        width: 4px;
      }

      &::-webkit-scrollbar-track {
        background: #40467E;
      }

      &::-webkit-scrollbar-thumb {
        background: #656A8A;
      }

      &::-webkit-scrollbar-thumb:hover {
        background: #656A8A;
      }

      &::-webkit-scrollbar-corner {
        background: #20274F;
      }
    }

    &__option {
      height: 16px;

      &--highlight, &--selected {
        background: #5897fb !important;
      }
    }

    &__single-value {
      color: #fff;
    }
  }
}
</style>