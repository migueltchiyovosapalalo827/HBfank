<template>
<Main>
  <div class="content-header">
              <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1 class="m-0 text-dark"></h1>
                  </div>
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                  </div>
                </div>
              </div><!-- /.container-fluid -->
            </div>
 <section class="content">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-percent "></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"> de vendas </span>
                            <span class="info-box-number">
                          {{data.percentagem_de_vendas}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Clientes Satisfeito</span>
                            <span class="info-box-number">{{data.clientes_satisfeito}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Vendas</span>
                            <span class="info-box-number">{{data.productos_vendidos}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Clientes novos</span>
                            <span class="info-box-number">{{data.clientes}}</span>
                        </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- MAP & BOX PANE -->
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pedidos Recentes</h3>

                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>cliente</th>
                                    <th>Estado</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in data.pedidos" :key="item.id">
                                    <td> <router-link  :to="{ path: `/factura/${item.id}` }">{{ item.id}}</router-link></td>
                                    <td>{{item.cliente.nome}}</td>
                                    <td><span class="badge " :class="Status(item.estado)">{{item.estado}}</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#00a65a" data-height="20">{{item.total}}</div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        </div>
                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="col-md-4">
                <!-- Info Boxes Style 2 -->
                <div class="info-box mb-3 bg-secondary">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Productos disponivel</span>
                    <span class="info-box-number">{{data.productos}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-info">
                <span class="info-box-icon"><i class="far fa-comment"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Messagens</span>
                    <span class="info-box-number">163,921</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
</Main>
</template>

<script>
export default {
    mounted() {
        // console.log("INI HOME ADMINz");
        this.displayData();
    },


    data() {
        return {
            data: [],
        }
    },
    computed:{

    },

    methods: {
        displayData() {
            axios.get('/api/home')
                .then(res => {
                    this.data = res.data;

                })
        },

         Status (params) {


              switch (params) {
                   case 'pendente':
                    return 'badge-warning';
                     break;
                    case 'aceito':
                     return  'badge-success';
                    break;
                      case 'rejeitado':
                         return 'badge-danger'
                            break;
                        case 'entregue':
                         return   'badge-info'
                          break;
                      case 'recusado':
                     return   'badge-danger'
                      break;

                  default:
                      return   'badge-info'
                      break;
              }
        }
    }
}
</script>

