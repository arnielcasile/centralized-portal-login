export default {
    state: {
        delete_confirmations: []
    },
    mutations: {
        DELETE_PUSH_NOTIFICATION(state, notification){
            state.delete_confirmations.push({
                ...notification,
                id: (Math.random().toString(36)+Date.now().toString(36)).substr(2)
            })
        },
        DELETE_REMOVE_NOTIFICATION(state){
            state.delete_confirmations = [];
        }
    },
    actions: {
    addDeleteConfirmation({commit}, notification) {
        commit('DELETE_PUSH_NOTIFICATION', notification)
     },
     removeDeleteConfirmation({commit}) {
        commit('DELETE_REMOVE_NOTIFICATION')
     },
    },
    getters: {
        getDeleteConfirmation: state => state.delete_confirmations,
    }
  };
  