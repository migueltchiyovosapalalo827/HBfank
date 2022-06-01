<template>


<div class="login-page">
<div class="login-box" >
 <div class="login-logo">
    <a href="#"><b>Hanburgaria</b>Fank</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Faça login para iniciar sua sessão</p>

    <div class="alert alert-danger" v-if="hasErrors">
        <ul>

                <li v-for="(error, key) in errors" :key="key">{{ error }}</li>

        </ul>
    </div>

      <form @submit.prevent="submit">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" v-model="form.email" autofocus autocomplete="of">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" v-model="form.password" required autocomplete="of">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember"  v-model="form.remember">
              <label for="remember">
                Lembre de mim
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html">Esqueci a minha senha</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Registre uma nova associação</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
</div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: {
                email: '',
                password: '',
                remember: false,
            },
            errors: {},
        }
    },
    computed:{
        hasErrors() {
            return Object.keys(this.errors).length > 0
        },
         },

    methods: {
        setErrors(errors)
        {
         this.errors = errors;
        },
        submit() {
           axios.get('/sanctum/csrf-cookie').then((response) => {
    // Login...
      axios.post('/api/login',this.form).then((response) =>{
      this.setErrors([]);
      const token = response.data.token;
      const user =  response.data.user;
      this.$store.dispatch('auth/login',token);
      this.$store.dispatch('auth/getUser', user);

    }).catch( (error) =>
     {

   if (error.response) {

    this.setErrors(error.response.data.error);
   }

  });

    });
        },
    }
}
</script>
