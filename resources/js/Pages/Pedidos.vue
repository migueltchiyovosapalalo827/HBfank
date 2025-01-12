<template>
    <Main>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Lista de Pedidos</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Pedidos Recebidos</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">

            <div class="card card-solid">
                <div class="card-body pb-0">
                    <div class="row">
                        <div v-for="pedido in pedidos.data" :key="pedido.id"
                            class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">
                                    Pedido #{{ pedido.id }}

                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <p><strong>Estado:</strong> <span :class="statusClass(pedido.estado)">{{ pedido.estado }}</span></p>
                                            <p><strong>Cliente:</strong> {{ pedido.cliente.nome }}</p>
                                            <p><strong>Endereco de entrega:</strong> {{ pedido.endereco }}</p>
                                            <p><strong>Telefone:</strong> {{ pedido.cliente.telefone }}</p>
                                            <p><strong>Data:</strong> {{ formatDate(pedido.created_at) }}</p>
                                            <p><strong>Forma de pagamento:</strong> {{ pedido.forma_de_pagamento }}</p>
                                            <p><strong>Referencia de pagamento:</strong> {{
                                                pedido.referencia_de_pagamento }}</p>
                                            <p><strong>Total:</strong> KZ {{ pedido.total }}</p>
                                            <p><strong>iva:</strong> KZ {{ pedido.iva }}</p>
                                            <div class="mt-2">
                                                <h3 class="font-semibold">Itens:</h3>
                                                <ul class="list-disc list-inside">
                                                    <li v-for="item in pedido.productos" :key="item.id">
                                                        {{ item.pivot.quantidade }}x {{ item.nome }} - KZ {{ item.preco
                                                        }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">

                                        <a href="#" class="btn btn-sm btn-primary" @click.prevent="entregarPedido(pedido)">
                                          Atender
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>

                <div class="card-footer">
                    <pagination :data="pedidos" @pagination-change-page="getResults"></pagination>
                </div>

            </div>

        </section>

    </Main>
</template>

<script>

import axios from 'axios';

export default {

    data() {
        return {

            pedidos: {},

        }
    },
    methods: {

        getResults(page = 1) {



            axios.get('/api/pedidos?page=' + page).then(({ data }) => (this.pedidos = data.data))
                .catch((error) => {
                    if (error.response.status === 401 && error.response.statusText === "Unauthorized" ||
                        error.response.status === 419 && error.response.statusText === "Unauthorized") { this.$store.dispatch('auth/logout'); }
                });


        },
        loadpedidos() {

            // if(this.$gate.isAdmin()){
            axios.get("/api/pedidos").then(({ data }) => (this.pedidos = data.data)).catch((error) => {
                if (error.response.status === 401 && error.response.statusText === "Unauthorized" ||
                    error.response.status === 419 && error.response.statusText === "Unauthorized") { this.$store.dispatch('auth/logout'); }
            });

            // }
        },

        statusClass(status) {
            const classes = {
                'Pendente': 'text-yellow-500',
                'Em preparo': 'text-blue-500',
                'Entregue': 'text-green-500',
                'Cancelado': 'text-red-500'
            };
            return classes[status] || 'text-gray-500';
        },
        //atender pedido
        atenderPedido(pedido) {
            axios.put(`/api/pedidos/atender/${pedido.id}`).then(({ response }) => {
                Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                this.loadpedidos();
            }).catch((error) => {
                if (error.response.status === 401 && error.response.statusText === "Unauthorized" ||
                    error.response.status === 419 && error.response.statusText === "Unauthorized") { this.$store.dispatch('auth/logout'); }
            });
        },
        //cancelar pedido
        cancelarPedido(pedido) {
            axios.put(`/api/pedidos/${pedido.id}`, { estado: 'Cancelado' }).then(({ data }) => {
                this.loadpedidos();
            }).catch((error) => {
                if (error.response.status === 401 && error.response.statusText === "Unauthorized" ||
                    error.response.status === 419 && error.response.statusText === "Unauthorized") { this.$store.dispatch('auth/logout'); }
            });
        },
        //entregar pedido
        entregarPedido(pedido) {
            axios.get(`/api/pedidos/atender/${pedido.id}`, { estado: 'Entregue' }).then(({ data }) => {
                Toast.fire({
                        icon: 'success',
                        title: data.message
                  });

                this.loadpedidos();
            }).catch((error) => {
                if (error.response.status === 401 && error.response.statusText === "Unauthorized" ||
                    error.response.status === 419 && error.response.statusText === "Unauthorized") { this.$store.dispatch('auth/logout'); }
            });
        },






    },
    mounted() {

    },
    created() {

        this.loadpedidos();


    },

    computed: {
        filteredItems() {
            return this.autocompleteItems.filter(i => {
                return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
        },

    },
}

</script>
