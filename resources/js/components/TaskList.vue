<template>
    <div class="container justify-content-center align-items-center">
        <form
            class=""
            @submit.prevent="addNewTask"
        >
            <div class="d-flex  pt-3 pb-3 justify-content-center align-items-center text-center">
                <div class="d-flex justify-content-center align-items-center text-center col-lg-6 col-md-6 col-sm-12">
                    <input v-model="newTask.title" type="text" placeholder="Write your task ..." class="col-6 mx-2 py-2 bg-white">
                    <button class="col-2 mx-2 py-2 bg-white text-red fs-16 fw-600" type="submit">Add</button>
                </div>
            </div>
        </form>
        <div class="container d-flex justify-content-center align-items-center col pt-3">
            <div class="d-flex justify-content-center align-items-top text-center col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div v-for="(status,i) in allStatus" :key="i" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 justify-content-center align-items-center">
                <div class="card rounded-0">
                    <div class="card-header text-center fs-22 fw-600 rounded-0">
                        {{status.title}}
                    </div>
                    <div class="card-body text-center bg-white">
                        <div v-for="(task,i) in tasks" :key="i" >
                            <div v-if="task.status == status.id" class="bg-grey py-2 my-1 border rounded-0 task-box">
                                {{task.title}}
                                <div>
                                    <b-dropdown id="dropdown-1" text="" class="">
                                        <b-dropdown-item @click="activateInEditMode(task)">Edit</b-dropdown-item>
                                        <b-dropdown-item v-if="task.status == 1" @click="updateStatus(task)">In Progress</b-dropdown-item>
                                        <b-dropdown-item v-if="task.status == 2"  @click="updateStatus(task)">Done</b-dropdown-item>
                                        <b-dropdown-item @click="deleteTask(task)">Delete</b-dropdown-item>
                                        <b-dropdown-item @click="showPriorityModal(task)" v-if="task.status == 2 || task.status == 1">Update Priority</b-dropdown-item>
                                    </b-dropdown>
                                </div>
                               <div :ref="task.id" class="d-none">
                                    <form  @submit.prevent="editTasks(task)">
                                        <div class="form-group">
                                            <input v-model="editTask.title" type="text" class="form-control my-2" >
                                            <button class="btn btn-red align-items-right"  type="submit">Edit</button>
                                        </div>
                                    </form>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

            <!-- Modal -->
            <div ref="modal" class="modal modal-custom" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Priority</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="" >
                        <select v-model="modalTask.prioritySelect" class="modal-select" style="width:200px;">
                            <option value="0" disabled selected>Select:</option>
                            <option value="3">High</option>
                            <option value="1">Normal</option>
                            <option value="2">Low</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">Close</button>
                    <button type="button" class="btn btn-red" @click="updatePriority()">Update</button>
                </div>
                </div>
            </div>
            </div>
    </div>
</template>

<script>
    export default {
        props: {
            statuses:Array,
            allTasks:Object
        },
        data() {
            return {
                allStatus:[],
                newTask: {
                    title: "",
                    staus: 1
                },
                tasks:[],
                editTask:{
                    id: null,
                    title: ""
                },
                errorMessage:"",
                modalTask: {
                    id: null,
                    prioritySelect: 0
                },
            }
        },
        created() {
        },
        mounted() {
            this.tasks = this.$attrs.alltasks
            this.allStatus = this.$props.statuses
            // console.log(this.statuses)
        },
        methods: {
            addNewTask() {
                if (!this.newTask.title) {
                    this.errorMessage = "The title field is required";
                    return;
                }

                axios
                    .post("/tasks", {newTask:this.newTask})
                    .then(res => {
                        this.newTask.title = ""
                        this.tasks.push(res.data.task)
                    })
                    .catch(err => {

                    });

            },
            editTasks(task){
                this.editTask.id = task.id
                let taskId = task.id
                axios
                    .put(`/tasks/${task.id}`, {editTask:this.editTask})
                    .then(res => {
                        this.tasks = res.data.tasks
                        this.editTask.id = null
                        this.editTask.title = ""
                        this.$refs[taskId][0].classList.add("d-none");
                    })
                    .catch(err => {

                    });
            },
            activateInEditMode(task) {
                let taskId = task.id
                this.$refs[taskId][0].classList.remove("d-none");


            },
            deleteTask(task){

                axios
                    .delete(`/tasks/${task.id}`)
                    .then(res => {
                        const taskIndex = this.tasks.indexOf(task)
                        this.tasks.splice(taskIndex, 1)
                    })
                    .catch(err => {

                    });
            },
            updateStatus(task){
                console.log(task)

                axios
                    .post('/tasks/status-update', {task:task})
                    .then(res => {
                        console.log(res)
                        this.tasks = res.data.tasks
                    })
                    .catch(err => {

                    });
            },
            showPriorityModal(task){
                this.modalTask.id = task.id
                this.$refs.modal.classList.add("d-block");
            },
            closeModal(){
                this.$refs.modal.classList.remove("d-block");
            },
            updatePriority(){

                axios
                    .post('/tasks/priority-update', {priorityTask:this.modalTask})
                    .then(res => {
                        this.tasks = res.data.tasks
                        this.$refs.modal.classList.remove("d-block");
                    })
                    .catch(err => {

                    });

            }
        }
    }
</script>
