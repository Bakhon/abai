<template>
    <div class="select__input">
        <select v-model="selected" v-if="options.length>0">
            <option :value="option.name_ru"
                    v-for="option in options"
                    v-if="name=='name'"
            >{{option.name_ru}}</option>
            <option :value="option.diameter"
                    v-for="option in options"
                    v-if="name=='diameter'"
            >{{option.diameter}}</option>
        </select>
        <input type="text" class="input" v-model="selected">
    </div>
</template>

<script>
    export default {
        name: "SelectInput",
        props: ['options', 'name'],
        data(){
            return{
                selected: '',
            }
        },
    }
</script>

<style scoped>
.select__input{
    position: relative;
    min-width: 150px;
    min-height: 20px;
}
.select__input .input{
   position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: calc(100% - 15px);
    background: #454D7D;
    padding-left: 5px;
}
</style>