<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-light float-start">{{ title }}</h5>
                        </div>
                        <div class="col-md-6">
                            <button @click="openAddTaskModal" class="btn btn-primary btn-sm float-end">Add Task</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <th>id</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Assignee</th>
                                <th>Reporter</th>
                                <th>Status</th>
                                <th>Points</th>
                                <th>Details</th>
                            </thead>
                            <tbody>
                                <tr v-for="(task, index) in tasks" :key="index">
                                    <td>{{ task.id }}</td>
                                    <td>{{ task.title }}</td>
                                    <td>{{ task.date }}</td>
                                    <td>{{ task.assignee }}</td>
                                    <td>{{ task.reporter }}</td>
                                    <td>{{ task.status }}</td>
                                    <td>{{ task.points }}</td>
                                    <td>{{
                                        task.details.length <= 10 ? task.details : task.details.substr(0, 10) + '...'
                                    }}
                                            </td>
                                    <td>
                                        <button @click="editTask(task)"
                                            class="btn btn-primary btn-sm mx-1">Edit</button>
                                        <button @click="openDeleteTaskModal(task)"
                                            class="btn btn-danger btn-sm mx-1">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div :class="`modal-dialog modal-dialog-centered ${!deleteMode ? 'modal-lg' : 'modal-sm'}`">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel" v-show="!deleteMode">{{!editMode ? 'Add New Task' :
                    'Update Task'}}</h5>
                    <h5 class="modal-title" id="taskModalLabel" v-show="deleteMode">Delete Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" v-show="!deleteMode">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" v-model="taskData.title" class="form-control">
                                <span class="text-danger" v-show="taskErrors.title">Title is required</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" v-model="taskData.date" class="form-control">
                                    <span class="text-danger" v-show="taskErrors.date">Date is required</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="assignee">Assignee</label>
                                        <select class="form-control" v-model="taskData.assignee">
                                            <option v-for="user in users" :key="user.name" :value="user.name">
                                                {{ user.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reporter">Reporter</label>
                                        <input class="form-control" type="text" v-model="taskData.reporter" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="points">Points</label>
                                        <input type="number" v-model="taskData.points" class="form-control">
                                        <span class="text-danger" v-show="taskErrors.points">Points are required</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select v-model="taskData.status" class="form-control">
                                            <option v-for="(value, key) in status" :key="key" :value="value">{{ value }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-show="!deleteMode">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="details">Details</label>
                                <textarea class="form-control" rows="3" v-model="taskData.details"></textarea>
                            </div>
                        </div>
                    </div>

                    <h5 class="text-center" v-show="deleteMode">Are you sure you want to delete this task?</h5>
                </div>
                <div class="modal-footer" v-show="!deleteMode">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button @click="!editMode ? addTask() : updateTask()" type="button" class="btn btn-primary">
                        {{!editMode ? 'Add Task' : 'Save changes'}}</button>
                </div>
                <div class="modal-footer" v-show="deleteMode">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="deleteTask" class="btn btn-primary">Delete Task</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Status from '../Status.js';

export default {
    setup: () => ({
        title: 'All Tasks'
    }),
    data() {
        return {
            taskData: {
                id: 0,
                title: '',
                date: '',
                assignee: '',
                reporter: '',
                points: 0,
                status: '',
                details: ''
            },
            taskErrors: {
                title: false,
                date: false,
                points: false
            },
            userInfo: {
                id: '',
                name: '',
                email: '',
            },
            editMode: false,
            deleteMode: false,
            tasks: {},
            users: {},
            status: Status,
        }
    },
    mounted() {
        this.getUserInfo();
        this.getTasks();
        this.getUsers();
    },
    methods: {
        openAddTaskModal() {
            this.editMode = false;
            this.deleteMode = false;
            this.taskData = {
                id: 0,
                title: '',
                date: '',
                assignee: '',
                reporter: this.userInfo.name,
                points: 0,
                status: Status.Open,
                details: ''
            }
            this.taskErrors = {
                title: false,
                date: false,
                points: false
            }
            $('#taskModal').modal('show');
        },
        getTasks() {
            axios.get(window.url + 'api/getTasks').then(response => {
                this.tasks = response.data;
            }).catch(errors => {
                console.log(errors);
            });
        },
        getUsers() {
            axios.get(window.url + 'api/getUsers').then(response => {
                this.users = response.data;
            }).catch(errors => {
                console.log(errors);
            });
        },
        getUserInfo() {
            axios.get(window.url + 'api/getUserInfo').then(response => {
                this.userInfo = response.data;
            }).catch(errors => {
                console.log(errors);
            });
        },
        updateTask() {
            this.taskData.title == '' ? this.taskErrors.title = true : this.taskErrors.title = false;
            this.taskData.date == '' ? this.taskErrors.date = true : this.taskErrors.date = false;
            this.taskData.points == 0 ? this.taskErrors.points = true : this.taskErrors.points = false;

            if (this.taskData.title && this.taskData.date && this.taskData.points) {
                axios.post(window.url + 'api/updateTask/' + this.taskData.id, this.taskData).then(response => {
                    this.getTasks();
                }).catch(errors => {
                    console.log(errors);
                }).finally(() => {
                    $('#taskModal').modal('hide');
                })
            }
        },
        editTask(task) {
            this.editMode = true;
            this.deleteMode = false;
            this.taskData = {
                id: task.id,
                title: task.title,
                date: task.date,
                assignee: task.assignee,
                reporter: task.reporter,
                points: task.points,
                status: task.status,
                details: task.details
            };
            $('#taskModal').modal('show');
        },
        deleteTask() {
            axios.post(window.url + 'api/deleteTask/' + this.taskData.id).then(response => {
                this.getTasks()
            }).catch(errors => {
                console.log(errors)
            }).finally(() => {
                $('#taskModal').modal('hide')
            });
        },
        openDeleteTaskModal(task) {
            this.deleteMode = true;
            this.taskData.id = task.id;
            $('#taskModal').modal('show');
        },
        addTask() {
            this.taskData.title == '' ? this.taskErrors.title = true : this.taskErrors.title = false;
            this.taskData.date == '' ? this.taskErrors.date = true : this.taskErrors.date = false;
            this.taskData.points == 0 ? this.taskErrors.points = true : this.taskErrors.points = false;

            if (this.taskData.title && this.taskData.date && this.taskData.points) {
                axios.post(window.url + 'api/addTask', this.taskData).then(response => {
                    this.getTasks();
                }).catch(errors => {
                    console.log(errors)
                }).finally(() => {
                    $('#taskModal').modal('hide');
                })
            }
        }
    }
}
</script>