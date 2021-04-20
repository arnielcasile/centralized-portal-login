<template>
  <b-container fluid>
    <b-row>
      <b-col>
        <AHeader></AHeader>
      </b-col>
    </b-row>
    <b-row>
      <b-col class="p-0">
        <div class="body">
          <router-view></router-view>
         
        </div>
      </b-col>
    </b-row>
     <!-- <AFooter></AFooter> -->
    <a v-if="arrowUpDisplay" href="#" class="arrow-up"><font-awesome-icon icon="chevron-up" size="2x" class="hamburger" /></a>
     <LogoutConfirmation fontawesome_icon="info-circle" title="Information"></LogoutConfirmation>
     <DeleteConfirmation fontawesome_icon="info-circle" title="Information"></DeleteConfirmation>
     <ChangePassword fontawesome_icon="info-circle" title="Information"></ChangePassword>
     
  </b-container>
</template>

<script>
import AHeader from "../components/AHeader.vue";
import AFooter from "../components/AFooter.vue";
import LogoutConfirmation from "../components/LogoutConfirmation.vue";
import DeleteConfirmation from "../components/DeleteConfirmation.vue";
import ChangePassword from "../components/ChangePassword.vue";
export default {
  name: "Base",
  components: {
    AHeader,
    AFooter,
    LogoutConfirmation,
    DeleteConfirmation,
    ChangePassword
  },
  data(){
    return {
        scrollYPosition : 0,
        arrowUpDisplay : false
    }
  },
  methods:{
     getScrollPositionY(event){
      this.scrollYPosition = window.scrollY;
      (this.scrollYPosition > 500) ? this.arrowUpDisplay = true : this.arrowUpDisplay = false
      
    }
  },
  created: function () {
        window.addEventListener('scroll', this.getScrollPositionY);
  },
};
</script>

<style lang="scss">
@import "../../sass/variables";
.body {
  width:100%;
  // min-height:100vh;
  height:100%;
  
}

body{
  background-color: #eef2f3;
  overflow-x: hidden;
}

html {
  scroll-behavior: smooth;
  width: 100%;
  min-height: 100vh;
  background:#e9ecec;
}

.arrow-up{
    position: fixed;
    color: white;
    background-color: $prime;
    padding: 4px;
    border-radius: 3px;
    right: 1%;
    bottom: 1%;
    transition: 0.5s ease-in-out;
    &:hover{
      color: white;
      padding: 10px;
    }
}
</style>