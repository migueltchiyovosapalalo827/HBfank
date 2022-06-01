

const state = {
  cartItems: [],
}


const mutations = {

  ADD_CART_ITEMS (state, payload) {
      if (state.cartItems != null) {
        let cartProductExists = false;
        state.cartItems.map((cartProduct) => {
          if (cartProduct.id === payload.id) {
            cartProduct.quantity++;
            cartProductExists = true;
          }
        });
        if (!cartProductExists){
              payload.quantity = 1;
             state.cartItems.push(payload);
        }
      } else{
        payload.quantity = 1;
        state.cartItems.push(payload);
      }

    localStorage.setItem('cartItems',JSON.stringify(state.cartItems));
  },
  REMOVE_CART_ITEM(state, payload)
  {
    state.cartItems.map((cartProduct) => {
        if (cartProduct.id === payload.id && cartProduct.quantity > 1) {
          cartProduct.quantity--;
        } else if (cartProduct.id ===  payload.id && cartProduct.quantity === 1) {
          const cartIndexToRemove = state.cartItems.findIndex(cartProduct => cartProduct.id === payload.id);
          state.cartItems.splice(cartIndexToRemove, 1);
        }
      });
      localStorage.setItem('cartItems',JSON.stringify(state.cartItems));
  },

  REMOVE_ALL_CART_ITEMS(state)
  {
    state.cartItems = [];
    localStorage.removeItem('cartItems');
  },
  UPDATE_CART_ITEMS (state,payload){
      let cart = JSON.parse(localStorage.getItem('cartItems'));
      if (cart != null) {
        state.cartItems =  cart;
      } else {
        state.cartItems = [];
      }

   },
}

const actions = {
   getCartItems ({ commit }) {

        commit('UPDATE_CART_ITEMS');

    },
    addCartItem ({ commit }, cartItem) {
     commit('ADD_CART_ITEMS', cartItem);
    },
    removeCartItem ({ commit }, cartItem) {
     commit('REMOVE_CART_ITEM', cartItem)

    },
    removeAllCartItems ({ commit }) {
        commit('REMOVE_ALL_CART_ITEMS');
    }
  }
  const getters = {
    cartItems: state => state.cartItems,
    cartTotal: state => {

      return state.cartItems.reduce((acc, cartItem) => {
        return (cartItem.quantity * cartItem.preco) + acc;
      }, 0).toFixed(2);
    },
    cartQuantity: state => {

      return state.cartItems.reduce((acc, cartItem) => {
        return cartItem.quantity + acc;
      }, 0);
    }
  }

  const cartModule = {

    state,
    mutations,
    actions,
    getters
  }
  export default cartModule;
