<template>
  <Main>
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de Bairros</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Bairros</li>
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
              <h2 class="card-title">Lista de Bairros</h2>
               <div class="card-tools">

                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add Bairros
                  </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <Table :fields="fields">
                <tr v-for="(item, index) in bairros.data" :key="item.id">
                            <td>{{index+1}}</td>
                            <td>{{item.nome}}</td>
                            <td>  {{item.cidade.nome}}   </td>
                            <td>
                            <div class="btn-group btn-group-sm">
                                <a @click="editModal(item)" class="btn btn-primary btn-edit"><i class="fas fa-user-edit"></i></a>
                                <a  @click="deleteBairro(item)" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                            </div>
                            </td>
               </tr>
                </Table>

            </div>
            <!-- /.card-body -->
          </div>
            <div class="card-footer">
               <pagination :data="bairros" @pagination-change-page="getResults"></pagination>
             </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row -->

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" cidade="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" cidade="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Cadastrar Novo Bairro</h5>
                    <h5 class="modal-title" v-show="editmode">actualiar informação do Bairro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateBairro() : createBairro()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <input v-model="form.nome" type="text" name="nome"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('nome') }">
                             <div v-if="form.errors.has('nome')" v-html="form.errors.get('nome')"/>
                        </div>

                <div class="form-group">
                  <label>Cidade</label>
                  <select class="form-control" style="width: 100%;" v-model="form.cidade"  name="cidade" id="cidade"  :class="{ 'is-invalid': form.errors.has('cidade') }">
                    <option v-for="(item, index) in cidades" v-bind:value="item.id" :key="index" :selected="form.cidade == item.id" >{{item.nome}}</option>
                  </select>
                    <div v-if="form.errors.has('cidade')" v-html="form.errors.get('cidade')"/>
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
        fields:['nome','cidade'],
        editmode: false,
        bairros:{},
        cidades:{},
        form: new Form({
             id:"",
             nome:"",
             cidade:Number,
        })
    }
},
methods: {
        getResults(page = 1) {
                  axios.get('api/bairro?page=' + page).then(({ data }) => (this.bairros = data.data)).catch((error)=>{

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
       loadBairro(){
         axios.get("api/bairro").then(( response) => {
             this.bairros = response.data.data;
         }).catch((error)=>{

                       if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                  });
         },

            updateBairro(){

                this.form.put('api/bairro/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');

                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });

                    this.loadcidade();
                })
                .catch((error) => {
                     if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                });

            },
            editModal(bairro){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');

                this.form.nome= bairro.nome;
                this.form.id = bairro.id;
                this.form.cidade = bairro.cidade.id;
            },

      createBairro(){

              this.form.post('api/bairro')
              .then((response)=>{
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: response.data.message
                  });

                  this.loadBairro();

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
    deleteBairro(item){

        Swal.fire({
               title: 'Você tem certeza que pretendes excluir esta cidade?',
                text: "Você não poderá reverter isso!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!',
                cancelButtonText: 'Cancelar'
            })
            .then((result) => {
                if (result.value) {

                    this.form.delete('api/bairro/'+item.id).then((response) => {
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message,
                        });
                        this.loadBairro();

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

            loadCidades()
            {
                axios.get('api/cidade/all').then((response)=>{
                   this.cidades = response.data.data;
                }).catch((error)=>{
                    if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                });
            }
},
created()
{
    this.loadBairro();
    this.loadCidades();
},
}
</script>

