<template>
    <div>
        <div class="spinner-box"  v-if="loading">
            <div class="spinner"></div>
        </div>
        <form method="post" @submit.prevent="addArticle()" enctype="multipart/form-data" class="form-add side">
            <div class="form-wrapper pr-50">
                <div class="help--data_check">
                    <div class="check-box">
                        <p>Режим помощи</p>
                        <span @click="checkHelpAction()" class="ivu-switch" v-bind:class="{ 'ivu-switch-checked': checkHelp }">
                            <span class="ivu-switch-inner">
                                <span v-if="checkHelp">On</span>
                                <span v-else>Off</span>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="form--text_data">
                    <div class="form--container__data">
                        <div class="form--item">
                            <div class="item pos-r">
                                <input type="text" :maxlength="max" v-model="artilcle.title" placeholder="Введите заголовок поста*">
                                <span class="count" v-text="(max - artilcle.title.length)"></span>
                                <span class="help--info" v-if="helpInfo">Введите название своего поста, используя не больше 100 символов.</span>
                            </div>
                            <div class="item descripton pos-r">
                                <textarea v-model="artilcle.description" name="description" :maxlength="maxDescription" cols="30" rows="10" placeholder="Введите описание поста*"></textarea>
                                <span class="count" v-text="(maxDescription - artilcle.description.length)"></span>
                                <span class="help--info" v-if="helpInfo">Напишите небольшое вступление. Это именно тот текст, который будет выводиться в общей ленте вместе с заголовком.</span>
                            </div>
                        </div>
                        <draggable v-model="form" :move="checkMove">
                            <transition-group type="transition" name="flip-list">
                                <div class="form--item" v-for="(item, index) in form" :key="index">
                                    <div class="item pos-r">
                                        <input type="text" :maxlength="max" v-model="item.title" placeholder="Заголовок (не обязательно)">
                                        <span class="count" v-text="(max - item.title.length)"></span>
                                        <span class="help--info" v-if="helpInfo">Введите название своего поста, используя не больше 100 символов.</span>
                                    </div>
                                    <div class="item-upload" v-if="item.image == ''">
                                        <p class="upload--title">Добавить изображения:</p>
                                        <span class="upload--description">Вы можете загрузить до 5 изображений. Размер каждого не более 2048 Kb</span>
                                        <div class="data-gallery">
                                            <label :for="'gallery_id_'+index" class="gallery_id">
                                                <input type="file" @change="uploadImages(item,index)" name="image" multiple accept="image/*" :id="'gallery_id_'+index"/>
                                                <span><svg><use xlink:href="#camera"></use></svg> Нажмите для загрузки изображений</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="item-upload" v-else>
                                        <div class="image-loadiing">
                                            <img :src="'/storage/'+item.image" :alt="item.title" :title="item.title">
                                            <button type="button" class="btn-delete" @click.prevent="deleteImageToBlock(item)">
                                                <svg><use xlink:href="#crash"></use></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="item descripton pos-r">
                                        <textarea v-model="item.description" name="description" id="description" :maxlength="maxDescription" cols="30" rows="10" placeholder="Описание фотографии (не обязательно)"></textarea>
                                        <span class="count" v-text="(maxDescription - item.description.length)"></span>
                                        <span class="help--info" v-if="helpInfo">Напишите небольшое вступление. Это именно тот текст, который будет выводиться в общей ленте вместе с заголовком.</span>
                                    </div>

                                   <div class="item-footer">
                                       <p class="help--required"><span>*</span> Поля, обязательные для заполнения</p>
                                       <button class="btn-blue" type="button" @click.prevent="deleteBlock(index)">удалить блок</button>
                                   </div>
                                </div>
                            </transition-group>
                        </draggable>

                    </div>
                    <div class="form-btn-action">
                        <button class="add-block" type="button" @click.prevent="addGallery"><span><svg><use xlink:href="#plus"></use></svg></span> добавить блок</button>
                        <!--<div class="help--data_check">
                            <div class="check-box">
                                <p>Автоматическая нумерация блоков</p>
                                <span class="ivu-switch">
                                    <span class="ivu-switch-inner">
                                        <span>Off</span>
                                    </span>
                                </span>
                            </div>
                        </div>-->
                    </div>

                    <button type="submit" class="btn-blue">сохранить и перейти в предпросмотр</button>
                </div>
            </div>
            <div class="sidebar large right">
                <div class="s--header">
                    <p>теги <span class="red-req">*</span></p>
                    <span class="sub-s---header">Выберите не менее 2-ух тегов:</span>
                </div>
                <div class="article__tags mt-20" v-if="tagsBase.length > 0">
                    <ul>
                        <li v-for="(tag, n) in tagsBase">
                            <div id="ck-button">
                                <label>
                                    <input type="checkbox" v-model="tagsselect" name="tagsselect" class="checkbox" :value="tag.id">
                                    <span v-html="tag.title"></span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
                <p class="sub-input">Или добавьте свои:</p>
                <div class="item  pos-r">
                    <input type="text" v-model="tagsUser" name="tagsuser" value="">
                    <span class="help--info" v-if="helpInfo">Выберите или введите как минимум от 3 до 8 уникальных тегов, каждый должен содержать не менее трех цифр, или букв русского или латинского алфавита.</span>
                </div>
                <div class="s--header">
                    <p>источник новости*</p>
                </div>
                <div class="radio-row">
                    <div class="radio">
                        <input type="radio" v-model="sourceRadio" name="source"  checked="" id="source_no"  value="0">
                        <label for="source_no">Это моя новость</label>
                    </div>
                    <div class="radio">
                        <input type="radio" v-model="sourceRadio" name="source"  checked="" id="source_yes"  value="1">
                        <label for="source_yes">Другой источник</label>
                    </div>
                    <input type="text" v-model="sourceArticle" class="input-sidebar" placeholder="Введите источник новости">
                </div>

            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';
    import draggable from 'vuedraggable';
    export default {
        name: "addArticle",
        components: {
            draggable,
        },
        data: function(){
            return {
                max: 100,
                maxDescription: 1000,
                tagsBase: [],
                helpInfo: true,
                checkHelp: true,
                loading: false,
                tagsselect: [],
                tagsUser: '',
                sourceArticle: '',
                sourceRadio: 0,
                artilcle:{
                    title: '',
                    description: ''
                },
                form:[]
        }
    },
    computed: {

    },
    mounted(){
        let element  = {
            title: '',
            description: '',
            image: ''
        };
        this.form.push(element);
        this.getTags();
    },
    methods: {
        addArticle(){
            //const config = { 'content-type': 'multipart/form-data' };
            const formData = new FormData()
            formData.append('title', this.artilcle.title);
            formData.append('description', this.artilcle.description);
            formData.append('articles', JSON.stringify(this.form));
            formData.append('tags', JSON.stringify(this.tagsselect));
            formData.append('sourceradio', this.sourceRadio);
            formData.append('sourcearticle', this.sourceArticle);
            formData.append('tagsuser', this.tagsUser);
            axios.post('/add-article',formData)
                .then((response) => {
                    if (response.data.error == 0) {
                        toast.fire({
                            type: 'success',
                            title: response.data.message
                        });
                        window.location.href = response.data.link;
                    }else{
                        toast.fire({
                            type: 'error',
                            title: response.data.message
                        });
                    }
                })
                .catch(error => {});
        },
        uploadImages(item,tnum){
            const that = this;
            const config = {headers: {'Content-Type': 'multipart/form-data'}};
            that.loading = true;
            $(event.target.files).each(function( index,value,form ) { //Идем по массиву загруженных картинок

                let formData = new FormData();
                formData.append('image', value);  //Присваиваем переменной загруженную фотку
                return axios.post('/upload/article/images',formData,config) //Загружаем фотку на сервак и присылаем обратно название
                    .then((response) => {
                        if (response.data.error === 0) {
                            let el = that.form.find((f, idx) => f.image == '' && idx >= tnum);
                            if (el){
                                el.image = response.data.filename
                            }
                            else{
                                that.form.push({
                                    title: '',
                                    description: '',
                                    image: response.data.filename
                                });
                            }
                        }else{
                            toast.fire({
                                type: 'error',
                                title: response.data.message
                            });
                        }

                        that.loading = false;

                    })
                    .catch(error => {});

            });
        },
        deleteImageToBlock(item){
            item.image = '';
        },
        addGallery: function() {
            let element  ={
                title: '',
                description: '',
                image: '',
            };
            this.form.push(element);
        },
        deleteBlock(x){
            this.form.splice(x, 1);
        },
        getTags(){
            axios.get('/tags/get-tags')
                .then((response) => {
                    this.tagsBase = response.data;
                })
                .catch(error => {});
        },
        checkHelpAction(){
            if (this.checkHelp === false){
                this.helpInfo = true;
                this.checkHelp = true;
            }else{
                this.checkHelp = false;
                this.helpInfo = false;
            }
        },
        checkMove: function(e) {
            //window.console.log("Future index: " + e.draggedContext.futureIndex);
        }
    }
    }
</script>
