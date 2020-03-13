<template>
    <div class="col-md-12">
        <div class="form-group">
            <label>Dodaj tag</label>
            <input type="text" class="form-control" v-model="term" @keydown.enter.prevent="addTag()">
            <div class="tags">
                <div class="col-auto tag" v-for="(tag, index) in tags">
                    {{tag.tag}}
                    <span @click="tags.splice(index, 1)"></span>
                </div>
            </div>
        </div>
        <div style="display: none">
            <input :name="'tags['+index+']'" :value="tag.tag" v-for="(tag, index) in tags">
        </div>
    </div>
</template>
<script>
    export default {
        props:['data'],
        data: () => {
            return{
                term: '',
                tags: [],
            }
        },
        mounted() {
            if(this.data){
                this.tags = this.data;
            }
        },
        methods:{
            addTag(){
                if(this.term != '' && this.tags.findIndex(x => x.tag == this.term) == -1){
                    this.tags.push({tag: this.term});
                    this.term = '';
                }
            }
        }
    }

</script>
<style lang="scss">
    .tags{
        margin: 10px 0px;
        display: flex;
        .tag{
            display: flex;
            align-items: center;
            cursor: pointer;
            margin: 4px;
            padding: 5px 20px;
            border-radius: 20px;
            border: 1px solid #f2f2f2;
            span{
                transition: all 300ms;
                display: flex;
                align-items: center;
                justify-content: center;
                &:hover{
                    opacity: 0.6;
                }
                &:after{
                    content: 'C';
                    font-family: voyager!important;
                    font-style: normal!important;
                    font-weight: 400!important;
                    font-variant: normal!important;
                    text-transform: none!important;
                    speak: none;
                    line-height: 1;
                    -webkit-font-smoothing: antialiased;
                }
            }
        }
    }
</style>
