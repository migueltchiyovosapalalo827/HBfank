<template>
    <Main>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Venda directa</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">POS</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-8">
                                        <h4 class="mt-0 header-title">Lista de productos disponivel</h4>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Productos</label>
                                    <input type="text" class="form-control" placeholder="digite o nome do producto"
                                        id="kode-produk" v-model="search" @keyup="searchProduct()">
                                    <div class="dropdown-search">
                                        <ul>
                                            <li v-for="data in productSearch" :key="data.id"
                                                @click="addProductToCart(data)"><img
                                                    :src="`${data.productoimagens[0].url}`" alt=""
                                                    class='dropdown-image'><span> {{ data.nome }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary float-right"
                                    id="btn-tambah-produk">pesquisar</button>

                                <div class="form-group">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="alert alert-success" v-if="successMsg !== ''">
                                    {{ successMsg.message }} deseja imprimir a factura <router-link
                                        :to="{ name: '/factura', params: { invoice_id: successMsg.data.id } }"><i
                                            class="nav-icon fas fa-print mr-1"></i> </router-link>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-8">
                                        <h4 class="mt-0 header-title">Lista de produto</h4>
                                    </div>
                                </div>
                                <div class="float-right mb-2">
                                    <h5>Total geral: <span id="rp">Akz <span id="total-price" data-value='0'>{{
                                                formatPrice(totalPrice) }}</span></span></h5>
                                </div>
                                <form action="" method="post" id="form-transaction">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-transaction">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>nome</th>
                                                    <th>Preco</th>
                                                    <th>quantidae</th>
                                                    <th>iva</th>
                                                    <th>Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(product, index) in cart" :key="product.id">
                                                    <td class="product_id">{{ index + 1 }}</td>
                                                    <td> {{ product.nome }}</td>
                                                    <td>
                                                        AKz {{ formatPrice(product.realPrice) }}
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control"
                                                            @blur="changeQuantity($event, index)"
                                                            v-model.number="qty[index]" min="1">
                                                    </td>

                                                    <td>
                                                        Akz {{ formatPrice(14 / 100 * product.realPrice) }}
                                                    </td>
                                                    <td>
                                                        Akz {{ formatPrice(product.preco + (14 / 100 * product.preco)) }}
                                                    </td>
                                                    <td>
                                                        <button type="button" @click="deleteCart(index)"
                                                            class='btn btn-danger btn-sm'><i
                                                                class="fas fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div>
                                        <div class='row' v-if="this.cart.length >= 1">
                                            <div class='col-md-6 offset-md-6'>
                                                <div class='form-group  mt-3'>
                                                    <label>valor apagar</label>
                                                    <input type='number'
                                                        :class='{ "form-control": true, "is-invalid": this.error }'
                                                        id='nomi  nal-bayar' name='nominal_bayar'
                                                        @keyup='hitungKembalian()' v-model="bayar">
                                                    <div class="invalid-feedback" v-if="this.error">
                                                        {{ error }}
                                                    </div>
                                                </div>
                                                <div class='form-group  mt-3'>
                                                    <label>troco</label>
                                                    <input type='number' class='form-control' id='kembalian'
                                                        name='kembalian' readonly v-model="kembalian">
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary float-right" type="button"
                                            v-if="this.cart.length >= 1" @click="showKeteranganModal()">Processar a
                                            venda</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>

                <!-- KETERANGAN MODAL -->
                <div class="modal fade" id="keteranganModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">dados do cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="" @submit.prevent="processTransaction()">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">clientes: </label>

                                        <select class="form-control" v-model="customer">
                                            <option v-for="(cliente, index) in customers" :key="index"
                                                :value="cliente.id" :selected="cliente.id == customer">{{ cliente.nome
                                                }}</option>
                                        </select>


                                    </div>
                                    <div class="form-group">
                                        <label for="">Metodo de pagamento: </label>
                                        <select class="form-control" v-model="payment_method">
                                            <option v-for="(payment, index) in payment_methods" :key="index"
                                                :value="payment" :selected="payment == payment_method">{{ payment}}</option>
                                        </select>


                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">finalizar a venda</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- container fluid -->
        </section>
    </Main>
</template>


<script>


export default {

    data() {
        return {
            search: '',
            cart: [],
            productSearch: [],
            totalPrice: 0,
            kembalian: 0,
            bayar: 0,
            error: false,
            successMsg: '',
            customers: [],
            customer: '',
            payment_methods: ['cash', 'transferencia', 'deposito'],
            payment_method: "",
            qty: [],
        }
    },

    methods: {
        searchProduct() {
            let searchProduct = this.search;

            if (this.search == '') {
                this.productSearch = []
            } else {
                axios.get('api/producto/all', { params: { 'search': searchProduct } })
                    .then(res => {
                        this.productSearch = res.data.data;
                    });
            }
        },

        addProductToCart(producto) {

            producto.producto_id = producto.id;
            this.qty.push(1)
            producto.quantity = 1;
            producto.realPrice = producto.preco;


            let obj = this.cart.find(o => o.id === producto.id);

            if (obj !== undefined) {
                Toast.fire({
                    icon: 'error',
                    title: 'o produto ja se encontra no carrinho'
                });
            } else {
                this.cart.push(producto);
            }

            this.productSearch = '';
            this.countTotalPrice();
        },

        changeQuantity(event, index) {
            console.log(event.target.value);
            let qty = event.target.value;
            let price = this.cart[index].realPrice;
            this.cart[index].quantity = qty;
            let newPrice = price * qty;
            this.cart[index].preco = newPrice;

            this.countTotalPrice();
        },

        countTotalPrice() {
            this.totalPrice = 0;
            let totalPrice = 0;
            this.cart.forEach((data_cart, index) => {
                let realPrice = parseInt(data_cart.realPrice + (14 / 100 * data_cart.realPrice));
                let quantity = parseInt(data_cart.quantity);


                let total = realPrice * quantity;
                totalPrice += total;
            });

            this.totalPrice = totalPrice;
            this.hitungKembalian();
        },

        deleteCart(index) {
            this.cart.splice(index, 1)
            this.qty.splice(index, 1)
            this.countTotalPrice();
            console.log(this.cart);
        },

        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },

        processTransaction() {

            let productos = this.cart;
            let forma_de_pagamento = this.payment_method
            let cliente = this.customer


            axios.post(`/api/pedido/pos`, { productos, cliente, forma_de_pagamento })
                .then(res => {
                    console.log(res.data);

                    Swal.fire(
                        `sucesso!`,
                        `venda efectuada com sucesso`,
                        'success'
                    );

                    this.cart = [],
                    this.kembalian = 0;
                    this.totalPrice = 0;
                    this.bayar = 0;
                    this.successMsg = res.data;

                    $('#keteranganModal').modal('toggle');

                }).catch((error) => {
                    if (error.response.status === 401 && error.response.statusText === "Unauthorized" ||
                        error.response.status === 419 && error.response.statusText === "Unauthorized") { this.$store.dispatch('auth/logout'); }
                    $('#keteranganModal').modal('toggle');
                    this.cart = [],
                    this.kembalian = 0;
                    this.totalPrice = 0;
                    this.bayar = 0;
                    Toast.fire({
                        icon: 'error',
                        title: error.response.data.message
                    });

                });
        },

        hitungKembalian() {
            let totalPrice = this.totalPrice;
            let bayar = this.bayar;

            let kembalian = bayar - totalPrice;

            if (this.bayar >= this.totalPrice) {
                this.error = false;
            }

            this.kembalian = kembalian;
        },

        showKeteranganModal() {
            if (this.bayar < this.totalPrice) {
                this.error = `valor minimo a pagar ${this.totalPrice}`;
                return;
            }
            /*   axios.get('/api/v1/payment-method')
                   .then(res => {
                       this.payment_methods = res.data.data;
                   });*/
            axios.get('api/cliente/all').then(response => {
                this.customers = response.data.data;
            });


            $('#keteranganModal').modal('toggle');

        }


    }
}
</script>
<style scoped>
.dropdown-search {
    background-color: #fdfdfd;
    border: 1px solid #eee;
    box-shadow: 2px 5px 10px #ccc;
}

.dropdown-search ul {
    list-style: none;
    margin-bottom: 0;
    padding-left: 0;
}

.dropdown-search ul li {
    padding: 10px 0 10px 10px;
    cursor: pointer;
}

.dropdown-search ul li:hover {
    background-color: #eee;
}

.dropdown-search ul li span {
    margin-left: 10px;
}

.dropdown-image {
    width: 40px;
    height: 40px;
    object-fit: cover
}

#rp {
    color: #d35400
}
</style>
