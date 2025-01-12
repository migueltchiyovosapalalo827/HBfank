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
                            <li class="breadcrumb-item active">Lista de clientes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-12">

                        <div class="card" v-if="is('admin')">
                            <div class="card-header">
                                <h3 class="card-title">Lista de clientes</h3>

                                <div class="card-tools">

                                    <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                                        <i class="fa fa-plus-square"></i>
                                        Add
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <Table :fields="fields">
                                    <tr v-for="(cliente, index) in clientes.data" :key="cliente.id">

                                        <td>{{ index + 1 }}</td>
                                        <td class="text-capitalize">{{ cliente.user.name }}</td>
                                        <td>{{ cliente.user.email }}</td>
                                        <td>{{ cliente.telefone }}</td>

                                        <td>

                                            <a href="#" @click="editModal(cliente)">
                                                <i class="fa fa-edit blue"></i>
                                            </a>
                                            /
                                            <a href="#" @click="deleteCliente(cliente.id)">
                                                <i class="fa fa-trash red"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </Table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <pagination :data="clientes" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>




                <!-- Modal -->
                <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editmode">Cadastrar Novo cliente</h5>
                                <h5 class="modal-title" v-show="editmode">actualiar informação do cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <!-- <form @submit.prevent="createCliente"> -->

                            <form @submit.prevent="editmode ? updateCliente() : createCliente()">
                                <div class="modal-body">
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
                                                :selected="form.bairros == bairro.id">
                                                {{ bairro.cidade.nome }}-{{ bairro.nome }}</option>

                                        </select>
                                        <div v-if="form.errors.has('bairro')" v-html="form.errors.get('bairro')" />

                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input v-model="form.password" type="password" name="password"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }"
                                            autocomplete="false">
                                        <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" />

                                    </div>
                                    <div class="form-group">
                                        <label>Confirmar Password</label>
                                        <input v-model="form.password_confirmation" type="password"
                                            name="password_confirmation" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                                            autocomplete="false">
                                        <div v-if="form.errors.has('password_confirmation')"
                                            v-html="form.errors.get('password_confirmation')" />

                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                    <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Main>
</template>

<script>
export default {
    data() {
        return {
            editmode: false,
            clientes: {},
            tempcliente: {},
            bairros: {},
            fields: ['Nome', 'Email', 'Telefone'],
            form: new Form({
                id: '',
                name: '',
                email: '',
                password: "",
                password_confirmation: "",
                bairro: "",
                telefone: "",

            })
        }
    },
    methods: {

        getResults(page = 1) {
            axios.get('api/cliente?page=' + page).then(({ data }) => (this.clientes = data.data)).catch((error) => {
                if (error.response.status === 401 && error.response.statusText === "Unauthorized" ||
                    error.response.status === 419 && error.response.statusText === "Unauthorized"
                ) {
                    this.$store.dispatch('auth/logout');
                }
            });
        },
        updateCliente() {

            // console.log('Editing data');
            this.form.put('api/cliente/' + this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });

                    //  Fire.$emit('AfterCreate');

                    this.loadclientes();
                })
                .catch((error) => {
                    if (error.response.status === 401 && error.response.statusText === "Unauthorized" ||
                        error.response.status === 419 && error.response.statusText === "Unauthorized"
                    ) {
                        this.$store.dispatch('auth/logout');
                    }
                    Toast.fire({
                        icon: 'error',
                        title: error.response.data.message
                    });
                    console.log(error.response.data.data);
                });

        },

        editModal(cliente) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.id = cliente.id;
            this.form.name = cliente.user.name;
            this.form.email = cliente.user.email;
            this.form.bairro = cliente.bairro.id;
            this.form.telefone = cliente.telefone;
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        deleteCliente(id) {
            Swal.fire({
                title: 'Você tem certeza que pretendes excluir este cliente ?',
                text: "Você não poderá reverter isso!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, exclua!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {

                // Send request to the server
                if (result.value) {
                    this.form.delete('api/cliente/' + id).then((response) => {
                        Swal.fire(
                            'Deleted!',
                            response.data.message,
                            'success'
                        );
                        // Fire.$emit('AfterCreate');
                        this.loadclientes();
                    }).catch((data) => {
                        if (data.response.status === 401 && data.response.statusText === "Unauthorized" ||
                            data.response.status === 419 && data.response.statusText === "Unauthorized"
                        ) { this.$store.dispatch('auth/logout'); }

                        Swal.fire("Failed!", data.response.data.data, "warning");
                    });
                }
            })
        },
        loadclientes() {
            axios.get("api/cliente").then(({ data }) => (this.clientes = data.data));
        },

        loadBairros() {
            axios.get("api/bairro/all").then(({ data }) => (this.bairros = data.data)).catch(
                (error) => {
                    if (error.response.status === 401 && error.response.statusText === "Unauthorized" ||
                        error.response.status === 419 && error.response.statusText === "Unauthorized") {
                        this.$store.dispatch('auth/logout');
                    }
                });

        },

        createCliente() {

            this.form.post('api/cliente')
                .then((response) => {
                    $('#addNew').modal('hide');

                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });


                    this.loadclientes();

                })
                .catch((error) => {
                    console.log(error);
                    if (error.response.status === 401 && error.response.statusText === "Unauthorized" ||
                        error.response.status === 419 && error.response.statusText === "Unauthorized") {
                        this.$store.dispatch('auth/logout');
                    }
                    Toast.fire({
                        icon: 'error',
                        title: error.response.data.message
                    });
                })
        }

    },
    mounted() {

    },
    created() {
        this.loadclientes();
        this.loadBairros();

    }
}
</script>
