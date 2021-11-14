<template>
    <div class="dropdown" :class="{active: isOpen}">
        <div class="dropdown__header">
            <button class="dropdown-header-button" ref="menu" @click="openClose($event)">
            </button>
            <div class="dropdown__header-title">
                <div class="dropdown__search" v-if="search">
                    <input type="text" v-model="query" v-on:input="changeSearch" placeholder="Введите текст |">
                </div>
                <span v-if="options.length>0 && !search && currentItem==null">
                    {{options[0].name}}
                </span>
                <span v-if="options.length>0 && !search && currentItem!=null">
                    {{currentItem}}
                </span>
            </div>
            <div class="dropdown__header-icon">
                <img src="/img/digital-drilling/dropdown-toggle-icon.svg" alt="">
            </div>
        </div>
        <div class="dropdown__body" ref="body" v-if="isOpen" >
            <div class="dropdown__content">
                <ul v-if="options.length>0">
                    <li v-for="item in options" @click="changeCurrentItem(item)">{{item.name}}</li>
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
        props: ['title', 'options', 'search'],
        data(){
            return{
                isOpen: false,
                currentItem: null,
                query: '',
                isOpen: false,
            }
        },
        methods:{
            changeCurrentItem(item){
                this.isOpen = false
                this.query = item.name
                this.currentItem = item.name
                this.$emit('updateList', item)
            },
            changeSearch(){
                this.$emit('search', this.query)
            },
            openClose(e) {
                var _this = this
                const closeListerner = (e) => {
                    if ( _this.catchOutsideClick(e, _this.$refs.menu, _this.$refs.body ) ){
                        window.removeEventListener('click', closeListerner) , _this.isOpen = false
                    }
                }
                window.addEventListener('click', closeListerner)
                this.isOpen = !this.isOpen
            },
            catchOutsideClick(event, dropdown, body)	{
                if( dropdown == event.target ){
                    return false
                }

                if( this.isOpen && dropdown != event.target){
                    return true
                }
            },
        },
    }
</script>

<style scoped>
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
        width: 235px;
        min-width: 200px;
        height: 23px;
        padding: 0 15px 0 10px;
        cursor: pointer;
        position: relative;
    }
    .dropdown-header-button{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
        background-color: transparent;
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
        background-color: transparent;
        border: 0;
    }
    .dropdown__search input:focus{
        outline: none;
    }
</style>