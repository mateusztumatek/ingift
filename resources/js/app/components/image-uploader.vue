<template>
    <div>
        <v-file-input @click:clear="clear()" ref="image_uploader" accept="image/*" label="File input" @change="upload($event)"></v-file-input>
    </div>
</template>
<script>
    import {Upload} from "../../api/upload";

    export default {
        props:['value'],
        data: () => {
            return{

            }
        },
        methods:{
            clear(){
              this.$emit('input', null);
            },
            upload(file){
                if(file){
                    var formData = new FormData();
                    formData.append('file', file);
                    Upload(formData, 'user_images').then(response => {
                        this.$emit('input', response[0]);
                    }).catch(e => {
                        this.$root.$eventBus.$emit('addMessage', {text: 'Wgrywanie pliku się nie powiodło. Zmieniejsz wagę obrazka i spróbuj ponownie', type: 'error'});
                        this.$refs.image_uploader
                    })
                }
            }
        }
    }
</script>
