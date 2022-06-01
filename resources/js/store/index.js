import {createStore} from 'vuex';

import authModule from './auth';
import cartModule from './cart';
import productModule from './product';
import notificationModule from './notification';
export default createStore({
    modules: {
        auth: authModule,
        productModule: productModule,
        cartModule: cartModule,
        notificationModule:notificationModule
    }
});
