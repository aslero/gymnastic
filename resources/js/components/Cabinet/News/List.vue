<template>
    <div class="list-items">
        <div class="article-item" v-if="posts.length > 0" v-for="(post,index) in posts">
            <div class="article-item-header">
                <div class="img" :style='{ backgroundImage: `url("/storage/${post.image}")` }'></div>
                <div class="article-header-info">
                    <div class="title" v-html="post.title"></div>
                    <div class="actions">
                        <a :href="'/cabinet/posts/'+post.slug" class="btn-edit"><svg><use xlink:href="#btn_edit"></use></svg></a>
                        <button type="button" @click.prevent="deletePost(post.id,index)" class="btn-delete"><svg><use xlink:href="#btn_delete"></use></svg></button>
                        <div class="published">
                            <div class="check-box">
                        <span @click="checkHelpAction()" class="ivu-switch" :class="{ 'ivu-switch-checked': post.published }">
                            <span class="ivu-switch-inner">
                                <span v-if="post.published == 1">On</span>
                                <span v-else>Off</span>
                            </span>
                        </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="description" v-html="post.description"></div>
            <div class="article-footer">

            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "List",
        data: function(){
            return{
                helpInfo: true,
                checkHelp: true,
                posts: []
            }
        },
        computed: {

        },
        mounted(){
            this.getPosts();
        },
        methods:{
            checkHelpAction(){
                if (this.checkHelp === false){
                    this.checkHelp = true;
                }else{
                    this.checkHelp = false;
                }
            },
            getPosts(){
                axios.get('/cabinet/posts-list')
                .then((response) => {
                    this.posts = response.data;
                })
                .catch(error => {});
            },
            deletePost(id,x){
                toastDelete.fire({
                    title: 'Удалить пост?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Удалить',
                    cancelButtonText: 'Отмена'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/cabinet/delete/post',{id:id})
                            .then((response) => {
                                if (response.data.error == 0) {
                                    toast.fire({
                                        type: 'success',
                                        title: response.data.message
                                    });
                                    this.posts.splice(x);
                                }else{
                                    toast.fire({
                                        type: 'error',
                                        title: response.data.message
                                    });
                                }
                            })
                            .catch(error => {});
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>