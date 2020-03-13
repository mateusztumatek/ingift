<template>
    <v-navigation-drawer
            :value="show_sidebar"
            absolute
            temporary
            @input="$emit('change', $event)"
    >
        <v-list>
            <v-list-item key="main">
                <v-list-item-title><v-btn @click="back()" v-if="filtered.parent != null" icon><v-icon>mdi-arrow-left</v-icon></v-btn>{{filtered.name}}</v-list-item-title>
            </v-list-item>
            <v-list-item :key="key" @click="setActive(item)" v-for="(item, key) in filtered.childrens">
                <v-list-item-title>{{item.name}}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>
<script>
    export default {
        props:['items', 'show_sidebar'],
        data(){
          return{
              active: null,
          }
        },
        computed:{
            filtered(){
                if(this.active == null){
                    var items = [];
                    for (var i in this.items){
                        var item = {};
                        item.name = i;
                        item.childrens = this.items[i];
                        item.parent = null;
                        items.push(item);
                    }
                    var tmp = {
                        name: 'Menu glowne',
                        childrens:items,
                        parent: null

                    }
                    return tmp;
                }else{
                    return this.active;
                }
            }
        },
        methods:{
            setActive(item){
                if(item.childrens && item.childrens.length > 0){
                    var parent = Object.assign({}, this.filtered);
                    this.active = {
                        childrens: item.childrens,
                        name: item.name,
                        parent:parent
                    }
                }else{
                    this.goToLink(item);
                }
            },
            getMainCategoryItem(name, childrens){
                return {
                    name: name,
                    childrens: childrens,
                    parent: null,
                    main: true
                }
            },
            goToLink(item){

            },
            back(){
                this.active = this.active.parent;
            }
        }
    }
</script>
<style lang="scss">
    .menu-enter-active, .menu-leave-active {
        transition: opacity .5s;
    }
    .menu-enter, .menu-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>
