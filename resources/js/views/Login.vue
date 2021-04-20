<template>
  <div class="parent__body">
    <b-container fluid>
      <img :src="'images/fujitsu.png'" class="fujitsu" />
      <b-row align-h="between" class="vh-100" align-v="center">
        <b-col class="d-lg-block d-md-none d-sm-none d-none">
          <div class="left__pane">
            <div class="image__block">
              <div class="label__image__1__block">
                <img :src="'images/login_1.PNG'" class="label__image__1" />
              </div>
              <div class="label__image__2__block">
                <img :src="'images/login_2.PNG'" class="label__image__2" />
              </div>
            </div>
            <div class="label__block">
              <label class="title"> FDTP<br />SYSTEMS </label>
              <br />
              <hr />
              <p>
                " Welcome to our new all-in-one business solution portal.<br />
                Having only one account to access all new incoming systems. "
              </p>
            </div>
          </div>
        </b-col>
        <b-col xl="5" lg="6" class="d-flex justify-content-center">
          <div class="login__box">
            <div class="block__1">
              <label class="login__label">Let's get you started</label>
              <div class="block__1__image">
                <img :src="'images/girl_laptop.png'" class="image__laptop" />
              </div>
            </div>
            <form
              id="form-login"
              class="form__login"
              method="post"
              @submit.prevent="submitLoginForm"
            >
              <div class="form__login__group">
                <label>Employee Number</label>
                <input type="text" name="emp_id" v-model="emp_id" />
              </div>
              <div class="form__login__group">
                <label>Password</label>
                <input :type="show_pw_status" name="password" v-model="password" />
              </div>
              <b-form-checkbox
                        id="checkbox-show-pw"
                        v-model="show_pw_status"
                        name="checkbox-show-pw"
                        value="text"
                        unchecked-value="password"
                        class="form__chk mb-3"
                        >
                        Show Password
                </b-form-checkbox>

              <button id="btn-login" type="submit" class="login__btn__ok">
                Login
              </button>
              <button
                type="button"
                class="login__btn__cancel"
                @click="clearForm"
              >
                Cancel
              </button>
            </form>
            <div class="sign_up_container">
                  No user account yet? <a href="#" v-b-modal.modal-1>Sign Up</a> here
            </div>
            <!-- <b-button v-b-modal.modal-1>No account ye</b-button> -->
          </div>
        </b-col>
      </b-row>
    </b-container>
     <b-modal id="modal-1" title="User Account Registration" hide-footer>
      <div class="sign_up_content my-5 p-4">
        <b-form  method="post" @submit.prevent="submitSignupForm" id="form-submit-sign-up">
          <img :src="'images/signup.svg'" alt="sign up image" class="sign_up_image mb-5" />
          <p>Register an account by inputting your employee number on the field below</p>
          <b-form-input  placeholder="Enter your Employee Number" class="mb-3" name="emp_id" id="emp_id"></b-form-input>
          <b-button  type="submit" variant="danger" class="btn-register">Register</b-button> <br>
          <label class="error-msg">{{error_msg}}</label>
         </b-form>
      </div>
    </b-modal>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "login",
  data() {
    return {
      emp_id: "",
      password: "",
      show_pw_status : "password",
      error_msg: null
    };
  },
  methods: {
    submitLoginForm: function () {
      var formData = new FormData(document.getElementById("form-login"));

      if (this.emp_id != "" || this.password != "") {
        document.getElementById("btn-login").disabled = true;
        this.$store
          .dispatch("login", formData)
          .then((response) => {

            if (response.data.status == 1) {
              this.toast("warning", response.data.message);
              document.getElementById("btn-login").disabled = false;

            } else if (response.data.status == 2) {

              this.toast("warning", response.data.message);
               document.getElementById("btn-login").disabled = false;

            } else if (response.data.status == 3) {
              
              this.toast("success", response.data.message);
              document.getElementById("btn-login").disabled = false;
              this.$router.push({ name: 'Home' });

            } else if (response.data.status == 4) {
              this.toast("warning", response.data.message);
               document.getElementById("btn-login").disabled = false;
            }
            //  1 = User dont exist in portal database
            //  2 = User dont exist in HRIS database
            //  3 = User successfully logged in
            //  4 = USer password incorrect
          })
          .catch((error) => {
            this.toast("error", "Something went wrong");
            console.log(error);
          })
          .finally(() => {
           
          });
      } else {
        this.toast("error", "Please complete the form");
      }
    },
    clearForm: function () {
      this.emp_id = "";
      this.password = "";

      var sample = localStorage.getItem('fdtpPortal');

      // console.log(JSON.parse(sample));
    },
    toast: function (status, message) {
      this.$toast(message, {
        type: status,
        toastClassName: `toastification--${status}`,
        position: "top-center",
      });
    },
    submitSignupForm: function(){
      let formData = new FormData(document.getElementById('form-submit-sign-up'))
    
      if(formData.get('emp_id') != null && formData.get('emp_id') != '')
      {
        this.$store.dispatch("signup", formData)
        .then(response =>{
          console.log(response)
          this.toast("success", response.data.message);
          this.resetSignUp();
        })
        .catch(error => {
          this.error_msg = error.data.message
        })
      }
      else{
        this.error_msg = '*Employee Number is can\'t be blank. Please input employee number'
      }
    },
    resetSignUp: function(){
      document.getElementById('emp_id').value = null
    }
  },
};
</script>

