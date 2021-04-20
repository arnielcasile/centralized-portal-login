<template>
    <div class="footer">
        <div class="text-center pt-3">
            <h1>FDTP Portal</h1>
            <p>" Welcome to our new all-in-one business solution portal. <br>Having only one account to access all new incoming systems."</p>
                <router-link :to="{name:'Home', params:{id:'home'}}" class="nav-a">Home</router-link> |
                <router-link to="/fdtp-portal/public/home#system_list" class="nav-a">Systems</router-link> |
                <router-link :to="{name:'Admin'}" class="nav-a">Admin</router-link> |
                <router-link :to="{name:'UserManagement'}"  class="nav-a">User</router-link> |
                <a class="nav-a" @click="logout()">Logout</a> 
        </div>
        <div class="footer__line">
            Copyright © 2021 FDTP. All Rights Reserved. 
        </div>
    </div>    
</template>

<script>
export default {
    name: "Footer",
    methods:{
         logout(){
      
            let lstorage = JSON.parse(localStorage.getItem('userdata'));
            let emp_id = lstorage.data.data.emp_id;

            if (emp_id === undefined)
            {
                emp_id = lstorage.data.data.emp_pms_id;
            }
            this.$store 
                .dispatch("logout", emp_id)
                .then((response) => {
                    console.log(response);
                    if(response.code === 200)
                    {
                    this.$router.push({ name: 'login' });
                    }
                })
        },
    }
}
</script>


<style lang="scss">
    @import "../../sass/variables";
    @import "../../sass/mediascreens";
    @import "../../sass/main";
  

    .footer{
        background-color: $prime;
        height: 400px;
        width: 100%;
        position: absolute;
        left:0%;
        // bottom: 0%;
        color: $white;
        font-family: MontserratLight;
        // bottom: 0px;
        a{
            color: $white;
        }
        &__line{
            background-color: $violet;
            height: 50px;
            width: 100%;
            position:absolute;
            bottom: 0;
            text-align: center;
            color: $white;
            padding-top: 10px;
        }
    }
</style>