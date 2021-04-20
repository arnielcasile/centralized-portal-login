<template>
    <div class="user-account-modal">
        <div class="user-triangle"></div>
        <a class="nav-a" @click="showChangePasswordModal"><font-awesome-icon icon="unlock-alt" />&nbsp;Change Password</a>
        <hr>
        <a  class="nav-a" @click="showModal"><font-awesome-icon icon="sign-out-alt" />&nbsp;Logout</a>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
export default {
    name: "UserAccountModal",
    computed: {
        ...mapGetters(["get_pw_visibility"]),
    },
    data(){
        return {
            show_pw_status : "password",
        }
    },
    mounted() {
        // this.$root.$on('bv::modal::hide', (bvEvent, modalId) => {
        //     console.log('trigger')
        //     this.$store.dispatch("changeVisibility", this.get_pw_visibility)
        // })
    },
    methods:{
        showModal:function(){
            this.$store.dispatch('addLogoutConfirmation',{
                    variant: "primary",
            });
        },
     
        showChangePasswordModal:function(){
            this.$store.dispatch('showChangePassword',{
                    variant: "primary",
            });
        },
        
    },
}
</script>

<style lang="scss">
@import "../../sass/variables";
    
</style>