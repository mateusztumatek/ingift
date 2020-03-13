<template>
    <div>
        <input type="hidden" name="attributes" value="">
        <div class="col-md-12" style="margin-top: 30px">
            <h4>Atrybuty produktu: </h4>
        </div>

        <div v-for="attribute in attributes_list" class="col-md-12" style="margin-bottom: 10px; padding: 10px">
            <div class="card">
                <div class="card-header">
                    {{attribute.name}}
                </div>
                <div class="card-body">
                    <div class="form-group" v-if="attribute.is_boolean">
                        <label>{{attribute.name}}</label>
                        <input :type="(attribute.is_boolean)? 'checkbox' : 'text'"  v-bind:class="{'form-control': !attribute.is_boolean, 'form-check-input': attribute.is_boolean}" v-model="attributes[attribute.id]">
                    </div>
                    <div v-else>
                        <button @click="" type="button" @click="addAtribute(attribute)" class="btn btn-primary" >Dodaj ten atrybut</button>
                        <ul class="list-group">
                            <li class="list-group-item" v-for="a,key in attributes[attribute.id]">{{a.value}}
                                <span v-if="attribute.type == 'color'" style="width: 100px; height: 50px" :style="{'background-color': a.value}"></span>
                                <button type="button" class="btn btn-danger" @click="deleteAttribute(key, attribute.id)">Usuń</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" v-bind:class="{'show': added.id}" v-bind:style="{'display': (added.id != null)? 'block' : 'none'}">
            <div class="modal-dialog" role="document">
                <div class="modal-content" v-if="added">
                    <div class="modal-header">
                        <h5 class="modal-title">Atrybut {{added.name}}</h5>
                    </div>
                    <div class="modal-body" v-if="added.type == 'text'">
                        <div class="form-group">
                            <label>Wpisz wartość</label>
                            <input class="form-control" v-model="value">
                        </div>
                    </div>
                    <div class="modal-body" v-if="added.type == 'color'">
                        <div class="form-group">
                            <label>Wybierz kolor</label>
                            <input type="color" class="form-control" v-model="value">
                        </div>
                    </div>
                    <div class="modal-body" v-if="added.type == 'boolean'">
                        <div class="form-group">
                            <label>{{added.name}}</label>
                            <input type="checkbox" class="toggleswitch" v-model="value">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="storeAttribute()">Dodaj</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="added = {}; value= ''">Zamknij</button>
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none">
            <input :name="'attributes['+index+'][value]'" :value="attribute.value" v-for="(attribute,index) in attributes_input">
            <input :name="'attributes['+index+'][attribute_id]'" :value="attribute.attribute_id" v-for="(attribute,index) in attributes_input">
        </div>
    </div>
</template>
<script>
    export default {
        props:['attributes_list', 'product'],
        data(){
            return{
                value: '',
                added: {},
                attributes:{}
            }
        },
        computed:{
            attributes_input(){
                var arr = [];
                for (var i in this.attributes){
                    this.attributes[i].forEach(item => {
                        arr.push({
                            value: item.value,
                            attribute_id: i
                        });
                    })
                }
                return arr;
            }

        },
        watch:{
            attributes: {
                deep: true,
                handler: function(){
                    /* this.attributes_list.forEach(item => {
                         if(typeof this.attributes[item.id] == 'undefined' && item.is_boolean){
                             this.attributes[item.id] = false;
                         }
                     })*/
                    $('input[name = attributes]').val(JSON.stringify(this.attributes));
                    /*this.$emit('attributes', this.attributes);*/
                }
            }
        },
        mounted(){
            if (this.product){
                this.product.attributes.forEach(item => {
                    if(!item.attribute.is_boolean){
                        if(typeof this.attributes[item.attribute_id] != 'object'){
                            this.attributes[item.attribute_id] = [];
                        }
                        this.attributes[item.attribute_id].push({value: item.value});
                    }else{
                        this.attributes[item.attribute_id] = item.value;
                    }
                    this.refresh();
                })
            }
        },
        methods:{
            refresh(){
                var tmp = this.attributes;
                this.attributes = {};
                this.attributes = tmp;
            },
            addAtribute(attribute){
                this.added = attribute;
                if(this.added.type == 'boolean'){
                    this.value = true;
                }else{
                    this.value = '';
                }
            },
            storeAttribute(){
                if(!this.attributes[this.added.id] || typeof this.attributes[this.added.id] != 'object'){
                    this.attributes[this.added.id] = [];
                }
                this.attributes[this.added.id].push({value: this.value});
                this.refresh();
                this.value = "";
                this.added = {};
            },
            deleteAttribute(key, tab_id){
                var temp = Object.assign(this.attributes[tab_id]);
                temp.splice(key, 1);
                Vue.set(this.attributes, tab_id, temp);
                this.refresh();
            }
        }

    }
</script>
<style lang="scss">
    .modal{
        background-color: rgba(0,0,0,0.3);
    }
    .card{
        .card-header{
            padding: 10px 25px;
        }
        border-radius: 10px;
        -webkit-box-shadow: 2px 2px 15px 0px rgba(0,0,0,0.2) !important;
        -moz-box-shadow: 2px 2px 15px 0px rgba(0,0,0,0.2) !important;
        box-shadow: 2px 2px 15px 0px rgba(0,0,0,0.2) !important;
    }
    .list-group-item{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
