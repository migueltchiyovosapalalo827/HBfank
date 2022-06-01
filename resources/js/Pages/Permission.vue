<template>
  <Main>
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de permissões</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">permissões</li>
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
              <h2 class="card-title">Lista de permissões</h2>

               <div class="card-tools">

                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add Permissão
                  </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">

                <Table :fields="fields">
                      <tr v-for="(item, index) in permissions.data" :key="item.id">
                            <td>{{index+1}}</td>
                            <td>{{item.name}}</td>
                            <td>
                            <div class="btn-group btn-group-sm">
                                <a @click="editModal(item)" class="btn btn-primary btn-edit"><i class="fas fa-user-edit"></i></a>
                                <a  @click="deletePermission(item)" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                            </div>
                            </td>
                            </tr>
                </Table>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                    <pagination :data="permissions" @pagination-change-page="getResults"></pagination>

             </div>
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
                    <h5 class="modal-title" v-show="!editmode">Cadastrar Nova Permissão</h5>
                    <h5 class="modal-title" v-show="editmode">actualiar informação da Permissão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updatePermission() : createPermission()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                             <div v-if="form.errors.has('name')" v-html="form.errors.get('name')"/>

                        </div>

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

export default {

data() {
    return {
        fields:['nome'],
        editmode: false,
        permissions:{},
        form: new Form({
             id:"",
             name: '',
        })
    }
},
methods: {
        getResults(page = 1) {
                  axios.get('api/permission?page=' + page).then(( {data} ) => (this.permissions = data.data)).catch((error)=>{

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
       loadPermission(){
         axios.get("api/permission").then(( { data }) => {this.permissions = data.data;}).catch((error)=>
         {             if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
        });
         },

            updatePermission(){

                this.form.put('api/permission/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });

                    this.loadPermission();
                })
                .catch((error) => {
                     if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                });

            },
            editModal(permission){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(permission);
            },

      createPermission(){

              this.form.post('api/permission')
              .then((response)=>{
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: response.data.message
                  });

                  this.loadPermission();

              })
              .catch((error)=>{
            if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}

              })
          },
    deletePermission(item){

        Swal.fire({
               title: 'Você tem certeza que pretendes excluir esta permissão?',
                text: "Você não poderá reverter isso!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!',
                cancelButtonText: 'Cancelar'
            })
            .then((result) => {
                if (result.value) {

                    this.form.delete('api/permission/'+item.id).then((response) => {
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message,
                        });
                        this.loadPermission();

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
            })}
},
created()
{
    this.loadPermission();
},
}
</script>

