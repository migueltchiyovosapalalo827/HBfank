<template>
    <div class="page">
        <main>
            <nav class="navbar menu navbar-expand-lg navbar-dark" aria-label="Tenth navbar example">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Never expand</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="bi bi-menu-up btn-icone"></i>
                    </button>

                    <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
                        <ul class="navbar-nav">
                            <li class="nav-item nav-items">
                                <a class="nav-link" href="index.html">INICIO</a>
                            </li>
                            <li class="nav-item nav-items">
                                <a class="nav-link" href="#">MENU</a>
                            </li>
                            <li class="nav-item nav-items">
                                <a class="nav-link" href="#">SOBRE</a>
                            </li>
                            <li class="nav-item nav-items">
                                <a class="nav-link" href="#">CONTACTOS</a>
                            </li>
                            <li class="nav-item nav-items dropdown menu-perfil">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-circle"></i></a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown01">
                                  <li><a class="dropdown-item" href="#">Action</a></li>
                                  <li><a class="dropdown-item" href="#">Another action</a></li>
                                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                              </li>
                        </ul>
                    </div>
                </div>
            </nav>

<div class="col-md-12 px-lg-5">
                <div class="row  px-lg-5" style="width: 100%;">
                    <div class="col-md-6">
                        <img src="/storage/imagens/Cachorro quentecachorro-quente-com-mostarda-amarela-e-ketchup-na-tabua-de-madeira_93675-89324.webp" width="500" height="500" class="imagemdetalhe" alt="">
                    </div>
                    <div class="col-md-6 p-5">
                        <h1 class="lead titulo-detalhe">{{producto.nome}}</h1>
                        <br>
                        <p class="desc">Preço</p>
                        <h1 class="preco-detalhe">{{producto.preco}} AKZ</h1>
                        <br>
                        <p class="desc">Ingredientes</p>
                        <div class="ingred">
                            {{producto.descrecao}}
                        </div>
                        <a href="#" class="btn btn-color mb-2" @click="addCartItem(producto)">Adicionar ao carrinho</a>
                        <a href="#" class="btn btn-danger mb-2" @click="removeCartItem(producto)">remover do  carrinho</a>
                    </div>
                   </div>

            </div>
            </main>


        <div class="col-md-12 myfooter">
            <div class="container">
                <footer class="d-flex flex-wrap justify-content-between align-items-center py-3">
                    <ul class="nav col-md-6 justify-content-start">
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
                      </ul>

                    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                        <li class="ms-3"><a class="text-muted" href="#"><i class="bi bi-facebook"  style="color: rgb(177, 177, 177); font-size: 15pt;"></i></a></li>
                        <li class="ms-3"><a class="text-muted" href="#"><i class="bi bi-whatsapp"  style="color: rgb(177, 177, 177); font-size: 15pt;"></i></a></li>
                        <li class="ms-3"><a class="text-muted" href="#"><i class="bi bi-instagram"  style="color: rgb(177, 177, 177); font-size: 15pt;"></i></a></li>
                    </ul>
                  </footer>
            </div>
          </div>

    </div>
</template>
<script>



import HomeMain from'@/Layouts/HomeMain.vue'
import { mapActions , mapGetters} from 'vuex';
import axios from 'axios';
export default {
  name: 'CartListItem',
  components:{
   HomeMain
  },

data() {
        return {
          producto:{}
        }
    },
    mounted() {
   this.getCartItem(this.$route.params.id);
    },

  methods: {
    ...mapActions([
      'addCartItem',
      'removeCartItem'
    ]),
    getCartItem(id){
 axios.get(`/api/producto/show/${id}`).then((response)=>{
   this.producto = response.data.data;
   console.log(this.producto.productoimagens[0].url);
    });
    }
  }
}
</script>
