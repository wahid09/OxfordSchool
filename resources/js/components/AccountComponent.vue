<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <strong><p>For Account Create, Update and Edit, You have to Login First!</p></strong>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Account Information</h4>
                        <div class="card-tools" style="position: absolute; right: 1rem; top: 0.5rem;">
                            <button type="button" class="btn btn-primary" @click="create()"><i class="fa fa-plus"></i>Add Account</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Account Name</th>
                                    <th scope="col">Bank</th>
                                    <th scope="col">Account No</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Account Type</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in accounts" :key="item.id">
                                    <th scope="row">{{item.account_name}}</th>
                                    <td>{{item.organization.name}}</td>
                                    <td>{{item.account_no}}</td>
                                    <td>{{item.branch}}</td>
                                    <td v-if="item.account_type == 1">Saving Account</td>
                                    <td v-if="item.account_type == 2">Current Account</td>
                                    <td v-if="item.account_type == 3">Join Account</td>
                                    <td class="text-center">
                                        <a @click="edit(item)" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <a @click="destroy(item.id)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        &nbsp;
                        <pagination-component
                            v-if="pagination.last_page > 1 "
                            :pagination = "pagination"
                            :offset = "5"
                            @paginate ="getAccounts()"
                        ></pagination-component>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="accountModalLong" tabindex="-1" role="dialog" aria-labelledby="accountModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="accountModalLongTitle">{{editMode ? "Edit" : "Add New"}} Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? update() : store()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Account Name</label>
                                <input v-model="form.account_name" type="text" name="account_name" class="form-control" :class="{ 'is-invalid': form.errors.has('account_name') }">
                                <has-error :form="form" field="account_name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Bank</label>
                                <select name="organization" v-model="form.organization" class="form-control">
                                    <option v-for="item in organizations" :value="item.id">{{ item.name }}</option>
                                </select>
                                <has-error :form="form" field="organization"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Account No</label>
                                <input v-model="form.account_no" type="text" name="account_no" class="form-control" :class="{ 'is-invalid': form.errors.has('account_no') }">
                                <has-error :form="form" field="account_no"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Branch</label>
                                <input v-model="form.branch" type="text" name="branch" class="form-control" :class="{ 'is-invalid': form.errors.has('branch') }">
                                <has-error :form="form" field="branch"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Account Type</label>
                                <select name="account_type" v-model="form.account_type" class="form-control">
                                    <option value="1" selected>Saving Account</option>
                                    <option value="2">Current Account</option>
                                    <option value="3">Joint Account</option>
                                </select>
                                <has-error :form="form" field="account_name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Swift Code</label>
                                <input v-model="form.swift_code" type="text" name="swift_code" class="form-control" :class="{ 'is-invalid': form.errors.has('swift_code') }">
                                <has-error :form="form" field="swift_code"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Route No</label>
                                <input v-model="form.route_no" type="text" name="route_no" class="form-control" :class="{ 'is-invalid': form.errors.has('route_no') }">
                                <has-error :form="form" field="route_no"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button :disabled="form.busy" type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            editMode: false,
            pagination:{
                    current_page: 1
            },
            accounts: [],
            organizations:[],
            form: new Form({
                id: '',
                account_name: '',
                organization: '',
                name: '',
                account_type: '',
                account_no: '',
                branch: '',
                swift_code: '',
                route_no: '',

            }),
        }
    },
    mounted() {
        this.getAccounts();
        this.getOganizations();
        //console.log('Component mounted.')
    },
    methods: {
        getAccounts() {
            axios.get('/api/accounts?page='+this.pagination.current_page)
                .then(response => {
                    this.accounts = response.data.data
                    this.pagination = response.data.meta
                    //console.log(response)
                })
                .catch(e => {
                    console.log(e)
                })
        },
        getOganizations() {
            axios.get('/api/organizations')
                .then(response => {
                    this.organizations = response.data
                    //console.log(response)
                })
                .catch(e => {
                    console.log(e)
                })
        },
        create() {
            this.editMode = false;
            this.form.reset();
            this.form.clear();
            $("#accountModalLong").modal("show");
        },
        store() {
                this.form.busy = true;
                this.form.post('api/accounts')
                    .then(response=>{
                        this.getAccounts();
                        $('#accountModalLong').modal('hide')
                        if(this.form.successful){
                            toast.fire({
                              type: 'success',
                              title: 'Account created successfully'
                            })
                        }else{
                            toast.fire({
                              type: 'warning',
                              title: 'Somthing went wrong in here'
                            })
                        }
                    })
                    this.getAccounts();
        },
        edit(item) {
            this.editMode = true
            this.form.reset();
            this.form.clear();
            this.form.fill(item);
            $("#accountModalLong").modal("show");
        },
        update(){
                this.form.busy = true;
                this.form.put("api/accounts/" +this.form.id)
                    .then(response =>{
                        $('#accountModalLong').modal('hide')
                        if(this.form.successful)
                            toast.fire({
                              type: 'success',
                              title: 'Account Update successfully'
                            })
                    }).catch(e=>{
                        consol.log(e)
                    })
                    this.getAccounts();
        },
        destroy(id) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    this.form.delete('api/accounts/' + id)
                        .then(response => {
                            swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            this.getAccounts();
                        }).catch(() => {
                            swal.fire("Failed", "There Was Somthing Wrong", "warning")
                        });
                }
            })
        }
    }
}

</script>
