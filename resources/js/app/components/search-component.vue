<template>
    <div>
        <v-autocomplete
                v-if="isSearch"
                v-model="selected"
                @change="goToItem()"
                :items="items"
                :loading="loading"
                :search-input.sync="search"
                hide-no-data
                hide-details
                color="red"
                solo-inverted
                flat
                class="search"
                no-filter
                item-text="name"
                @click:append="isSearch = false"
                item-value="id"
                :label="$t('Szukaj')"
                prepend-inner-icon="mdi-magnify"
                :placeholder="$t('Wpisz szukany przedmiot')"
                return-object
        >
            <template v-slot:item="{item}">
                <div>
                    <v-avatar tile color="blue" class="mr-2">
                        <img
                                :src="$root.getSrc(item.main_image)"
                                alt="Produkt"
                        >
                    </v-avatar>
                    {{item.name}}
                </div>
                <div>
                    <span class="float-right">{{item.price | toCurrency()}}</span>
                </div>
            </template>
            <template v-slot:append>
                <v-btn dark icon fab @click="searchToggle()">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </template>
        </v-autocomplete>

        <v-btn v-if="!isSearch" @click="searchToggle()" icon>
            <img :src="$root.base_url+'/images/search.svg'">
        </v-btn>
    </div>
</template>
<script>
    import {Search} from "../../api/search";

    export default {
        data(){
            return{
                selected:{},
                loading:false,
                isSearch: false,
                items:[],
                search:null,
            }
        },
        watch:{
            search: function(){
                this.searchApi();
            }
        },
        methods:{
            searchToggle(){
              this.isSearch = !this.isSearch;
              this.$emit('search', this.isSearch);
            },
            searchApi(){
                this.loading = true;
                Search({term: this.search}).then(response => {
                    this.items = response;
                    this.loading = false;
                }).catch(e => {
                    this.loading = false;
                     })
            },
            goToItem(){
                window.location.href=this.selected.link;
            }
        }
    }
</script>
<style lang="scss">
    .v-autocomplete__content{
        .v-list-item{
            justify-content: space-between;
        }
    }
    .search{
        .v-text-field__details{
            display: none !important;
        }
        .v-input__slot{
            margin-bottom: 0px !important;
        }
    }
</style>
