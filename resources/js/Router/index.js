import {
    createRouter,
    createWebHistory,
    RouteRecordRaw
} from 'vue-router';
import Login from '@/Pages/Auth/Login';
import Dashboard from '@/Pages/Dashboard';
import store from '@/store/index';
import Home from '@/Pages/Home';
import Users from '@/Pages/Users';
import Permission from '@/pages/permission';
import Roles from '@/Pages/Roles';
import Profile from "@/Pages/Profile";
import Cidade from '@/Pages/Cidade';
import Bairro from '@/Pages/Bairro';
import Categorias from '@/Pages/Categorias';
import Productos from '@/Pages/Productos';
import Clientes from '@/Pages/Clientes';
import Pos from '@/Pages/pos';
import Factura from '@/Pages/Factura';
import Historico from '@/Pages/Historico';
import Pedido from '@/Pages/pedido';
import Pedidos from '@/Pages/Pedidos';
import CartListItem from '@/Pages/Cart_List_Item';
import Register from '@/Pages/Register';
import AdminCampaigns from '@/Pages/AdminCampaigns';
import PublicCampaigns from '@/Pages/PublicCampaigns';
import Reporter from '@/Pages/Reporter';
const routes = [

    {
        path: '/admin',
        name: 'Dashboard',
        component: Dashboard,
        meta: {
            requiresAuth: true
        }
    },

    {
        path: '/users',
        name: 'Users',
        component: Users,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/permissao',
        name: 'Permission',
        component: Permission,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/roles',
        name: 'Roles',
        component: Roles,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile,
        meta: {
            requiresAuth: true
        }
    },

    {
        path: '/cidades',
        name: 'Cidades',
        component: Cidade,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/bairros',
        name: 'Bairros',
        component: Bairro,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/categorias',
        name: 'Categorias',
        component: Categorias,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/productos',
        name: 'Productos',
        component: Productos,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/clientes',
        name: 'Clientes',
        component: Clientes,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/pos',
        name: 'Pos',
        component: Pos,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/factura/:invoice_id',
        name: 'factura',
        component: Factura,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/pedidos',
        name: 'Pedidos',
        component: Pedidos,
        meta: {
            requiresAuth: true
        }
    },


    {
        path: '/pedido/:pedido_id',
        name: '/pedido',
        component: Pedido,
        meta: {
            requiresAuth: true
        }
    },

    {
        path: '/historico',
        name: 'Historico',
        component: Historico,
        meta: {
            requiresAuth: true
        }
    },
    //campanha publicitaria
    {
        path: '/publicidades',
        name: 'publicidade',
        component: AdminCampaigns,
        meta: {
            requiresAuth: true
        }
    },
    //relatorio
    {
        path: '/relatorios',
        name: 'relatorios',
        component: Reporter,
        meta: {
            requiresAuth: true
        }
    },

    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            requiresUnauth: true
        }
    },
    {
        path: '/detalhe/:id',
        name: 'detalhe',
        component: CartListItem,
        meta: {
            requiresUnauth: true
        }
    },
    {
        path: '/admin/Login',
        name: 'Login',
        component: Login,
        meta: {
            requiresUnauth: true
        }
    },
    {
        path: '/admin/register',
        name: 'Register',
        component: Register,
        meta: {
            requiresUnauth: true
        }
    },
    {
         path: '/publicidade/promossoes',
         name: 'Promossoes',
         component: PublicCampaigns,
         meta: {
             requiresUnauth: true
         }
     }
     /*
     {
         path: '/recover-password',
         name: 'RecoverPassword',
         component: RecoverPassword,
         meta: {
             requiresUnauth: true
         }
     },
     {
         path: '/privacy-policy',
         name: 'RecoverPassword',
         component: PrivacyPolicy
     },*/

];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    if (to.name !== 'Login' && to.meta.requiresAuth && !store.getters['auth/token']) {
        console.log(store.getters['auth/token']);
        next('/admin/login')
    } else if (to.meta.requiresUnauth && !!store.getters['auth/token']) {
        next();
    } else {
        next();
    }
});

export default router;
