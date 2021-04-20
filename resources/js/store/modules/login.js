import { faLongArrowAltUp } from "@fortawesome/free-solid-svg-icons";
import axios from "axios";
// import createPersistedState from "vuex-persistedstate";
export default {
    state: {
        authenticated_user: [],
        authenticated_pcheck: false
    },
    mutations: {
        SET_AUTHENTICATED_USER(state, user) {
            state.authenticated_user = user;
        },
        SET_AUTHENTICATED_PCHECK(state, bool) {
            state.authenticated_pcheck = bool;
        }
    },
    actions: {
        async login({commit}, payload) {
            // console.log(payload.get("password"));
            return new Promise((resolve, reject) => {
                axios
                    .post(`user/login`, payload)
                    .then(function(response) {
                        commit("SET_AUTHENTICATED_USER", response.data);
                        if(response.data.data.status === 3){
                            localStorage.userdata = JSON.stringify(response.data);
                            if(payload.get("password") === "Fujitsu@1234"){
                                localStorage.pcheck = true;
                            } 
                            else{

                                localStorage.pcheck = false;
                            }
                        }
                        resolve(response.data);
                    })
                    .catch(function(error) {
                        reject(error);
                    });
            });
        },

        async logout({commit}, payload){
            // console.log(payload)
            return new Promise((resolve, reject) => {
                axios
                    .delete(`user/logout/${payload}`)
                    .then(function(response) {
                        localStorage.clear();
                        resolve(response.data);
                        commit("SET_AUTHENTICATED_PCHECK", false)
                        // localStorage.userdata = JSON.stringify(response.data);
                    })
                    .catch(function(error) {
                        reject(error);
                    });
            });
        },

        async signup(state, payload)
        {
            return new Promise((resolve, reject) => {
                axios.post("user/register", payload)
                .then(response => {
                    resolve(response)
                })
                .catch(error => {
                    reject(error.response)
                })
            })
        }
    },
    getters: {
        authenticated_user: state => state.authenticated_user,
        authenticated_pcheck: state => state.authenticated_pcheck
    },
    // plugins: [createPersistedState({
    //     key:'userdata',
    // })]
};
