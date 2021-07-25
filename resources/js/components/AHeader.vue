<template>
  <header>
    <img :src="'images/fujitsu.png'" class="nav-logo" />

    <ul class="nav-menu">
     
      <li><router-link :to="{name:'Home', params:{id:'home'}}" class="nav-a">
        <font-awesome-icon icon="home" />&nbsp;Home</router-link>
      </li>
      <li><router-link to="/centralized-portal-login/public/home#system_list" class="nav-a">
        <font-awesome-icon icon="laptop" />&nbsp;Systems</router-link>
      </li>
      <template  v-if="isAdmin">
      <li><router-link :to="{name:'Admin'}" class="nav-a">
        <font-awesome-icon icon="user-shield" />&nbsp;Admin</router-link>
      </li>
      <li><router-link :to="{name:'UserManagement'}"  class="nav-a">
        <font-awesome-icon icon="user-circle" />&nbsp;User</router-link>
      </li>
      </template>
      <li>
        <a  class="nav-a" @click="openCloseUserModal">
        <font-awesome-icon icon="cog" />&nbsp;Account</a>
      </li>
    </ul>

    <ul class="nav-min">
      <router-link :to="{ name: 'Admin' }" class="nav-a">
        <font-awesome-icon icon="bars" size="2x" class="hamburger" />
        </router-link>
    </ul>
    <UserAccountModal v-if="get_pw_visibility"/>
  </header> 
</template>

<script>
import UserAccountModal from "./UserAccountModal";
import {mapGetters} from "vuex";
export default {
  name: "AHeader",
  components:{
    UserAccountModal
  },
  data(){
    return {
      isAdmin : false
    }
  },
  computed:{
    ...mapGetters(["get_pw_visibility"]),
  },
  mounted(){
    this.isAdminPortal()
  },
  methods:{

    showModal:function(){
      this.$store.dispatch('addLogoutConfirmation',{
            variant: "primary",
      });
    },

    openCloseUserModal(){
      this.$store.dispatch("changeVisibility",this.get_pw_visibility)
      
    },

    isAdminPortal(){
      let lstorage = JSON.parse(localStorage.getItem('userdata'))
      let section_code = lstorage.data.data.section_code
      let systems =  lstorage.data.data.systems
      console.log(systems)
      console.log(section_code)
      if(systems != undefined)
      {
        if(systems.length > 0)
        {
          for(const [key, value] of Object.entries(systems))
          {
            if(value.name == "FDTP Portal"){
              this.isAdmin = true
            }
          }
        }
      }
   
      if(section_code === "MIT")
      {
        this.isAdmin = true
      }
    }
  }
};
</script>

<style lang="scss">
@import "../../sass/variables";
@import "../../sass/mediascreens";

header {
  width: 100%;
  height: auto;
  max-height: 100px;
  display: flex;
  justify-content: space-between;
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  z-index: 100;
}

.nav-logo {
  width: 140px;
  padding: 15px 0 0 30px;
}

.nav-menu {
  width: auto;
  list-style-type: none;
  display: inline;
  overflow: hidden;
  margin: 0;
  padding: 35px 35px 0 0;
  font-family: MontserratRegular;
  font-size: 19px;
  color: $black;
  cursor: pointer;
  

  li {
    float: left;
    margin: 0 20px 0 20px;
    transition: 0.5s;
  }

  li a {
    display: block;
    color: $black;
    text-align: center;
    text-decoration: none;
  }

  a:hover {
    color: $red;
  }
}

.nav-min{
    padding:30px 40px 0 0;

    .hamburger{
        color:$black;
        transition:.5s;
    }

    .hamburger:hover{
        color:$red;
    }
}

@include xl {
  .nav-min {
    display: none;
  }
}

@include lg {
  .nav-min {
    display: none;
  }
}

@include md {
  .nav-menu {
    display: none;
  }
}

@include sm {
  .nav-menu {
    display: none;
  }
}

@include xs {
  .nav-menu {
    display: none;
  }
}
</style>