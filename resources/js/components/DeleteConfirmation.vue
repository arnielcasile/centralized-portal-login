<template>
    <div>
        <div class="confirm" :class="typeVariantConfirm" v-for="notification in getDeleteConfirmation" :key="notification.id">
            <div class="confirmation__box" :class="typeVariantConfirmationBox">
                <div class="confirmation__box__icon">
                     <font-awesome-icon v-if="fontawesome_icon" :icon="fontawesome_icon" />
                     {{title}}
                </div>
                <div class="confirmation__box__content">
                     <div class="text-center" style="margin-bottom: 20px">
                        Are you sure you want to delete this record? 
                    </div>
                    <div class="text-center">
                        <b-button size="lg" variant="danger" @click="deleteRoleID()">Yes</b-button>
                        <b-button size="lg" @click="hideModal">Cancel</b-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import {mapGetters} from 'vuex';
export default {
    name: "deleteConfirmation",
    computed: {
        ...mapGetters(['getDeleteConfirmation']),
        typeVariantConfirm(){
            return (this.getDeleteConfirmation[0].variant!=undefined)? `confirm--${this.getDeleteConfirmation[0].variant}` : '';
        },
        typeVariantConfirmationBox(){
            return (this.getDeleteConfirmation[0].variant!=undefined)? `confirmation__box--${this.getDeleteConfirmation[0].variant}` : '';
        }
    },
    props:{
        fontawesome_icon : String,
        title : String
    },
    methods: {
    hideModal(){
      this.$store.dispatch('removeDeleteConfirmation');
    },
    deleteRoleID: function () {
        let id = this.getDeleteConfirmation[0].record_id;
       
        this.$store
            .dispatch("deleteRoleID", id)
            .then((response) => {
                let status = response.data.status;
                if (status == "success") {
                    this.loadRoles(this.getDeleteConfirmation[0].system_id);
                    this.hideModal()
                } else if (status == "warning") {
                    this.toast(status, "Please review your inputs.");
                } else if (status == "error") {
                    this.toast(status, response.data.message);
                }
                })
            .catch((error) => {
                this.toast("error", "Something went wrong");
        });
    },
    loadRoles: function (system_id) {
        this. rolesUpdateID= system_id;
        this.$store.dispatch("loadSystemRole", system_id).then((result) => {
            this.toast(result.status, result.message);
            console.log(result.data)
        });
    },
    toast: function (status, message) {
      this.$toast(message, {
        type: status,
        toastClassName: `toastification--${status}`,
        position: "top-center",
      });
    },
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
    z-index: 99999;

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
    width: 500px;
    transition: 1s;
    animation: fadeIn .5s;
    
    &--primary{ 
        border-top: 7px solid $red;
    }

    // &--success{ 
    //     border-top: 7px solid $success;
    // }

    // &--info{ 
    //     border-top: 7px solid $info;
    // }

    // &--warning{ 
    //     border-top: 7px solid $warning;
    // }

    // &--error{ 
    //     border-top: 7px solid $error;
    // }

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
</style>