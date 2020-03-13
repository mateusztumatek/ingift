import Vue from 'vue';
const querystring = require('query-string');
import {downloadURI} from "../utilies/helpers";

const product = new Vue({
    data: () => {
        return{
            product: {
                variants: {},
            },
            preview:{

            },
            quantity: 1,
            generated: {
                data: null,
                show: false,
            },
            generating: false,
            iframe: false,
        }
    },
    computed:{
        isGenerable(){

        },
        caluclatePrice(){
            var quantity = 0;
            (!this.quantity)? quantity = 1 : quantity = this.quantity;
            if(this.product.price){
                var price = this.product.calculated * quantity;
                return price.toFixed(2);
            }
            return 0;
        }
    },
    mounted(){
    },
    methods:{
        setDefaultVariant(variant, id){
            this.product.variants[id] = variant.value;
        },
        set(data){
            this.product = data;
            this.$set(this.product, 'variants', {});
        },
        setPreview(data){
            data.forEach(item => {
                if(item.type == 'image'){
                    item.image_src = null;
                }
            })
            this.preview = data;
        },
        previewCallback(data){
              this.generated.data = data.preview;
              this.generated.show = true;
              this.iframe = false;
              this.generating = false;
        },
        downloadPreview(){
            downloadURI(this.generated.data, this.product.name+'.png');
        },
        generatePreview(){
            return new Promise((resolve , reject) => {
                this.generating = true;
                var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
                var eventer = window[eventMethod];
                var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

                // Listen to message from child window
                eventer(messageEvent,({data}) => {
                    if(data.type){
                        if(data.type == 'previewCallback'){
                            this.previewCallback(data.value);
                            resolve();
                        }
                    }
                },false);
                var data = {
                    data:{},
                    product: this.product
                };
                this.preview.forEach(item => {
                    if(item.type == 'text'){
                        data.data[item.id] = item.text;
                    }
                    if(item.type == 'image' && item.image_src != null){
                        data.data[item.id] = item.image_src;
                    }
                })
                this.iframe = true;
                this.$nextTick(() => {
                    var iframe = window.document.getElementById('previewIframe');
                    iframe.onload = () => {
                        document.getElementById('previewIframe').contentWindow.postMessage({type: 'preview', value: data}, '*');
                    }
                })
                setTimeout(() => {
                    if(this.generating){
                        this.generating = false;
                        this.generated.show = false;
                        this.iframe = false;
                        this.$root.$eventBus.$emit('addMessage', {text: 'Nie udało się wygenerować podglądu', type: 'error'});
                        reject();
                    }
                }, 8000)
            })
        }
    }
});

Vue.prototype.$product = product;
