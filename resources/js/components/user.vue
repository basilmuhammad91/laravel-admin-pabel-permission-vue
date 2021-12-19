<template>
   <div class="card">
      <div class="card-header">
        <h3 class="card-title">User Table</h3>

    {{ permissions }}

        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item mr-1">
                    <button type="button" class="btn btn-sm btn-primary" @click="createMode()"><i class="fas fa-plus-circle"></i> Add New</button>
                </li>

                <li class="nav-item">
                    <div class="input-group mt-0 input-group-sm" style="width: 350px;">
                        <input type="text" name="table_search" v-model="searchWord" class="form-control float-right" placeholder="Search by name, email">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default" @click="search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
      </div>
      <!-- /.card-header -->

      <!-- Table to show user records  -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Role</th>
              <th>Email</th>
              <th>Date Posted</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

            <tr v-for="user in users" :key="user.id">
              <td>{{user.id}}</td>
              <td>{{user.name}}</td>
              <td>{{user.role}}</td>
              <td>{{user.email}}</td>
              <td>{{user.created_at | date}}</td>
              <td>
                <button class="btn btn-sm btn-info" @click="viewUser(user)"> <i class="fa fa-eye"></i> View</button>
                <button class="btn btn-sm btn-warning" @click="editUser(user)" > <i class="fa fa-edit"></i> Edit</button>
                <button class="btn btn-sm btn-danger" @click="deleteUser(user)"> <i class="fa fa-trash"></i> Delete </button>
              </td>
            </tr>

          </tbody>
        </table>
      </div>
      <!-- End of User Table -->
      <loading :loading="loading"></loading>
      <!-- View Modal Start -->
      <div class="modal fade" id="viewUser" tabindex="-1" aria-labelledby="viewUserLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <p><b>Name: </b>{{user.name}}</p>
                  <p><b>Email: </b>{{user.email}}</p>
                  <p><b>Last Updated: </b>{{user.updated_at | date}}</p>
                  <p><b>Date Posted: </b>{{user.created_at | date}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End of View Modal -->

      <!-- Create Modal Start -->
      <div class="modal fade" id="createUser" tabindex="-1" aria-labelledby="createUserLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createUserLabel" v-show="!editMode">Create User</h5>
              <h5 class="modal-title" id="createUserLabel" v-show="editMode">Edit User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="!editMode ? createUser() : updateUser()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Name </label>
                            <input v-model="form.name" type="text" name="name" placeholder="Name"
                                class="form-control" :class="{'is-invaild': form.errors.has('name')}">
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <label> Email </label>
                            <input v-model="form.email" type="text" name="email" placeholder="Email"
                                class="form-control" :class="{'is-invaild': form.errors.has('email')}">
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <label> Phone Number </label>
                            <input v-model="form.phone" type="text" name="phone" placeholder="Phone Number"
                                class="form-control" :class="{'is-invaild': form.errors.has('phone')}">
                            <has-error :form="form" field="phone"></has-error>
                        </div>

                        <div class="form-group">
                            <label> Choose Role </label>
                            <b-form-select
                                v-model="form.role"
                                :options="roles"
                                text-field="name"
                                value-field="id"

                            ></b-form-select>
                            <has-error :form="form" field="role"></has-error>

                        </div>

                        <div class="form-group">
                            <label> Password </label>
                            <input v-model="form.password" type="password" name="password" placeholder="Password"
                                class="form-control" :class="{'is-invaild': form.errors.has('password')}">
                            <has-error :form="form" field="password"></has-error>
                        </div>

                        <b-form-group label="Assign Permissions">
                            <b-form-checkbox
                                v-for="option in permissions"
                                v-model="form.permissions"
                                :key="option.name"
                                :value="option.name"
                                name="flavour-3a"
                            >
                                {{ option.name }}
                            </b-form-checkbox>
                        </b-form-group>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <b-button variant="primary" v-if="!load" disabled>
                          <b-spinner small type="grow"></b-spinner>
                          {{ action }}
                        </b-button>
                        <button type="submit" v-if="load" class="btn btn-primary" v-show="!editMode">Save</button>
                        <button type="submit" v-if="load" class="btn btn-primary" v-show="editMode">Update</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
      <!-- End of Create Modal -->

      <!-- /.card-body -->
    </div>

</template>

<script type="text/javascript">

  export default{
    data(){
      return {
        action: '',
        searchWord: '',
        editMode: false,
        loading: false,
        load: true,
        user: [],
        users: [],
        permissions: [],
        roles: [],
        form: new Form({
          'id': '',
          'name': '',
          'phone': '',
          'password': '',
          'email': '',
          'permissions': [],
          'role': 1,
        })
      }
    },

    methods: {
      // Mode to check whether it is creating or updating
      createMode(){
        this.form.reset();
        this.editMode = false;
        $('#createUser').modal('show');
      },
      // function will run when user click on edit button
      editUser(user){
        this.editMode = true;
        this.form.reset();
        this.form.fill(user);
        this.form.role = user.roles[0].id;
        this.form.permissions = user.userPermissions;
        $('#createUser').modal('show');
      },
      // Get all the users to show in table
      getUsers(){
        this.loading = true;
        // axios.get('getAllUsers')
        axios.get('getAllUsers')
        .then((response)=>{
          this.loading = false;
          this.users = response.data.users
        }).catch((e)=>{
          swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: e,
          });
          this.loading = false;
        })
      },
      // Get roles to show in dropdown
      getRoles(){
        axios.get('getAllRoles')
        .then((response)=>{
          this.roles = response.data.roles
        }).catch((e)=>{
          swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: e,
          })
        })
      },
      // Get permissions to show in checboxes
      getPermissions(){
        axios.get('api/getOrgPermissions')
        // axios.get('getAllPermission')
        .then((response)=>{
          this.permissions = response.data
        if(this.$access.can('edit_user'))
        {
            console.log('Authorize');
        }
        else
        {
            console.log('Unauthorize');
        }
        // console.log(this.$access.can('create_user'));
        }).catch((e)=>{
            swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: e,
            })
        });
      },
      // Function will call on submit button to save the record into database
      createUser(){
        this.action = 'Creating User...';
        this.load = false;
        this.form.post('/account/create')
        .then((response)=>{
          this.load = true;
          Fire.$emit('loadUser');
          $('#createUser').modal('hide');
          swal.fire({
              icon: 'success',
              title: 'Account Created',
              text: 'Your account has been created successfully',
            });
          this.form.reset();
          // window.location = 'user';
        }).catch((e)=>{
          this.load = true;
          swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: e,
            })
        })
      },

      // Update the user
      updateUser(){
        this.action = 'Updating User...';
        this.load = false;
        this.form.put('/account/update/'+this.form.id)
        .then((response)=>{
          this.load = true;
          Fire.$emit('loadUser');
          $('#createUser').modal('hide');
          swal.fire({
              icon: 'success',
              title: 'User Updated',
              text: 'Your account has been updated successfully',
            });
          this.form.reset();
          window.location = '/user';
        }).catch((e)=>{
          this.load = true;
          swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: e,
            })
        })
      },

      // Function will call on clicking the view button
      viewUser(user){
        $('#viewUser').modal('show');
        this.user = user;
      },

      deleteUser(user){
        swal.fire({
          title: 'Are you sure?',
          text: user.name+" will be deleted",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
             axios.delete('user/delete/'+user.id)
              .then((response)=>{
                swal.fire({
                  icon: 'success',
                  title: 'User Deleted !',
                  text: 'User has been deleted successfully !',
                });

              }).catch((e)=>{
                swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: e,
                })
              })
            }
          })
      },

      // Search for the user
      search(){
          axios.get('search/user?search='+this.searchWord)
            .then((response)=>{
              this.users = response.data.users
            }).catch((e)=>{
              swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: e,
                })
            })
      },

    },
    created()
    {
      this.getUsers();
      this.getRoles();
      this.getPermissions();
      Fire.$on('loadUser', () => {
        this.getUsers;
      })
    }
  }

</script>
