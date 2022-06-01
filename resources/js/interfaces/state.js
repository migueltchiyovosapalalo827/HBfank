import {IUser} from './user';

const IAuthState = {
    token: String,
    user: IUser
}

const IAuthModule = {
    namespaced: Boolean,
    state: IAuthState,
    mutations: any,
    actions: any,
    getters: any,
}

export default {
    IAuthState,
    IAuthModule
}
