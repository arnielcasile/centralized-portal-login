import axios from "axios";

export default {
	state: {
		systemmanagement: [],
		section_owner: [],
		system_role:[],
	},
	mutations: {
		SET_SYSTEMMANAGEMENT(state, systemmanagement) {
			state.systemmanagement = systemmanagement;
		},
		SET_SECTIONOWNER(state, section_owner) {
			state.section_owner = section_owner;
		},
		SET_ROLE(state, system_role) {
			state.system_role = system_role;
		},
	},
	actions: {
		//SYSTEM REGISTRATION
		async loadSystemManagement({ commit }) {
			return new Promise((resolve, reject) => {
				axios
					.get("systems/load")
					.then(function(response) {
						commit("SET_SYSTEMMANAGEMENT", response.data);
						let result = {
							code: response.data.code,
							status: response.data.status,
							message: response.data.message,
							data: response.data.data,
						};
						resolve(result);
					})
					.catch(function(error) {
						reject(error);
					});
			});
		},	
		async insertSystemRegistration(state, payload) {
			return new Promise((resolve, reject) => {
				axios
					.post("systems/store ", payload)
					.then(function(response) {
						resolve(response);
					})
					.catch(function(error) {
						reject(error.response.data.errors);
						console.log("ERRRR:: ",error.response.data.errors);
					});
			});
		},
		async deleteDeactivate(state, id) {
			return new Promise((resolve, reject) => {
				axios
					.delete(`systems/delete/${id}`)
					.then(function(response) {
						resolve(response);
					})
					.catch(function(error) {
						reject(error);
					});
			});
		},
		async loadSectionOwner({ commit }) {
			return new Promise((resolve, reject) => {
				axios
					.get("user/load-sections")
					.then(function(response) {
						commit("SET_SECTIONOWNER", response.data);
						resolve(response.data.data);
					})
					.catch(function(error) {
						reject(error);
					});
			});
		},

		//SYSTEM ROLE
		async loadSystemRole({ commit }, system_id) {
			return new Promise((resolve, reject) => {
				axios
					.get(`role/load/${system_id}`)
					.then(function(response) {
						commit("SET_ROLE", response.data);
						let result = {
							code: response.data.code,
							status: response.data.status,
							message: response.data.message,
							data: response.data.data,
						};
						resolve(result);
					})
					.catch(function(error) {
						reject(error);
					});
			});
		},	
		async deleteRoleID(state, id) {
			return new Promise((resolve, reject) => {
				axios
					.delete(`role/delete/${id}`)
					.then(function(response) {
						resolve(response);
					})
					.catch(function(error) {
						reject(error);
					});
			});
		},
		async insertSystemRoles(state, payload) {
			return new Promise((resolve, reject) => {
				axios
					.post("role/store", payload)
					.then(function(response) {
						resolve(response);
					})
					.catch(function(error) {
						reject(error);
					});
			});
		},
		async loadSelectedRoles(state, id) {
			return new Promise((resolve, reject) => {
				axios
					.get(`role/get/${id}`)
					.then(function(response) {
						resolve(response);
					})
					.catch(function(error) {
						reject(error);
					});
			});
		},
		async updateFormRoles(state, payload) {
			return new Promise((resolve, reject) => {
				payload["formData"].append("_method", "PATCH");
				axios
					.post(
						`role/update/${payload["id"]}`,
						payload["formData"]
					)
					.then(function(response) {
						resolve(response);
					})
					.catch(function(error) {
						reject(error);
						console.log(error);
					});
			});
		},
		
	
	},
	getters: {
		getSystemManagement: (state) => state.systemmanagement,
		getSystemRole: (state) => state.system_role,
	},
};