<style lang="scss">
@import "../../sass/variables";
@import "../../sass/mediascreens";
.parent__body {
  width: 100%;
  height: 100vh;
  background-color: white;
  overflow: hidden;
}

.headerline {
  position: fixed;
  top: 0;
  height: 4px;
  width: 100%;
  background: $red;
  left: 0;
}

.login__box {
  width: 450px;
  height: 650px;
  background-image: url(/fdtp-portal/public/images/redbkg.jpg);
  background-repeat: no-repeat;
  background-size: cover;
  border-radius: 50px;
  box-shadow: 12px 10px 25px #7d7c7c;
}

.block__1 {
  display: flex;

  .login__label {
    color: white;
    width: 50%;
    font-family: Rubik;
    font-size: 40px;
    float: left;
    text-align: left;
    padding: 40px 0px 0px 15px;
    text-shadow: 7px -4px #ef7b8799;
  }

  .block__1__image {
    width: 270px;
    float: right;
    margin-right: -50px;
    .image__laptop {
      width: 100%;
      height: auto;
      animation: sway 2s infinite ease-in-out;
    }
  }
}

@keyframes sway {
  0% {
    transform: rotate(0deg);
  }
  50% {
    transform: rotate(2deg);
  }
  100% {
    transform: rotate(0deg);
  }
}

@keyframes sway1 {
  0% {
    transform: rotate(0deg);
  }
  50% {
    transform: rotate(1deg);
  }
  100% {
    transform: rotate(0deg);
  }
}

.form__chk{
  color: $white
}
.form__login {
  display: block;
  text-align: left;
  padding: 20px 0px 0px 20px;
  font-family: PoppinsRegular;
  &__group {
    label {
      color: white;
      display: block;
      font-size: 20px;
      margin-bottom: 5px;
    }
    input {
      margin-bottom: 20px;
      border: 0;
      border-radius: 5px;
      outline: none;
      width: 75%;
      height: 35px;
      padding: 10px;
    }
  }

  .login__btn__ok {
    border: 0;
    border-radius: 20px;
    padding: 10px 20px 10px 20px;
    width: 150px;
    background: linear-gradient(160deg, #ff4f5a, #d0242f);
    color: white;
    outline: none;
    transition: all 0.3s;
  }

  .login__btn__ok:hover {
    background: linear-gradient(160deg, #ef7a81, #e25059);
  }

  .login__btn__ok:active {
    font-size: 15px;
  }

  .login__btn__cancel {
    border: 0;
    border-radius: 20px;
    padding: 10px;
    width: 100px;
    background: transparent;
    color: white;
    outline: none;
    transition: 1s;
  }
  .login__btn__cancel:hover {
    color: #ff9393;
  }
}

@include lg {
  .login__box {
    width: 400px;
    height: 560px;
  }

  .block__1 {
    .login__label {
      font-size: 37px;
    }

    .block__1__image {
      width: 247px;
    }
  }

  .form__login {
    &__group {
      label {
        font-size: 18px;
      }
      input {
        margin-bottom: 20px;
        border: 0;
        border-radius: 5px;
        outline: none;
        width: 75%;
        height: 33px;
        padding: 10px;
      }
    }
  }
}

.left__pane {
  width: 100%;
  height: 100%;
  position: relative;
}

.label__block {
  position: absolute;
  top: -80px;
  left: 5%;
  .title {
    font-size: 80px;
    font-family: MontserratLight;
    line-height: 90%;
    color: $red;
  }
  p {
    margin-top: 20px;
    font-size: 23px;
    font-family: MontserratLightItalic;
    color: #8c898a;
  }

  hr {
    border: 0.5px solid $red;
  }
}

.image__block {
  position: absolute;
  width: 600px;
  height: 500px;
  top: -250px;
  left: 250px;
}

.label__image__1__block {
  width: 600px;
  position: absolute;
  z-index: 2;
  left: 130px;
  .label__image__1 {
    width: 100%;
    height: auto;
    animation: sway1 2s infinite ease-in-out;
  }
}

.label__image__2__block {
  width: 570px;
  position: absolute;
  z-index: 1;
  top: -110px;
  .label__image__2 {
    width: 100%;
    height: auto;
    animation: sway1 2s infinite ease-in-out;
  }
}

.ball1 {
  position: absolute;
  width: 2000px;
  height: 2000px;
  background: #c53c49;
  border-radius: 100%;
  top: -495px;
  left: -935px;
  transition: all 1s;
  box-shadow: 0 0 0px 16px #f0a0a8;
}

.fujitsu {
  position: absolute;
  width: 150px;
  left: 60px;
  top: 30px;
}

.sign_up_container
{
  color: $white;
  padding: 10px;
  text-align: center;

  a {
    color: rgb(117, 162, 247);
    text-decoration: underline;
  }
}


.sign_up_content
{
  text-align: center;
  width: 100%;
  .btn-register
  {
    background-color: $prime;
    width: 80%;
  }
  .sign_up_image
  {
    width: 300px;
  }

  .error-msg
  {
    color: $red;
    margin-top: 10px;
  }
}

</style>