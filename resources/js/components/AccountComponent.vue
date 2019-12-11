<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Account Information</h4>
                        <div class="card-tools" style="position: absolute; right: 1rem; top: 0.5rem;">
                            <button type="button" class="btn btn-primary" @click="create()"><i class="fa fa-plus"></i></button>
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
                                    <td>{{item.organization}}</td>
                                    <td>{{item.account_no}}</td>
                                    <td>{{item.branch}}</td>
                                    <td v-if="item.account_type == 1">Saving Account</td>
                                    <td v-if="item.account_type == 2">Current Account</td>
                                    <td v-if="item.account_type == 3">Join Account</td>
                                    <td class="text-center">
                                        <a @click="edit(item)" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <a @click="destroy(item)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                    <form @submit.prevent="store()" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Account Name</label>
                                <input v-model="form.account_name" type="text" name="account_name" class="form-control" :class="{ 'is-invalid': form.errors.has('account_name') }">
                                <has-error :form="form" field="account_name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Bank</label>
                                <select name="organization" v-model="form.organization" class="form-control">
                                    <option value="">--SELECT--</option>
                                </select>
                                <has-error :form="form" field="account_name"></has-error>
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
            accounts: [],
            form: new Form({
                id: '',
                account_name: '',
                organization: '',
                account_type: '',
                account_no: '',
                branch: '',

            }),
        }
    },
    mounted() {
        this.getAccounts();
        //console.log('Component mounted.')
    },
    methods: {
        getAccounts() {
            axios.get('/api/accounts')
                .then(response => {
                    this.accounts = response.data.data
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
            this.form.busy = true
            this.form.post('/api/accounts')
                .then(response => {
                    this.getAccounts();
                    $("#accountModalLong").modal("hide");
                    if (this.form.successful) {
                        this.$Progress.finish()
                        this.$snotify.success('Account added successfully', 'Success')
                    } else {
                        this.$snotify.success('Something went wrong', 'Error')
                    }
                })
                .catch(e => {
                    console.log(e)
                })
        },
        edit(item) {
            this.editMode = true
            this.form.reset();
            this.form.clear();
            this.form.fill(item);
            $("#accountModalLong").modal("show");
        },
        destroy(item) {
            this.$snotify.clear();
            this.$snotify.confirm(
                "You will not be able to recover this data!",
                "Are you sure?", {
                    showProgressBar: false,
                    closeOnClick: false,
                    pauseOnHover: true,
                    buttons: [{
                            text: "Yes",
                            action: toast => {
                                this.$snotify.remove(toast.id);
                                axios
                                    .delete("/api/accounts/" + item.id)
                                    .then(response => {
                                        this.getAccounts();
                                        this.$snotify.success(
                                            "Account Successfully Deleted",
                                            "Success"
                                        );
                                    })
                                    .catch(e => {
                                        console.log(e);
                                    });
                            },
                            bold: true
                        },
                        {
                            text: "No",
                            action: toast => {
                                this.$snotify.remove(toast.id);
                            },
                            bold: true
                        }
                    ]
                }
            );
        }
    }
}

</script>
