<template>
    <div>
        <v-app-bar
                app
                :color="(!scrolled)? 'transparent' : 'white'"
                style="padding: 0px"
                clipped-left
                elevate-on-scroll
                class="topbar"
                height="40px"
        >
            <div class="container my-0 d-flex" style="height: 100%">
                <v-toolbar-title class="d-flex align-center"><a href="/"><img class="logo" :class="{'logo-scrolled': scrolled}" :width="($root.isMobile)? '50': '100'" :src="$root.getSrc('default/logo-white.png')" :alt="'logo'"></a></v-toolbar-title>

                <v-spacer></v-spacer>
                <span v-if="!isMobile">
                    <v-menu transition="slide-x-reverse-transition" :close-on-content-click="false" color="primary" dark content-class="top-menu" :min-width="menu_width" @input="activeCategory = null" open-on-hover bottom v-for="(main_cat, index) in categories" offset-y  left>
                    <template v-slot:activator="{ on, value }">
                        <v-btn
                                class="h-100"
                                tile
                                :color="(!value)? 'transparent' : 'primary'"
                                v-on="on"
                                depressed
                        >
                            {{index}}
                        </v-btn>
                    </template>
                    <div class="row mx-0">
                        <div class="col-md-12 pa-0">
                            <v-list color="primary" style="border-radius: 0px !important;">
                                <span @mouseover="setActive(category)" @mouseleave="active = null" v-for="category in main_cat">
                                    <v-list-item :class="{'v-item--active v-list-item--active v-list-item--link' : activeCategory == category}"  v-if="category.childrens.length == 0">{{category.name}}</v-list-item>
                                        <v-list-group color="primary" v-if="category.childrens.length > 0">
                                            <template v-slot:activator @click.stop.prevent class="white--text">
                                                <v-list-item-title class="white--text">{{category.name}}</v-list-item-title>
                                            </template>
                                            <v-list color="primary" dark>
                                                <v-list-item v-for="category2 in category.childrens">
                                                    <v-list-item-title class="white--text">{{category2.name}}</v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-list-group>
                                </span>
                            </v-list>
                        </div>
                    </div>
                </v-menu>
                <v-badge class="nav-item">
                    <template v-slot:badge><span>2</span></template>
                    <v-btn color="transparent" depressed @click="$root.toggleCart()" class="h-100">
                        <img width="30px" :src="storage('/default/bag.svg')">
                    </v-btn>
                </v-badge>
                <v-btn class="nav-item h-100" depressed color="transparent" v-if="!isSearch" @click="$root.$eventBus.$emit('toggleDesigns')">
                    <img width="30px" :src="storage('/default/user (1).svg')">
                </v-btn>
                </span>
                <span v-else>
                    <v-btn @click="drawer = !drawer" color="transparent" depressed class="nav-item h-100">
                        <v-icon>mdi-menu</v-icon>
                    </v-btn>

                </span>
                <!--<search-component @search="changeSearch"></search-component>-->
            </div>
        </v-app-bar>
        <sidebar-component @change="(data) => {drawer = data}" :show_sidebar="drawer" :items="categories"></sidebar-component>
    </div>
</template>
<script>
    import SearchComponent from '../components/search-component';
    import SidebarComponent from './sidebar';
    export default {
        props:['categories_parent'],
        components:{SearchComponent},
        computed:{
            isMobile(){
                return this.$vuetify.breakpoint.smAndDown;
            },
            menu_width(){
                if(this.$vuetify.breakpoint.lgAndUp) return '40%';
                return '90%';
            }
        },
        mounted(){
          if(this.categories_parent){
              this.categories = this.categories_parent;
          }
          this.$root.$eventBus.$on('header-static', () => {
              this.static = true;
              this.scrolled = true;
          })
          window.addEventListener('scroll', (ev) => {
              this.onScroll(ev);
          })
        },
        data(){
            return{
                drawer: false,
                static: false,
                scrolled: false,
                fab: false,
                isSearch: false,
                categories:[],
                collapseOnScroll: true,
                activeCategory: null,
            }
        },
        methods:{
            onScroll (e) {
                if(this.static){
                    this.scrolled = true;
                    return null;
                }
                this.scrolled = window.pageYOffset > 5;
            },
            changeSearch(data){
                console.log(data);
                this.isSearch = data;
            },
            setActive(cat){
                this.activeCategory = cat;
            }
        }
    }
</script>
<style lang="scss">
    @import "../../../sass/variables";
    header{
        width: 100vw !important;
        i{
            &:before{
                font-weight: 600 !important;
            }
        }
    }
    .topbar{
        .v-badge__badge{
            top: 20px !important;
            left: calc(100% - 30%) !important;
        }
        .v-toolbar__content{
            padding: 0px !important;
        }
    }
    .top-menu{
        border-radius: 0px !important;
        box-shadow: none !important;
    }
    .logo{
        transition: all 300ms;
    }
    .logo-scrolled{
        filter: brightness(10%);
    }
</style>
