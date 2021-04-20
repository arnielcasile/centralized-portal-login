<template>
    <div>
        <b-modal id="set-admin-account-modal" size="lg" hide-footer>
            <b >Add Admin Account to System</b>
            <div class="mt-5">

                <div class="left-panel">
                    <img :src="'images/search_image.svg'" alt="Search Image" class="search_image mb-4"/>
                        Set this user as an administrator account for the systems listed below.
                    <b-form-select v-model="selected_system" :options="options_system" class="form_select" @change="load_system_roles"></b-form-select>
                    <b-form-select v-model="selected_roles" :options="options_roles" class="form_select"></b-form-select>
                    <b-button variant="danger" class="btn btn-primary form_button" @click="assign_system_role_user">Add Role</b-button>
                    <label v-if="error_msg != null" class="error_msg">{{error_msg}}</label>
                </div>
                <div class="right-panel">
                     <b-table  hover :items="items"  no-border-collapse style="border: solid 1px lightgray;" show-empty></b-table>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {
    name: "SetAdminAccount",
    props: {
        employee_number : Number,
        default: 1
    },
    data() {
      return {
        items: [],
        selected_system: null,
        options_system: [
          { value: null, text: 'Please select a system' },
        //   { value: 'a', text: 'This is First option' },
        //   { value: 'b', text: 'Selected Option' },
        //   { value: { C: '3PO' }, text: 'This is an option with object value' },
        //   { value: 'd', text: 'This one is disabled', disabled: true }
        ],
        selected_roles: null,
        options_roles: [
            { value: null, text: 'Please select a role' }
        ],
        error_msg : null
      
      }
    },
    mounted() {
        this.load_system_names(),
        this.$root.$on('bv::modal::show', (bvEvent, modalId) => {
            if(modalId === 'set-admin-account-modal')
            {
                this.get_system_access_user()
            }
        })

    },
    computed: {
        systemPerUser(){
            this.get_system_access_user();
            console.log('triggered');
            return this.employee_number
        }
    },
    methods:{
        load_system_names(){
            this.$store.dispatch("loadSystemManagement")
            .then(response => {
                for(const[key,value] of Object.entries(response.data))
                {
                    this.options_system.push({
                        "value": value.id,
                        text   : value.name
                    })
                }
            })
        },
        load_system_roles(){
            this.$store.dispatch("loadSystemRole", this.selected_system)
            .then(response => {
                this.options_roles = [
                    { value: null, text: 'Please select a role' }
                ];
                this.selected_roles = null;
                for(const[key,value] of Object.entries(response.data))
                {
                    this.options_roles.push({
                        "value": value.id,
                        text   : value.role
                    })

                }
            })
        },
        assign_system_role_user(){

            if(this.selected_system !== null  && this.selected_roles !== null)
            {
                this.error_msg = null;
                let data = {
                    system_id : this.selected_system,
                    role_id : this.selected_roles,
                    emp_id : this.employee_number
                };

                this.$store.dispatch("assignSystemRolesUser",data)
                .then(response => {
                    this.get_system_access_user()
                    this.selected_system = null
                    this.selected_roles = null
                })
            }
            else
            {
                this.error_msg = '*Please select system and role'
            }
            
        },
        get_system_access_user(){
            this.$store.dispatch("getSystemAccessUser", this.employee_number)
            .then(response => {
                // console.log(response.data.data);
                this.items = [];
                if(response.data.data != false)
                {
                     for(const [key, value] of Object.entries(response.data.data.system_access)){
                    value.forEach(element => {
                         this.items.push({
                            system_name : key,
                            role : element.role
                        })
                    });
                   
                }
                }
               
            })
        }
    }
}
</script>

<style lang="scss" scoped>
    @import "../../sass/variables";
    .left-panel{
        // border: solid 3px blue;
        float: left;
        width: 40%;
        text-align: center;
        padding: 20px;
        .search_image{
            width: 90%;
        }
        .form_select
        {
            margin-top: 10px;
        }
        .form_button
        {
            width: 80%;
            margin-top: 10px;
        }
        .error_msg
        {
            color: $prime;
        }
    }

    .right-panel{
        // border: solid 3px red;
        float: right;
        width: 60%;
    }
    
</style>