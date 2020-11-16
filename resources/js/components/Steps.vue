<template>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <div class="nav-link"> Steps </div>
                            </li>

                            <li class="nav-item">
                                <button id="btn-add-step" class="btn btn-sm btn-primary" @click="openModalStep()" disabled="disabled">Add New Step</button>
                            </li>
                        </ul> 
                    </nav>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-sm table-hover" id="step-table">
                        <thead class="table-dark">
                            <tr>
                                <td>Description</td>
                                <td>Assigned</td>
                                <td>Date End</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in steps" @click="loadTask(row.id)" :id="'st-tr-' + row.id">
                                <td>{{ row.description }}</td>
                                <td>{{ row.assigned.name }}</td>
                                <td>{{ row.date_end }}</td>
                                <td width="130">
                                    <button @click="editStep(row)" class="btn btn-sm btn-primary">Edit</button>
                                    <button @click="deleteRow(row)" class="btn btn-sm btn-danger">Del</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="modal fade" id="modalStep">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Step</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="project_id"  v-model="projectId"/>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" required="required" id="description" v-model="form.description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="assigned_id">Assigned</label>
                            <select id="assigned_id" class="form-control" v-model="form.assigned_id">
                                <option value="0">Select User Assigned</option>
                                <option v-for="user in users" :value="user.id">{{ user.name }}</option>
                            </select> 

                        </div>
                        <div class="form-group">
                            <label for="date_end">Date End</label>
                            <input  type="date" class="form-control" required id="date_end" v-model="form.date_end"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" @click="closeModal()">Close</button>
                        <button type="submit" class="btn btn-primary" v-show="!editMode" @click="saveStep(form)">Save
                        </button>
                        <button type="submit" class="btn btn-primary" v-show="editMode" @click="updateStep(form)">Update
                        </button>
                    </div>
                </div><!-- /.modal-content -->

            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="col-md-6">
            <tasks :step-id="currentId" :data="tasks"></tasks>
        </div>
    </div>

</template>

<script>

    import Tasks from './Tasks'

    export default {
        components: {
            Tasks,
        },
        props: ['data', 'projectId'],
        data() {
            return {
                editMode: false,
                form: {
                    description: null,
                    assigned_id: null,
                    date_end: null,
                    project_id: this.projectId
                },
                users: [],
                steps: this.data,
                tasks: [],
                currentId: this.data[0] ? this.data[0].id : null
            };
        },
        watch: { 
            data: function(newVal, oldVal) { 
                this.steps = newVal;
            },
            projectId: function(newVal, oldVal) {
                if (newVal !== oldVal) {
                    this.tasks = [];
                    this.currentId = null;
                }
                if( (newVal === null)) {
                    $('#btn-add-step').attr('disabled', 'disabled');  
                } else  {
                    $('#btn-add-step').attr('disabled', null);  
                }
                             
            }
            
        },     
        methods: {
            openModalStep: function () {
                axios.get('/get-users/').then((response) => {
                    this.users = response.data.users;
                });
                $('#modalStep').modal('show');
            },
            closeModal: function () {
                $('#modalStep').modal('hide');
                this.reset();
                this.editMode = false;
            },
            reset: function () {
                this.form = {
                    description: null,
                    date_end: null,
                    assigned_id: null,
                    project_id: this.projectId
                };
            },
            saveStep: function (data) {
                data._method = 'POST';
                axios.post('/steps/', data).then((response) => {
                    this.steps = response.data.data;
                });
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            editStep: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModalStep();
            },
            updateStep: function (data) {
                if (!confirm('Sure'))
                    return;
                data._method = 'PUT';

                axios.post('/steps/' + data.id, data).then((response) => {
                    this.steps = response.data.data;
                });
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Sure'))
                    return;
                data._method = 'DELETE';
                axios.post('/steps/' + data.id, data).then((response) => {
                    this.steps = response.data.data;
                });
                this.reset();
                this.closeModalStep();
            },

            loadTask: function (currentId) {
                this.currentId = currentId;
                $('#step-table').find('tr').removeClass('table-info');
                $('#st-tr-' + currentId).addClass('table-info');
                axios.get('/tasks/step/' + currentId).then((response) => {
                    this.tasks = response.data.data;
                });
            }
        }
    }
</script>
