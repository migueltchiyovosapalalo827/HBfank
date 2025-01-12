<template>
    <div class="bg-gray-200 min-vh-100">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link to="/" class="nav-link">INICIO</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/publicidade/promossoes" class="nav-link">Publicidades</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Campaigns Section -->
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row align-items-center product-card">
                        <div class="col-md-6 text-center">
                            <img :src="`${imangen}`" class="imagemdetalhe img-fluid" alt="">
                        </div>
                        <div class="col-md-6">
                            <h1 class="lead titulo-detalhe">{{producto.nome}}</h1>
                            <br>
                            <p class="desc">Preço: {{producto.preco}} AKZ</p>
                            <br>
                            <p class="desc">Descrição: {{producto.descricao}}</p>

                            <a href="#" class="btn btn-color mb-2" @click="addCartItem(producto)">Adicionar ao carrinho</a>
                            <a href="#" class="btn btn-danger mb-2" @click="removeCartItem(producto)">remover do carrinho</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HomeMain from'@/Layouts/HomeMain.vue'
import { mapActions } from 'vuex';
import axios from 'axios';

export default {
  name: 'CartListItem',
  components: {
    HomeMain
  },
  data() {
    return {
      producto: {},
      imangen: ""
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
    getCartItem(id) {
      axios.get(`/api/producto/show/${id}`).then((response) => {
        this.producto = response.data.data;
        this.imangen = this.producto.productoimagens[0].url;
        console.log(this.producto);
      });
    }
  }
}
</script>

<style scoped>
.bg-gray-200 {
    background-color: #e2e2e2;
    /* Cor de fundo cinza */
}

.navbar-dark .navbar-nav .nav-link {
    font-size: 1.2em;
}

.imagemdetalhe {
    max-width: 100%;
    height: auto;
    object-fit: cover;
}

.product-card {
    background-color: #333; /* Background cinza escuro */
    border: 2px solid #555; /* Bordas destacadas */
    border-radius: 10px; /* Bordas arredondadas */
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra para destaque */
    color: #fff; /* Texto branco para contraste */
}

.titulo-detalhe {
    font-size: 2em;
    font-weight: bold;
}

.preco-detalhe {
    font-size: 1.5em;
    color: #ddd;
}

.desc {
    font-size: 1.2em;
}

.ingred {
    margin-bottom: 20px;
}

.btn-color {
    background-color: #ff8c00;
    color: #fff;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}
</style>
