

<template>
    <a href="#" class="nav-link" v-on:click="logout()">
         <slot></slot>
        </a>
</template>

<script>
export default {
     data() {
         return {

         }
     },
     methods: {
         logout(){

         axios.post('/api/logout',{web:true}).then((response)=>{

           if (response.data.sucess) {
               this.$store.dispatch('auth/logout');
           }

         }).catch( (error) => {

             if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                  error.response.status === 419 && error.response.statusText ==="Unauthorized"
            ) {
                 this.$store.dispatch('auth/logout');
             }

         });

         }
     },
}
</script>
