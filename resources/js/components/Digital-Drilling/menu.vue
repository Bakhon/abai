<template>
    <div class="controlBlock d-flex">

        <div class="block">
            <div class="dropdown">
                <button type="button" class="btn main-btn"
                        :class="{active: module=='home', open: !homeOpen}"
                        @click="openHome"
                >
                    <i><img src="/img/digital-drilling/left-arrow.svg" alt=""></i>
                    <img src="/img/digital-drilling/menu8.svg" alt="">{{ trans('digital_drilling.database') }}
                </button>
            </div>
        </div>
        <div class="block">
            <div class="dropdown">
                <button type="button" class="dropdown-toggle project-btn" data-toggle="dropdown"
                        :class="{active: module=='project'}"
                >
                    <div class="btn-name">
                        <img src="/img/digital-drilling/menu8.svg" alt="">{{ trans('digital_drilling.designing') }}
                    </div>
                    <div class="settings">
                        <img src="/img/digital-drilling/settings.png" alt="" class="">
                    </div>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item"  @click="createNewWell">Создать новую скважину</a>
                    <a class="dropdown-item" @click="openNewWell">Открыть недавно созданную скважину</a>
                </div>
            </div>
        </div>
        <div class="block">
            <div class="dropdown">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <img src="/img/digital-drilling/menu9.svg" alt="">{{ trans('digital_drilling.drilling_online') }} <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" v-for="page in pages.online" @click="changePage(page)"><img :src="page.img" alt="">{{ trans(page.name) }}</a>
                </div>
            </div>
        </div>
        <div class="block">
            <div class="dropdown">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <img src="/img/digital-drilling/menu10.svg" alt="">{{ trans('digital_drilling.supervising_menu') }} <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" v-for="page in pages.supervising" @click="changePage(page)"><img :src="page.img" alt="">{{ trans(page.name) }}</a>
                </div>
            </div>
        </div>
        <div class="block">
            <div class="dropdown">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <img src="/img/digital-drilling/menu11.svg" alt="">{{ trans('digital_drilling.analytics_menu') }} <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" v-for="page in pages.analytics" @click="changePage(page)"><img :src="page.img" alt="">{{ trans(page.name) }}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import pages from './pages'

    export default {
        name: "menuHead",
        props: ['homeOpen'],
        data(){
            return{
                pages: pages,
                module: 'home'
            }
        },
        methods:{
            changePage(page){
                this.$emit('changePage', page)
            },
            openHome(){
                this.$emit('changePage', 'home')
                this.module = "home"
            },
            createNewWell(){
                this.$emit('createNewWel')
            },
            openNewWell(){
                // this.$emit('openNewWell')
                this.$emit('changePage', 'project')
                this.module = "project"
            },
        },
    }
</script>

<style scoped>

</style>