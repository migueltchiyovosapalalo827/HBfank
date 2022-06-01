<template>
<Main>
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Encomenda nº {{pedido_id}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Encomendas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
        <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">informação da Encomenda</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">

              <div class="row">
                <div class="col-12">
                  <h4>Productos</h4>
                    <div class="post clearfix" v-for="item in productos" :key="item.id">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="" >
                        <span class="username">
                          <a href="#">{{item.nome}}.</a>
                        </span>
                        <span class="description"> Akz: {{item.preco}}</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                       Quantidade encomendada: {{item.pivot.quantidade}}.
                      </p>

                      <p>
                       <i class="fas fa-link mr-1"></i> Subtotal: {{item.preco * item.pivot.quantidade}} Akz
                      </p>
                    </div>
                      <h3>Total a pagar: <strong>{{ data_pedido.total}}</strong></h3>

                </div>
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
              <h5 class="mt-5 text-muted">informação do cliente</h5>
              <ul class="list-unstyled">
                <li>
                 <p class="text-sm">Nome
                  <b class="d-block">{{cliente.nome}}</b>
                </p>
                </li>
                <li>
                  <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-envelope"></i> {{cliente.telefone}}</a>
                </li>

              </ul>
              <div class="text-center mt-5 mb-3">
                  <h4>Estado do pedido</h4>
                <a href="#" class="btn btn-sm btn-primary">Add files</a>
                <a href="#" class="btn btn-sm btn-warning">Report contact</a>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
</Main>
</template>

<script>
export default {
    mounted() {
       this.pedido_id = this.$route.params.pedido_id;
      this.getPedido(this.pedido_id);
    },

    data() {
        return {
            pedido_id:'',
            cliente: {},
            pagamento:{},
            data_pedido: {},
            productos:{}
        }
    },
    methods: {
        getPedido(pedido_id){
               axios.get(`/api/pedido/show/${pedido_id}`)
                .then(res => {
                    console.log(res);
                    this.data_pedido = res.data.data;
                    this.cliente   = this.data_pedido.cliente;
                      this.productos = this.data_pedido.productos;

                });
        }
    },
}
</script>

<style>

</style>"
