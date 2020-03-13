<template>
    <div class="d-flex quantity-input" :style="vars">
        <v-btn @click="decrement()" color="primary" style="height: 100%" class="mr-3" depressed><v-icon>mdi-minus</v-icon></v-btn>
        <v-text-field height="height" outlined label="Ilość" v-model="data" class="no-validation"></v-text-field>
        <v-btn @click="increment()" color="primary" style="height: 100%" class="ml-3" depressed><v-icon>mdi-plus</v-icon></v-btn>
    </div>
</template>
<script>
    export default {
        props:['value'],
        data:() => {
            return{
                height: 55,
                data: null,
            }
        },
        computed:{
          vars(){
              return{
                  '--height' : this.height+'px'
              }
          }
        },
        watch:{
            data : function () {
                this.$emit('input', this.data);
            }
        },
        mounted() {
            this.data = this.value;
        },
        methods:{
            increment(){
                this.data = this.data + 1;
            },
            decrement(){
                if(this.data == 1) return;
                this.data = this.data - 1;
            }
        }
    }
</script>
<style lang="scss">
    .quantity-input{
        height: var(--height);
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        input{
            text-align: center !important;
        }
        .v-input__slot{
            margin-bottom: 0px !important;
        }
        .v-btn{
            min-width: unset !important;
            border-radius: 100%;
        }
    }
</style>
