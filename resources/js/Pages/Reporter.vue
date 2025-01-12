<template>
    <Main>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Relatório de Vendas</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Data Inicial:</label>
                            <input type="date" class="form-control" v-model="startDate">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Data Final:</label>
                            <input type="date" class="form-control" v-model="endDate">
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" @click="fetchSales">Buscar Vendas</button>
                <button class="btn btn-secondary" @click="printReport">Imprimir Relatório</button>
                <div class="mt-3">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Data</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sale in sales" :key="sale.id">
                                <td>{{ sale.id }}</td>
                                <td>{{formatDate( sale.created_at) }}</td>
                                <td><span v-for="item in sale.productos">{{ item.nome }} |  </span></td>
                                <td>{{ sale.quantidade }}</td>
                                <td>{{ sale.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </Main>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            startDate: '',
            endDate: '',
            sales: []
        };
    },
    methods: {
        fetchSales() {
            // Aqui você deve fazer a chamada à API para buscar as vendas no período especificado.
            //vamos os dados na api/SalesReporter via metodo post
            axios.post('/api/saleReporter', {
                startDate: this.startDate, endDate: this.endDate
            }).then((response) => {
                console.log(response.data.data)
                this.sales = response.data.data;
            }).catch((error) => {
                console.log(error);
            });



        },
        printReport() {
            window.print();
        }
    }
};
</script>

<style scoped>
.card {
    margin: 20px;
}
</style>
