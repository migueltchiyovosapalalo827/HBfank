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
                      <li class="breadcrumb-item active">Lista de funcionarios</li>
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
                <h3 class="card-title">Lista de funcionarios</h3>

                <div class="card-tools">

                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add New
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                  <Table :fields="fields">
                      <tr v-for="(user,index) in users.data" :key="user.id">

                      <td>{{index+1}}</td>
                      <td class="text-capitalize">{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td>{{formatDate(user.created_at)}}</td>

                      <td>

                        <a href="#" @click="editModal(user)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteUser(user.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </Table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="users" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>




        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Cadastrar Novo Utilizador</h5>
                    <h5 class="modal-title" v-show="editmode">actualiar informação do Utilizador</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->

                <form  @submit.prevent="editmode ? updateUser() : createUser()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                             <div v-if="form.errors.has('name')" v-html="form.errors.get('name')"/>

                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="text" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                          <div v-if="form.errors.has('email')" v-html="form.errors.get('email')"/>

                        </div>
                         <div class="form-group">
                            <label>Endereco</label>
                            <input v-model="form.endereco" type="text" name="endereco"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('endereco') }">
                            <div v-if="form.errors.has('endereco')" v-html="form.errors.get('endereco')"/>

                        </div>
                        <div class="form-group">
                            <label>Telefone</label>
                            <input v-model="form.telefone" type="text" name="telefone"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('telefone') }">
                            <div v-if="form.errors.has('telefone')" v-html="form.errors.get('endereco')"/>

                        </div>
                         <div class="form-group">
                            <label>Data</label>
                            <input v-model="form.data_de_nascimento" type="date" name="data_de_nascimento"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('data_de_nascimento') }" >
                                    <div v-if="form.errors.has('data_de_nascimento')" v-html="form.errors.get('data_de_nascimento')"/>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input v-model="form.password" type="password" name="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" autocomplete="false">
                            <div v-if="form.errors.has('password')" v-html="form.errors.get('password')"/>

                        </div>
                        <div class="form-group">
                            <label>Confirmar Password</label>
                            <input v-model="form.password_confirmation" type="password" name="password_confirmation"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" autocomplete="false">
                            <div v-if="form.errors.has('password_confirmation')" v-html="form.errors.get('password_confirmation')"/>

                        </div>

                        <div class="form-group">
                            <label>Funções</label>
                            <select name="roles_list[]" multiple="multiple" v-model="form.roles_list" id="roles_list" class="form-control" :class="{ 'is-invalid': form.errors.has('roles_list') }">
                                <option v-for="role in roles" :key="role.id" v-bind:value="role.id" :selected="form.roles_list.includes(role.id)" >{{role.name}}</option>

                            </select>
                           <div v-if="form.errors.has('roles_list')" v-html="form.errors.get('roles_list')"/>

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
import { data } from 'autoprefixer';
    export default {
        data () {
            return {
                editmode: false,
                users : {},
                tempUser:{},
                roles:{},
                 fields:['nome','Email','Data de cadastro'],
                form: new Form({
                    id : '',
                    roles_list : [],
                    name: '',
                    email: '',
                    password:"",
                    password_confirmation:"",
                    endereco:"",
                    telefone:"",
                    data_de_nascimento: "",

                })
            }
        },
        methods: {

            getResults(page = 1) {
                  axios.get('api/user?page=' + page).then(({ data }) => (this.users = data.data)).catch((error)=>{
                        if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                  error.response.status === 419 && error.response.statusText ==="Unauthorized"
            ) {
                 this.$store.dispatch('auth/logout');
             }
                  });
            },
            updateUser(){

                // console.log('Editing data');
                this.form.put('api/user/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });

                        //  Fire.$emit('AfterCreate');

                    this.loadUsers();
                })
                .catch((error) => {
                      if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                  error.response.status === 419 && error.response.statusText ==="Unauthorized"
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

            editModal(user){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                    this.form.id = user.id;
                    this.form.name = user.name;
                    this.form.email = user.email;
                    this.form.endereco = user.empregado.endereco;
                    this.form.telefone = user.empregado.telefone;
                    this.form.data_de_nascimento = user.empregado.data_de_nascimento;
                    for (let index = 0; index < user.roles.length; index++) {
                        this.form.roles_list.push(user.roles[index].id);
                    }
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteUser(id){
                Swal.fire({
                    title: 'Você tem certeza que pretendes excluir este usuario?',
                     text: "Você não poderá reverter isso!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                   confirmButtonText: 'Sim, exclua!',
                   cancelButtonText: 'Cancelar'
                    }).then((result) => {

                        // Send request to the server
                         if (result.value) {
                                this.form.delete('api/user/'+id).then((response)=>{
                                        Swal.fire(
                                        'Deleted!',
                                         response.data.message,
                                        'success'
                                        );
                                    // Fire.$emit('AfterCreate');
                                    this.loadUsers();
                                }).catch((data)=> {
                                      if (data.response.status === 401 && data.response.statusText ==="Unauthorized" ||
                                          data.response.status === 419 && data.response.statusText ==="Unauthorized"
                                          ) { this.$store.dispatch('auth/logout');}
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                         }
                    })
            },
          loadUsers(){
              axios.get("api/user").then(({ data }) => (this.users = data.data));
                   },

          loadRoles(){
             axios.get("api/role/all").then(({ data }) => (this.roles = data.data)).catch(
                 (error) => {
             if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                  error.response.status === 419 && error.response.statusText ==="Unauthorized")
                  {
                 this.$store.dispatch('auth/logout');
                 }
                 });

          },

          createUser(){

              this.form.post('/api/user')
              .then((response)=>{
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: response.data.message
                  });


                  this.loadUsers();

              })
              .catch((error)=>{
                 console.log(error);
                   if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                       error.response.status === 419 && error.response.statusText ==="Unauthorized"  )
                       {
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
            this.loadUsers();
            this.loadRoles();

        }
    }
</script>
