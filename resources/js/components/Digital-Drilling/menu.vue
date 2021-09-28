<template>
    <div class="controlBlock">

        <div class="block">
            <div class="dropdown active">
                <button type="button" class="btn btn-primary main-btn"
                        :class="{active: !homeOpen}"
                        @click="openHome"
                >
                    <i><img src="/img/digital-drilling/left-arrow.svg" alt=""></i>
                    <img src="/img/digital-drilling/menu8.svg" alt="">{{ trans('digital_drilling.database') }}
                </button>
            </div>
        </div>
        <div class="block">
            <div class="dropdown">
                <button type="button" class="dropdown-toggle project-btn" data-toggle="dropdown">
                    <div class="btn-name">
                        <img src="/img/digital-drilling/menu8.svg" alt="">{{ trans('digital_drilling.designing') }}
                    </div>
                    <div class="settings">
                        <img src="/img/digital-drilling/settings.png" alt="" class="">
                    </div>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item"  @click="createNewWell">Создать новую скважину</a>
                    <a class="dropdown-item" @click="openNewWell">Открыть недавно созданнуюскважину</a>
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
        data(){
            return{
                pages: pages,
                homeOpen: true,

            }
        },
        methods:{
            changePage(page){
                this.$emit('changePage', page)
            },
            openHome(){
                this.homeOpen = !this.homeOpen
                this.$emit('changePage', 'home')
            },
            createNewWell(){
                this.$emit('createNewWel')
            },
            openNewWell(){
                this.$emit('openNewWell')
            },
        },
    }
</script>

<style scoped>

</style>