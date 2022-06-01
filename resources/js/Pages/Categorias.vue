<template>
<Main>
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de Categoria</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Categoria</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de Categorias</h3>

                <div class="card-tools">

                  <button type="button" class="btn btn-sm btn-primary" @click="newModal()">
                      <i class="fa fa-plus-square"></i>
                      Add Categoria
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                   <Table :fields="fields">
                       <tr v-for="(item, index) in categorias.data" :key="item.id">
                            <td>{{index+1}}</td>
                            <td>{{item.nome}}</td>
                            <td>{{item.descricao}}</td>
                            <td>
                            <div class="btn-group btn-group-sm">
                                <a @click="editModal(item)" class="btn btn-primary btn-edit"><i class="fas fa-user-edit"></i></a>
                                <a  @click="deleteCategoria(item)" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                            </div>
                            </td>
                       </tr>
                   </Table>

              </div>
                <div class="card-footer">
                    <pagination :data="categorias" @pagination-change-page="getResults"></pagination>

             </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Cadastrar Nova categoria</h5>
                    <h5 class="modal-title" v-show="editmode">actualiar informação da categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateCategoria() : createCategoria()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <input v-model="form.nome" type="text" name="nome"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('nome') }">
                            <div v-if="form.errors.has('nome')" v-html="form.errors.get('nome')"/>
                        </div>
                        <div class="form-group">
                            <label>descrição</label>
                            <textarea  v-model="form.descricao"  name="descricao"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('descricao') }" cols="30" rows="10"></textarea>

                            <div v-if="form.errors.has('descricao')" v-html="form.errors.get('descricao')"/>
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
    </div>
  </section>
</Main>
</template>

<script>
    export default {
        data () {
            return {
              categorias : {},
              editmode: false,
              // Create a new form instance
              fields: ['nome','descrição'],
              form: new Form({
                  id : '',
                  nome: '',
                  descricao: '',
              })
            }
        },
        methods: {

            getResults(page = 1) {
                  axios.get('api/categoria?page=' + page).then(( {data} ) => (this.categorias = data.data)).catch((error)=>{

                       if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                  });
            },

          loadCategories(){
            // if(this.$gate.isAdmin()){
              axios.get("api/categoria").then(({ data }) => (this.categorias = data.data))
              .catch((error)=>{
                       if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
              });
            // }
          },
              newModal(){
                this.editmode = false;
                this.form.reset();
               $('#addNew').modal('show');

            },
           updateCategoria(){

                this.form.put('api/categoria/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });

                    this.loadCategories();
                })
                .catch((error) => {
                     if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                });

            },
            editModal(categoria){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(categoria);
            },



          createCategoria(){

              this.form.post('api/categoria')
              .then((data)=>{
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });

                  this.loadCategories();

              })
              .catch((error)=>{
            if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })
          },

          deleteCategoria(item){

        Swal.fire({
               title: 'Você tem certeza que pretendes excluir esta Categoria?',
                text: "Você não poderá reverter isso!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!',
                cancelButtonText: 'Cancelar'
            })
            .then((result) => {
                if (result.value) {

                    this.form.delete('api/categoria/'+item.id).then((response) => {
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message,
                        });
                        this.loadCategorias();

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
        mounted() {

        },
        created() {

            this.loadCategories();
        }
    }
</script>
