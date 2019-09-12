<template>
    <form @submit.prevent="updateProfile()" class="form-settings">
        <div class="row">
            <div class="col-12">
                <div class="item-avatar">
                    <div class="avatar" v-bind:style='{ backgroundImage: `url("${profile.avatar}")` }'></div>
                    <div class="box-avatar">
                        <div class="box-avatar-header">
                            <div class="file-upload-link">
                                <label>
                                    <input type="file" name="image" id="file" class="avtara-in">
                                    <span>
                                    <svg class="icon icon-clip"><use xlink:href="#icon-clip"></use></svg>
                                    Загрузить аватар
                                </span>
                                </label>
                            </div>
                            <button class="btn-del">Удалить</button>
                        </div>
                        <div class="box-avatar-body">
                            <p>
                                Минимальный размер 60x60px. Принимаются картинки таких типов: gif, jpg, jpeg, png.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="item">
                    <label for="">Логин:</label>
                    <input type="text" placeholder="Ваш логин:" name="login" v-model="profile.login" value="">
                </div>
                <div class="item">
                    <label for="">E-mail:</label>
                    <p class="input" v-html="profile.email"></p>
                </div>
                <div class="item">
                    <label for="">ФИО:</label>
                    <input type="text" placeholder="Ваше ФИО:" v-model="profile.fullname" name="fullname" value="" >
                </div>
                <div class="item">
                    <label for="">Дата рождения:</label>
                    <input type="date" name="birthday" v-model="profile.gender" dirname="gender">
                </div>
                <div class="item">
                    <label for="gender">Пол:</label>
                    <select v-model="profile.gender" name="gender" id="gender">
                        <option v-bind:value="0">Не выбрано</option>
                        <option v-bind:value="1">Мужской</option>
                        <option v-bind:value="2">Женский</option>
                    </select>
                </div>
                <button type="submit" class="btn-blue">Сохранить</button>
            </div>
        </div>
    </form>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "Profile",
        data: function() {
            return {
                profile:{
                    login: '',
                    fullname: '',
                    birthday: '',
                    avatar: '',
                    email: '',
                    gender: 0
                }
            }
        },
        mounted(){
            this.getProfile();
        },
        methods: {
            getProfile(){
                axios.get('/cabinet/get-user')
                    .then((response) => {
                        this.profile.login = response.data.login;
                        this.profile.fullname = response.data.fullname;
                        this.profile.birthday = response.data.birthday;
                        this.profile.avatar = '/storage/'+response.data.avatar;
                        this.profile.email = response.data.email;
                        this.profile.gender = response.data.gender;
                    })
                    .catch(error => {});
            },
            updateProfile(){

            }
        }
    }
</script>

<style scoped>

</style>