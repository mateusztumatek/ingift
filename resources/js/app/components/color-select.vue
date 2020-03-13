<template>
    <div class="colors">
        <div @click="data = color.value" v-for="color in colors" class="color" :class="{'active': data == color.value}" :style="{'background-color': color.value}"></div>
    </div>
</template>
<script>
    export default {
        props:['colors', 'value'],
        data(){
            return{
                data: null,
            }
        },
        mounted() {
            this.data = this.value;
            console.log(this.colors);
        }
    }
</script>
<style lang="scss" scoped>
    .colors{
        display: flex;
        .active{
          &:after{
              opacity: 1 !important;
          }
        }
        .color{
            &:after{
                content: "\F12C";
                align-items: center;
                display: inline-flex;
                font-feature-settings: "liga";
                font-size: 12px;
                position: absolute;
                right: 0px;
                left: 0px;
                color: white !important;
                justify-content: center;
                letter-spacing: normal;
                line-height: 1;
                font: normal normal normal 24px/1 "Material Design Icons";
                position: relative;
                text-indent: 0;
                transition: .3s cubic-bezier(.25,.8,.5,1),visibility 0s;
                vertical-align: middle;
                opacity: 0;
            }
            cursor: pointer;
            min-width: 30px;
            min-height: 30px;
            border-radius: 100%;
            border: 1px solid #e9e9e9;
        }
        .color:not(:first-of-type){
            margin-left: 10px;
        }
    }
</style>
