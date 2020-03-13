<template>
    <div>
        <div class="text-center">
            <div class="row" v-show="image != null">
                <div class="col-md-7">
                    <div style="width:100%; margin: auto" id="konva-wrapper">
                        <v-stage @mousedown="handleStageMouseDown" @mouseup="updateElements()" ref="stage" :config="configKonva">
                            <v-layer ref="layer" >
                                <v-image @click="activeLayer = null"  key="image" v-if="configImage.src" :config="configImage"/>
                                <v-text v-for="(place, index) in places" :ref="'text'+place.name" :config="place.text" v-if="place.text && selectedShapeName != place.id && place.text.type == 'text'"></v-text>
                                <v-image v-for="(place, index) in places" :ref="'image'+place.name" :config="place.text" v-if="selectedShapeName != place.id && place.text.type == 'image' && place.text.image_src != null"></v-image>
                                <v-rect @click="setActiveLayer(place)" @dragstart="setActiveLayer(place)" v-for="(place, index) in places" :ref="'place.'+place.id" @dragmove="dragmove" :key="place.name" v-if="place.text.type != 'mask' && !isMaskShowed && !previewGenerated" :config="place"></v-rect>
                                <v-transformer ref="transformer" />
                                <v-image @click="setActiveLayer(place)" :config="place.text" v-for="(place, index) in places" v-if="place.text.type == 'mask' && place.text.show == 1" :ref="'mask'+place.id" ></v-image>
                            </v-layer>
                        </v-stage>
                    </div>
                </div>
                <div class="col-md-5">
                    <v-btn color="primary" @click="addLayer()">Dodaj warstwę</v-btn>
                    <v-btn color="primary" @click="addMask()">Dodaj maskę</v-btn>
                    <v-list>
                        <v-list-item style="border-radius: 16px" class="my-3 pa-5" v-for="place in sortedPlaces" :class="{'elevation-10': activeLayer == place, 'elevation-2': activeLayer != place}">
                            <v-list-item-content>
                                <v-btn-toggle v-if="place.text.type != 'mask'" @change="changeType($event, place)" class="mb-4" v-model="place.text.type">
                                    <v-btn small value="text">
                                        Tekst
                                    </v-btn>
                                    <v-btn small value="image">
                                        Zdjęcie
                                    </v-btn>
                                </v-btn-toggle>
                                <v-text-field v-if="place.text.type != 'mask'" dense label="Nazwa pola" v-model="place.field_name"></v-text-field>
                                <div v-if="place.text.type == 'text'">
                                    <v-text-field dense label="Domyślny tekst" v-model="place.text.text"></v-text-field>
                                    <v-text-field dense type="number" label="Rozmiar czcionki" v-model="place.text.fontSize"></v-text-field>
                                    <v-select dense label="Czcionka" v-model="place.text.fontFamily" :items="fonts" item-text="name" item-value="family"></v-select>
                                    <v-color-picker label="Wybierz kolor" v-model="place.text.fill"></v-color-picker>

                                    <v-btn-toggle v-model="place.text.align">
                                        <v-btn small value="left">
                                            <v-icon>mdi-format-align-left</v-icon>
                                        </v-btn>
                                        <v-btn small value="center">
                                            <v-icon>mdi-format-align-center</v-icon>
                                        </v-btn>
                                        <v-btn small value="right">
                                            <v-icon>mdi-format-align-right</v-icon>
                                        </v-btn>
                                    </v-btn-toggle>
                                    <v-text-field label="Maksymalna ilość liter" v-model="place.text.max_length"></v-text-field>
                                </div>
                                <div v-if="place.text.type == 'image'">
                                    <v-file-input accept="image/*"  multiple label="Wgraj zdjęcie" @change="uploadFile($event, place)"></v-file-input>
                                </div>
                                <div v-if="place.text.type == 'mask'">
                                    <v-file-input accept="image/*"  multiple label="Wgraj maskę" @change="uploadFile($event, place)"></v-file-input>
                                    <v-switch label="Pokaż maskę" v-model="place.text.show" false-value="0" true-value="1"></v-switch>
                                </div>
                                <v-btn color="danger" @click="deleteLayer(place)">Usuń warstwę</v-btn>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {Upload} from "../../api/upload";
    import {downloadURI} from "../../utilies/helpers";

    export default {
        data:() => {
            return{
                fonts: [],
                width: 1000,
                parent_data: null,
                image: null,
                configKonva: {
                    width: 200,
                    height: 200
                },
                places:[],
                configImage: {
                    width: 100,
                    height: 100,
                    src: null,
                    image: null
                },
                activeLayer: null,
                selectedShapeName: null,
                defaultImage: null,
                loaded: false,
                previewGenerated: false,
            }
        },
        computed:{
            sortedPlaces(){
                return this.places.sort((a,b) => {
                    if(a.text.type == 'mask' && b.text.type != 'mask') return -1;
                    return 1;
                })
            },
            isMaskShowed(){
                var check = false;
                this.places.forEach(item => {
                    if(item.text.type == 'mask'){
                        if(item.text.show == 1) check = true;
                    }
                })
                return check;
            }
        },
        mounted(){
            setInterval(() => {
                this.emit();
            }, 1000)
            var element = document.getElementsByClassName('v-content')[0];
            new ResizeObserver(() => {
                window.top.postMessage({type: 'height', value: element.clientHeight}, '*');
            }).observe(element);
            var defImage = new Image();
            defImage.src = this.storage('default/image.png');
            var v  = this;
            defImage.onload = function(){
                v.defaultImage = this;
            }
            this.fonts = fonts;
            // Create IE + others compatible event handler
            var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
            var eventer = window[eventMethod];
            var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
            eventer(messageEvent,(e) => {
                this.reciveMessage(e);
            },false);
            if(window.addEventListener){
                window.addEventListener('message', this.reciveMessage, false);
            }else{
                window.attachEvent('onmessage', this.reciveMessage);
            }
            this.configKonva.width = this.width;
            this.configKonva.height = this.width;
        },
        methods:{
            getFonts(){

            },
            setActiveLayer(layer){
                this.activeLayer = layer;
            },
            setImage(event){
                this.initImages();
            },
            reciveMessage(data){
                if(data.data){
                    if(data.data.image && data.data.image != this.image){
                        console.log('IMAGE', data.data);
                        this.image = data.data.image;
                        this.initImages();
                    }
                    if(data.data.type == 'places'){
                        if(!this.loaded && typeof data.data.value == 'object'){
                            data.data.value.forEach(item => {
                                if(item.text.type == 'text') this.places.push(item);
                                if(item.text.type == 'image' || item.text.type == 'mask'){
                                    var img = new Image();
                                    img.src = this.storage(item.text.image_src);
                                    var v =this;
                                    img.onload = function () {
                                        item.text.image = this;
                                        v.places.push(item);
                                    }
                                }
                            })
                        }
                        this.loaded = true;
                    }
                    if(data.data.type == 'preview' && !this.previewGenerated){
                        this.previewGenerated = true;
                        this.previewImagesInit(data.data.value).then(response => {
                            this.generatePreview({product: data.data.value.product, data: response});
                        });
                    }
                }
            },
            dragmove(){

            },
            previewImagesInit(data){
                return new Promise((resolve, reject) => {
                    var process = JSON.parse(data.product.data);
                    var imagesItems = 0;
                    var imagesChecked = 0;
                    for(var i in data.data){
                        var index = process.findIndex(x => x.id == i);
                        if(index != -1){
                            if(process[index].text.type == 'text'){
                                process[index].text.text = data.data[i];
                            }
                            if(process[index].text.type == 'image'){
                                process[index].text.image_src = data.data[i];
                            }
                        }
                    }
                    process.forEach((item,index) => {
                        var check = false;
                        if(item.text.type == 'mask') check = true;
                        for(var i in data.data){
                            if(item.id == i) check = true;
                        }
                        if(!check) process.splice(index, 1);
                    })
                    process.forEach(item => {
                        if((item.text.type == 'mask' || item.text.type == 'image')){
                            imagesItems = imagesItems + 1;
                        }
                    })
                    process.forEach(item => {
                        if(item.text.type == 'mask' || item.text.type == 'image'){
                            var img = new Image();
                            img.src = this.storage(item.text.image_src);
                            img.onload = function(){
                                item.text.image = this;
                                imagesChecked = imagesChecked + 1;
                                if(imagesChecked == imagesItems){
                                    resolve(process);
                                }
                            }
                        }
                    })
                    if(imagesItems == 0) resolve(process);
                })
            },
            generatePreview(data){
                this.previewGenerated = true;
                this.image = data.product.main_image;
                this.initImages();
                this.places = data.data;
                setTimeout(() => {
                    var preview = this.$refs.stage.getStage().toDataURL({pixelRatio: 1.3});
                    parent.postMessage({type: 'previewCallback', value: {preview: preview}}, '*');
                }, 1000);
            },
            addLayer(){
                let r = Math.random().toString(36).substring(0);
                this.places.push({
                    id: r,
                    x: 50,
                    text: {
                        align: 'left',
                        text: 'Przykładowy tekst',
                        fontSize: 12,
                        wrap: 'word',
                        fill: '#000000',
                        x: 50,
                        y: 50,
                        type: 'text',
                        height: 300,
                        width: 300,
                        fontFamily: null,
                        max_length: 20
                    },
                    edited: false,
                    y: 50,
                    width: 300,
                    height: 300,
                    fill: 'rgba(130, 197, 255, 0.2)',
                    name: r,
                    stroke:'#82c5ff',
                    draggable: true
                })
            },
            updatePlaces(){
                this.places.forEach(item => {
                    if(item.scaleX){
                        var w = item.width * item.scaleX;
                    }else{
                        var w = item.width;
                    }
                    if(item.scaleY){
                        var h = item.height * item.scaleY;
                    }else{
                        var h = item.height;
                    }
                    item.text = {
                        ...item.text,
                        x: item.x,
                        y: item.y,
                        rotation: item.rotation,
                        width: w,
                        height: h,
                    }
                })
            },
            initImages(){
                let v = this;
                var img = new Image();
                img.src = this.storage(this.image);
                img.onload = function(){
                    v.configImage.image = img;
                    v.configImage.image_src = this.image;
                    v.configImage.src = v.storage(this.image);
                    var large = null;
                    if(this.width >= this.height){
                        var ratio = v.width / this.width;
                        v.configImage.width = this.width * ratio;
                        v.configImage.height = this.height * ratio;
                    }else{
                        var ratio = v.width / this.width;
                        v.configImage.width = this.width * ratio;
                        v.configImage.height = this.height * ratio;
                    }
                }

            },
            handleStageMouseDown(e) {
                if (e.target === e.target.getStage()) {
                    this.selectedShapeName = null;
                    this.updateTransformer();
                    return null;
                }
                const clickedOnTransformer = e.target.getParent().className === 'Transformer';
                if (clickedOnTransformer) {
                    return null;
                }
                if(e.target.attrs && e.target.attrs.id){
                    var id = e.target.attrs.id;
                    this.places[this.places.findIndex(x => x.id == id)].edited = true;
                    var rect = this.places.find(r => r.id == id);
                }else{
                    var id = null;
                    var rect = null;
                }
                if (rect) {
                    this.selectedShapeName = e.target.name();
                } else {
                    this.selectedShapeName = null;
                }
                this.updateTransformer();
            },
            updateTransformer() {
                const transformerNode = this.$refs.transformer.getStage();
                const stage = transformerNode.getStage();
                const { selectedShapeName } = this;
                const selectedNode = stage.findOne('.' + selectedShapeName);
                if (selectedNode === transformerNode.node()) {
                    return;
                }
                if (selectedNode) {
                    transformerNode.attachTo(selectedNode);
                } else {
                    transformerNode.detach();
                }
                this.updatePlaces();
                transformerNode.getLayer().batchDraw();
            },
            updateElements(){
                const stage = this.$refs.stage.getStage();
                const { selectedShapeName } = this;
                const selectedNode = stage.findOne('.' + selectedShapeName);
                if(typeof selectedNode != 'undefined'){
                    var index = this.places.findIndex(i => i.name == this.selectedShapeName);
                    this.places[index] = selectedNode.attrs;
                    this.updatePlaces();
                }
            },
            changeType(event, place){
                place.text.type = event;
                if(event == 'image'){
                    place.text.image = this.defaultImage;
                    place.text.image_src = 'default/image.png';
                }
            },
            uploadFile(files, place){
                var formData = new FormData();
                formData.append('file', files[0]);
                Upload(formData, 'placeholders').then(response => {
                    var img  = new Image();
                    var v =this;
                    img.src = this.storage(response[0]);
                    img.onload = function () {
                        var index = v.places.findIndex(x => x.id == place.id);
                        v.places[index].text.image = this;
                        v.places[index].text.image_src = response[0];
                        v.updatePlaces();
                    }
                })
            },
            deleteLayer(place){
                this.places.splice(this.places.indexOf(place), 1);
                if(this.selectedShapeName == place.id){
                    this.selectedShapeName = null;
                    this.updateTransformer();
                }
            },
            emit(){
                var data = JSON.stringify(this.places);
                parent.postMessage({type: 'data', value: data}, '*');
            },
            addMask(){
                let r = Math.random().toString(36).substring(0);
                var w = this.width;
                this.places.push({
                    id: r,
                    x: 0,
                    y: 0,
                    text: {
                        show:0,
                        x: 0,
                        y: 0,
                        type: 'mask',
                        height: w,
                        width: w,
                    },
                    edited: false,
                    y: 0,
                    width: w,
                    height: w,
                    name: r,
                    draggable: false
                })
            }
        }
    }
</script>
<style lang="scss">
    #konva-wrapper{
        .konvajs-content{
            margin: auto;
            border: 1px solid black;
        }
    }
</style>
