<template>
  <div class="app-modal">
    <create-user/>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">User List</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <div class="row mb-2">
            <div class="col-md-4">
              <input
                type="text"
                v-on:keyup="searchUser"
                v-model="user.searchName"
                class="form-control bg-light border-0 small"
                placeholder="Search for Name..."
                aria-label="Search"
                aria-describedby="basic-addon2"
              />
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-6 pull-right text-right">
              <button class="btn btn-success" @click="showCreateUser">
                <i class="fas fa-plus"></i> Add User
              </button>
            </div>
          </div>
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th class="text-center">Name</th>
                <th class="text-center">Username</th>
                <th class="text-center">Email</th>
                <th class="text-center">Department</th>
                <!-- <th class="text-center">Role</th> -->
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in userList" v-bind:key="user.id">
                <td class="text-center">{{ user.id }}</td>
                <td class="text-center">{{ user.name }}</td>
                <td class="text-center">{{ user.username }}</td>
                <td class="text-center">{{ user.email }}</td>
                <td class="text-center">{{ user.department_type }}</td>
                <!-- <td class="text-center">lorem</td> -->
                <td class="text-center">
                    <div v-if="user.is_active === 1 ">
                        Active
                    </div>
                    <div v-else>
                        Inactive
                    </div>
                </td>
                <td class="text-center">
                  <button class="btn btn-primary btn-sm" @click="userDetail(user.id)">
                    <i class="fas fa-pencil-alt"></i>
                  </button>
                  <button class="btn btn-danger btn-sm" @click="deleteUser(user.id)">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="row no-padding no-margin">
            <div class="col-md-12 no-padding">
              <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                  <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a
                      class="page-link"
                      href="#"
                      @click="fetchUsers(pagination.prev_page_url)"
                    >Previous</a>
                  </li>
                  <li class="page-item" disabled>
                    <a
                      class="page-link text-dark"
                      href="#"
                    >Page {{pagination.current_page}} of {{pagination.last_page}}</a>
                  </li>
                  <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchUsers(pagination.next_page_url)">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const Toast = swal.mixin({
    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
});

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
      searchName: ""
    };
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    searchUser() {
      let vm = this;
      let search = this.user.searchName ? this.user.searchName : "";
      console.log(vm);

      fetch("user/search?search=" + search)
        .then(res => res.json())
        .then(res => {
          this.userList = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    fetchUsers(page_url) {
      let vm = this;
      page_url = page_url || "user/list";
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          // console.log(res.data);
          this.userList = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };
      this.pagination = pagination;
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