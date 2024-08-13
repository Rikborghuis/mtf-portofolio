<script setup>
import 'vue3-carousel/dist/carousel.css'
import {Carousel, Slide, Pagination, Navigation} from 'vue3-carousel'
const slides = [
    {id: '1', title: 'John doe', content: 'Merknaam + model uitvoering'},
    {id: '2', title: 'John doe', content: 'Merknaam + model uitvoering'},
    {id: '3', title: 'John doe', content: 'Merknaam + model uitvoering'},
    {id: '4', title: 'John doe', content: 'Merknaam + model uitvoering'},
    {id: '5', title: 'John doe', content: 'Merknaam + model uitvoering'},
]
const breakpoints = {
    // 700px and up
    768: {
        itemsToShow: 2,
        snapAlign: 'center',
    },
    1280: {
        itemsToShow: 3,
        snapAlign: 'center',
    }
}
</script>

<template>
    <section class="relative">
        <div class="absolute w-full h-full flex flex-row justify-between">
            <div class="z-40 bg-gradient-to-l from-white/5 to-white w-1/3 h-full"></div>
            <div class="z-40 bg-gradient-to-r from-white/5 to-white w-1/3 h-full"></div>
        </div>
        <Carousel :wrap-around="true" :breakpoints="breakpoints" :autoplay="2000" :transition="2000">
            <Slide v-for="slide in slides" :key="slide.id">
                <div class="carousel__item w-full">
                    <div class="flex flex-col gap-8">
                        <div class="review-slider-style">
                            <div class="flex justify-start ">
                                <svg width="20" height="19" viewBox="0 0 20 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path id="Vector"
                                          d="M9.07088 0.612343C9.41462 -0.204115 10.5854 -0.204114 10.9291 0.612346L12.9579 5.43123C13.1029 5.77543 13.4306 6.01061 13.8067 6.0404L19.0727 6.45748C19.9649 6.52814 20.3267 7.62813 19.6469 8.2034L15.6348 11.5987C15.3482 11.8412 15.223 12.2218 15.3106 12.5843L16.5363 17.661C16.744 18.5211 15.7969 19.201 15.033 18.7401L10.5245 16.0196C10.2025 15.8252 9.7975 15.8252 9.47548 16.0196L4.96699 18.7401C4.20311 19.201 3.25596 18.5211 3.46363 17.661L4.68942 12.5843C4.77698 12.2218 4.65182 11.8412 4.36526 11.5987L0.353062 8.2034C-0.326718 7.62813 0.0350679 6.52814 0.927291 6.45748L6.19336 6.0404C6.5695 6.01061 6.89716 5.77543 7.04207 5.43123L9.07088 0.612343Z"
                                          fill="#FF753E"/>
                                </svg>
                                <svg width="20" height="19" viewBox="0 0 20 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path id="Vector"
                                          d="M9.07088 0.612343C9.41462 -0.204115 10.5854 -0.204114 10.9291 0.612346L12.9579 5.43123C13.1029 5.77543 13.4306 6.01061 13.8067 6.0404L19.0727 6.45748C19.9649 6.52814 20.3267 7.62813 19.6469 8.2034L15.6348 11.5987C15.3482 11.8412 15.223 12.2218 15.3106 12.5843L16.5363 17.661C16.744 18.5211 15.7969 19.201 15.033 18.7401L10.5245 16.0196C10.2025 15.8252 9.7975 15.8252 9.47548 16.0196L4.96699 18.7401C4.20311 19.201 3.25596 18.5211 3.46363 17.661L4.68942 12.5843C4.77698 12.2218 4.65182 11.8412 4.36526 11.5987L0.353062 8.2034C-0.326718 7.62813 0.0350679 6.52814 0.927291 6.45748L6.19336 6.0404C6.5695 6.01061 6.89716 5.77543 7.04207 5.43123L9.07088 0.612343Z"
                                          fill="#FF753E"/>
                                </svg>
                                <svg width="20" height="19" viewBox="0 0 20 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path id="Vector"
                                          d="M9.07088 0.612343C9.41462 -0.204115 10.5854 -0.204114 10.9291 0.612346L12.9579 5.43123C13.1029 5.77543 13.4306 6.01061 13.8067 6.0404L19.0727 6.45748C19.9649 6.52814 20.3267 7.62813 19.6469 8.2034L15.6348 11.5987C15.3482 11.8412 15.223 12.2218 15.3106 12.5843L16.5363 17.661C16.744 18.5211 15.7969 19.201 15.033 18.7401L10.5245 16.0196C10.2025 15.8252 9.7975 15.8252 9.47548 16.0196L4.96699 18.7401C4.20311 19.201 3.25596 18.5211 3.46363 17.661L4.68942 12.5843C4.77698 12.2218 4.65182 11.8412 4.36526 11.5987L0.353062 8.2034C-0.326718 7.62813 0.0350679 6.52814 0.927291 6.45748L6.19336 6.0404C6.5695 6.01061 6.89716 5.77543 7.04207 5.43123L9.07088 0.612343Z"
                                          fill="#FF753E"/>
                                </svg>
                                <svg width="20" height="19" viewBox="0 0 20 19" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path id="Vector"
                                          d="M9.07088 0.612343C9.41462 -0.204115 10.5854 -0.204114 10.9291 0.612346L12.9579 5.43123C13.1029 5.77543 13.4306 6.01061 13.8067 6.0404L19.0727 6.45748C19.9649 6.52814 20.3267 7.62813 19.6469 8.2034L15.6348 11.5987C15.3482 11.8412 15.223 12.2218 15.3106 12.5843L16.5363 17.661C16.744 18.5211 15.7969 19.201 15.033 18.7401L10.5245 16.0196C10.2025 15.8252 9.7975 15.8252 9.47548 16.0196L4.96699 18.7401C4.20311 19.201 3.25596 18.5211 3.46363 17.661L4.68942 12.5843C4.77698 12.2218 4.65182 11.8412 4.36526 11.5987L0.353062 8.2034C-0.326718 7.62813 0.0350679 6.52814 0.927291 6.45748L6.19336 6.0404C6.5695 6.01061 6.89716 5.77543 7.04207 5.43123L9.07088 0.612343Z"
                                          fill="#FF753E"/>
                                </svg>
                                <svg width="20" height="19" viewBox="0 0 20 19" fill="black"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path id="Vector"
                                          d="M9.07088 0.612343C9.41462 -0.204115 10.5854 -0.204114 10.9291 0.612346L12.9579 5.43123C13.1029 5.77543 13.4306 6.01061 13.8067 6.0404L19.0727 6.45748C19.9649 6.52814 20.3267 7.62813 19.6469 8.2034L15.6348 11.5987C15.3482 11.8412 15.223 12.2218 15.3106 12.5843L16.5363 17.661C16.744 18.5211 15.7969 19.201 15.033 18.7401L10.5245 16.0196C10.2025 15.8252 9.7975 15.8252 9.47548 16.0196L4.96699 18.7401C4.20311 19.201 3.25596 18.5211 3.46363 17.661L4.68942 12.5843C4.77698 12.2218 4.65182 11.8412 4.36526 11.5987L0.353062 8.2034C-0.326718 7.62813 0.0350679 6.52814 0.927291 6.45748L6.19336 6.0404C6.5695 6.01061 6.89716 5.77543 7.04207 5.43123L9.07088 0.612343Z"
                                          fill="#FF753E"/>
                                </svg>
                            </div>
                            <p class="font-bold py-6"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at
                                venenatis
                                ipsum.
                            </p>
                            <div class="flex flex-col md:flex-row gap-4">
                                <img class="rounded-full object-cover w-20 h-20 " :src="'/img/reviewer.jpeg'">
                                <div class="flex flex-col justify-center">
                                    <p>{{ slide.title }}</p>
                                    <p>{{ slide.content }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Slide>
        </Carousel>
    </section>
</template>

<style>
.carousel__item {
    min-height: 200px;
    width: 100%;
    color: black;
    font-size: 20px;
    border-radius: 8px;
    justify-content: center;
    align-items: center;
}

.carousel__slide {
    padding: 10px;
}
</style>