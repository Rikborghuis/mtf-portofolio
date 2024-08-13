<script setup>
import { ref, defineProps, computed, watch, onMounted } from "vue";

const props = defineProps({
    customPosts: Object,
    xlColumn: { type: Number },
    mdColumn: { type: Number },
});

const customPosts = ref(props.customPosts);

const paginatedData = ref([]);

//get grid layout to display different ammounts of cars on speceific pages
const gridClass = computed(() => {
    return `xl:grid-cols-${props.xlColumn} md:grid-cols-${props.mdColumn}`;
});

function changePagination(pageState) {
    if (
        !Array.isArray(customPosts.value.posts) ||
        customPosts.value.posts.length === 0
    )
        return;

    if (pageState.page > pageState.pageCount || pageState.page < 0) return;

    const start = pageState.rows * pageState.page;
    const end = start + pageState.rows;
    paginatedData.value = customPosts.value.posts.slice(start, end);
    console.log(paginatedData.value, "check");
}

watch(
    () => props.customPosts,
    (newPosts) => {
        customPosts.value = newPosts;
        changePagination({
            first: 0,
            page: 0,

            pageCount: Math.ceil(newPosts.length / 12),
            rows: 24,
        });
    },
    { immediate: true }
);

onMounted(async () => {
    if (customPosts.value && customPosts.value.posts) {
        changePagination({
            first: 0,
            page: 0,
            pageCount: Math.ceil(customPosts.value.posts.length / 12),
            rows: 24,
        });
    }
    paginatedData.value = customPosts.value;
    console.log("onload props", props.customPosts);
});
</script>

