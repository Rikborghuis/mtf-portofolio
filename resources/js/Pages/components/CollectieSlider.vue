<script>
import 'vue3-carousel/dist/carousel.css';
import { ref } from 'vue';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';

export default {
    name: 'App',
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
};
</script>
<template>
    <Carousel :itemsToShow="1" :wrap-around="true">
        <Slide v-for="slide in 6" :key="slide">
            <!-- Use slot to add different content in each slide -->
            <template #default>
                <div v-if="slide === 1" class="p-3">
                    <div class="">
                        <div class="flex flex-col sm:flex-row gap-8 pb-8">
                            <img class="w-full aspect-sqaure" :src="'/img/placeholder_image.webp'" alt="">
                            <div class="flex flex-col gap-2 text-center sm:text-left text-balance">
                                <div class="flex flex-col">
                                    <p class="font-semibold">Audi e-tron 50 quattro </p>
                                    <p>Electriciteit 🔌</p>
                                </div>
                                <div class="h-full">
                                    <p>Elektrische prestaties, geavanceerde technologie en luxe comfort in één
                                        indrukwekkende SUV!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="slide === 2" class="p-3">
                    <div class="">
                        <div class="flex flex-col sm:flex-row gap-8 pb-8">
                            <img class="w-full aspect-sqaure" :src="'/img/placeholder_image.webp'" alt="">
                            <div class="flex flex-col gap-2 text-center sm:text-left text-balance">
                                <div class="flex flex-col">
                                    <p class="font-semibold">Audi e-tron 50 quattro </p>
                                    <p>Electriciteit 🔌</p>
                                </div>
                                <div class="h-full">
                                    <p>Elektrische prestaties, geavanceerde technologie en luxe comfort in één
                                        indrukwekkende SUV!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="slide === 3" class="p-3">
                    <div class="">
                        <div class="flex flex-col sm:flex-row gap-8 pb-8">
                            <img class="w-full aspect-sqaure" :src="'/img/placeholder_image.webp'" alt="">
                            <div class="flex flex-col gap-2 text-center sm:text-left text-balance">
                                <div class="flex flex-col">
                                    <p class="font-semibold">Audi e-tron 50 quattro </p>
                                    <p>Electriciteit 🔌</p>
                                </div>
                                <div class="h-full">
                                    <p>Elektrische prestaties, geavanceerde technologie en luxe comfort in één
                                        indrukwekkende SUV!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="slide === 4" class="p-3">
                    <div class="">
                        <div class="flex flex-col sm:flex-row gap-8 pb-8">
                            <img class="w-full aspect-sqaure" :src="'/img/placeholder_image.webp'" alt="">
                            <div class="flex flex-col gap-2 text-center sm:text-left text-balance">
                                <div class="flex flex-col">
                                    <p class="font-semibold">Audi e-tron 50 quattro </p>
                                    <p>Electriciteit 🔌</p>
                                </div>
                                <div class="h-full">
                                    <p>Elektrische prestaties, geavanceerde technologie en luxe comfort in één
                                        indrukwekkende SUV!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="slide === 5" class="p-3">
                    <div class="">
                        <div class="flex flex-col sm:flex-row gap-8 pb-8">
                            <img class="w-full aspect-sqaure" :src="'/img/placeholder_image.webp'" alt="">
                            <div class="flex flex-col gap-2 text-center sm:text-left text-balance">
                                <div class="flex flex-col">
                                    <p class="font-semibold">Audi e-tron 50 quattro </p>
                                    <p>Electriciteit 🔌</p>
                                </div>
                                <div class="h-full">
                                    <p>Elektrische prestaties, geavanceerde technologie en luxe comfort in één
                                        indrukwekkende SUV!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="slide === 6" class="p-3">
                    <div class="">
                        <div class="flex flex-col sm:flex-row gap-8 pb-8">
                            <img class="w-full aspect-sqaure" :src="'/img/placeholder_image.webp'" alt="">
                            <div class="flex flex-col gap-2 text-center sm:text-left text-balance">
                                <div class="flex flex-col">
                                    <p class="font-semibold">Bekijk meer op onze social media</p>
                                    <p>Bekijk meer op onze social media</p>
                                </div>
                                <div class="h-full">
                                    <p>Elektrische prestaties, geavanceerde technologie en luxe comfort in één
                                        indrukwekkende SUV!</p>
                                    <div class="flex flex-row gap-2 justify-center sm:justify-start">
                                        <a href="" class="">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M22 12.3033C22 6.7467 17.5229 2.24219 12 2.24219C6.47715 2.24219 2 6.7467 2 12.3033C2 17.325 5.65684 21.4874 10.4375 22.2422V15.2116H7.89844V12.3033H10.4375V10.0867C10.4375 7.56515 11.9305 6.17231 14.2146 6.17231C15.3088 6.17231 16.4531 6.36882 16.4531 6.36882V8.8448H15.1922C13.95 8.8448 13.5625 9.62041 13.5625 10.4161V12.3033H16.3359L15.8926 15.2116H13.5625V22.2422C18.3432 21.4874 22 17.3252 22 12.3033Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                        <a href="" class="">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M16 3.24219H8C5.23858 3.24219 3 5.48077 3 8.24219V16.2422C3 19.0036 5.23858 21.2422 8 21.2422H16C18.7614 21.2422 21 19.0036 21 16.2422V8.24219C21 5.48077 18.7614 3.24219 16 3.24219ZM19.25 16.2422C19.2445 18.0348 17.7926 19.4867 16 19.4922H8C6.20735 19.4867 4.75549 18.0348 4.75 16.2422V8.24219C4.75549 6.44954 6.20735 4.99768 8 4.99219H16C17.7926 4.99768 19.2445 6.44954 19.25 8.24219V16.2422ZM16.75 8.49219C17.3023 8.49219 17.75 8.04447 17.75 7.49219C17.75 6.93991 17.3023 6.49219 16.75 6.49219C16.1977 6.49219 15.75 6.93991 15.75 7.49219C15.75 8.04447 16.1977 8.49219 16.75 8.49219ZM12 7.74219C9.51472 7.74219 7.5 9.75691 7.5 12.2422C7.5 14.7275 9.51472 16.7422 12 16.7422C14.4853 16.7422 16.5 14.7275 16.5 12.2422C16.5027 11.0479 16.0294 9.90176 15.1849 9.05727C14.3404 8.21278 13.1943 7.73953 12 7.74219ZM9.25 12.2422C9.25 13.761 10.4812 14.9922 12 14.9922C13.5188 14.9922 14.75 13.761 14.75 12.2422C14.75 10.7234 13.5188 9.49219 12 9.49219C10.4812 9.49219 9.25 10.7234 9.25 12.2422Z"
                                                      fill="white" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add more v-else-if or v-else blocks for additional slides -->
            </template>
        </Slide>

        <template #addons>
            <Pagination/>
        </template>
    </Carousel>


</template>
<style scoped>
.custom-pagination .carousel__pagination-item {
    /* Add your custom styles here */
    background-color: red;
    border-radius: 50%;
}
.custom-pagination .carousel__pagination-item--active {
    /* Add your custom styles for the active item here */
    background-color: green;
}
</style>
