<template>

    <div class="col">

        <div class="row py-3">
            <div class="col h-50">

                <div class="card">
                    <div class="card-header">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <div class="nav-link"> Projects </div>
                                </li>

                                <li class="nav-item">
                                    <button class="btn btn-sm btn-primary" @click="openModalProject()">Add New Project</button>
                                </li>
                            </ul> 
                        </nav>
                    </div>

                    <div class="card-body overflow-auto h-50">

                        <table id="project-table" class="table table-bordered table-sm table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <td>Title</td>
                                    <td>Date Start</td>
                                    <td>Date End</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in projects" @click="loadStep(row.id)" :id="'pr-tr-' + row.id">
                                    <td>{{ row.title }}</td>
                                    <td>{{ row.date_start }}</td>
                                    <td>{{ row.date_end }}</td>
                                    <td width="130">
                                        <button @click="edit(row)" class="btn btn-sm btn-primary">Edit</button>
                                        <button @click="deleteRow(row)" class="btn btn-sm btn-danger">Del</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="modal fade" id="modalProject">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">New Project</h4>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input class="form-control" required="required" id="title" v-model="form.title"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_start">Date Start</label>
                                        <input  type="date" class="form-control" required id="date_start" v-model="form.date_start"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_end">Date End</label>
                                        <input  type="date" class="form-control" required id="date_end" v-model="form.date_end"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea  type="date" class="form-control" required id="description" v-model="form.description"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" @click="closeModal()">Close</button>
                                    <button type="submit" class="btn btn-primary" v-show="!editMode" @click="saveProject(form)">Save
                                    </button>
                                    <button type="submit" class="btn btn-primary" v-show="editMode" @click="updateProject(form)">Update
                                    </button>
                                </div>
                            </div><!-- /.modal-content -->

                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <steps :project-id="currentId" :data="steps"></steps> 
            </div>
        </div>
    </div>

</template>

<script>

    import Steps from './Steps'

    export default {
        components: {
            Steps,
        },
        props: ['data'],
        data() {            
            return {                
                editMode: false,
                form: {
                    title: null,
                    date_start: null,
                    date_end: null
                },
                projects: this.data,
                currentId: this.data[0] ? this.data[0].id : null,
                steps: []
            };
        },
        methods: {
            openModalProject: function () {
                $('#modalProject').modal('show');
            },
            closeModal: function () {
                $('#modalProject').modal('hide');
                this.reset();
                this.editMode = false;
            },
            reset: function () {
                this.form = {
                    title: null,
                    date_start: null,
                    date_end: null,
                }
            },
            saveProject: function (data) {
                data._method = 'POST';
                axios.post('/projects/', data).then((response) => {console.log(response); this.projects = response.data.data;});
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true; 
                this.openModal();
            },
            updateProject: function (data) {
                if (!confirm('Sure'))
                    return;
                data._method = 'PUT';
                
                axios.post('/projects/' + data.id, data).then((response) => {console.log(response); this.projects = response.data.data;});
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Sure'))
                    return;
                data._method = 'DELETE';
                axios.post('/projects/' + data.id, data).then((response) => {this.projects = response.data.data;});
                this.reset();
                this.closeModal();
            },
            
            loadStep: function(projectId) {
                this.currentId = projectId; 
                $('#project-table').find('tr').removeClass('table-success');
                $('#step-table').find('tr').removeClass('table-info');
                $('#pr-tr-' + projectId).addClass('table-success');
                axios.get('/steps/project/' + projectId).then((response) => {this.steps = response.data.data;});
            }
        }
    }
</script>