<template>
    <div
        :class="gridClass"
        v-if="paginatedData.length > 0"
        class="gap-2 grid grid-cols-1"
    >
        <div
            v-for="data in paginatedData"
            :key="data.id"
            class="flex justify-center"
        >
            <div class="bg-white shadow-lg border space-y-3 rounded-lg w-full">
                <div
                    v-for="image in data.images"
                    :key="image.id"
                    :style="{
                        backgroundImage:
                            'url(storage/images/' + image.bestandsnaam + ')',
                    }"
                    class="bg-cover w-full aspect-square max-h-64 rounded-t-lg"
                >
                    <p
                        v-if="data.actieprijs"
                        class="float-right text-center rounded-lg mt-2 mr-2 py-1 w-3/12 bg-white font-bold text-lg"
                    >
                        ACTIE
                    </p>
                    <p
                        v-if="data.condition.nieuw_voertuig == '1'"
                        class="float-right text-center rounded-lg mt-2 mr-2 py-1 w-3/12 bg-white font-bold text-lg"
                    >
                        NIEUW
                    </p>
                </div>

                <div class="px-2 pb-2 flex flex-col gap-5">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row flex-wrap gap-x-2">
                            <div class="flex flex-row gap-2">
                                <h6 v-if="data.carinfo && data.carinfo.merk">
                                    {{ data.carinfo.merk }}
                                </h6>
                                <h6 v-if="data.carinfo && data.carinfo.model">
                                    {{ data.carinfo.model }}
                                </h6>
                            </div>
                            <p v-if="data.carinfo && data.carinfo.type">
                                {{ data.carinfo.type }}
                            </p>
                        </div>
                        <div class="grid grid-cols-1">
                            <div class="flex gap-1 items-center w-1/3 md:w-1/2">
                                <svg
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M12 4C6.486 4 2 8.486 2 14C1.99871 15.5434 2.35864 17.0656 3.051 18.445C3.221 18.785 3.567 19 3.946 19H20.053C20.432 19 20.779 18.785 20.949 18.445C21.6414 17.0656 22.0013 15.5434 22 14C22 8.486 17.514 4 12 4ZM17.022 9.022L13.06 15.06C12.9498 15.2283 12.8074 15.3733 12.6411 15.4865C12.4748 15.5998 12.2878 15.6791 12.0908 15.72C11.8938 15.7608 11.6906 15.7624 11.493 15.7247C11.2953 15.687 11.1071 15.6106 10.939 15.5C10.7263 15.3609 10.5516 15.171 10.4306 14.9474C10.3097 14.7238 10.2464 14.4737 10.2464 14.2195C10.2464 13.9653 10.3097 13.7152 10.4306 13.4916C10.5516 13.268 10.7263 13.0781 10.939 12.939L16.977 8.977C16.9843 8.97247 16.9931 8.97097 17.0015 8.97284C17.0099 8.97471 17.0173 8.97979 17.022 8.987C17.0252 8.99229 17.0269 8.99834 17.0269 9.0045C17.0269 9.01067 17.0252 9.01671 17.022 9.022Z"
                                        fill="black"
                                    />
                                </svg>
                                <p class="text-sm">
                                    {{ data.condition.tellerstand }}km
                                </p>
                            </div>

                            <div class="flex gap-1 items-center w-2/3">
                                <svg
                                    width="24"
                                    height="24"
                                    viewBox="0 0 25 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M18.3335 10C18.0683 10 17.8139 9.89464 17.6264 9.70711C17.4389 9.51957 17.3335 9.26522 17.3335 9C17.3335 8.73478 17.4389 8.48043 17.6264 8.29289C17.8139 8.10536 18.0683 8 18.3335 8C18.5987 8 18.8531 8.10536 19.0406 8.29289C19.2281 8.48043 19.3335 8.73478 19.3335 9C19.3335 9.26522 19.2281 9.51957 19.0406 9.70711C18.8531 9.89464 18.5987 10 18.3335 10ZM12.3335 10H6.3335V5H12.3335M20.1035 7.23L20.1135 7.22L16.3935 3.5L15.3335 4.56L17.4435 6.67C16.5035 7 15.8335 7.93 15.8335 9C15.8335 9.3283 15.8982 9.65339 16.0238 9.95671C16.1494 10.26 16.3336 10.5356 16.5657 10.7678C17.0346 11.2366 17.6705 11.5 18.3335 11.5C18.6935 11.5 19.0235 11.42 19.3335 11.29V18.5C19.3335 18.7652 19.2281 19.0196 19.0406 19.2071C18.8531 19.3946 18.5987 19.5 18.3335 19.5C18.0683 19.5 17.8139 19.3946 17.6264 19.2071C17.4389 19.0196 17.3335 18.7652 17.3335 18.5V14C17.3335 13.4696 17.1228 12.9609 16.7477 12.5858C16.3726 12.2107 15.8639 12 15.3335 12H14.3335V5C14.3335 4.46957 14.1228 3.96086 13.7477 3.58579C13.3726 3.21071 12.8639 3 12.3335 3H6.3335C5.2235 3 4.3335 3.89 4.3335 5V21H14.3335V13.5H15.8335V18.5C15.8335 19.163 16.0969 19.7989 16.5657 20.2678C17.0346 20.7366 17.6705 21 18.3335 21C18.6618 21 18.9869 20.9353 19.2902 20.8097C19.5935 20.6841 19.8691 20.4999 20.1013 20.2678C20.3334 20.0356 20.5176 19.76 20.6432 19.4567C20.7688 19.1534 20.8335 18.8283 20.8335 18.5V9C20.8335 8.31 20.5535 7.68 20.1035 7.23Z"
                                        fill="black"
                                    />
                                </svg>
                                <p class="text-sm">
                                    {{ data.techinfo.brandstof }}
                                </p>
                            </div>
                            <div class="flex gap-1 items-center">
                                <svg
                                    width="24"
                                    height="24"
                                    viewBox="0 0 25 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M22.6665 12C22.6665 17.523 18.1895 22 12.6665 22C7.1435 22 2.6665 17.523 2.6665 12C2.6665 6.477 7.1435 2 12.6665 2C18.1895 2 22.6665 6.477 22.6665 12ZM8.6665 8.25C8.86542 8.25 9.05618 8.32902 9.19683 8.46967C9.33749 8.61032 9.4165 8.80109 9.4165 9V11.25H11.9165V9C11.9165 8.80109 11.9955 8.61032 12.1362 8.46967C12.2768 8.32902 12.4676 8.25 12.6665 8.25C12.8654 8.25 13.0562 8.32902 13.1968 8.46967C13.3375 8.61032 13.4165 8.80109 13.4165 9V11.25H13.6665C14.1425 11.25 14.4625 11.25 14.7095 11.233C14.9505 11.216 15.0675 11.187 15.1445 11.155C15.4515 11.028 15.6945 10.785 15.8215 10.478C15.8535 10.401 15.8825 10.284 15.8995 10.043C15.9165 9.796 15.9165 9.476 15.9165 9C15.9165 8.80109 15.9955 8.61032 16.1362 8.46967C16.2768 8.32902 16.4676 8.25 16.6665 8.25C16.8654 8.25 17.0562 8.32902 17.1968 8.46967C17.3375 8.61032 17.4165 8.80109 17.4165 9V9.025C17.4165 9.47 17.4165 9.841 17.3965 10.145C17.3836 10.4557 17.3194 10.7622 17.2065 11.052C17.0684 11.3857 16.8659 11.689 16.6106 11.9445C16.3553 12.2 16.0522 12.4027 15.7185 12.541C15.4285 12.661 15.1285 12.708 14.8115 12.729C14.5075 12.75 14.1365 12.75 13.6915 12.75H13.4165V15C13.4165 15.1989 13.3375 15.3897 13.1968 15.5303C13.0562 15.671 12.8654 15.75 12.6665 15.75C12.4676 15.75 12.2768 15.671 12.1362 15.5303C11.9955 15.3897 11.9165 15.1989 11.9165 15V12.75H9.4165V15C9.4165 15.1989 9.33749 15.3897 9.19683 15.5303C9.05618 15.671 8.86542 15.75 8.6665 15.75C8.46759 15.75 8.27683 15.671 8.13617 15.5303C7.99552 15.3897 7.9165 15.1989 7.9165 15V9C7.9165 8.90151 7.9359 8.80398 7.97359 8.71299C8.01129 8.62199 8.06653 8.53931 8.13617 8.46967C8.20582 8.40003 8.2885 8.34478 8.37949 8.30709C8.47049 8.2694 8.56801 8.25 8.6665 8.25Z"
                                        fill="black"
                                    />
                                </svg>
                                <p class="text-sm">
                                    {{ data.techinfo.transmissie }}
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex flex-row w-full flex-wrap justify-between items-baseline"
                        >
                            <h3 class="text-orange">
                                €{{ data.verkoopprijs_particulier }}
                            </h3>
                            <div>
                                <img :src="'img/napcheck.webp'" />
                            </div>

                            <div
                                class="flex flex-row flex-wrap gap-x-2 items-baseline text-nowrap"
                            >
                                <h5>
                                    €{{ data.lease_maandbedrag }}
                                    p/m
                                </h5>
                                <p class="text-xs">op basis van financiering</p>
                            </div>
                        </div>
                        <a
                            :href="'/details?id=' + data.id"
                            class="orange-button md:w-full text-center"
                            >Details</a
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
