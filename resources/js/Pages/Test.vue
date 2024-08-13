<template>
    <main class="py-80">
        <template>
            <section class="review-container">
                <h2>ToDo List</h2>
                <div class="tags-wrapper">
                    <p v-for="(filter, index) in filters" :key="index">
                        <span
                            @click="filterTodo(filter)"
                            :class="{ active: filter === activeFilter }"
                            >{{ filter }}</span
                        >
                    </p>
                </div>

                <ul>
                    <li
                        v-for="(todo, index) in getTodos"
                        :key="index"
                        :class="{ done: todo.done }"
                    >
                        <span class="task" @click="doneTodo(todo)">{{
                            todo.content
                        }}</span>
                        <span class="label">{{ todo.type }}</span>
                    </li>
                </ul>
            </section>
        </template>
        <template>
            <section class="empty-container">
                <h2>Your tasks will appear here</h2>
                <img
                    src="https://doodleipsum.com/700?i=b2a7f828acad27e884b0aabcf6f10ab6"
                    alt="a picture of man relaxing and drinking tea"
                />
            </section>
        </template>
    </main>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";

const todos = ref();
const filters = ref(["All", "Personal", "Work", "Other"]);
const activeFilter = ref("All");

const fetchData = async () => {
    try {
        const response = await axios.get("/backend/posts");
        todos.value = response.data.posts.map((post) => ({
            done: false,
            content: post.title, // Adjust this based on the structure of your post data
            type: post.type, // Adjust this based on the structure of your post data
            id: post.id,
        }));
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

onMounted(fetchData);

const getTodos = computed(() => {
    if (activeFilter.value === "All") {
        return todos.value;
    }
    return todos.value.filter((item) => item.type === activeFilter.value);
});
const emptyNote = computed(() => {
    return `There is no tasks with type ${activeFilter.value} so far. Please, add some!`;
});

function doneTodo(todo) {
    todo.done = !todo.done;
    saveData();
}

function saveData() {
    const storageData = JSON.stringify(todos.value);
    localStorage.setItem("todos", storageData);
}
function filterTodo(type) {
    activeFilter.value = type;
}

/*const defaultData = [
    {
        done: false,
        content: "Write a blog post",
        type: "Personal",
        id: Date.now(),
    },
];
const todosData = JSON.parse(localStorage.getItem("todos")) || defaultData;
*/
</script>
