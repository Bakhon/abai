<template>
    <div class="left__menu">
        <div v-for="page in pages">
            <div class="page" v-if="!page.accordion" @click="changePageComponent(page)">
                <img :src="page.img" alt="">
                <div class="name">{{trans(page.name)}}</div>
            </div>
            <accordion class="accordion"
                       v-else :content="page"
                       @changePage="changePageComponent"
            />
        </div>
    </div>
</template>

<script>
    import Accordion from './Accordion'

    export default {
        name: "leftMenu",
        components: {Accordion},
        props: ['pages'],
        methods:{
            changePageComponent(page){
                this.$emit('changePageComponent', page)
            }
        },
    }
</script>

<style scoped>

</style>