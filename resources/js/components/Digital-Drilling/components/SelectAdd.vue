<template>
    <div class="select__add">
        <div class="select__add-dropdown">
            <button class="dropdown-header" ref="menu" @click="openClose($event)">
                {{ selected.name_ru }}
            </button>
            <div class="dropdown-body defaultScroll" ref="body" v-if="isOpen">
                <ul>
                    <li v-for="option in options" @click="selectOption(option)" :class="{active: selected==option}">{{option.name_ru}}</li>
                </ul>
                <div class="add__item" @click="addItem">
                    Добавить
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SelectAdd",
        props: ['options'],
        data(){
            return{
                selected: '',
                isOpen: false,
            }
        },
        methods:{
            selectOption(option){
                this.selected = option
            },
            addItem(){
                this.$emit('addItem')
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
        }
    }
</script>

<style scoped>
    .select__add{
        position: relative;
        min-width: 150px;
        min-height: 20px;
    }
    .select__add-dropdown{
        position: relative;
    }
    .dropdown-header{
        padding: 0 0 0 5px;
        height: 20px;
        width: 100%;
        background: #454D7D;
        border: 0;
        position: relative;
        font-size: 12px;
        text-align: left;
    }
    .dropdown-header::after{
        content: "";
        display: block;
        position: absolute;
        left: calc(100% - 12px);
        top: 5px;
        width: 7px;
        height: 7px;
        border-right: 2px solid #fff;
        border-bottom: 2px solid #fff;
        transform: translateY(-2px) rotate(
                45deg
        );
    }
    .dropdown-body{
        position: absolute;
        top: calc(100% + 10px);
        background: #454D7D;
        min-width: 100%;
        width: max-content;
        height: 200px;
        overflow-x: hidden;
        overflow-y: scroll;
        text-align: left;
    }
    .dropdown-body ul{
        list-style: none;
    }
    .dropdown-body ul li{
        padding: 5px;
    }
    .dropdown-body ul li.active,
    .dropdown-body ul li:hover{
        background-color: #2e50e9;
    }
    .add__item{
        padding: 5px;
        cursor: pointer;
        color: #0ef80e;
        font-weight: bold;
        font-size: 14px;
    }
    .add__item:hover{
        background-color: #2e50e9;
    }

</style>