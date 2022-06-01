<template>
   <!-- Content Header (Page header) -->
   <Main>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perfil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Perfil do Utilizador</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="/assets/img/default-profile.png"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{user.name}}</h3>

                <p class="text-muted text-center" v-for="(item, index) in user.roles" :key="index">{{item.name}}</p>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Informações Pessoais</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Formações</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Endereço</strong>

                <p class="text-muted">{{user.empregado.endereco}}</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Formações Tecnicas</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span> <br>
                  <span class="tag tag-success">Coding</span> <br>
                  <span class="tag tag-info">Javascript</span> <br>
                  <span class="tag tag-warning">PHP</span> <br>
                  <span class="tag tag-primary">Node.js</span>
                </p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Actividades</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Configuração</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="/assets/img/default-profile.png" alt="user image">
                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Shared publicly - 7:30 PM today</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post clearfix">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="/assets/img/default-profile.png" alt="User Image">
                        <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Sent you a message - 3 days ago</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <form class="form-horizontal">
                        <div class="input-group input-group-sm mb-0">
                          <input class="form-control form-control-sm" placeholder="Response">
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-danger">Send</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="/assets/img/default-profile.png" alt="User Image">
                        <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Posted 5 photos - 5 days ago</span>
                      </div>
                      <!-- /.user-block -->
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="/assets/img/default-profile.png" alt="Photo">
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-6">
                              <img class="img-fluid mb-3" src="/assets/img/default-profile.png" alt="Photo">
                              <img class="img-fluid" src="/assets/img/default-profile.png" alt="Photo">
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                              <img class="img-fluid mb-3" src="/assets/img/default-profile.png" alt="Photo">
                              <img class="img-fluid" src="/assets/img/default-profile.png" alt="Photo">
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                    </div>
                    <!-- /.post -->
                  </div>

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal" @submit.prevent="updatedProfile()">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Nome</label>
                        <div class="col-sm-10">
                           <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')"/>
                        </div>

                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input v-model="form.email" type="text" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <div v-if="form.errors.has('email')" v-html="form.errors.get('email')"/>
                        </div>

                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Endereco</label>
                        <div class="col-sm-10">
                              <input v-model="form.endereco" type="text" name="endereco"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('endereco') }">
                                <div v-if="form.errors.has('endereco')" v-html="form.errors.get('endereco')"/>
                        </div>

                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Telefone</label>
                        <div class="col-sm-10">
                             <input v-model="form.telefone" type="text" name="telefone"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('telefone') }">
                                                       <div v-if="form.errors.has('telefone')" v-html="form.errors.get('telefone')"/>
                        </div>

                      </div>
                        <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Data de nascimento</label>
                        <div class="col-sm-10">
                         <input v-model="form.data_de_nascimento" type="date" name="data_de_nascimento"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('data_de_nascimento') }" >
                                <div v-if="form.errors.has('data_de_nascimento')" v-html="form.errors.get('data_de_nascimento')"/>
                        </div>

                      </div>
                        <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                        <input v-model="form.password" type="password" name="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <div v-if="form.errors.has('password')" v-html="form.errors.get('password')"/>
                        </div>


                      </div>
                        <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Confirmar Password</label>
                        <div class="col-sm-10">
                           <input v-model="form.password_confirmation" type="password" name="password_confirmation"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" >
                        <div v-if="form.errors.has('password_confirmation')" v-html="form.errors.get('password_confirmation')"/>
                        </div>

                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Função</label>
                        <div class="col-sm-10">
                            <select name="roles_list[]" multiple="multiple" v-model="form.roles_list" id="inputExperience" class="form-control" :class="{ 'is-invalid': form.errors.has('roles_list') }" disabled>
                                <option v-for="role in user.roles" :key="role.id" v-bind:value="role.id" :selected="form.roles_list.includes(role.id)" >{{role.name}}</option>
                            </select>
                             <div v-if="form.errors.has('roles_list')" v-html="form.errors.get('roles_list')"/>
                        </div>

                      </div>

                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-success ">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
   </Main>
</template>

<script>
import store from '@/store/index';
import {computed} from 'vue';
export default {
setup() {
    const user =  computed(() => store.getters['auth/user'])
    return { user }
  },
   data () {
            return {
                editmode: false,
                form: new Form({
                    id : '',
                    roles_list : [],
                    name: '',
                    email: '',
                    password:"",
                    password_confirmation:"",
                    endereco:"",
                    telefone:"",
                    data_de_nascimento: "",

                })
            }
        },
      methods:{
            setForm()
        {

          this.form.id = this.user.id;
          this.form.name = this.user.name;
          this.form.email = this.user.email;
          this.form.endereco = this.user.empregado.endereco;
          this.form.data_de_nascimento = this.user.empregado.data_de_nascimento;
          this.form.telefone = this.user.empregado.telefone;
          for (let index = 0; index < this.user.roles.length; index++)
            {
                this.form.roles_list.push(this.user.roles[index].id)

            }
        },
        updatedProfile()
         {
             // console.log('Editing data');
                this.form.put('api/user/'+this.form.id)
                .then((response) => {
                    // success
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });

                        //  Fire.$emit('AfterCreate');

                })
                .catch((error) => {
                      if (error.response.status === 401 && error.response.statusText ==="Unauthorized" ||
                  error.response.status === 419 && error.response.statusText ==="Unauthorized"
            ) {
                 this.$store.dispatch('auth/logout');
             }
             Toast.fire({
                      icon: 'error',
                      title: error.response.data.message
                  });
                console.log(error.response.data.data);
                });
        },
      },
        created() {
           this.setForm()
        },
}
</script>

<style>

</style>
