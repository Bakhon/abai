<template>
    <div class="dropdown" :class="{active: isOpen}" v-click-outside="outDropdown">
        <div class="dropdown__header" :class="{report: report}">
            <div class="dropdown__header-title">
                <div class="cancel" v-if="cancelFilter && current.name" @click="cancelFilterItem">
                    <img src="/img/digital-drilling/cancel-filter.svg" alt="">
                </div>
                <span @click="isOpen=!isOpen" class="name">
                    <span v-if="!report">{{current.name}}</span><span v-else>{{current.well_num}}</span>
                </span>
            </div>
            <div class="dropdown__header-icon" @click="isOpen=!isOpen">
                <img src="/img/digital-drilling/dropdown-toggle-icon.svg" alt="">
            </div>
        </div>
        <div class="dropdown__body">
            <div class="dropdown__content">
                <div class="dropdown__search" v-if="search">
                    <input type="text" v-model="query" v-on:input="changeSearch" :placeholder="trans('digital_drilling.window_head.enter_text')">
                </div>
                <ul v-if="options.length>0">
                    <li v-for="item in options" @click="changeCurrentItem(item)"><span v-if="!report">{{item.name}}</span><span v-else>{{item.well_num}}</span></li>
                </ul>
                <ul v-else>
                    <li>No result</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "dropdown",
        props: ['title', 'options', 'search', 'current', 'cancelFilter', 'report'],
        data(){
            return{
                isOpen: false,
                currentItem: null,
                query: '',
            }
        },
        methods:{
            outDropdown(){
                if (this.isOpen) {
                    this.isOpen = false
                }
            },
            changeCurrentItem(item){
                this.isOpen = false
                this.query = item.name
                this.currentItem = item.name
                this.$emit('updateList', item)
            },
            changeSearch(){
                this.$emit('search', this.query)
            },
            cancelFilterItem(){
                this.$emit('cancelFilterItem')
            },
        },
    }
</script>

<style scoped>
    .dropdown__search input{
        color: #ffffff;
        padding: 2px 7px;
    }
    .dropdown:not(:focus) .dropdown__body{
        height: 0;
    }
    .dropdown__header{
        background: #1F2142;
        border: 1px solid #454FA1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 15px;
        line-height: 19px;
        color: #FFFFFF;
        width: 100%;
        min-width: 200px;
        height: 23px;
        padding: 0 15px 0 10px;
        cursor: pointer;
    }
    .dropdown__header-title{
        display: flex;
        align-items: center;
        flex-grow: 1;
    }
    .dropdown__header-title .name{
        flex-grow: 1;
    }
    .dropdown__header-title img{
        margin-right: 10px;
        cursor: pointer;
    }
    .dropdown .dropdown__header-icon{
        transition: 0.4s ease;
    }
    .dropdown.active .dropdown__header-icon{
        transform: rotate(-180deg);
    }
    .dropdown.active .dropdown__body{
        height: auto;
    }
    .dropdown__body{
        position: absolute;
        top: 27px;
        left: 0;
        height: 0;
        max-height: 200px;
        width: 100%;
        overflow: auto;
        background-color: #323370;
        transition: 0.4s ease;
        z-index: 2000;
    }
    .dropdown__content ul li {
        padding: 0 10px;
        margin-top: 10px;
        cursor: pointer;
    }
    .dropdown__content ul li:hover{
        background: rgba(51, 102, 255, 0.4);
    }
    .dropdown__body::-webkit-scrollbar-thumb{
        background-color: #000000;
        border: 2px solid #ffffff;
    }
    .dropdown__body::-webkit-scrollbar{
        width:2px;
    }
    .dropdown__search{
        width: 100%;
        height: 20px;
    }
    .dropdown__search input{
        width: 100%;
        height: 100%;
        background: #272953;
        border: 2px solid #070a18!important;
        border-radius: 6px;
        padding: 5px 3px;
    }
    .dropdown__search input:focus{
        outline: none;
    }
    .dropdown__header.report{
        background-color: #334296!important;
        width: 200px!important;
        padding: 0!important;
        height: 100%!important;
    }
</style>