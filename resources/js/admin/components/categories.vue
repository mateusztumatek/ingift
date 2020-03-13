<template>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3" v-for="(category, index) in categories">
                <h3 style="font-size: 1.2rem; margin-left:  0px">{{index}}</h3>
                <ul class="categories-list">
                    <li v-for="category in category">
                        {{category.name}}
                        <input type="checkbox" v-model="selected[category.id]" value="1">
                        <ul v-if="category.childrens.length > 0">
                            <li v-for="category_2 in category.childrens">
                                {{category_2.name}}
                                <input type="checkbox" value="1" v-model="selected[category_2.id]">
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div>
            <input type="hidden" v-for="(cat,index) in toReturn" :name="'categories['+index+']'" :value="cat">
        </div>
    </div>
</template>
<script>
    import {getCategories} from "../../api/categories";

    export default {
        props:['data'],
        data: () => {
            return{
                categories: [],
                selected: {},

            }
        },
        computed:{
            toReturn(){
                 var data = [];
                 for (var i in this.selected){
                     if(this.selected[i] == true){
                         data.push(i);
                     }
                 }
                 return data;
            }
        },
        mounted() {
            if(this.data){
                this.data.forEach(item => {
                    this.$set(this.selected, item.id, true);
                })
            }
            this.getCategories();
        },
        methods:{
            getCategories(){
                getCategories().then(response => {
                    this.categories = response;
                })
            }
        }
    }
</script>
