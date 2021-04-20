<template>
    <div>
  <b-modal
        id="register-system-modal-insert"
        size="lg"
        hide-footer
        title="System Form Registration"
        title-class="alpha__modal__title"
    >
        <b-form
        class="pl-4 pr-4"
        id="form-registration"
        @submit.prevent="submitForm"
        method="post"
        >
        <b-row style="padding-top:60px;">
            <b-col cols="9" class="mb-2">
                <b-form-group
                id="input-group-system-name"
                label="System Name :"
                label-class="alpha__form__label"
                label-for="input-system-name"
                >
                    <b-form-input
                    class="alpha-input"
                    id="input-system-name"
                    name="name"
                    type="text"
                    placeholder="Enter system name"
                    required
                    /> 
                </b-form-group>
            </b-col>
            <b-col cols="3" class="mb-2">
                <b-form-group
                id="input-group-abbrevation"
                label="Abbreviation :"
                label-class="alpha__form__label"
                label-for="input-abbrevation"
                >
                    <b-form-input
                    class="alpha-input"
                    id="input-abbrevation"
                    name="abbreviation"
                    type="text"
                    placeholder="Enter abbrevation"
                    required
                    /> 
                </b-form-group>
            </b-col>
            <b-col cols="6" class="mb-2">
                <b-form-group
                id="input-group-section-owner"
                label="Section Owner :"
                label-class="alpha__form__label"
                label-for="input-section-owner"
                >
                <b-form-select
                    class="alpha-input"
                    id="input-section-owner"
                    name="section_owner"
                    type="text"
                    placeholder="Enter section owner"
                    required
                    :options="options_section_owner"
                ></b-form-select>
                </b-form-group>
            </b-col>
            <b-col cols="6" class="mb-2">
                <b-form-group
                id="input-group-status"
                label="Status :"
                label-class="alpha__form__label"
                label-for="input-status"
                >
                <b-form-select
                    class="alpha-input"
                    id="input-status"
                    name="status"
                    type="text"
                    placeholder="Enter status"
                    required
                    :options="options_status"
                ></b-form-select>
                </b-form-group>
            </b-col>
            <b-col cols="12" class="mb-2">
                <b-form-group
                id="input-group-url"
                label="SYSTEM URL :"
                label-class="alpha__form__label"
                label-for="input-url"
                >
                <b-form-input
                    class="alpha-input"
                    id="input-url"
                    name="url"
                    type="text"
                    placeholder="Enter URL"
                    required
                    /> 
                </b-form-group>
            </b-col>
            <b-col cols="4" class="mb-2">
                <b-form-group
                id="input-group-reference-number"
                label="Reference Number :"
                label-class="alpha__form__label"
                label-for="input-reference-number"
                >
                <b-form-input
                    class="alpha-input"
                    id="input-reference-number"
                    name="reference_number"
                    type="text"
                    placeholder="Enter Reference Number"
                    required
                    /> 
                </b-form-group>
            </b-col>
            <b-col cols="4" class="mb-2">
                <b-form-group
                id="input-group-reference-code"
                label="Reference Code :"
                label-class="alpha__form__label"
                label-for="input-reference-cod"
                >
                <b-form-input
                    class="alpha-input"
                    id="input-reference-code"
                    name="reference_code"
                    type="text"
                    placeholder="Enter Reference Code"
                    required
                    /> 
                </b-form-group>
            </b-col>
            <b-col cols="4" class="mb-2">
                <b-form-group
                id="input-group-date-deployed"
                label="Date Deployed :"
                label-class="alpha__form__label"
                label-for="input-date-deployed"
                >
                <b-form-input
                    class="alpha-input"
                    id="input-date-deployed"
                    name="date_deployed"
                    type="date"
                    placeholder="Enter Date Deployed"
                    required
                    /> 
                </b-form-group>
            </b-col>
            <b-col cols="12" class="mb-2">
                <b-form-group
                id="input-group-description"
                label="Description :"
                label-class="alpha__form__label"
                label-for="input-description"
                >
                <b-form-textarea
                    class="alpha-input"
                    id="input-description"
                    name="description"
                    rows="3"
                    max-rows="6"
                    type="text"
                    placeholder="Enter description"
                    required
                    /> 
                </b-form-group>
            </b-col>
        </b-row>
        <hr/>
        <div class="float-right">
            
            <b-button
            id="button-submit"
            type="submit"
            title="Click to add new register system"
            variant="danger"
            >
            <font-awesome-icon icon="save" size="sm" class="icon" />  
            Save Information
            </b-button>
            <b-button
            type="button"
            title="Click to clear form"
            class="mr-2"
            @click="clearForm"
            >
            Cancel
            </b-button>
        </div>
        </b-form>
    </b-modal>
    </div>
</template>

<script>
export default {
    name: "ModalSystemInsert",
    data(){
        return {
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
             options_status:[
                { text: 'Development', value: 'Development' },
                { text: 'Production', value: 'Production' },
            ],
            options_section_owner: [],
        }
    },
    mounted(){
        this.loadSectionOwner();
    },
    methods:{
          toast: function (status, message) {
            this.$toast(message, {
                type: status,
                toastClassName: `toastification--${status}`,
                position: "top-center",
            });
        },
        clearForm: function () {
            console.log('trigger');
            this.form = {
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
            };
        },
         loadTable: function () {
          
            this.$store.dispatch("loadSystemManagement").then((result) => {
            this.toast(result.status, result.message);
                
            });
        },
        submitForm: function () {
        var formData = new FormData(document.getElementById("form-registration"));
        document.getElementById("button-submit").disabled = true;
        this.$store
            .dispatch("insertSystemRegistration", formData)
            .then((response) => {
            let status = response.data.status;
            if (status == "success") {
                this.toast(status, response.data.message);
                this.loadTable();
                this.$bvModal.hide("register-system-modal-insert");
            } else if (status == "warning") {
                Object.keys(response.data.data).forEach((key) => {
                this.form[key]["state"] = false;
                this.form[key]["validation"] = response.data.data[key][0];
                });
                this.toast(status, "Please review your inputs.");
            } else if (status == "error") {
                this.toast(status, response.data.message);
            }
            })
            .catch((error) => {
            this.toast("error", "Something went wrong. Please check your input");
            console.log(error);
            })
            .finally(() => {
            document.getElementById("button-submit").disabled = false;
            });
        },
        loadSectionOwner: function () {
            this.$store.dispatch("loadSectionOwner").then((result) => {
                Object.keys(result).forEach((key) => {
                let obj = {};
                obj["value"] = result[key]["id"];
                obj["text"] = result[key]["section"];
                this.options_section_owner.push(obj);
                });
            });
        },
    }
}
</script>

<style lang="scss">

</style>