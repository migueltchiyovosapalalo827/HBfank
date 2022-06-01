<template>
    <Main>
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de Funções</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Funções</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h2 class="card-title">Lista de Funções</h2>
               <div class="card-tools">

                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add Função
                  </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <Table :fields="fields">
                <tr v-for="(item, index) in roles.data" :key="item.id">
                            <td>{{index+1}}</td>
                            <td>{{item.name}}</td>
                            <td> <span v-for="(permission, index) in item.permissions" :key="index"> {{permission.name}} | </span> </td>
                            <td>
                            <div class="btn-group btn-group-sm">
                                <a @click="editModal(item)" class="btn btn-primary btn-edit"><i class="fas fa-user-edit"></i></a>
                                <a  @click="deleteRole(item)" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                            </div>
                            </td>
               </tr>
                </Table>

            </div>
            <!-- /.card-body -->
          </div>
            <div class="card-footer">
               <pagination :data="roles" @pagination-change-page="getResults"></pagination>
             </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Cadastrar Nova Função</h5>
                    <h5 class="modal-title" v-show="editmode">actualiar informação da Função</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateRole() : createRole()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                             <div v-if="form.errors.has('name')" v-html="form.errors.get('name')"/>
                        </div>

                <div class="form-group">
                  <label>Permissões</label>
                  <select class=" form-control" v-model="form.permissions_list" multiple name="permissions_list[]" id="permissions_list"  :class="{ 'is-invalid': form.errors.has('permissions_list') }">
                    <option v-for="(item, index) in permissions" v-bind:value="item.id" :key="index" :selected="form.permissions_list.includes(item.id)" >{{item.name}}</option>
                  </select>
                    <div v-if="form.errors.has('permissions_list')" v-html="form.errors.get('permissions_list')"/>
                </div>
                <!-- /.form-group -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Actualizar</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">salvar</button>
                    </div>
                  </form>
                </div>
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
        fields:['nome','permissões'],
        editmode: false,
        roles:{},
        permissions:{},
        form: new Form({
             id:"",
             name:"",
             permissions_list: [],
        })
    }
},
methods: {
        getResults(page = 1) {
                  axios.get('api/role?page=' + page).then(({ data }) => (this.roles = data.data)).catch((error)=>{

                       if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                  });
            },
          newModal(){
                this.editmode = false;
                this.form.reset();

               $('#addNew').modal('show');

            },
       loadRole(){
         axios.get("api/role").then(( response) => {
             this.roles = response.data.data;
         }).catch((error)=>{

                       if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                  });
         },

            updateRole(){

                this.form.put('api/role/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });

                    this.loadRole();
                })
                .catch((error) => {
                     if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                });

            },
            editModal(role){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.name= role.name;
                this.form.id = role.id;

                for (let index = 0; index < role.permissions.length; index++)
                 {
                    this.form.permissions_list.push(role.permissions[index].id);

                }


            },

      createRole(){

              this.form.post('api/role')
              .then((response)=>{
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: response.data.message
                  });

                  this.loadRole();

              })
              .catch((error)=>{
            if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}

                            Toast.fire({
                            icon: 'error',
                            title: error.message,
                        });
                    console.log(error.response.data.message);
              })
          },
    deleteRole(item){

        Swal.fire({
               title: 'Você tem certeza que pretendes excluir esta função?',
                text: "Você não poderá reverter isso!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!',
                cancelButtonText: 'Cancelar'
            })
            .then((result) => {
                if (result.value) {

                    this.form.delete('api/role/'+item.id).then((response) => {
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message,
                        });
                        this.loadRole();

                    }).catch((error) => {
                         if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                        Toast.fire({
                            icon: 'error',
                            title: error.message,
                        });
                    })
                }
            })},

            loadPermissios()
            {
                axios.get('api/permission/all').then((response)=>{
                   this.permissions = response.data.data;
                }).catch((error)=>{
                    if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                });
            }
},
created()
{
    this.loadRole();
    this.loadPermissios();
},
}
</script>

