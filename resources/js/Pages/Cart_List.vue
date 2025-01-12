<template>
    <div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Finalizar compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center p-0 mt-3 mb-2">
                            <div class="px-0 pt-4 pb-0 mt-3 mb-3">
                                <div id="form">
                                    <ul id="progressbar">
                                        <li v-for="(item, index) in stepList" :key="index"
                                            :class="(current == index + 1) ? 'active' : ''">
                                            <strong>{{ item }}</strong>
                                        </li>
                                    </ul>
                                    <div class="progress">
                                        <div class="progress-bar"></div>
                                    </div> <br>
                                    <div v-show="stepControle[0]">
                                        <h2>Sua lista de produtos</h2>
                                        <table class="table justify-content-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nº</th>
                                                    <th scope="col">Item</th>
                                                    <th scope="col">Produto</th>
                                                    <th scope="col">Preço</th>
                                                    <th scope="col">Qtd.</th>
                                                    <th scope="col">Acção</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="cartItem in cartItems" :key="cartItem.id">
                                                    <th scope="row">{{ cartItem.id }}</th>
                                                    <td>
                                                        <div class="col">
                                                            <img :src="`${cartItem.productoimagens[0].url}`"
                                                                :alt="`${cartItem.nome}`" width="80" height="80"
                                                                class="img-fluid d-none d-md-block rounded mb-2 shadow ">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col mt-sm-2">
                                                            <h4>{{ cartItem.nome }}</h4>

                                                        </div>
                                                    </td>
                                                    <td>{{ cartItem.preco }}</td>
                                                    <td>
                                                        <div class="col-md-3" style="margin: 0 auto;">
                                                            <input type="number" @click="addCartItem(cartItem)"
                                                                class="form-control form-control-md text-center" min="1"
                                                                v-model.number="cartItem.quantity">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-md-2" style="margin: 0 auto;">
                                                            <a href="#" @click="removeCartItem(cartItem)"
                                                                class="btn btn-white border-secondary bg-danger btn-md my-2">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="col-md-4 d-flex justify-content-center align-items-center"
                                            style="color: #333; margin: 0 auto;">
                                            <h4>Total:</h4>
                                            <h1> &nbsp;Akz {{ cartTotal }}</h1>
                                        </div>
                                        <button class="btn btn-danger " @click="removeAllCartItems">
                                            remover todos

                                        </button>
                                        <button class="btn btn-danger " @click="logout">
                                            sair

                                        </button>
                                        <button type="button" name="next-step" @click="nextStep()" class="next-step">
                                            Avançar </button>
                                    </div>
                                    <div v-show="stepControle[1]">
                                        <h2>Faça o ligin</h2>
                                        <form @submit.prevent="login">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body p-4 text-center">
                                                        <div class="alert alert-danger" v-if="hasErrors">
                                                            <ul>

                                                                <li v-for="(error, key) in errors" :key="key">{{ error
                                                                    }}</li>

                                                            </ul>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <input type="email" class="form-control rounded-4"
                                                                id="floatingInput" v-model="form.email" autofocus
                                                                autocomplete="of">
                                                            <label style="color: #333;"
                                                                for="floatingInput">Email</label>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <input type="password" class="form-control rounded-4"
                                                                id="floatingPassword" v-model="form.password" required
                                                                autocomplete="of">
                                                            <label style="color: #333;"
                                                                for="floatingPassword">Password</label>
                                                        </div>
                                                        <div class="col-4">
                                                        </div>
                                                        <small class="text-muted">Ainda não tem conta? </small><a
                                                            href="/admin/register">Cadastre-se</a>

                                                    </div>
                                                </div>

                                            </div>
                                            <button type="submit" name="next-step" class="next-step"> Avançar </button>
                                            <button type="button" name="previous-step" @click="previousStep()"
                                                class="previous-step"> Voltar </button>
                                        </form>
                                    </div>
                                    <div v-show="stepControle[2]">
                                        <h2>Selecione a forma de pagamento</h2>
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body p-4 text-center">
                                                    <select class="form-select form-select-lg mb-3"
                                                        aria-label=".form-select-lg example" v-model="formaPagamento">
                                                        <option v-bind:value="'cash'">A Cash</option>
                                                        <option v-bind:value="'transferencia'">Transferencia</option>
                                                        <option v-bind:value="'deposito'">Deposito</option>
                                                    </select>
                                                    <div class="input-group" v-if="formaPagamento != 'cash'">
                                                        <input type="text" class="form-control"
                                                            v-model="referencia_de_pagamento"
                                                            placeholder="referencia de pagamento">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" name="next-step" @click="nextStep()" class="next-step">
                                            Avançar </button>
                                        <button type="button" name="previous-step" @click="previousStep()"
                                            class="previous-step"> Voltar </button>
                                    </div>
                                    <div v-show="stepControle[3]">
                                        <div class="finish" v-if="message.type == 'success'">
                                            <h2 class="text-center text-green-500">
                                                <strong>{{ message.text }}</strong>
                                            </h2>
                                        </div>
                                        <div v-if="message.type == 'error'">
                                            <h3 class=" text-center text-red-700">
                                                <strong>{{ message.text }}</strong>
                                            </h3>
                                        </div>
                                        <button type="button" name="previous-step" @click="previousStep()"
                                            class="previous-step"> Voltar </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import Button from '@/components/Button.vue';
