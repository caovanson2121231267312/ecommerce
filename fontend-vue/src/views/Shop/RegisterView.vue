<template>
    <section>
        <div class="limiter">
            <div class="container-login100" style="background-image: url(/src/assets/images/banners/bg-01.webp);">
                <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                    <form class="login100-form validate-form" @submit.prevent="signup">
                        <span class="login100-form-title p-b-49">
                            Sign up
                        </span>
                        <div class="wrap-input100 validate-input m-b-23" data-validate="Username is reauired">
                            <span class="label-input100">Username</span>
                            <input class="input100" type="text" v-model="name" name="username"
                                placeholder="Type your username">
                            <span class="focus-input100" data-symbol="&#xf206;"></span>
                        </div>
                        <div class="wrap-input100 validate-input m-b-23" data-validate="Username is reauired">
                            <span class="label-input100">Email</span>
                            <input class="input100" type="text" v-model="email" name="email" placeholder="your email">
                            <span class="focus-input100" data-symbol="&#xf206;"></span>
                        </div>
                        <div class="wrap-input100 validate-input m-b-23" data-validate="Password is required">
                            <span class="label-input100">Password</span>
                            <input class="input100" type="password" v-model="password" name="pass"
                                placeholder="Type your password">
                            <span class="focus-input100" data-symbol="&#xf190;"></span>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <span class="label-input100">Comfirm Password</span>
                            <input class="input100" type="password" v-model="password_confirmation"
                                placeholder="confirm password">
                            <span class="focus-input100" data-symbol="&#xf190;"></span>
                        </div>
                        <div class="text-right p-t-8 p-b-31">
                            <a href="#">
                                Forgot password?
                            </a>
                        </div>
                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn" type="submit">
                                    Sign up
                                </button>
                            </div>
                        </div>
                        <div class="txt1 text-center p-t-54 p-b-20">
                            <span>
                                Or Sign Up Using
                            </span>
                        </div>
                        <div class="flex-c-m">
                            <a href="#" class="login100-social-item bg1">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="login100-social-item bg2">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="login100-social-item bg3">
                                <i class="fab fa-google-plus-g"></i>
                            </a>
                        </div>
                        <div class="d-flex mt-5 justify-content-between">
                            <RouterLink class="border-2" to="/">
                                <span class="txt1 p-b-17">
                                    <i class="fas fa-home"></i> Home page
                                </span>
                            </RouterLink>

                            <RouterLink class="border-2" to="/login">
                                <span class="txt2">
                                    Login
                                </span>
                            </RouterLink>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="dropDownSelect1"></div>
    </section>
</template>

<script>
import {
    RouterLink
} from 'vue-router'
import api from '../../stores/axios'
import { alert, notify } from "../../config"

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        }
    },
    methods: {
        async signup() {
            let UserForm = await new FormData()
            await UserForm.append('email', this.email)
            await UserForm.append('password', this.password)
            await UserForm.append('password_confirmation', this.password_confirmation)
            await UserForm.append('name', this.name)
            try {
                const data = await api.post('api/auth/register', UserForm, {
                    'Content-Type': 'application/json',
                })
                await this.$store.dispatch('signup', data)
                await this.$router.push('/login');
                await alert('success', 'top-center', 'Đăng ký thàng công, đăng nhập để tiếp tục.');
            } catch (e) {
                notify('danger', 'top-center', e);
                this.$store.dispatch('alert', e)
            }
        },
    }
}
</script>

<style scoped>
body,
html {
    height: 100%;
    font-family: Poppins-Regular, sans-serif
}

a {
    font-family: Poppins-Regular;
    font-size: 15px;
    transition: all .4s;
    -webkit-transition: all .4s;
    -o-transition: all .4s;
    -moz-transition: all .4s;
    text-decoration: none;
}

a:focus {
    outline: none !important
}

p {
    font-family: Poppins-Regular;
    font-size: 15px;
    line-height: 1.7;
    color: #666;
    margin: 0
}

ul,
li {
    margin: 0;
    list-style-type: none
}

input {
    outline: none;
    border: none
}

textarea {
    outline: none;
    border: none
}

textarea:focus,
input:focus {
    border-color: transparent !important
}

input:focus::-webkit-input-placeholder {
    color: transparent
}

input:focus:-moz-placeholder {
    color: transparent
}

input:focus::-moz-placeholder {
    color: transparent
}

input:focus:-ms-input-placeholder {
    color: transparent
}

textarea:focus::-webkit-input-placeholder {
    color: transparent
}

textarea:focus:-moz-placeholder {
    color: transparent
}

textarea:focus::-moz-placeholder {
    color: transparent
}

textarea:focus:-ms-input-placeholder {
    color: transparent
}

input::-webkit-input-placeholder {
    color: #adadad
}

input:-moz-placeholder {
    color: #adadad
}

input::-moz-placeholder {
    color: #adadad
}

input:-ms-input-placeholder {
    color: #adadad
}

textarea::-webkit-input-placeholder {
    color: #adadad
}

textarea:-moz-placeholder {
    color: #adadad
}

textarea::-moz-placeholder {
    color: #adadad
}

textarea:-ms-input-placeholder {
    color: #adadad
}

button {
    outline: none !important;
    border: none;
    background: 0 0
}

button:hover {
    cursor: pointer
}

iframe {
    border: none !important
}

.login100-social-item {
    font-size: 25px;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 5px;
}
</style>