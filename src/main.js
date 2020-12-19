import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import Home from './components/Home.vue'
import About from './components/About.vue'
import Products from './components/Products.vue'
import Login from './components/Login.vue'
import ShopDetail from './components/ShopDetail.vue'
import Account from './components/Account.vue'
import Cart from './components/Cart.vue'
import VueFlashMessage from 'vue-flash-message';
import 'es6-promise/auto'
import Vuex from 'vuex'

// https://github.com/shakee93/vue-toasted
//https://shakee93.github.io/vue-toasted/?ref=madewithvuejs.com#!
import Toasted from 'vue-toasted';


import createPersistedState from "vuex-persistedstate";
import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserSecret, faTrash, faRemoveFormat, faCartPlus } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
require('@/assets/_css/main.css')
require('@/assets/_css/styles.css')
library.add(faUserSecret, faTrash, faRemoveFormat, faCartPlus)
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.use(Vuex);
Vue.config.productionTip = false
Vue.use(VueRouter);
Vue.use(Toasted, {
    theme: "outline",
    position: "bottom-right",
    duration: 5000
});
Vue.use(VueFlashMessage, {
    messageOptions: {
        timeout: 5000,
        // important: true,
        // autoEmit: false,
        // pauseOnInteract: true
    }
});

const store = new Vuex.Store({
    state: {
        logado: false,
        user_id: '',
        hoverCode: '',
        cart: [{
            id: '',
            preco: '',
            itens: [],
            status: ''
        }]
    },
    plugins: [createPersistedState()],
    getters: {
        logado: state => {
            return state.logado
        },
        user_id: state => {
            return state.user_id
        },
        hoverCode: state => {
            return state.hoverCode
        },
        cart: state => {
            return state.cart
        },
        cartItens: state => {
            return state.cart[0].itens
        },
        totalProdutos: state => {
            var precoTotal = 0;
            state.cart[0].itens.forEach(el => {
                precoTotal += el.precototal;
            });
            return precoTotal
        }

    },
    mutations: {
        increment(state) {
            state.count++
        },
        login(state, x) {
            state.logado = true
            state.user_id = x
        },
        logout(state) {
            state.logado = false
            state.user_id = ''

        },
        addCart(state, payload) {
            state.cart[0].itens.push(payload.item);
            console.log(state.cart[0]);
        },
        removeCart(state, id) {
            console.log(state.cart[0].itens.splice(id.item, 1));
            console.log(state.cart[0].itens)
        },
        setHovCode(state, id) {
            state.hoveCode = id
        },
        addQty(state, id) {
            if (state.cart[0].itens[id.item].quantidade >= state.cart[0].itens[id.item].limite) {
                console.log('Quantidade maxima em estoque do produto ' + state.cart[0].itens[id.item].nome + ' de tamanho ' + state.cart[0].itens[id.item].tamanho + ' atiginda');
            } else {
                console.log(state.cart[0].itens[id.item].quantidade++);
            }

        },
        removeQty(state, id) {
            if (state.cart[0].itens[id.item].quantidade > 1) {
                console.log(state.cart[0].itens[id.item].quantidade--);
            } else {
                console.log('Quantidade minima do produto ' + state.cart[0].itens[id.item].nome + ' do tamanho ' + state.cart[0].itens[id.item].tamanho + ' atiginda');
            }
        },
        attPreco(state, id) {
            console.log(state.cart[0].itens[id.item]);
            state.cart[0].itens[id.item].precototal =
                state.cart[0].itens[id.item].quantidade *
                state.cart[0].itens[id.item].precoU

        }
    }
})

// function guardMyroute(to, from, next) {
//     if (this.state.logado) {
//         next()
//     } else {
//         next({
//             name: 'login'
//         });
//     }
// }
const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    saveScrollPosition: true,
    routes: [{

            path: '/',
            component: Home
        },
        {

            path: '/shop/',
            name: 'shop',
            component: Products

        },
        {
            path: '/shop/:id',
            name: 'shop/:id',
            component: ShopDetail
        },
        {
            path: '/about/',
            component: About
        },
        {
            path: '/account/',
            component: Account
        },
        {
            path: '/login/',
            name: 'login',
            component: Login,
            beforeCreate() {

            },
        },
        {
            path: '/cart/',
            component: Cart
        }
    ],
    methods: {
        goBack() {
            window.history.length > 1 ?
                this.$router.go(-1) :
                this.$router.push('/')
        }
    }
})

new Vue({
    router,
    store: store,
    modules: {

    },
    render: h => h(App),
}).$mount('#app')