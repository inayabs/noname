<template>
  <div class="app-modal">
    <create-user/>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-info">User List</h5>
      </div>
      <div class="card-body">
        <v-client-table :data="userList" :columns="columns" :options="options" ref="trainerTable">
          <div slot="afterLimit" class="ml-2">
            <div class="btn-group">
              <a href="javascript:void(0)" @click="showCreateUser" class="btn btn-success" slot="afterLimit"><i class="fas fa-plus"></i> Add User</a>
              <!-- <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Export to
                  <span class="sr-only">Toggle Dropdown</span>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#"><i class="far fa-file-pdf text-danger"></i>&nbsp; PDF</a>
                <a class="dropdown-item" href="#"><i class="far fa-file-excel text-success"></i>&nbsp; Excel (CSV)</a>
              </div> -->
            </div>
          </div>
          <div class="btn-group" slot="actions" slot-scope="{row}">
            <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="userDetail(row.id)"> <i class="fas fa-edit"> </i></a>
            <a href="javascript:void(0)" class="btn btn-danger btn-sm text-white" @click="deleteUser(row.id)"> <i class="fas fa-trash"> </i></a>
          </div>
        </v-client-table>
      </div>
    </div>
  </div>
</template>
<script>

import CreateUser from './createUserComponent.vue'

export default {
  name: 'app-modal',
  components:{
    CreateUser
  },   
  data() {
    return {
      userList: [],
      user: {
        id: "",
        name: "",
        username: "",
        email: "",
        department_type: "",
        role: "",
        is_active: ""
      },
      user_id: "",
      pagination: {},
      edit: false,
      searchName: "",

      // Vue-Tables-2 Syntax
      columns:['id','name', 'username','email','is_active','actions'],
      options: {
        initialPage:1,
        perPage:10,
        highlightMatches:true,
        sortIcon: { base:'fas', up:'fa-sort-amount-up', down:'fa-sort-amount-down', is:'fa-sort' },
        headings: {
          id: '#',
          name: 'Name',
          username: 'Username',
          email: 'Email',
          is_active: 'Status',
          actions: 'Actions'
        },
        sortable: ['id','name'],
        texts: {
          filter: "Search:",
          filterPlaceholder: "Search keywords",
        }
      },
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    fetchUsers(page_url) {
      let vm = this;
      page_url = page_url || "user/list";
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.userList = res.data;
        })
        .catch(err => console.log(err));
    },
    deleteUser(id){
      swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
      })
      .then((result) => {
        let vm = this;
        if (result.value === true) {
            axios({
              method: 'delete',
              url: 'user/'+id
            })
            .then(res => {
              console.log(res);
              let i = vm.userList.map(item => item.id).indexOf(id) // find index of your object
              vm.userList.splice(i, 1) // remove it from array
              if(res.data.status == 'success'){
                  Toast.fire({
                    type: 'success', title: 'Data is deleted successfully',
                  });
              }else{
                  Toast.fire({
                      type: 'error', title: 'Opss.. data was not deleted',
                  });
                  }
              })
              .catch(err => console.log(err));
            }
        })
    },
    showCreateUser () {
      this.$modal.show('size-modal',{
        edit : false,
        id : '',
        firstname : '',
        lastname : '',
        username : '',
        password : '',
      })
    },
    userDetail (id) {
        window.location.href = 'users/'+id;
    }
  }
};
</script>