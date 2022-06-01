<template>
          <!-- Main Sidebar Container -->
          <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <router-link to="/admin" class="brand-link">
              <img :src="'/assets/img/logo.png' " alt="The Logo" class="brand-image img-circle elevation-3"
                   style="opacity: .8">
              <span class="brand-text font-weight-light">{{ 'Laravel' }}</span>
            </router-link>

            <!-- Sidebar -->
            <div class="sidebar">
              <!-- Sidebar user panel (optional) -->
                <router-link to="/profile">
                  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                      <div class="image">
                        <img :src="(user && user.photo) ? user.photo :'/assets/img/default-profile.png'" class="img-circle elevation-2" alt="User Image">
                      </div>
                      <div class="info">
             <router-link to="/profile" class="d-block">
                    {{user && user.name}}
                </router-link>

                      </div>
                  </div>
                </router-link>

              <!-- Sidebar Menu -->
                <Menu></Menu>
              <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
          </aside>
</template>

<script>
import Menu from '../components/Menu.vue';


import {mapGetters ,mapState} from 'vuex';
export default {
 components:{
   Menu
 },
 props:{
   user:{}
 },
 data() {
     return {

     }
 },
 mounted() {
     //this.user = window;
 },

 mounted() {

 },

 updated() {

 },

}
</script>
