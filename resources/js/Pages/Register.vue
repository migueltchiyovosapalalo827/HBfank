<template>

    <div class="login-page">
        <div class="register-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="#" class="h1"><b>Hanburgaria</b>Fank</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Criar conta cliente</p>
                    <form @submit.prevent="createCliente">
                        <div class="form-group">
                            <label>Nome</label>
                            <input v-model="form.name" type="text" name="name" class="form-control"
                                :class="{ 'is-invalid': form.errors.has('name') }">
                            <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" />

                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="text" name="email" class="form-control"
                                :class="{ 'is-invalid': form.errors.has('email') }">
                            <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" />

                        </div>

                        <div class="form-group">
                            <label>Telefone</label>
                            <input v-model="form.telefone" type="text" name="telefone" class="form-control"
                                :class="{ 'is-invalid': form.errors.has('telefone') }">
                            <div v-if="form.errors.has('telefone')" v-html="form.errors.get('endereco')" />

                        </div>
                        <div class="form-group">
                            <label>Endereço</label>
                            <select name="bairro" v-model="form.bairro" id="bairro" class="form-control"
                                :class="{ 'is-invalid': form.errors.has('bairro') }">
                                <option v-for="bairro in bairros" :key="bairro.id" v-bind:value="bairro.id"
                                    :selected="form.bairros == bairro.id">{{ bairro.cidade.nome }}-{{ bairro.nome }}
                                </option>

                            </select>
                            <div v-if="form.errors.has('bairro')" v-html="form.errors.get('bairro')" />

                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input v-model="form.password" type="password" name="password" class="form-control"
                                :class="{ 'is-invalid': form.errors.has('password') }" autocomplete="false">
                            <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" />

                        </div>
                        <div class="form-group">
                            <label>Confirmar Password</label>
                            <input v-model="form.password_confirmation" type="password" name="password_confirmation"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                                autocomplete="false">
                            <div v-if="form.errors.has('password_confirmation')"
                                v-html="form.errors.get('password_confirmation')" />

                        </div>
                        <div class="row">


                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Criar conta</button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            bairros:{},
            fields: ['Nome', 'Email', 'Telefone'],
            form: new Form({
                id: '',
                name: '',
                email: '',
                password: "",
                password_confirmation: "",
                bairro: "",
                telefone: "",

            }),
            errors: {},
        }
    },
    computed: {
        hasErrors() {
            return Object.keys(this.errors).length > 0
        },
    },

    methods: {
        setErrors(errors) {
            this.errors = errors;
        },
        submit() {
            axios.get('/sanctum/csrf-cookie').then((response) => {
                // Login...
                axios.post('/api/login', this.form).then((response) => {
                    this.setErrors([]);
                    const token = response.data.token;
                    const user = response.data.user;
                    this.$store.dispatch('auth/login', token);
                    this.$store.dispatch('auth/getUser', user);

                }).catch((error) => {

                    if (error.response) {

                        this.setErrors(error.response.data.error);
                    }

                });

            });
        },


        loadBairros() {
            axios.get("/api/bairros/all").then(({ data }) => (this.bairros = data.data)).catch(
                (error) => {
                    console.log(error);
                });

        },

        createCliente() {

            this.form.post('/api/cliente/create')
                .then((response) => {

                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });

                  window.location.href = '/';

                })
                .catch((error) => {
                    console.log(error);
                    Toast.fire({
                        icon: 'error',
                        title: error.response.data.message
                    });
                })
        }
    },
    created() {

        this.loadBairros();

    }
}
</script>
