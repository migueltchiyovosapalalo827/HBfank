<template>
   <div class="wrapper" >
            <Header></Header>
           <Aside :user="user"></Aside>

          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
                  <!-- Content Header (Page header) -->

            <!-- Main content -->
           <!-- <router-view />-->
           <slot></slot>

          </div>
        <Footer></Footer>
        </div>
</template>
<script>
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';
import Aside from '@/components/Aside.vue';
import store from '@/store/index';
import { computed } from 'vue'
export default {
    name:'Main',
  components: {
    Header,
    Footer,
    Aside,
  },

   setup() {
    const user =  computed(() => store.getters['auth/user'])
    return { user }
  },

created() {

},
}
</script>
