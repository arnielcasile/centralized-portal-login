<template>
    <div class="Admin">
        <!-- <div class="header-circle"></div>  -->
          <div class="circle__wrapper" style="">
            <div class="circle"></div>
        </div>
        <section class="col-lg-12">
            <b-row class="header--title">
                <div class="col-6">
                    <img src="images/laptopHuman.png" alt="laptopHuman" class="laptopHuman">
                </div>
                <div class="content--right col-4">
                     <div class="title__container">
                    <span style="font-size: 85px;" class="color-black">SYSTEM</span>
                    <br>
                    <span style="font-size: 75px;" class="color-black">MANAGEMENT</span>
                    <br>
                    <span class="line__red"></span>
                    <div class="title__tagline">
                        " Fujitsu grows so do its requirements, as well as the need to efficiently manage and safeguard IT and data assets so we centralized system monitoring. "<br><small>- DaileDreamer</small>
                        <div class="title__controls">
                            <a class="title__btn p-3" href="/fdtp-portal/public/admin#system_list">GET STARTED</a>
                        </div>
                    </div> 
                </div>
                </div>
            </b-row>
        </section>
      
        <section class=" col-lg-12 system_list" id="system_list">

            <div class="body--management">
                <font-awesome-icon icon="user-shield"  class="icon" style="font-size:100px; margin-bottom:25px; "/>
                <h1>SYSTEM MANAGEMENT</h1>
                <p>Together we connect and manage Systems and Role. </p>
                 <img src="images/systemList.png" alt="listofsystem" class="body--image">
            </div>
            <div class="system_list__content">
                
                    <!-- SEARCH -->
                    <b-row align-h="between">
                        <b-col sm="12" md="4" class="mb-2">
                            <b-button
                            type="button"
                            variant="primary"
                            size="md"
                            class="btn btn-danger"
                            v-b-modal.register-system-modal-insert
                            title="Click to clear form"
                            >
                            <font-awesome-icon icon="plus-square" size="lg" class="icon" /> 
                            REGISTER NEW SYSTEM
                            </b-button>
                        </b-col>

                        <b-col sm="12" md="6" lg="5" xl="3" class="mb-2">
                            <b-input-group>
                            <b-form-input
                                id="filter-input"
                                v-model="filterRegister"
                                type="search"
                                placeholder="Type to Search"
                            >
                            </b-form-input>
                            <b-input-group-append>
                                <b-button
                                type="button"
                                size="md"
                                class="btn btn-danger"
                                :disabled="!filterRegister"
                                @click="filterRegister = ''"
                                >
                                <font-awesome-icon icon="eraser" size="sm" class="icon" />
                                Cancel
                                </b-button>
                            </b-input-group-append>
                            </b-input-group>
                        </b-col>
                    </b-row>

                    <!-- TABLE DATA -->
                    <b-table
                    id="system_management_table"
                    class="alpha__table text-nowrap"
                    hover
                    bordered
                    responsive
                    :fields="fields"
                    :filter="filterRegister"
                    :filter-included-fields="filterOn"
                    :items="getSystemManagement.data"
                    :per-page="perPage"
                    :current-page="currentPage"
                    >
                        <template #cell(actions)="data">
                            <b-button
                                type="button"
                                variant="danger"
                                size="sm"
                                title="Click to Add role"
                                v-b-modal.modal-add-role
                                @click="loadRoles(data.item.id)"
                                v-on:click="rolebuttonelement = true" >
                                <font-awesome-icon icon="clipboard-list" size="sm" class="icon" /> 
                                Add Role
                            </b-button>
                            <b-button
                                type="button"
                                variant="secondary"
                                size="sm"
                                title="Click to Terminate system"
                                v-b-modal.deactivate-modal
                                @click="loadDeactivate(data.item.id)">
                                <font-awesome-icon icon="trash" size="sm" class="icon" /> 
                                Terminate
                            </b-button>
                        
                        </template>
                    </b-table>

                    <!-- PAGINATION -->
                    <b-pagination
                        align="right"
                        class="alpha__table__pagination mb-0"
                        pills
                        v-model="currentPage"
                        :total-rows="rows"
                        :per-page="perPage"
                        >
                    </b-pagination> 
                
               
            </div>
        </section>

    <!-- MODALS -->
  
    <ModalSystemInsert></ModalSystemInsert>
    <b-modal
        id="deactivate-modal"
        size="md"
        hide-footer
        title="System Termination"
        title-class="alpha__modal__title">
        <b-form
        class="pl-4 pr-4"
        id="form-deactivate"
        @submit.prevent="submitForm"
        method="post"
        >
        <b-row style="padding-top:60px; text-align:center;">
            <h3>Are you sure you want to Terminate this system?</h3>
        </b-row>
        <hr/>
        <div style="text-align:center;">
            <b-button
            id="button-submit"
            type="submit"
            title="Click to Terminate system"
            variant="danger"
            size="lg"
            @click="getDeactivate(id)">
            Yes
            </b-button>
            <b-button
            type="button"
            title="Click to clear form"
            class="mr-2"
            size="lg"
            @click="$bvModal.hide('deactivate-modal')">
            No
            </b-button>
        </div>
        </b-form>
    </b-modal> 
    <b-modal
        id="modal-add-role"
        size="xl"
        hide-footer
        title="Register New Role"
        title-class="alpha__modal__title">
      
        <!-- search -->
        <b-row style="padding-top:60px;" align-h="between">
            <b-col sm="12" md="4" class="mb-2"> </b-col>
            <b-col sm="12" md="6" lg="5" xl="5" class="mb-2">
                <b-input-group>
                <b-form-input
                    id="filter-input"
                    v-model="filterRole"
                    type="search"
                    placeholder="Type to Search"
                >
                </b-form-input>
                <b-input-group-append>
                    <b-button
                    type="button"
                    size="md"
                    class="btn btn-danger"
                    :disabled="!filterRole"
                    @click="filterRole = ''"
                    >
                    <font-awesome-icon icon="eraser" size="sm" class="icon" />
                    Cancel
                    </b-button>
                </b-input-group-append>
                </b-input-group>
            </b-col>
        </b-row>

        <!-- body -->
        <b-row>
            <b-col lg="4">
                 <b-form
                    class="pl-4 pr-4"
                    id="form-roles"
                    @submit.prevent="submitFormRoles"
                    method="post"
                    >
                    <b-row style="padding-top:10px;">
                        <b-form-input
                        class="alpha-input"
                        id="input-system-id"
                        name="system_id"
                        type="text"
                        v-model="rolesUpdateID"
                        required
                        hidden                        
                        /> 
                        <b-col cols="12" class="mb-2">
                            <b-form-group
                            id="input-group-role"
                            label="System Role :"
                            label-class="alpha__form__label"
                            label-for="input-role"
                            >
                                <b-form-input
                                class="alpha-input"
                                id="input-role"
                                name="role"
                                v-model="formroles.role.value"
                                type="text"
                                placeholder="Enter role"
                                required
                                /> 
                            </b-form-group>
                        </b-col>
                        <b-col cols="12" class="mb-2">
                            <b-form-group
                            id="input-group-role-description"
                            label="Description :"
                            label-class="alpha__form__label"
                            label-for="input-role-description"
                            >
                                <b-form-textarea
                                class="alpha-input"
                                id="input-role-description"
                                name="description"
                                v-model="formroles.description.value"
                                type="text"
                                rows="8"
                                max-rows="1"
                                placeholder="Enter role description"
                                required
                                /> 
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <hr/>
                    <div class="float-right">
                        <b-button
                        type="button"
                        title="Click to clear form"
                        class="mr-2"
                        @click="clearFormRoles"
                        v-on:click="rolebuttonelement = true" 
                        >
                        Cancel
                        </b-button>

                        <b-button
                        id="button-submit-role"
                        type="submit"
                        title="Click to add new register system"
                        variant="danger"
                        v-show="rolebuttonelement"
                        >
                        <font-awesome-icon icon="save" size="sm" class="icon" />  
                        Save Information
                        </b-button>

                        <b-button
                        id="button-update-role"
                        type="button"
                        title="Click to Update role"
                        variant="warning"
                        @click="updateFormRoles(subroleupdateId)"
                        v-show="!rolebuttonelement"
                        >
                        <font-awesome-icon icon="save" size="sm" class="icon" /> 
                        Update Information
                        </b-button>
                    </div>
                    </b-form>
            </b-col>
            <b-col lg="8" class="footer--role">
                <!-- TABLE DATA -->
                <b-table
                id="system_role_table"
                class="alpha__table text-nowrap"
                hover
                bordered
                responsive
                :fields="fieldsRoles"
                :filter="filterRole"
                :filter-included-fields="filterOn"
                :items="getSystemRole.data"
                :per-page="perPageRole"
                :current-page="currentPageRole"
                >
                    <template #cell(actions)="data">
                        <b-button
                            type="button"
                            variant="danger"
                            size="sm"
                            title="Click to Update"
                            v-b-modal.modal-add-role
                            @click="loadSelectedRoles(data.item.id)" 
                            v-on:click="rolebuttonelement = false"                           
                            >
                            <font-awesome-icon icon="clipboard-list" size="sm" class="icon" /> 
                            Update
                        </b-button>
                        <b-button
                            type="button"
                            variant="secondary"
                            size="sm"
                            title="Click to Delete"
                            v-b-modal.role-modal
                            @click="showDeleteModal(data.item.id)"
                            
                            >
                            <font-awesome-icon icon="trash" size="sm" class="icon" /> 
                            Delete
                        </b-button>
                    
                    </template>
                </b-table>
                <!-- PAGINATION  @click="deleteRoleID(data.item.id)"-->
                <b-pagination
                    align="right"
                    class="alpha__table__pagination_role"
                    pills
                    v-model="currentPageRole"
                    :total-rows="rowsrole"
                    :per-page="perPageRole">
                </b-pagination> 
            </b-col>
            
        </b-row>
 
    </b-modal> 

    </div>
    
