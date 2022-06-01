import router from '@/Router/index';
const actions = {
    login: (context, payload) => {
        context.commit('setToken', payload);
        window.location.replace('/admin')
     // router.push('/admin');
    },
    getUser: (context,  payload) => {
        context.commit('setUser', payload);
    },
    logout: (context) => {
        context.commit('setToken', null);
        context.commit('setUser', null);
        localStorage.removeItem('token');
        localStorage.removeItem('user');
       window.location.replace('/')
      // router.replace('');
    },
    addToken:(context,payload) =>
    {
        context.commit('setToken', payload);
    }

};


const   mutations = {
    setToken: (state, payload) => {
        state.token = payload;
        localStorage.setItem('token',payload);

    },
    setUser: (state, payload) => {
        state.user = payload;
        localStorage.setItem('user',JSON.stringify(payload));
    }
};

const getters = {
    user: (state) => state.user,
    token: (state) => state.token
};

export default  {
    namespaced: true,
    state: {
        token: localStorage.getItem('token'),
        user: JSON.parse(localStorage.getItem('user')),
    },
    mutations,
    actions,
    getters
};


