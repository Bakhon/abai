<template>
    <div class="main_content"
        :class="{closed: leftClose || rightClose}"
    >
        <div class="main_content-block"
            :class="{closeBlock: leftClose}"
        >
            <div class="content">
                <div class="content-header">
                    {{left_content}}
                    <div class="left_functions">
                        <slot name="left_function">
                        </slot>
                    </div>
                    <div class="close close_left" @click="closeLeftBlock" v-if="!rightClose">
                        <img src="/img/digital-drilling/left-arrow.svg" alt="">
                    </div>
                </div>
                <div class="content-body defaultScroll">
                    <slot name="content_body">
                    </slot>
                </div>
            </div>
        </div>
        <div class="main_content-block"
             :class="{closeBlock: rightClose}"
        >
            <div class="content">
                <div class="content-header">
                    {{right_content}}
                    <div class="right_functions">
                        <slot name="right_function">
                        </slot>
                    </div>
                    <div class="close close_right" @click="closeRightBlock" v-if="!leftClose">
                        <img src="/img/digital-drilling/left-arrow.svg" alt="">
                    </div>
                </div>
                <div class="content-body defaultScroll">
                    <slot name="content_body_right">
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MainContent",
        props: ['left_content', 'right_content'],
        data(){
            return{
                leftClose: false,
                rightClose: false,
            }
        },
        methods:{
            closeLeftBlock(){
                this.leftClose = !this.leftClose
            },
            closeRightBlock(){
                this.rightClose = !this.rightClose
            }
        }
    }
</script>

<style scoped>
    .main_content{
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .main_content.closed .main_content-block{
        width: calc(100% - 35px);
    }
    .main_content-block{
        width: calc(50% - 2px);
        height: 100%;
    }
    .main_content-block.closeBlock{
        width: 30px!important;
    }
    .main_content-block.closeBlock .left_functions{
        display: none;
    }
    .main_content-block.closeBlock .content-header{
        writing-mode: vertical-rl;
        text-orientation: mixed;
        padding: 0;
        width: 30px;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .main_content-block.closeBlock .content-body{
        display: none;
    }
    .main_content-block.closeBlock .close{
        transform: rotate(180deg);
    }
    .content{
        height: 100%;
        width: 100%;
        background-color: #272953;
    }
    .content-header{
        position: relative;
        padding: 13px;
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        line-height: 17px;
        color: #FFFFFF;
        height: 44px;
    }
    .close{
        position: absolute;
        top: 0;
        background: #333975;
        border: 1px solid #545580;
        box-sizing: border-box;
        border-radius: 4px;
        width: 30px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .close_left{
        right: 0;
    }
    .close_right{
        left: 0;
    }
    .close_right img{
        transform: rotate(180deg);
        position: relative;
        z-index: 10;
    }
    .left_functions{
        position: absolute;
        right: 40px;
        top: 50%;
        transform: translate(0, -50%);
    }
    .right_functions{
        position: absolute;
        left: 40px;
        top: 0;
        top: 50%;
        transform: translate(0, -50%);
    }
    .content-body{
        margin-top: 5px;
        padding: 5px;
        height: calc(100% - 55px);
        overflow-y: scroll;
    }
</style>