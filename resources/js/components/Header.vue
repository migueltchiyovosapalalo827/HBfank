<template>

          <!-- Navbar -->
          <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
              </li>
            </ul>

            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
             <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{notification.length}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu dropdown-menu-right"  >
          <div  v-for="item in notification" :key="item.id" >
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" @click="readNotification(item)">
            <i class="fas fa-envelope mr-2"></i> O cliente  {{item.cliente.nome}} fez um pedido
            <span class="float-right text-muted text-sm">{{formatDate(item.created_at)}}</span>
          </a>
          <br>
          <div class="dropdown-divider"></div>
          </div>
          <a href="#" class="dropdown-item dropdown-footer" v-if="notification.length > 0">Ver todos os pedidos</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
          </nav>
          <!-- /.navbar -->
</template>
<script>
import store from '@/store/index';
import {computed} from 'vue';
import { mapGetters, mapActions } from "vuex";
import router from '@/Router';
export default {
 setup() {
    const user =  computed(() => store.getters['auth/user'])
    return { user }
  },
  data() {
      return {

      }
  },
  computed:{
      ...mapGetters(["notification"]),
  },
 created() {
  this.$store.dispatch("getNotification");
 },

mounted() {
    Echo.private(`App.Models.User.${this.user.id}`)
    .notification((notification) => {
     let pedido =  notification.data.pedido;
    $(document).Toasts('create', {
        position: 'bottomRight',
        icon: 'fas fa-envelope fa-lg',
        title: 'Encomenda',
        subtitle: this.formatDate(pedido.created_at),
        body: `O cliente  ${pedido.cliente.nome}  Fez um novo pedido. `
      })
      this.addNotification(pedido);
    });
},
methods: {
    ...mapActions(['removeAllNotification','addNotification','removeNotification']),
   readNotification(item){
      let notification = item;
      this.removeNotification(item);
      router.push(`/pedido/${notification.id}`)
    },
},
}
</script>
