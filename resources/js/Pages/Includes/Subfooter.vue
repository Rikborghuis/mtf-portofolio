<script setup>
import Button from 'primevue/button';
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
    // 1024 and up
    1024: {
        itemsToShow: 3,
        snapAlign: 'start',
    },
    1280: {
        itemsToShow: 4,
        snapAlign: 'center',

    }
}
</script>
<template>
    <div class="flex flex-col justify-center py-12 md:py-20 lg:py-28 gap-12">
        <div class="w-11/12 px:0 md:px-6 xl:px-0 max-w-6xl mx-auto flex flex-col gap-20">
            <div class="flex singe-item w-full flex-col items-start gap-20">
                <div class="flex flex-col lg:flex-row items-center gap-20 self-stretch">
                    <div class="flex flex-col items-start gap-6 flex-1">
                        <div class="flex flex-col gap-4">
                            <p class="font-semibold">Bezoek ons</p>
                            <h2>MTF Automobielen Almelo</h2>
                        </div>
                        <p>Purus viverra nam lacus adipiscing lacus tortor aliquet. Gravida sem sed
                            suscipit sit est.
                            Pellentesque lectus arcu bibendum purus tempus odio pellentesque et leo. Gravida enim congue
                            at
                            sit morbi viverra. Placerat faucibus est vitae amet et cras egestas semper pellentesque.
                            Tincidunt convallis scelerisque elit elit in blandit tristique.
                            Iaculis malesuada posuere luctus aenean purus. Ac netus ridiculus felis a. Nec eleifend ac
                            augue
                            sit risus tempus nisi. Nibh mauris habitant feugiat neque et ultricies scelerisque tempor.
                            Vitae
                            gravida vulputate sed amet amet fames ipsum faucibus. Vitae facilisi at eu quam posuere.
                            Lobortis vel vitae varius in massa. Mi consequat pharetra aliquam sodales egestas.</p>
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-6 pt-4 w-full">
                            <a target="_blank"
                                href="https://www.google.com/maps/place/MTF+Automobielen/@52.3748333,6.6866339,17z/data=!3m1!4b1!4m6!3m5!1s0x47b80944fdf6ce63:0xae066dc37ab5966b!8m2!3d52.3748301!4d6.6892088!16s%2Fg%2F11q1vdhjkj?entry=ttu">
                                <Button class="orange-button font" label="Kom langs!" severity="warning" />
                            </a>

                            <a href="/overons">
                                <Button class="grey-button" label="Contact" severity="warning" />
                            </a>
                        </div>
                    </div>
                    <div class="lg:w-5/12">
                        <img class="rounded-lg h-auto" :src="'/img/mtfsubfooter.webp'" alt="placeholder">
                    </div>
                </div>
            </div>
                        <div class="flex flex-col gap-4">
            <h2>Customer Reviews</h2>
            <p>Read and submit reviews for the vehicle</p>
            </div>
        </div>
    <section class="relative">
        <div class="hidden md:flex absolute w-full h-full flex-row justify-between">
            <div class="z-20 bg-gradient-to-l from-white/5 to-white w-1/3 h-full"></div>
            <div class="z-20 bg-gradient-to-r from-white/5 to-white w-1/3 h-full"></div>
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
    </div>
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
