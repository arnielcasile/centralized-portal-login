<template>
  <div style="font-family: MontserratLight">
    <div class="circle__wrapper" style="">
            <div class="circle"></div>
        </div>
    <b-row>
      <b-col>
        <div class="page__body">
          <b-row class="mb-5">
            <b-col xl="7" lg="12" md="12">
                <img :src="'images/user_mgmt.svg'" class="image__user_mgmt" />
            </b-col>
            <b-col xl="5" lg="12" md="12">
                <div class="title__container user_container">
                    <span style="font-size: 85px;" class="color-black">USER</span>
                    <br>
                    <span style="font-size: 75px;" class="color-black">MANAGEMENT</span>
                    <br>
                    <span class="line__red"></span>
                    <div class="title__tagline">
                        " Welcome to User Management of the FDTP System Portal. All employees list down here can request access to FDTP Systems through their Section Heads approval and system role allocation"
                        <div class="title__controls">
                            <a class="title__btn p-3" href="/centralized-portal-login/public/user-management#list" >GET STARTED</a>
                        </div>
                    </div> 
                </div>
            </b-col>
          </b-row>
          <b-row class="my-5">
              <b-col id="list" class="my-5">
                <div class="table__container">
                  <b-row>
                    <b-col xl="2" lg="2" md="4">
                      <b-form-group
                        id="input-group-2"
                        label="Select display row"
                        label-for="per-page-select"
                        description="Displayed row base on selection"
                        class="filter__group"
                      >
                        <b-form-select
                          id="per-page-select"
                          v-model="perPage"
                          :options="pageOptions"
                          size="sm"
                          class="custom__input"
                        ></b-form-select>
                      </b-form-group>
                    </b-col>
                    <b-col xl="4" lg="4" md="8">
                      <b-form-group
                        id="input-group-1"
                        label="Search Keyword:"
                        label-for="filter-input"
                        description="What are you looking for?"
                        class="filter__group"
                      >
                        <b-form-input
                          id="filter-input"
                          v-model="filter"
                          type="search"
                          class="custom__input"
                        >
                        </b-form-input>
                      </b-form-group>
                    </b-col>
                    <b-col cols="12">
                      <b-table
                        id="budgets_table"
                        class="custom__table"
                        hover
                        bordered
                        responsive
                        :fields="fields"
                        :filter="filter"
                        :filter-included-fields="filterOn"
                        :items="this.getUsers.data"
                        :per-page="perPage"
                        :current-page="currentPage"
                      >
                        <template #cell(emp_photo)="data">
                          <center>
                            <b-avatar :src="`${data.item.photo}`" size="60px"></b-avatar>
                          </center>
                        </template>

                        <template #cell(name)="data">
                          <label>
                            {{ data.item.first_name}}
                            {{ data.item.middle_name}}
                            {{ data.item.last_name }}
                          </label>
                        </template>

                        <template #cell(controls)="data">
                          <b-button
                            type="button"
                            variant="primary"
                            size="sm"
                            class="btn btn-danger"
                            title="Click to clear form"
                            v-b-modal="'set-admin-account-modal'"
                            @click="getDetailsEmployeeAdmin(data.item.employee_number)"
                            >
                            <font-awesome-icon icon="user-slash"  class="icon" /> 
                              Set Admin
                            </b-button>
                          <b-button
                            type="button"
                            variant="outline-secondary"
                            size="sm"
                            class="btn"
                            title="Click to clear form"
                            @click="reset_password(data.item.employee_number)"
                            >
                            <font-awesome-icon icon="user-slash"  class="icon" /> 
                            Reset Password
                            </b-button>
                        </template>
                      </b-table>
                    </b-col>

                    <b-col class="d-flex justify-content-center mt-3">
                      <b-pagination
                        v-model="currentPage"
                        :total-rows="rows"
                        :per-page="perPage"
                        class="custom__pagination"
                      >
                        <template #first-text><span>First</span></template>
                        <template #prev-text><span>Prev</span></template>
                        <template #next-text><span>Next</span></template>
                        <template #last-text><span>Last</span></template>
                        <template #ellipsis-text>
                          <b-spinner small type="grow"></b-spinner>
                          <b-spinner small type="grow"></b-spinner>
                          <b-spinner small type="grow"></b-spinner>
                        </template>
                        <template #page="{ page, active }">
                          <b v-if="active">{{ page }}</b>
                          <i v-else>{{ page }}</i>
                        </template>
                      </b-pagination>
                    </b-col>
                  </b-row>
                </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
    </b-row>
    <SetAdminAccount :employee_number="getActiveEmployeeId"/>
  </div>
