<template>

<Main>
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Vendas</h1>
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
        <div class="col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-8">
                            <h4 class="mt-0 header-title">Historico de vendas</h4>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-lg" id='transaction-table'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>cliente</th>
                                    <th>Total pago</th>
                                    <th>data</th>
                                    <th>Acção</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in transactions" :key="data.id">
                                    <td>{{ index +1}}</td>
                                    <td>{{ data.cliente.nome }}</td>
                                    <td>Akz: {{ numberFormat(data.pagamento.valor) }}</td>
                                    <td>{{ formatDate(data.created_at) }}</td>
                                    <td>
                                        <router-link  :to="{ path: `/factura/${data.id}` }" class="btn btn-primary btn-sm">ver factura</router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                            <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
              <li class="page-item "><a class="page-link" href="#" @click=" prevPage()">{{"<<"}}</a></li>
              <li class="page-item active"><a class="page-link" href="#">{{current_page}}</a></li>
              <li class="page-item"><a class="page-link" href="#" @click="nextPage()">{{">>"}}</a></li>

            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->
                </div>
            </div>

        </div>

    </div>

    <!-- end row -->

</div><!-- container fluid -->
</Main>
</template>

<script>
import moment from 'moment';
export default {
    mounted() {
        this.displayData();
    },

    data() {
        return {
            transactions:{},
            page: 1,
            search: '',
            current_page: this.$route.query.page || 1,


        }
    },

    methods: {
       displayData(page=1,search="") {
           axios.get('/api/pedidos/history?page=' + page,{ params: { 'search': search }})
            .then(res => {
                this.transactions = res.data.data.data;
               this.current_page = page;
            }).catch(err => console.log(err.response));
       },

       invoiceTransaction(id) {

       },

       nextPage() {
            this.current_page +=1
            this.displayData(this.current_page, this.search);
        },

        prevPage() {


         this.current_page =  (this.current_page == 1) ? this.current_page : this.current_page -=1;

            this.displayData(this.current_page, this.search);
        },
    }
}
</script>
