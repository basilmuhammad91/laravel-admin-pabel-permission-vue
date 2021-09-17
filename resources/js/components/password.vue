<template>
	<main>
		<div class="card">
		  <div class="card-header">
		    Change Password
		  </div>
		  <div class="card-body">
		    <form @submit.prevent="change_password()">
		    	<div class="row">
		    		<div class="col-md-12">

		    			<div class="form-group">
                            <label>Enter New Password</label>
                            <input v-model="form.password" type="password" name="password"  id="password" class="form-control" value="" placeholder="New Password">
                            <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" />
                        </div>

                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" v-model="form.confirm" name="confirm" id="confirm" class="form-control" value="" placeholder="New Password">
                        </div>

                        <button class="btn btn-primary" v-if="!load">Change Password</button>
                        <b-button variant="primary" disabled v-if="load">
                          <b-spinner small type="grow"></b-spinner>
                          Changing Password...
                        </b-button>

		    		</div>
		    	</div>
		    </form>
		  </div>
		</div>
	</main>
</template>

<script type="text/javascript">
	export default{
		data(){
			return{
				load: false,
				form: new Form({
					'password': '',
					'confirm': '',
				}),
			}
		},

		methods: {
			change_password(){
				this.load = true;
				this.form.post("http://localhost/laravel/admin/public/password/post")
				.then((response)=>{
					this.load = false;
					 swal.fire({
		              icon: 'success',
		              title: 'Password Changed',
		              text: 'Your password has been changed successfully',
		            });
					 this.l
				}).catch((e)=>{
					this.load = false;
					 swal.fire({
		              icon: 'success',
		              title: 'Account Created',
		              text: 'Your account has been created successfully',
		            });
				})
			}
		}

	}
</script>