<template>
<Main>
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Factura</h1>
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


    <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="invoice-title">
                                                        <h4 class="float-right font-16"><strong>Factura # {{ data_order.id }}</strong></h4>
                                                        <h3 class="m-t-0">
                                                            <img src="#" alt="logo" height="28"/>
                                                        </h3>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <address>
                                                                <strong>Para o cliente:</strong><br>
                                                              {{ cliente.nome }}<br>
                                                            </address>
                                                        </div>
                                                        <div class="col-6 text-right">
                                                            <address>
                                                                <strong>Entregue para:</strong><br>
                                                               {{ cliente.nome }}<br>
                                                            </address>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6 m-t-30">
                                                            <address>
                                                                <strong>Metodo de pagamento:</strong><br>
                                                                {{ data_order.forma_de_pagamento }} <br>
                                                            </address>
                                                        </div>
                                                        <div class="col-6 m-t-30 text-right">
                                                            <address>
                                                                <strong>Data da venda:</strong><br>
                                                                {{ formatDate(data_order.created_at) }}<br><br>
                                                            </address>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="panel panel-default">
                                                        <div class="p-2">
                                                            <h3 class="panel-title font-20"><strong>Lista de productos entregue</strong></h3>
                                                        </div>
                                                        <div class="">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <td><strong>Producto</strong></td>
                                                                        <td class="text-center"><strong>preco</strong></td>
                                                                        <td class="text-center"><strong>quantidade</strong>
                                                                        </td>
                                                                        <td class="text-right"><strong>Total</strong></td>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    <tr v-for="producto in data_order.productos" v-bind:key="producto.id">
                                                                        <td>{{producto.nome}}</td>
                                                                        <td class="text-center">Akz{{ numberFormat(producto.preco) }}</td>
                                                                        <td class="text-center">{{ producto.pivot.quantidade }}</td>
                                                                        <td class="text-right">Akz{{ numberFormat(producto.pivot.preco * producto.pivot.quantidade)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="no-line"></td>
                                                                        <td class="no-line"></td>
                                                                        <td class="no-line text-center">
                                                                            <strong>Iva</strong></td>
                                                                        <td class="no-line text-right">Akz {{  numberFormat(totalPPN) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="thick-line"></td>
                                                                        <td class="thick-line"></td>
                                                                        <td class="thick-line text-center">
                                                                            <strong>Subtotal</strong></td>
                                                                        <td class="thick-line text-right">Akz {{numberFormat(data_order.total)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="no-line"></td>
                                                                        <td class="no-line"></td>
                                                                        <td class="no-line text-center">
                                                                            <strong>Total</strong></td>
                                                                        <td class="no-line text-right"><h4 class="m-0">{{numberFormat(pagamento.valor)}}</h4></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <div class="d-print-none mo-mt-2">
                                                                <div class="float-right">
                                                                    <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i> Print</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div> <!-- end row -->

                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                        </div><!-- container fluid -->
</Main>
</template>
<script>
export default {
    mounted() {
        let invoice_id = this.$route.params.invoice_id;

        this.displayData(invoice_id);
    },

    data() {
        return {
            invoice_id: '',
            cliente: {},
            pagamento:{},
            data_order: {},
            total_ppn: '',
            productos:{}
        }
    },

    computed: {
        totalPPN() {
            let ppn = 0;
            let iva =0;

            for (let index = 0; index < this.productos.length; index++) {

                 ppn += this.productos[index].preco * this.productos[index].pivot.quantidade
            }
             iva = ppn * 14/100;
            return iva
        }
    },

    methods: {
        displayData(invoice_id) {
            axios.get(`/api/pedido/${invoice_id}`)
                .then(res => {
                    this.data_order = res.data.data;
                    this.cliente   = this.data_order.cliente;
                     this.pagamento = this.data_order.pagamento;
                      this.productos = this.data_order.productos;

                });
        }
    }
}
</script>


