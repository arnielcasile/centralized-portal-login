<template>
    <div>
        <div class="confirm" :class="typeVariantConfirm" v-for="notification in getChangePasswordConfirmation" :key="notification.id">
            <div class="confirmation__box" :class="typeVariantConfirmationBox">
                <div class="confirmation__box__icon">
                     <font-awesome-icon v-if="fontawesome_icon" :icon="fontawesome_icon" />
                     {{title}}
                </div>
                <div class="confirmation__box__content">
                    <b-form class="pl-4 pr-4" id="form-change-pw" @submit.prevent="submitForm" method="post">
                        <div class="mb-4 modal-change-pw__warning" v-if="authenticated_pcheck">
                            <div class="modal-change-pw__warning__title">
                                <font-awesome-icon icon="info-circle" size="lg" class="icon" /> Information
                            </div>
                            The system detected that you're using a default password. 
                            This will require you to change your password immediately for security purposes.
                        </div>
                        <b-form-group class="mb-4" id="input-group-system-name" label="Current Password :" label-class="user__label" label-for="current_password" >
                            <b-form-input  class="alpha-input" id="current_password" name="current_password" :type="show_pw_status" placeholder="Input text here" required /> 
                        </b-form-group>
                        <b-form-group class="mb-4" id="input-group-system-name" label="New Password :" label-class="user__label" label-for="password" 
                        description="Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character">
                            <b-form-input  class="alpha-input" id="password" name="password" :type="show_pw_status" placeholder="Input text here" required /> 
                        </b-form-group>
                        <b-form-group  id="input-group-system-name" label="Confirm Password :" label-class="user__label" label-for="password_confirmation" >
                            <b-form-input  class="alpha-input" id="password_confirmation" name="password_confirmation" :type="show_pw_status" placeholder="Input text here" required /> 
                        </b-form-group>
                        <b-form-checkbox id="checkbox-show-pw" class="user__label mb-4" v-model="show_pw_status" name="checkbox-show-pw" value="text" unchecked-value="password" >
                            Show Password
                        </b-form-checkbox>

                        <div class="text-center mb-4">
                            <b-button
                                id="button-submit"
                                type="submit"
                                title="Click to add new register system"
                                variant="danger">
                            <font-awesome-icon icon="save" size="sm" class="icon" />  
                                Change Password
                            </b-button>
                            <b-button
                                id="button-close"
                                type="button"
                                variant="secondary"
                                class="ml-2"
                                @click="hideModal"
                                v-if="!authenticated_pcheck">
                            <font-awesome-icon icon="times" size="sm" class="icon" />  
                                Close
                            </b-button>
                         </div>
                    </b-form>
                    
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import {mapGetters} from 'vuex';
export default {
    name: "ChangePassword",
    computed: {
        ...mapGetters(["getChangePasswordConfirmation"]),
        typeVariantConfirm(){
            return (this.getChangePasswordConfirmation[0].variant!=undefined)? `confirm--${this.getChangePasswordConfirmation[0].variant}` : '';
        },
        typeVariantConfirmationBox(){
            return (this.getChangePasswordConfirmation[0].variant!=undefined)? `confirmation__box--${this.getChangePasswordConfirmation[0].variant}` : '';
        },
        authenticated_pcheck(){
            let lstorage = localStorage.getItem("pcheck");
            return JSON.parse(lstorage);
        }
    },
    props:{
        fontawesome_icon : String,
        title : String
    },
     data(){
        return {
            show_pw_status : "password",
        }
    },
    methods: {
        hideModal(){
            this.$store.dispatch('hideChangePassword');
        },
        toast: function (status, message) {
            this.$toast(message, {
                type: status,
                toastClassName: `toastification--${status}`,
                position: "top-center",
            });
        },
        submitForm(){
            //submit change password
            let formData = new FormData(document.getElementById('form-change-pw'));
            formData.append("_method", "patch");
            this.$store.dispatch("changePassword",formData)
            .then((response) => {
                console.log(response);
                if(response.data.status.toLowerCase() == "success")
                {
                    this.toast(response.data.status,response.data.message);
                    document.getElementById("form-change-pw").reset();
                    this.show_pw_status = "password";
                    localStorage.pcheck = false;
                    this.hideModal()
                }
                else
                {
                    this.toast(response.data.status,response.data.data);
                }
              
            }).catch((error)=>{
                let error_data = error.data;
                let status = error.status;
                for(const[key] of Object.entries(error_data.password))
                {
                    this.toast(status,error_data.password[key]);
                };
                
            })
        }
  }
}
</script>


<style lang="scss">
@import "../../sass/variables";
@import "../../sass/mediascreens";
.confirm {
    align-items: center;
    background: rgba(0, 0, 0, 0.5);
    color: $black;
    bottom: 0;
    display: flex;
    justify-content: center;
    left: 0;
    position: fixed;
    right: 0;
    top: 0;
    transition: 1s ease-in-out;
    z-index: 100;

  &--primary{
    background: rgb(164 146 146 / 40%);
  }

  &--success{
      background: rgb(131 154 138 / 40%);
  }

   &--info{
      background: rgb(164 169 196 / 40%);
  }

  &--warning{
      background: rgb(170 168 130 / 40%);
  }

  &--error{
      background: rgb(41 41 40 / 40%);
  }
}

.confirmation__box {
    background: white;
    padding:10px;
    width: 700px;
    transition: 1s;
    animation: fadeIn .5s;
    
    &--primary{ 
        border-top: 7px solid $red;
    }

    .confirmation__box__content
    {
        font-size: 20px;
        padding-top: 30px;
    }

    .confirmation__box__icon
    {
        border-bottom: 3px solid #F2F3F7;
        font-size: 23px;
        font-weight: bold;
    }

}


@keyframes fadeIn {
    from {
        transform: scale(0,0);
    }
    to {
        transform: scale(1,1);
    }
}


.user-account-modal
    {
        background-color: white;
        height: 115px;
        width: 180px;
        border-radius: 5px;
        position: absolute;
        right: 1%;
        top: 90%;
        box-shadow: 0 0 3px rgb(211, 211, 211);
        padding: 15px;
        cursor: pointer;
        & a{
            color: $black;
        }
        & a:hover {
            text-decoration: none;
            color: $red;
        }

        .user-triangle
        {
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-bottom: 15px solid white;
            
            position: absolute;
            top: -10%;
            right: 35%;

        }
    }

    .user__label{
        font-weight: bold;
        font-size: 15px;
    }
    
    .modal-change-pw__warning
    {
        background-color: $red;
        color: $white;
        padding: 20px;
        border-radius: 5px;
        justify-content: center;
        font-size: 13px;
        // font-weight: bold;
        &__title{
            font-weight: bold;
            border-bottom: 1px solid $white;
            padding-bottom: 8px;
            margin-bottom: 10px;
            font-size: 15px;
        }
    }

    .text-muted
    {
        font-size: 12px;
    }
</style>