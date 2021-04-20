import axios from "axios";

export default {
    state: {
        user_list: []
    },
    mutations: {
        SET_USER_LIST(state, users) {
            state.user_list = users;
        }
    },
    actions: {
        async loadUsers({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`user/load-all-registered-users`)
                    .then(function(response) {
                        commit("SET_USER_LIST", response.data);
                        resolve(response.data);
                    })
                    .catch(function(error) {
                        reject(error);
                    });
            });
        },

        async resetPassword(state,payload){
            return new Promise((resolve, reject) => {
                axios.post(`/user/reset-password/${payload}`, {"id": payload, "_method": "patch"})
                .then(response =>{
                    resolve(reject)
                })
            })
        },
        async assignSystemRolesUser(state, payload) {
			return new Promise((resolve, reject) => {
				axios.post("system-access/store",payload)
				.then(response => {
					resolve(response)
				})
				.catch(error => {
					reject(error.response)
				})
			})
		},
		async getSystemAccessUser(state,employee_id){
			
			return new Promise((resolve,reject) => {
				axios.get(`user/system-role-access/${employee_id}`)
				.then(response => {
					resolve(response)
				})
				.catch(error => {
					reject(error)
				})
			})
		}
    },
    getters: {
        getUsers: state => state.user_list
    }
};
