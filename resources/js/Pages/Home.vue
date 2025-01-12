<template>
 <HomeMain>
     <div class="intro-header">

            <div class="bg-image parallax-bg"></div>
            <div class="header-content">
                <div class="hero-text-box">

                    <a class="btn my-4 btn-full js--scroll-to-plans" href="#menu">estou com fome</a>
                </div>
            </div>
        </div>
        <div class="content">

            <h1 class="lead titulo">COMIDAS RÁPIDAS COM OS MELHORES PREÇOS</h1>

            <br><br>


        </div>
        <div class="col-md-12 menu-prod" id="menu">
            <h1 class="lead titulo">NOSSO MENU</h1>
            <br><br>
            <div class="container" id="div-produtos">
        <Carousel :items-to-show="2.5" :wrap-around="true">
    <Slide v-for="producto in productItems" :key="producto.id">
      <div class="carousel__item ">
            <div class="item">
           <div class="card card-menu" style="width: 18rem;">
                            <img :src="`${producto.productoimagens[0].url}`"  class="card-img card-img-top" :alt="`${producto.nome}`">
                            <div class="card-overlay">
                                <h5 class="card-title card-titulo px-3">{{producto.preco}} kz</h5>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{producto.nome}}</h5>

                                <button @click="addCartItem(producto)"  class="btn btn-color mb-2">Adicionar ao carrinho</button>
                                <router-link :to="{ name: 'detalhe', params: { id: producto.id } }" class="btn btn-ghost js--scroll-to-start">Detalhes</router-link>
                            </div>
                        </div>
                    </div>
      </div>
    </Slide>
    <template #addons>
      <Navigation />
    </template>
  </Carousel>
            </div>
        </div>



        <di class="fab " @click="checkout()" >
             <i class="bi bi-cart3" style="color: white; font-size: 25pt;"></i><span style="color: white; font-size: 18pt;"
             >{{cartQuantity}}</span>  </di>

          <CartList></CartList>
</HomeMain>
</template>

<script>
import { defineComponent } from 'vue'
import { Carousel, Navigation, Slide } from 'vue3-carousel';
import {mapGetters, mapActions} from "vuex";
import CartList from '@/Pages/Cart_List';
import 'vue3-carousel/dist/carousel.css';
import HomeMain from '@/Layouts/HomeMain.vue';
export default defineComponent({
  name: 'WrapAround',
  components: {
      CartList,
    Carousel,
    Slide,
    Navigation,
    HomeMain
  },
      computed: {
    ...mapGetters(['cartQuantity','productItems']),

  },
  created() {
   this.$store.dispatch("getCartItems");
     this.$store.dispatch('getProductItems');
  },
mounted() {
   var $parallaxElement = $('.parallax-bg');
    var elementHeight = $parallaxElement.outerHeight();

    function parallax() {

        var scrollPos = $(window).scrollTop();
        var transformValue = scrollPos / 40;
        var opacityValue = 1 - (scrollPos / 2000);
        var blurValue = Math.min(scrollPos / 100, 3);

    }

    $(window).scroll(function () {
        parallax();


    });

    $(window).scroll(function () {
        var scroll = $(window).scrollTop();

        if (scroll > 500) {
            $('.menu').css('background-color', 'white');
            $('.nav-item a').css('color', '#333');
        } else {
            $('.menu').css('background-color', '');
            $('.nav-item a').css('color', '');
        }
    });



},
data() {
    return {

    }
},

methods:{
    checkout(){
        $('#staticBackdrop').modal('show');
    },

    loadProducto(){
         axios.get('api/producto/all')
                    .then(res => {
                        this.productos = res.data.data;
                        console.log(this.productos);
                    });
    },
    ...mapActions(["addCartItem"]),

    //makes a function that receives a notification about the status of the client's order with laravel echo server
    listenToNotification() {
        Echo.channel('order-channel')
            .listen('OrderStatusChanged', (e) => {
                console.log(e);
            });
    },

}
});
</script>


<style scoped>
.carousel__slide > .carousel__item {
  transform: scale(1);
  opacity: 0.5;
  transition: 0.5s;
}
.carousel__slide--visible > .carousel__item {
  opacity: 1;
  transform: rotateY(0);
}
.carousel__slide--next > .carousel__item {
  transform: scale(0.9) translate(-10px);
}
.carousel__slide--prev > .carousel__item {
  transform: scale(0.9) translate(10px);
}
.carousel__slide--active > .carousel__item {
  transform: scale(1.1);
}
</style>
