import axios from "axios";
import { reject } from "lodash";

export default {

    state: {
      change_pw_visibility : false,
      change_pw_notification: []
    },

    mutations: {
        set_pw_visibility(state,user) {
            state.change_pw_visibility = user
        },
        set_change_password_notification(state, notification){
            state.change_pw_notification.push({
                ...notification,
                id: (Math.random().toString(36)+Date.now().toString(36)).substr(2)
            })
        },
        remove_change_password_notification(state){
            state.change_pw_notification = [];
        }
    },

    actions: {
        async changeVisibility({commit}, payload){
            commit("set_pw_visibility", !payload)
        },
        
        async changePassword(state, payload){
            let lstorage = JSON.parse(localStorage.getItem('userdata'));
            let emp_id = lstorage.data.data.emp_id;

            if(emp_id == undefined)
            {
                emp_id = lstorage.data.data.emp_pms_id;
            }
            
            return new Promise((resolve, reject) => {
                axios
					.post(`user/update-password/${emp_id}`, payload)
					.then(function(response) {
						resolve(response);
					})
					.catch(function(error) {
						reject(error.response.data);
						// console.log("ERRRR:: ",error.response.data.errors);
					});
            })
           
        },

        showChangePassword({commit}, notification) {
            commit('set_change_password_notification', notification)
         },
         hideChangePassword({commit}) {
            commit('remove_change_password_notification')
         },
    },

    getters: {
        get_pw_visibility: state => state.change_pw_visibility,
        getChangePasswordConfirmation: state => state.change_pw_notification,
    }

};
