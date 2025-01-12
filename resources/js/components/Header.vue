<template>

          <!-- Navbar -->
          <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
              </li>
            </ul>


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

},
methods: {

},
}
</script>
