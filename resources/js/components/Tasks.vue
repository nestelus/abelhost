<template>
    <div class="card">
        <div class="card-header">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <div class="nav-link"> Tasks </div>
                    </li>

                    <li class="nav-item">
                        <button id="btn-add-task" class="btn btn-sm btn-primary" @click="openModalTask()" disabled="disabled">Add New Task</button>
                    </li>
                </ul> 
            </nav>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-sm table-hover">
                <thead class="table-dark">
                    <tr>
                        <td>Description</td>
                        <td>Assigned</td>
                        <td>Date End</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in tasks">
                        <td>{{ row.description }}</td>
                        <td>{{ row.assigned.name }}</td>
                        <td>{{ row.date_end }}</td>
                        <td width="130">
                            <button @click="editTask(row)" class="btn btn-sm btn-primary">Edit</button>
                            <button @click="deleteRow(row)" class="btn btn-sm btn-danger">Del</button>
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

        <div class="modal fade" id="modalTask">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Task</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="step_id"  v-model="stepId"/>
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
                        <button type="submit" class="btn btn-primary" v-show="!editMode" @click="saveTask(form)">Save
                        </button>
                        <button type="submit" class="btn btn-primary" v-show="editMode" @click="updateTask(form)">Update
                        </button>
                    </div>
                </div><!-- /.modal-content -->

            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</template>
<script>

    export default {

        props: ['data', 'stepId'],
        data() {
            return {
                editMode: false,
                form: {
                    description: null,
                    assigned_id: null,
                    date_end: null,
                    step_id: this.stepId
                },
                users: [],
                tasks: this.data,
                currentId: this.data[0] ? this.data[0].id : null
            };
        },
        watch: {
            data: function (newVal, oldVal) {
                this.tasks = newVal;
            },
            stepId: function(newVal, oldVal) {
                this.form.step_id = this.stepId;
                if( (newVal === null)) {
                    $('#btn-add-task').attr('disabled', 'disabled');  
                } else  {
                    $('#btn-add-task').attr('disabled', null);  
                }
            }
        },
        methods: {
            openModalTask: function () {
                axios.get('/get-users/').then((response) => {
                    this.users = response.data.users;
                });
                $('#modalTask').modal('show');
            },
            closeModal: function () {
                $('#modalTask').modal('hide');
                this.reset();
                this.editMode = false;
            },
            reset: function () {
                this.form = {
                    description: null,
                    date_end: null,
                    assigned_id: null,
                    step_id: this.stepId
                };
            },
            saveTask: function (data) {
                data._method = 'POST';
                axios.post('/tasks/', data).then((response) => {
                    this.tasks = response.data.data;
                });
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            editTask: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModalTask();
            },
            updateTask: function (data) {
                if (!confirm('Sure'))
                    return;
                data._method = 'PUT';

                axios.post('/tasks/' + data.id, data).then((response) => {
                    this.tasks = response.data.data;
                });
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Sure'))
                    return;
                data._method = 'DELETE';
                axios.post('/tasks/' + data.id, data).then((response) => {
                    this.tasks = response.data.data;
                });
                this.reset();
                this.closeModal();
            }
        }
    }
</script>
