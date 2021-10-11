<template>
    <div class="left__menu">
        <div v-for="page in pages">
            <div class="page"
                 v-if="!page.accordion" @click="changePageComponent(page, page.id)"
                 :class="{active: currentPage==page.id}"
            >
                <img :src="page.img" alt="">
                <div class="name">{{trans(page.name)}}</div>
            </div>
            <accordion class="accordion"
                       :content="page"
                       :is-open="getIsOpen(page.id)"
                       @changePage="changePageComponent"
                       v-else
            />
        </div>
    </div>
</template>

<script>
    import Accordion from './Accordion'

    export default {
        name: "leftMenu",
        components: {Accordion},
        data(){
            return{
                currentPage: 0,
            }
        },
        computed:{

        },
        props: ['pages'],
        methods:{
            changePageComponent(page, page_id){
                this.$emit('changePageComponent', page)
                this.currentPage = page_id
            },
            getIsOpen(id){
                if(this.currentPage==id){
                    return true
                }
                return false
            }
        },
    }
</script>

<style scoped>

</style>