<template>
    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/admin" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt blue"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/categorias" class="nav-link">
          <i class="nav-icon fas fa-list-ul orange"></i>
          <p>
            Categorias
          </p>
        </router-link>
      </li>

         <li class="nav-item">
        <router-link to="/productos" class="nav-link">
          <i class="nav-icon fas fa-box-open"></i>
          <p>
            Productos
          </p>
        </router-link>
      </li>
      <li class="nav-item">
          <router-link to="/clientes" class="nav-link">
            <i class="fa fa-user nav-icon grey"></i>
            <p>clientes</p>
          </router-link>
        </li>

        <li class="nav-item">
          <router-link to="/users" class="nav-link">
            <i class="fa fa-users nav-icon blue"></i>
            <p>Funcionarios</p>
          </router-link>
        </li>

             <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart mr-1"></i>
              <p>
                Vendas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
               <router-link to="/pos" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>POS</p>
               </router-link>
              </li>

               <li class="nav-item">
                    <router-link to="/bairros" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Ecomendas</p>
                    </router-link>
                  </li>
                  <li class="nav-item">
               <router-link to="/historico" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hisrorico de vendas</p>
               </router-link>
              </li>
            </ul>
          </li>
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-print mr-1"></i>
              <p>
                Relatorio
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
               <router-link to="/cidades" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Semanais</p>
               </router-link>
              </li>
               <li class="nav-item">
                    <router-link to="/bairros" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Mensais</p>
                    </router-link>
                  </li>
            </ul>
          </li>

           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-map-marker-alt mr-1"></i>
              <p>
                Cidades e Bairros
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
               <router-link to="/cidades" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Cidades</p>
               </router-link>
              </li>
               <li class="nav-item">
                    <router-link to="/bairros" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Bairros</p>
                    </router-link>
                  </li>
            </ul>
          </li>


      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog green"></i>
          <p>
            Settings
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/permissao" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                Permissões
              </p>
            </router-link>
          </li>


            <li class="nav-item">
              <router-link to="/roles" class="nav-link">
                  <i class="nav-icon fas fa-cogs white"></i>
                  <p>
                      Funções
                  </p>
              </router-link>
            </li>
        </ul>
      </li>



      <li class="nav-item">
          <Logout>
            <i class="nav-icon fas fa-power-off red"></i>
            <p>
              Logout
            </p>
          </Logout>

      </li>
    </ul>
  </nav>
</template>

<script>
import Logout from '../Pages/Auth/Logout.vue';
export default {
  components:{
      Logout
  }
}
</script>
