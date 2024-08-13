<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
            <li
                class="page-item"
                :class="{ disabled: currentPage === 1 }"
                @click="prevPage(merchants.prev_page_url)"
            >
                <a class="page-link" tabindex="-1">Previous</a>
            </li>
            <li
                v-for="(pageNumber, i) in totalPage"
                class="page-item"
                :class="{ active: currentPage === pageNumber }"
            >
                <a
                    class="page-link"
                    @click="setCurrentPage(pageNumber)"
                    v-if="
                        i + 1 === 1 ||
                        (currentPage - 3 <= i && currentPage + 3 >= i) ||
                        i === currentPage ||
                        i + 1 === totalPage
                    "
                    :class="{
                        disabled: currentPage === pageNumber,
                        last:
                            pageNumber === totalPage - 1 &&
                            Math.abs(pageNumber - currentPage) > 3,
                        first:
                            pageNumber === 0 &&
                            Math.abs(pageNumber - currentPage) > 3,
                    }"
                >
                    {{ pageNumber }}
                </a>
                <a
                    class="page-link"
                    v-else-if="
                        i === currentPage - (3 + 1) ||
                        i === currentPage + (3 + 1)
                    "
                    >...</a
                >
            </li>
            <li
                class="page-item"
                :class="{ disabled: currentPage === totalPage }"
                @click="nextPage(merchants['next_page_url'])"
            >
                <a class="page-link">Next</a>
            </li>
        </ul>
    </nav>
</template>
<script setup>
import { ref, watchEffect } from "vue";
import axios from "axios";

const pageNumber = ref(0);
const merchants = ref([]);
const statusList = ref([]);
const currentPage = ref(1);
const totalPage = ref(0);
const statusText = ref("");
const nextPageUrl = ref(null);

const capitalized = (name) => {
    const capitalizedFirst = name[0].toUpperCase();
    const rest = name.slice(1);
    return capitalizedFirst + rest;
};

const searchMerchant = (e) => {
    const search = e.target.value;
    fetchMerchants(0, "", search);
};

const filterByDate = (e) => {
    const joining_date = e.target.value;
    fetchMerchants(0, "", "", joining_date);
};

const fetchMerchants = (
    page = 0,
    status = "",
    search = "",
    joining_date = ""
) => {
    axios
        .get("/panel/merchants/merchants", {
            params: { page, status, search, joining_date },
        })
        .then((response) => {
            merchants.value = response.data;
            currentPage.value = response.data.current_page;
            totalPage.value = response.data.last_page;
        });
};

const fetchStatues = () => {
    axios.get("/panel/merchants/statuses").then((response) => {
        statusList.value = response.data;
    });
};

const filterMerchants = (status) => {
    statusText.value = status;
    fetchMerchants(currentPage.value, status);
};

const updateStatus = (merchant, status) => {
    axios
        .post(`/panel/merchants/${merchant}/update-status`, { status })
        .then(() => {
            fetchMerchants();
        });
};

const deleteMerchant = (merchant) => {
    axios.post(`/panel/merchants/${merchant}/delete`).then(() => {
        fetchMerchants();
    });
};

const clearFilter = () => {
    statusText.value = "";
    // Assuming search and joining_date are also refs, clear their values
    search.value = "";
    joining_date.value = "";
    fetchMerchants();
};

const setCurrentPage = (page) => {
    currentPage.value = page;
    fetchMerchants(page);
};

const nextPage = (url) => {
    if (currentPage.value < totalPage.value) {
        axios.get(url).then((response) => {
            merchants.value = response.data;
            currentPage.value = response.data.current_page;
        });
    }
};

const prevPage = (url) => {
    if (currentPage.value !== 1) {
        axios.get(url).then((response) => {
            merchants.value = response.data;
            currentPage.value = response.data.current_page;
        });
    }
};

// Fetch initial data on mount
watchEffect(() => {
    fetchMerchants();
    fetchStatues();
});
</script>
