<template>
    <div>
        <v-btn @click="rate.adding = !rate.adding" class="my-btn" color="primary"><span v-if="!rate.adding">Dodaj ocenę</span><span v-else>Schowaj</span></v-btn>
        <transition name="menu">
            <div v-if="rate.adding">
                <v-form ref="rate_form">
                    <v-rating class="mt-5" v-model="rate.rate" half-increments></v-rating>
                    <v-text-field class="only-validation" v-model="rate.rate" :rules="[validation.required]"></v-text-field>
                    <v-text-field class="mt-3 no-validation" outlined label="Twoje imię" v-model="rate.author"></v-text-field>
                    <v-textarea class="mt-3 no-validation" outlined label="Komentarz" v-model="rate.content"></v-textarea>
                    <v-btn class="my-btn w-100" @click="store()">Dodaj ocenę</v-btn>
                </v-form>
            </div>
        </transition>
        <div v-if="rates">
            <div v-if="rates.length == 0" class="empty-state mt-3">
                <span style="z-index: 100">Brak ocen</span>
            </div>
            <div class="w-100 my-5" v-for="rate in rates">
                <div class="d-flex align-end">
                    <h3 class="mr-3" v-if="rate.author">{{rate.author}}</h3>
                    <span class="text-muted">{{rate.created_diff}}</span>
                </div>
                <v-rating readonly :value="rate.rate"></v-rating>
                <p class="text-muted mb-0">{{rate.content}}</p>
            </div>
        </div>
    </div>
</template>
<script>
    import {getBreads, storeBread} from "../api/bread";
    export default {
        props:['data', 'id', 'type'],
        data: () => {
            return{
                rate: {
                    adding :false,
                },
                rates: [],
            }
        },
        mounted() {
            if(this.data){
                this.rates = this.data;
            }else{
                this.getRates();
            }
        },
        methods:{
            getRates(){
                getBreads('Rate', {model_name: 'Rate', foreign_key: this.id, type: this.type, per_page: 1000000}).then(response => {
                    this.rates = response.data;
                })
            },
            store(){
                if(this.$refs.rate_form.validate()){
                    storeBread('Rate', {foreign_key: this.id, type: 'product', ...this.rate}).then(response => {
                        this.$root.$eventBus.$emit('addMessage', {text: 'Udało się dodać ocenę', type: 'success'});
                        this.rates.push(response);
                    })
                }
            }
        }
    }
</script>
