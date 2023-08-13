<script setup>
import { ref, onMounted, computed, nextTick } from 'vue';
import { toast } from 'vue3-toastify';
import debounce from 'lodash.debounce'

const todos = ref([]);

const todoInput = ref('');

onMounted(() => {
    getList();
});

const completedTodos = computed(() => {
    return todos.value.filter((todo) => todo.completed);
})
const uncompletedTodos = computed(() => {
    return todos.value.filter((todo) => !todo.completed);
})

const getList = async () => {
    const { data } = await axios.get('/api/todos');
    todos.value = data.todos;
}

const updateCompleted = debounce(async (id, state) => {
    await axios.patch('/api/todos/' + id, { completed: state });
    toast("Saved successfully", {
        type: "success",
    });

}, 600);

const addTodo = async () => {
    const { data } = await axios.post('/api/todos', { title: todoInput.value });
    todoInput.value = '';
    todos.value.push(data.todo);
    toast("Saved successfully", {
        type: "success",
    });
}

const deletTodo = async (id) => {
    const { data } = await axios.delete('/api/todos/' + id);
    todos.value.splice(todos.value.findIndex(todo => todo.id == id), 1);
    toast("Deleted successfully", {
        type: "success",
    });
}
</script>

<template>
    <div class="bg-gray-100 flex flex-col min-h-screen w-full justify-center items-center">
        <h1 class="text-3xl font-semibold mb-4">Todo List</h1>
        <div class=" p-6 bg-white shadow-md w-1/2">
            <div class="w-full border-b-2 border-gray-200 pb-4 flex justify-between">
                <input placeholder="Enter Todo..." type="text" v-model="todoInput"
                    class="border-none focus:outline-none flex-grow">
                <button class="bg-indigo-700 hover:bg-indigo-500 text-white px-6 py-3 flex-shrink-0" @click="addTodo">Add
                    Todo</button>
            </div>

            <div class="w-full border-b-2 pb-3 border-gray-200 flex flex-col gap-3 mt-4">
                <h1 class="text-xl font-semibold text-gray-700 mb-4">Pending ( {{ uncompletedTodos.length }} )</h1>
                <div class="flex items-center" v-for="(todo) in uncompletedTodos" :key="todo.id">
                    <button class="flex-shrink-0 text-3xl text-gray-400 hover:text-gray-600"
                        @click="deletTodo(todo.id)">&times;</button>
                    <span class="flex-grow mx-4 text-gray-800 text-2xl">{{ todo.title }}</span>
                    <input type="checkbox" class="w-4 h-4" :id="'checkbox' + todo.id" v-model="todo.completed"
                        :checked="todo.completed == 1" @change="updateCompleted(todo.id, todo.completed)">
                </div>
            </div>

            <div class="w-full flex flex-col gap-3 mt-4">
                <h1 class="text-xl font-semibold text-gray-700 mb-4">Completed ( {{ completedTodos.length }} )</h1>
                <div class="flex items-center" v-for="(todo) in completedTodos" :key="todo.id">
                    <button class="flex-shrink-0 text-3xl text-gray-400 hover:text-gray-600"
                        @click="deletTodo(todo.id)">&times;</button>
                    <span class="flex-grow mx-4 text-gray-800 text-2xl line-through">{{ todo.title }}</span>
                    <input type="checkbox" class="w-4 h-4" :id="'checkbox' + todo.id" v-model="todo.completed"
                        @change="updateCompleted(todo.id, todo.completed)">
                </div>
            </div>


        </div>
    </div>
</template>