import { mapGetters, mapActions } from "vuex";
import store from '@/store/index';
import { computed } from 'vue'
export default {
    components: { Button },

    name: "CartList",
    setup() {
        const user = computed(() => store.getters['auth/user'])
        return { user }
    },
    computed: {
        ...mapGetters(["cartItems", "cartTotal", "cartQuantity"]),
        hasErrors() {
            return Object.keys(this.errors).length > 0
        },
    },
    data() {
        return {
            stepList: ['Lista', 'Login', 'Forma de pagamento', 'Finalizar'],
            stepControle: [true, false, false, false],
            current: 1,
            formaPagamento: 'cash',
            referencia_de_pagamento: null,
            form: {
                email: '',
                password: '',
                remember: false,
            },
            errors: {},
            message: {
                text: "",
                type: ""
            }
        }
    },
    mounted() {
        this.setProgressBar(this.current);
    },
    created() {
        this.$store.dispatch("getCartItems");

    },
    methods: {
        setErrors(errors) {
            this.errors = errors;
        },
        ...mapActions(['removeAllCartItems', 'addCartItem', 'removeCartItem']),
        //make function next step
        nextStep() {
            let current = this.current - 1;

            if (this.stepControle[current] == true && current == 0 && this.user) {
                this.stepControle[current] = false;
                this.stepControle[current + 2] = true;
                this.current = 3;
                this.setProgressBar();

            } else if (this.stepControle[current] == true) {
                this.stepControle[current] = false;
                this.stepControle[current + 1] = true;
                this.setProgressBar(this.current++);
            }


            if (this.stepControle[3] == true) {
                if (this.sendOrder()) {
                    this.stepControle = [true, false, false, false];
                    this.current = 1;
                    this.setProgressBar(this.current);
                    this.removeAllCartItems();
                    setTimeout(() => {
                        this.stepControle = [true, false, false, false];
                        this.current = 1;
                        this.setProgressBar(this.current);
                        this.removeAllCartItems();
                        $('#staticBackdrop').modal('hide');
                    }, 4000);
                }

            }
        },
        //make function previous step
        previousStep() {
            let current = this.current - 1;
            if (this.stepControle[current] == true && current == 2 && this.user) {
                this.stepControle[current] = false;
                this.stepControle[current - 2] = true;
                this.current = 1
                this.setProgressBar();
            }
            else if (this.stepControle[current] == true) {
                this.stepControle[current] = false;
                this.stepControle[current - 1] = true;
                this.setProgressBar(this.current--);
            }

        },
        //make function setProgressBar
        setProgressBar(step) {
            let total = this.stepControle.length;
            let percent = (100 / total) * this.current;
            $(".progress-bar")
                .css("width", percent + "%")
        },
        //make function send order to server and remove all items from cart
        async sendOrder() {
            let order = {
                items: this.cartItems,
                total: this.cartTotal,
                quantity: this.cartQuantity,
                cliente: this.user,
                formaPagamento: this.formaPagamento,
                referencia_de_pagamento: this.referencia_de_pagamento
            };
            //send order to server with axios
            await axios.post('/api/pedido/novo', order).then((response) => {

                this.message.text = response.data.message;
                this.message.type = 'success';
                this.downloadRecibo(response.data.data.id);

            }).catch(error => {
                console.log(error);
                this.message.text = error.response.data.message;
                this.message.type = 'error';
                return false;

            });
            return true;

        },
       
        async downloadRecibo(id) {
            try {
                const response = await axios.get(`/api/pedido/factura/${id}`, { responseType: 'blob' });
                const blob = new Blob([response.data], { type: 'application/pdf' });
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = `recibo_pedido_${id}.pdf`;
                link.click();
                window.URL.revokeObjectURL(link.href);
            } catch (error) {
                console.error('Erro ao fazer o download do recibo:', error);
                // Adicione aqui o tratamento de erro adequado para sua aplicação
            }
        }
        ,
        //Login
        login() {
            axios.get('/sanctum/csrf-cookie').then((response) => {
                axios.post('/api/login', this.form).then(response => {
                    this.setErrors([]);
                    const token = response.data.token;
                    const user = response.data.user;
                    this.$store.dispatch('auth/addToken', token);
                    this.$store.dispatch('auth/getUser', user);
                    this.nextStep();
                }).catch(error => {
                    if (error.response) {
                        this.setErrors(error.response.data.error);
                        return false;
                    }
                });

            }); //
        },
        logout() {

            axios.post('/api/logout', { web: true }).then((response) => {

                if (response.data.sucess) {
                    this.$store.dispatch('auth/logout');
                }

            }).catch((error) => {

                if (error.response.status === 401 && error.response.statusText === "Unauthorized" ||
                    error.response.status === 419 && error.response.statusText === "Unauthorized"
                ) {
                    this.$store.dispatch('auth/logout');
                }

            });

        }

    }
};
</script>
