<template>
    <div class="note">
        <div class="note__checked">
            <input type="checkbox" v-model="isActive">
            <label >Примечание:</label>
        </div>
        <div class="note__form">
            <textarea name="" id="" cols="30" rows="4" placeholder="Поле ввода |" :disabled="!isActive">

            </textarea>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Note",
        data(){
            return{
                isActive: false
            }
        },
    }
</script>

<style scoped>
    .note{
        display: flex;
        align-items: flex-start;
        margin: 20px;
    }
    .note__checked{
        display: flex;
        align-items: center;
        width: 120px;
        margin-top: 20px;
    }
    .note__checked label{
        margin-left: 10px;
        margin-bottom: 0;
    }
    .note__form{
        width: calc(100% - 120px);
    }
    .note__form textarea{
        width: 100%;
        background: #1F2142;
        border: 0.4px solid #454FA1;
        box-sizing: border-box;
        border-radius: 4px;
        padding: 10px;
    }
</style>