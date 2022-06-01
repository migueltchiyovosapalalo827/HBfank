const state = {
   notification: [],
  }


  const mutations = {

    ADD_NOTIFICATION (state, payload) {
      state.notification.push(payload);
      localStorage.setItem('notification',JSON.stringify(state.notification));
    },
    REMOVE_NOTIFICATION(state, payload)
    {
      state.notification.map((notification) => {
           if (notification.id ===  payload.id ) {
            const notificationIndexToRemove = state.notification.findIndex(notification => notification.id === payload.id);
            state.notification.splice(notificationIndexToRemove, 1);
          }
        });
        localStorage.setItem('notification',JSON.stringify(state.notification));
    },

    REMOVE_ALL_NOTIFICATION(state)
    {
      state.notification = [];
      localStorage.removeItem('notification');
    },
    UPDATE_NOTIFICATION (state,payload){
        let notification = JSON.parse(localStorage.getItem('notification'));
        if (notification != null) {
          state.notification =  notification;
        } else {
          state.notification = [];
        }

     },
  }

  const actions = {
     getNotification ({ commit }) {

          commit('UPDATE_NOTIFICATION');

      },
      addNotification ({ commit }, notification) {
       commit('ADD_NOTIFICATION', notification);
      },
      removeNotification ({ commit }, notification) {
       commit('REMOVE_NOTIFICATION', notification)

      },
      removeAllNotification ({ commit }) {
          commit('REMOVE_ALL_NOTIFICATION');
      }
    }

    const getters = {
     notification: state => state.notification,
    }

    const notificationModule = {

      state,
      mutations,
      actions,
      getters
    }
    export default notificationModule;
