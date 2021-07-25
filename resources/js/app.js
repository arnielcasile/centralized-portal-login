import Vue from "vue";
import VueRouter from "vue-router";
import Authentication from "./middleware/authentication";
import DefaultPasword from "./middleware/defaultPassword";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import { BootstrapVue } from "bootstrap-vue";
import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)

Vue.use(BootstrapVue);

Vue.use(VueRouter);

import store from "./store";

import "./icons.js";

import axios from "axios";
axios.defaults.baseURL = "http://192.168.0.103/centralized-portal-login/public/api/";

/*TEMPORARY*/
import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

const options = {
    // You can set your default options here
};

Vue.use(Toast, options);



import App from "./views/App";
import Base from "./views/Base";
import Login from "./views/Login";
import UserManagement from "./views/UserManagement";
import Admin from "./views/Admin";
import Home from "./views/Home";

let defaultPw = new DefaultPasword(store);

const base_url = "/centralized-portal-login/public/";
const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: `${base_url}login`,
            name: "login",
            component: Login,
            beforeEnter(to, from, next) {
                let authenticate = new Authentication(next, router);
                authenticate.guest();
            }
        },
        {
            path: `${base_url}`,
            name: "base",
            component: Base,
            beforeEnter(to, from, next) {
                if(to.name == 'base')
                {
                    next({ name: 'Home' });
                }
                
                next()
                
            },
            children: [
                {
                    path: `${base_url}admin`,
                    name: "Admin",
                    component: Admin,
                    beforeEnter(to, from, next) {
                        // check if the user is using a default password
                        defaultPw.checkDefaultPassword();
                        let authenticate = new Authentication(next, router);
                        authenticate.auth(to, from);
                    }
                },
                {
                    path: `${base_url}user-management`,
                    name: "UserManagement",
                    component: UserManagement,
                    beforeEnter(to, from, next) {
                        defaultPw.checkDefaultPassword();
                        let authenticate = new Authentication(next, router);
                        authenticate.auth(to, from);
                    }
                },
                {
                    path: `${base_url}home`, 
                    name: "Home",
                    component: Home,
                    beforeEnter(to, from, next) {
                        
                        defaultPw.checkDefaultPassword();
                        let authenticate = new Authentication(next, router);
                        authenticate.auth(to, from);
                    }
                }
            ]
        }
    ],
    scrollBehavior: function (to) {
        if (to.hash) {
          return {
            selector: to.hash
          }
        }
      },
});

const app = new Vue({
    el: "#app",
    components: { App },
    router,
    store
});

router.beforeEach((to, from, next) => {

    router.push({ name: from.name });
    // check if the user is logged in

    if (localStorage.getItem("userdata") === null && to.name === 'login') {
        alert('back to login');
        router.push({ name: from.name });
    }

    else if (localStorage.getItem("userdata") === null && to.name !== 'login') {
        alert('back to login');
        router.push({ name: 'login' });
    }
    
    next();
    
   
  })

