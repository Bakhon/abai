<template>
    <div class="select__input">
        <select v-model="selected">
            <option :value="option"
                    v-for="option in options"
            >{{option}}</option>
        </select>
        <input type="text" class="input" v-model="selected">
    </div>
</template>

<script>
    export default {
        name: "SelectInput",
        props: ['options'],
        data(){
            return{
                selected: this.options[0],
            }
        },
    }
</script>

<style scoped>
.select__input{
    position: relative;

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