</template> 

<script>
import Case from "../components/Case.vue";
import { mapGetters } from "vuex";
import SetAdminAccount from "../components/SetAdminAccount";
export default {
  name: "UserManagement",
  components: {
    Case,
    SetAdminAccount
  },
  data() {
    return {
      fields: [
        { key: "employee_number", sortable: true },
        { key: "emp_photo", sortable: true, label: "Image" },
        { key: "name", sortable: true, label: "Employee" },
        { key: "position", sortable: true },
        { key: "section", sortable: true },
        { key: "controls", sortable: true },
      ],
      currentPage: 1,
      perPage: 5,
      pageOptions: [5, 10, 15, { value: 100, text: "Show more" }],
      filter: null,
      filterOn: [],
      activeEmployeeId : null
    };
  },
  mounted() {
    this.load_users();
  },
  computed: {
    ...mapGetters(["getUsers"]),
    rows() {
      if (!this.getUsers.data) {
        return 1;
      } else {
        return this.getUsers.data.length;
      }
    },
    getActiveEmployeeId(){
      return this.activeEmployeeId;
    }
  },
  methods: {
    load_users: function () {
      this.$store.dispatch("loadUsers").then((result) => {
        this.toast(result.status, result.message);
      });
    },

    reset_password(id){
      this.$store.dispatch("resetPassword", id)
      .then(result => {
        this.toast(result.status, result.message);
      })
    },

    getDetailsEmployeeAdmin(activeEmployeeId){
      this.activeEmployeeId = activeEmployeeId
    },
    toast: function (status, message) {
      this.$toast(message, {
        type: status,
        toastClassName: `toastification--${status}`,
        position: "top-center",
      });
    }
  },
};
</script>

<style lang="scss">
@import "../../sass/variables";
@import "../../sass/mediascreens";
 @import "../../sass/animations";

 .title__container
 {
   color: $black;
 }
.page__body {
  width: 100%;
  height: auto;
  margin-top: 120px;
  padding-left: 15px;
  padding-right: 15px;
}

.page__title {
  width: 400px;
  font-size: 40px;
  border-bottom: 5px solid $red;
  color: $black;
}

.table__container {
  .filter__group {
    width: auto;
    background: white;
    padding: 10px 25px 10px 25px;
    border-radius: 10px;
    box-shadow: 10px 8px 13px #c6c9ca;
    margin-bottom: 20px;
  }

  .custom__input {
    height: 40px;
  }

  .custom__table {
    background: white;
    border-radius: 10px;
    box-shadow: 10px 8px 13px #c6c9ca;
    td {
      border: 0;
      color: $black;
      padding: 10px 20px 10px 20px;
      border-bottom: 1px solid #efefef;
      font-family: MontserratRegular;
    }

    th {
      border: 0;
      color: $black;
      border-bottom: 2px solid #eaeaea;
      padding: 20px 30px 20px 30px;
      font-family: MontserratBold;
    }
  }

  .custom__pagination {
    .page-item {
      .page-link {
        color: $black;
      }
    }

    .page-item.disabled {
      .page-link {
        color: #b2b5b5;
      }
    }

    .page-item.active {
      .page-link {
        color: white;
        background: $red;
        border-color: $red;
        outline-color: $red;
      }
    }
  }
}

 
  .image__user_mgmt{
      width: 70%;
      left: 28%;
      top: 20%;
      opacity: 0;
      position: inherit;
      animation: fadeIn 1s;
      animation-fill-mode: forwards;
  }
  .user_container{
    top: 0% !important;
  }
  
  
</style>