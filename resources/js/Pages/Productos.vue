<template>
 <Main>
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de Productos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Productos</li>
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
                <h3 class="card-title">Lista de Productos</h3>

                <div class="card-tools">

                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add Producto
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                  <Table :fields="fields">
                      <tr v-for="(item , index) in productos.data" :key="item.id">
                      <td>{{index + 1}}</td>
                      <td>{{item.nome}}</td>
                      <td>{{ truncate(item.descricao,30,'...') }}</td>
                      <td>{{item.preco}}</td>
                      <td>{{item.categoria.nome}}</td>
                      <td>
                 <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                  <div class="carousel-inner">
                    <div class="carousel-item active"  v-for="(foto, index) in item.productoimagens" :key="index" :class="{ 'active':index === 0 }">
                      <img width="40"  v-bind:src=" (foto) ? foto.url :'/assets/img/default-profile.png'" alt="First slide">
                    </div>
                  </div>
                </div>

             </td>
                      <td>

                        <a href="#" @click="editModal(item)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteProducto(item.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </Table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="productos" @pagination-change-page="getResults"></pagination>
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
                   <h5 class="modal-title" v-show="!editmode">Cadastrar Novo Producto</h5>
                    <h5 class="modal-title" v-show="editmode">actualiar informação do Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateProduct() : createProduct()" enctype="multipart/form-data"  >
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <input v-model="form.nome" type="text" name="nome"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('nome') }">
                            <div v-if="form.errors.has('nome')" v-html="form.errors.get('nome')"/>
                        </div>
                        <div class="form-group">
                            <label>Descrição</label>
                            <textarea v-model="form.descricao"  name="descricao"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('descricao') }">
                            </textarea>
                           <div v-if="form.errors.has('descricao')" v-html="form.errors.get('descricao')"/>
                        </div>
                        <div class="form-group">
                            <label>Preço</label>
                            <input v-model="form.preco" type="number" step="0.01" name="preco"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('preco') }">
                            <div v-if="form.errors.has('preco')" v-html="form.errors.get('preco')"/>
                        </div>
                        <div class="form-group">

                            <label>Categoria</label>
                            <select class="form-control" v-model="form.categoria" :class="{ 'is-invalid': form.errors.has('categoria') }">
                              <option
                                  v-for="(categoria,index) in categorias" :key="index"
                                  :value="categoria.id"
                                  :selected="categoria.id == form.categoria">{{ categoria.nome }}</option>
                            </select>
                           <div v-if="form.errors.has('categoria')" v-html="form.errors.get('categoria')"/>
                        </div>
                        <div class="form-group">
                            <label>Fotografia</label>
                            <input  type="file" name="imagens[]" multiple @change="handleFile"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('imagens') }">
                            <div v-if="form.errors.has('imagens')" v-html="form.errors.get('imagens')"/>
                        </div>
                        <div v-if="form.progress">Progresso: {{form.progress.percentage}} %</div>

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
import { serialize } from 'object-to-formdata/src';
import axios from 'axios';
import { data } from 'autoprefixer';

    export default {

        data () {
            return {
                editmode: false,
                productos : {},
               fields:['Nome','Descrição','Preço','categoria','foto'] ,
                form: new Form({
                    id : '',
                    nome: '',
                    descricao: '',
                    categoria: '',
                    preco: '',
                    imagens: [],
                }),
                categorias: {},
            }
        },
        methods: {
          handleFile(event)
          {
              for (let index = 0; index < event.target.files.length; index++) {
                  const file =  event.target.files[index];
                   this.form.imagens.push(file);
              }

                 /*const file =  event.target.files;
                this.form.imagens.push = file[0];*/
          },
          getResults(page = 1) {

              this.$Progress.start();

              axios.get('api/producto?page=' + page).then(({ data }) => (this.productos = data.data))
              .catch((error)=>{
                    if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
              });

              this.$Progress.finish();
          },
          loadProductos(){

            // if(this.$gate.isAdmin()){
              axios.get("api/producto").then(({ data }) => (this.productos = data.data)).catch((error)=>{
                    if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
              });

            // }
          },
          loadCategorias(){
              axios.get("api/categoria/all").then(({ data }) => (this.categorias = data.data)).catch((error)=>{
                    if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
              });
          },

          editModal(product){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.id = product.id;
              this.form.nome = product.nome;
              this.form.descricao = product.descricao;
              this.form.categoria = product.categoria.id;
              this.form.preco = product.preco;

          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
        async  createProduct(){
            //console.log(serialize());
            await  this.form.post('api/producto',{headers:{'Content-Type':'multipart/form-data'}})
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });

                  this.loadProductos();

                } else {
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });

                }
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
          getFormData(object,method){
              const formdata = new FormData();
              Object.keys(object).forEach(key=>{
                          if ( Array.isArray(object[key])) {
                              for (const index of Object.keys(object[key])) {
                                  formdata.append(key+'['+index+']',object[key][index])
                              }
                          } else
                          {
                            formdata.append(key,object[key])
                          }
                 });
              formdata.append('_method',method);
              return formdata;
          }
          ,
         async updateProduct(){

             await axios.post('api/producto/'+this.form.id,this.getFormData(this.form,'PUT'),{headers:{'Content-Type':'multipart/form-data'}})
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });

                  this.loadProductos();
              })
              .catch((error) => {
                   if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}

                   Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              });

          },
          deleteProducto(id){
              Swal.fire({
                 title: 'Você tem certeza que pretendes excluir este Producto?',
                text: "Você não poderá reverter isso!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!',
                cancelButtonText: 'Cancelar'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                              this.form.delete('api/producto/'+id).then((response)=>{
                                      Swal.fire(
                                      'Deleted!',
                                      response.data.message,
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadProductos();
                              }).catch((data)=> {
                                   if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                          error.response.status === 419 && error.response.statusText ==="Unauthorized" )
                          { this.$store.dispatch('auth/logout');}
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
          },

        },
        mounted() {

        },
        created() {

            this.loadProductos();

            this.loadCategorias();
        },

        computed: {
          filteredItems() {
            return this.autocompleteItems.filter(i => {
              return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
          },
        },
    }
</script>