</template>

<script>
import { mapGetters } from "vuex";
import ModalSystemInsert from "../components/ModalSystemInsert"
export default {
        name:"Admin",
        components:{
            ModalSystemInsert
        },
        data() {
       
        return {
            getDeactivateID: "",
            options_status:[
                { text: 'Development', value: 'Development' },
                { text: 'Production', value: 'Production' },
            ],
            options_section_owner: [],
            currentPage: 1,
            perPage: 10,
            filterRegister: null,
            filterOn: [],
            fields: [
            {
            key: "name",
            sortable: true,
            },
            {
            key: "abbreviation",
            sortable: true,
            },
            {
            key: "reference_code",
            sortable: true,
            },
            {
            key: "reference_number",
            sortable: true,
            },
            {
            key: "description",
            sortable: true,
            },
            {
            key: "status",
            sortable: true,
            },
            {
            key: "section_owner",
            sortable: true,
            },
            
            { 
            key: "actions",
            label: "Actions" 
            },
            ],
            form: {
                name: {
                    value: "",
                    state: null,
                    validation: "",
                },
                abbreviation: {
                    value: "",
                    state: null,
                    validation: "",
                },
                section_owner: {
                    value: "",
                    state: null,
                    validation: "",
                },
                status: {
                    value: "",
                    state: null,
                    validation: "",
                },
                description: {
                    value: "",
                    state: null,
                    validation: "",
                },
                reference_code: {
                    value: "",
                    state: null,
                    validation: "",
                },
                reference_number: {
                    value: "",
                    state: null,
                    validation: "",
                },
            },
            fieldsRoles:[
                {
                    key: "role",
                    sortable: true,
                },
                {
                    key: "description",
                    sortable: true,
                },
                { 
                    key: "actions",
                    label: "Actions" 
                },

            ],
            formroles: {
                role: {
                    value: "",
                    state: null,
                    validation: "",
                },
                description: {
                    value: "",
                    state: null,
                    validation: "",
                },
            },
            currentPageRole: 1,
            perPageRole: 6,
            rolesUpdateID:"",
            filterRole: null,
            subroleupdateId:"",
            rolebuttonelement:true,
            
        };
    },        
    mounted() {
        this.loadTable();
        // this.loadSectionOwner();
    },
    computed: {
        ...mapGetters(["getSystemManagement","getSystemRole"]),
        rows() {
            if (!this.getSystemManagement.data) {
                return 1;
            } else {
                return this.getSystemManagement.data.length;
            }
        },
        rowsrole() {
            if (!this.getSystemRole.data) {
                return 1;
            } else {
                return this.getSystemRole.data.length;
            }
        },
    },
    methods: {
        //Utility
        toast: function (status, message) {
            this.$toast(message, {
                type: status,
                toastClassName: `toastification--${status}`,
                position: "top-center",
            });
        },
        showDeleteModal:function(id){
            this.$store.dispatch('addDeleteConfirmation',{
                    variant: "primary",
                    record_id: id,
                    system_id: this. rolesUpdateID
            });
        },
        clearFormRoles: function (){
            this.formroles= {
                role: {
                    value: "",
                    state: null,
                    validation: "",
                },
                description: {
                    value: "",
                    state: null,
                    validation: "",
                },
            };
        },
        //System Registration
        loadTable: function () {
          
            this.$store.dispatch("loadSystemManagement").then((result) => {
            this.toast(result.status, result.message);
                
            });
        },
        loadDeactivate: function (id) {
            this.getDeactivateID = id;
        },
        getDeactivate: function () {
            var id = this.getDeactivateID;
            this.$store
                .dispatch("deleteDeactivate", id)
                .then((response) => {
                    let status = response.data.status;
                    if (status == "success") {
                        this.loadTable();
                        this.$bvModal.hide("deactivate-modal");
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
        
       
        //System Role
        loadRoles: function (system_id) {
            this. rolesUpdateID= system_id;
            this.$store.dispatch("loadSystemRole", system_id).then((result) => {
                this.toast(result.status, result.message);
                console.log(result.data)
            });
        },
        deleteRoleID: function (id) {
            this.$store
                .dispatch("deleteRoleID", id)
                .then((response) => {
                    let status = response.data.status;
                    if (status == "success") {
                        this.loadRoles(this.rolesUpdateID);
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
        submitFormRoles: function () {
        var formData = new FormData(document.getElementById("form-roles"));
        document.getElementById("button-submit-role").disabled = true;
        this.$store
            .dispatch("insertSystemRoles", formData)
            .then((response) => {
            let status = response.data.status;
            if (status == "success") {
                this.toast(status, response.data.message);
                this.loadRoles(this.rolesUpdateID);
                this.clearFormRoles();
            } else if (status == "warning") {
                Object.keys(response.data.data).forEach((key) => {
                this.formroles[key]["state"] = false;
                this.formroles[key]["validation"] = response.data.data[key][0];
                });
                this.toast(status, "Please review your inputs.");
            } else if (status == "error") {
                this.toast(status, response.data.message);
            }
            })
            .catch((error) => {
            this.toast("error", "Something went wrong");
            console.log(error);
            })
            .finally(() => {
            document.getElementById("button-submit-role").disabled = false;
            });
        },
        loadSelectedRoles: function (id) {
            this.subroleupdateId = id;
            this.$store.dispatch("loadSelectedRoles", id).then((result) => {
                var information = result.data.data;
                Object.keys(information).forEach((key) => {
                    if (key == "role" || key == "description") {
                        this.formroles[key]["value"] = information[key];
                    }
                });
            });
        },
        updateFormRoles: function () {
            var formData = new FormData(document.getElementById("form-roles"));
            document.getElementById("button-update-role").disabled = true;

            var patchData = {
                id: this.subroleupdateId,
                formData: formData,
            };

            this.$store
                .dispatch("updateFormRoles", patchData)
                .then((response) => {
                let status = response.data.status;
                if (status == "success") {
                    this.clearFormRoles;
                    this.toast(status, response.data.message);
                    this.loadRoles(this.rolesUpdateID);
                } else if (status == "warning") {
                    Object.keys(response.data.data).forEach((key) => {
                    this.formroles[key]["state"] = false;
                    this.formroles[key]["validation"] = response.data.data[key][0];
                    });
                    this.toast(status, "Please review your inputs.");
                } else if (status == "error") {
                    this.toast(status, response.data.message);
                }
                })
                .catch((error) => {
                this.toast("error", "Something went wrong");
                console.log(error);
                })
                .finally(() => {
                document.getElementById("button-update-role").disabled = false;
                });
        },
        
    }
 
}
</script>

<style lang="scss" scoped>
    @import "../../sass/variables";
    @import "../../sass/mediascreens";
    @import "../../sass/main";
h5 .modal-title{
    color: $black;
}
.Admin {
    background-color:$dark-gray;
    // padding: 0%; 
    // margin: 0%;
    // width: 100%;
    // height: 100%;
    color: $black;
}

.header-circle{
    background-color: $white;
    border-radius: 50%;
    height:650px;
    width:650px;
    margin-top: -100px;
    margin-left: -100px;
    position: absolute;
}

.header--title {
    // margin-bottom: 300px;
    font-family: MontserratLight;

    .laptopHuman {
        height:350px;
        margin-top: 200px;
        margin-left: 125px;
    }

    .content--right {
        // margin-top: 300px;
        margin-left: 150px;
        color: $black;
        font-family: MontserratLightItalic;
        .system-title {
            padding-bottom: 60px;
            font-family: MontserratLight;
            line-height: 40px;
            h1 {
                font-size: 60px;
                // font-weight: 900;
                font-family: MontserratLight;
            }
            p {
                font-size: 25px;
                
            }

            hr
            {
                height: 5px;
                width: 100%;
                position: absolute;
                animation: line_slide 0.7s;
                animation-fill-mode: forwards;
                animation-delay: 0.1s;
                background-color: $prime;
            }
            
            
        }
  
    }
}

.body-circle {
    background: white;
    border-radius: 50% 50% 0% 0%;
    margin-bottom: 0;
    padding: 0;
    width: 100%;
    height: auto;
    padding-bottom: 50px;;
}

.body--management {
    padding-top: 1%;
    width: 100%;
    text-align: center;
    margin-bottom: 50px;
    font-family: MontserratLight;
    
    p {
        width: 300px;
        margin-left: 42%;
        margin-right: 42%;
    }

    .body--image {
        height:300px;
        margin-top: -120px;
        margin-left: 1000px;
    }
}

th {
    color: $white;
    background-color: $prime 
}

.footer--management {
    padding: 0;
    margin: 0px 200px 0px 200px;
    
}

.alpha__table__pagination li a {
   color: $white;
   background-color: $red;
}

.alpha__table__pagination_role li a {
   color: $white;
   background-color: $red;
}

 .system_list{
        border-radius: 40% 40% 0 0;
        background-color: white;

        padding-top: 25px;

        width: 150%;
        height: 100vh;
        padding-top: 25px;
        margin-top: 235px;
        // margin-left: -25%;
        
        &__laptop{
        color: $black;
        }

        &__title{
            color: $black;
            font-size: 60px;
        }

        &__details{
            color: $black;
        }

        &__content{
            // border: solid 3px black;
           width: 100vw;
            position: absolute;
            left: 0%;
            padding: 50px;
            background-color: white;
        }
    } 


</style>