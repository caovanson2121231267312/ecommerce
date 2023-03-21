<template>
    <div id="get-tasks">
        <form @submit.prevent="addTask">
            <input class="form-control" :value="newTask" @change="getTask" placeholder="I need to...">
            <br>
            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> New Task</button>
        </form>
    </div>

    <div id="list-tasks">
        <div class="panel panel-default">
            <div class="panel-heading my-task">
                <h3 class="panel-title">My Tasks<span class="task-length" v-if="tasks.length > 0">{{ tasks.length }}</span>
                </h3>
            </div>
            <div class="panel-body">
                <ul class="list-group" name="custom-classes-transition" enter-active-class="animated tada"
                    leave-active-class="animated bounceOutRight" is="transition-group">
                    <li class="list-group-item" v-for="(task, index) in tasks" v-bind:key="index">
                        <img src="http://lazi.vn/files/large/5a64450874df215" alt="" width="53">
                        {{ task.body }}
                        <div class="btn-group">
                            <button type="button" @click="edit(task)" class="btn btn-default btn-sm" href="#edit"
                                role="button" data-toggle="modal">
                                <span class="glyphicon glyphicon-edit"></span> Edit
                            </button>
                            <button type="button" @click="complete(task)" class="btn btn-success btn-sm">
                                <span class="glyphicon glyphicon-ok-circle"></span> Complete
                            </button>
                            <button type="button" @click="remove(task)" class="btn btn-danger btn-sm">
                                <span class="glyphicon glyphicon-remove-circle"></span> Remove
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="completed-tasks">
        <div class="panel panel-default">
            <div class="panel-heading my-completed">
                <h3 class="panel-title">Completed<span class="completed-length" v-if="completed.length > 0">{{
                    completed.length }}</span></h3>
            </div>
            <div class="panel-body">
                <ul class="list-group" name="slide-fade" is="transition-group">
                    <li class="list-group-item complete-list" v-for="(task, index) in completed" v-bind:key="index">
                        <img src="http://lazi.vn/files/large/5a64450874df215" alt="" width="53">
                        {{ task.body }}
                        <button type="button" @click="remove(task)" class="btn btn-danger btn-sm remove-completed">
                            <span class="glyphicon glyphicon-remove-circle"></span> Remove
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <Products />

    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <img class="img-fluid" src="@/assets/images/banners/seo.jpg" alt="cao van son" />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Products from "../../components/Product/Products.vue";

export default {
    components: {
        Products,
    },
    setup() {
        // const store = useStore()
    },
    methods: {
        getTask(e) {
            this.$store.dispatch('getTask', e.target.value)
        },
        addTask(e) {
            e.preventDefault();
            this.$store.dispatch('addTask')
            this.$store.dispatch('clearTask')
        },
        edit(task) {
            this.$store.dispatch('editTask', task)
        },
        complete(task) {
            this.$store.dispatch('completeTask', task)
        },
        remove(task) {
            this.$store.dispatch('removeTask', task)
        },
        remove(task) {
            this.$store.dispatch('removeTask', task)
        }
    },
    computed: {
        newTask() {
            return this.$store.getters.newTask
        },
        tasks() {
            return this.$store.getters.tasks
        },
        newTask() {
            return this.$store.getters.newTask
        },
        completed() {
            return this.$store.getters.completedTask
        }
    }
}
</script>

<style>
.btn-group {
    float: right;
}
</style>