<script setup>
//primevue imports
import TabView from 'primevue/tabview';
import Dialog from 'primevue/dialog';
import TabPanel from 'primevue/tabpanel';
import Button from 'primevue/button';
import RadioButton from 'primevue/radiobutton';
import Galleria from 'primevue/galleria';

//vue imports
import { onMounted, ref, computed } from 'vue';
import { Head } from "@inertiajs/vue3";
//components
import Subfooter from './Includes/Subfooter.vue';
import faq from './components/Faq.vue';
import Slider from "./components/Slider.vue";
import { PhotoService } from './service/PhotoService';

//other imports
import "primeicons/primeicons.css";
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';
import { ChevronUpIcon } from '@heroicons/vue/20/solid';
import axios from 'axios';


//variable to load in data from database
const dataSet = ref(null);

//data from the images related to the post_id
let imgs = ref([]);
let accessoires = ref([]);

//front end 
const images = ref();
const responsiveOptionsDesktop = ref([
    {
        breakpoint: '1500px',
        numVisible: 5
    },
    {
        breakpoint: '1024px',
        numVisible: 4
    },
]);
const responsiveOptionsPhone = ref([
    {
        breakpoint: '768px',
        numVisible: 5
    },

    {
        breakpoint: '475px',
        numVisible: 4
    },

    {
        breakpoint: '360px',
        numVisible: 3
    },

]);
const displayBasic = ref(false);
const ingredient = ref('');

//get the post id from url 
const getUrlData = async () => {
    try {
        let currentUrl = window.location.href;
        let urlDecoded = decodeURIComponent(currentUrl);
        let searchparams = new URLSearchParams(urlDecoded.split("?")[1]);

        const getID = searchparams.get("id");
   

        const response = await axios.get("/detailsapi?id=" + getID); 

        
        dataSet.value = response.data[0]; 
       console.log(dataSet.value.carinfo.accessoires
       )
      
        
          
    } catch (error) {
        console.error("Error fetching filtered posts:", error);
    }
};

//causes the page to work idk why 
getUrlData().then(() => {
   dataSet.value;
});

const getAccessoires = async () => {
    // Assuming the string uses commas to separate different accessories
    const accessoiresArray = dataSet.value.carinfo.accessoires.split(',').map((accessoire) => {
        return {
            name: accessoire.trim(), // trim() to remove any leading/trailing whitespace
        };
    });

    accessoires.value = accessoiresArray;
    console.log('hoi',accessoires.value)
};

//put the images related to the post_id into a var 
const getImg = async () => {
    if (dataSet.value && Array.isArray(dataSet.value.images)) {
     

        //give the img let its values
        imgs.value = dataSet.value.images.map((image) => {
            return {
                name: image.bestandsnaam || 'No Bestandsnaam',
                value: image.nr,
            };
        });
           
    } else {
        console.error("dataSet.value or dataSet.value.images is not in the expected format");
    }
};

//ensures imgs can be loaded in individually
const filterImagesByValue = (value) => {

  return computed(() => {
    return imgs.value.filter(img => img.value === value);
  });
};

//eventueel in een foreach verwerken
const filteredImg1 = filterImagesByValue(1);
const filteredImg2 = filterImagesByValue(2);
const filteredImg3 = filterImagesByValue(3);
const filteredImg4 = filterImagesByValue(4);




onMounted(async () => {
    await getUrlData();
    PhotoService.getImages().then((data) => (images.value = data));
    await getImg();
    await getAccessoires();
});


//close div function
const position = ref('bottom');
const visible = ref(window.innerWidth >= 750);
window.addEventListener('resize', () => {
    visible.value = window.innerWidth >= 750;
});

//? dont know what this does
const openPosition = (pos) => {
    position.value = pos;
    visible.value = true;
}
</script>
<template>
    <Head>
        <title>{{ dataSet.carinfo.merk }} {{ dataSet.carinfo.model }} {{ dataSet.carinfo.type }}</title>
        <meta
            name="description"
           content="Ontdek alle details over de {{ dataSet.carinfo.merk }} bij MTF-Automobielen. Bekijk foto's, specificaties, en uitgebreide informatie over deze auto. Plan direct een proefrit!">
              <link
            rel="apple-touch-icon"
            sizes="120x120"
            href="img/apple-touch-icon.png"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="32x32"
            href="img/favicon-32x32.png"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="img/favicon-16x16.png"
        />
        <link rel="manifest" href="img/site.webmanifest" />
        <link
            rel="mask-icon"
            href="img/safari-pinned-tab.svg"
            color="#5bbad5"
        />
    </Head>
    

    <Dialog v-model:visible="visible" header="Financier dit voertuig" :style="{ width: '45rem' }" :position="position"
        :draggable="false">

        <p class=" w-6rem">Sed sit sit pretium nibh praesent turpis cursus.
            Interdum urna sed in etiam ante sed dignissim proin tellus. Lectus at egestas.</p>

        <div class="w-full text-center pt-6">
            <a href="#lease">
                <Button label="Bereken mijn financiering" class="w-full bg-orange text-white p-3" />
            </a>

        </div>
    </Dialog>
    <div   
     class="flex flex-col bg-blue text-white pt-16 md:pt-0 md:-space-y-80">
        <section 
    v-for="(img, index) in filteredImg1" 
    :key="index" 
        
    id="hero" 
    class="z-20 h-full bg-gradient-to-b from-blue/5 to-blue relative"
  >
            <!--image 1-->
          <div   :style="{
                        backgroundImage: 'url(storage/images/'+ img.name +')' ,
                    } "
                class="hidden h-screen md:flex flex-col max-h-[1200px] min-h-96 bg-bottom bg-cover w-full mb-24 bg-opacity-45">
                <div class="z-20 flex justify-center h-screen w-screen">
                    <div class="w-11/12 px:0 md:px-6 xl:px-0 h-4/6 md:h-5/6 max-w-6xl min-h-96">
                    </div>
                </div>
            </div> 
        </section>

        <section id="subhero"
            class="flex justify-center py-8 md:py-20 lg:py-28 z-20 bg-gradient-to-b from-blue/5 to-35% to-blue">
            <div class="w-11/12 px:0 md:px-6 xl:px-0 flex flex-col gap-10 max-w-6xl">
                <div  class="flex flex-col gap-4 pb-6">
                    <h3 class="md:text-right">{{ dataSet.carinfo.merk  }} {{ dataSet.carinfo.model }} {{ dataSet.carinfo.type  }}</h3>
                </div>
                <div class="flex flex-col lg:flex-row gap-20">
                    <div class="flex flex-row items-start gap-1 shrink-0  order-last lg:order-first">
                        <div class="flex items-start gap-10 self-stretch">
                            <div class="flex items-start flex-col self-stretch">
                                <p class="font-bold">Topsnelheid</p>
                                <p class="font-bold">Acceleratie</p>
                                <p class="font-bold">Motorvermogen</p>
                            </div>
                            <div class="flex items-start flex-col self-stretch">
                                <p>{{ dataSet.techinfo.topsnelheid }} km/u</p>
                                <p>0-100 {{ dataSet.techinfo.acceleratie }} sec</p>
                                <p>{{ dataSet.techinfo.vermogen_motor_kw }}kW</p>
                            </div>
                        </div>
                    </div>
                    <!-- Hier moet de foto slider komen zoals op desktop -->
                    <div class="block md:hidden">
                        <Galleria :value="imgs" :responsiveOptions="responsiveOptionsPhone" :numVisible="5"
                            :circular="true" containerStyle="max-width: 640px">
                            <template #item="slotProps">
                                <img :src="'storage/images/' + slotProps.item.name" :alt="slotProps.item.alt" style="width: 100%"
                                    class="rounded-lg" />
                            </template>
                            <template #thumbnail="slotProps">
                                <img :src="'storage/images/' + slotProps.item.name" :alt="slotProps.item.alt"
                                    class="rounded-lg" />
                            </template>
                        </Galleria>
                    </div>

                    <p class="text-pretty hidden md:block"> {{ dataSet.opmerkingen }}</p>
                </div>
                <div
                    class="text-white text-left text-nowrap mx-auto w-11/12 px:0 md:px-6 xl:px-0 max-w-6xl hidden md:grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-10">
                    <div class="flex gap-4 justify-start lg:justify-start">
                        <svg xmlns="http://www.w3.org/2000/svg" width="49" height="48" viewBox="0 0 49 48" fill="none">
                            <path d="M22.6665 24H34.6665V36H22.6665V24Z" fill="white" />
                            <path
                                d="M38.6665 8H34.6665V4H30.6665V8H18.6665V4H14.6665V8H10.6665C8.4605 8 6.6665 9.794 6.6665 12V40C6.6665 42.206 8.4605 44 10.6665 44H38.6665C40.8725 44 42.6665 42.206 42.6665 40V12C42.6665 9.794 40.8725 8 38.6665 8ZM38.6685 40H10.6665V16H38.6665L38.6685 40Z"
                                fill="white" />
                        </svg>
                        <div class="w-48">
                            <h5>Bouwjaar</h5>
                            <p>{{ dataSet.condition.bouwjaar }}</p>
                        </div>
                    </div>
                    <div class="flex gap-4 justify-start lg:justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="49" height="48" viewBox="0 0 49 48" fill="none">
                            <path d="M22.6665 24H34.6665V36H22.6665V24Z" fill="white" />
                            <path
                                d="M38.6665 8H34.6665V4H30.6665V8H18.6665V4H14.6665V8H10.6665C8.4605 8 6.6665 9.794 6.6665 12V40C6.6665 42.206 8.4605 44 10.6665 44H38.6665C40.8725 44 42.6665 42.206 42.6665 40V12C42.6665 9.794 40.8725 8 38.6665 8ZM38.6685 40H10.6665V16H38.6665L38.6685 40Z"
                                fill="white" />
                        </svg>
                        <div class="w-48">
                            <h5>Kilometerstand
                            </h5>
                            <p>{{ dataSet.condition.tellerstand}}</p>
                        </div>
                    </div>
                    <div class="flex gap-4 justify-start lg:justify-end">
                        <svg xmlns="http://www.w3.org/2000/svg" width="49" height="48" viewBox="0 0 49 48" fill="none">
                            <path d="M22.6665 24H34.6665V36H22.6665V24Z" fill="white" />
                            <path
                                d="M38.6665 8H34.6665V4H30.6665V8H18.6665V4H14.6665V8H10.6665C8.4605 8 6.6665 9.794 6.6665 12V40C6.6665 42.206 8.4605 44 10.6665 44H38.6665C40.8725 44 42.6665 42.206 42.6665 40V12C42.6665 9.794 40.8725 8 38.6665 8ZM38.6685 40H10.6665V16H38.6665L38.6685 40Z"
                                fill="white" />
                        </svg>
                        <div class="w-48">
                            <h5>Transmissie</h5>
                            <p>{{ dataSet.techinfo.transmissie }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <main>

        <section class="flex w-11/12 px:0 md:px-6 xl:px-0 max-w-6xl py-12 md:py-16 lg:py-20  mx-auto flex-col gap-8">
            <div class="hidden md:flex flex-row items-center gap-4 md:order-1">
                <p>Aanbod</p>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                    <path d="M6 3.5L11 8.5L6 13.5" stroke="black" stroke-width="1.5" />
                </svg>
                <p class="font-bold">{{ dataSet.carinfo.merk }} {{ dataSet.carinfo.model }} {{ dataSet.carinfo.type }}</p>
            </div>
            <div class="lg:hidden flex flex-col gap-4 ">
                <div class="flex w-full justify-between ">
                    <h2>€7.899,-</h2>
                    <a href="#lease" class="flex justify-end items-end gap-2 flex-1 flex-row">
                        <p>Financiering vanaf <span class="text-orange">€86,- p/m </span></p>
                    </a>
                </div>
                <div class="flex flex-col items-start gap-4 w-full">
                    <div class="flex flex-row items-start gap-4 w-full">
                        <a class="flex py-3 px-6 justify-center items-center gap-3 flex-1 bg-orange rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24"
                                fill="none">
                                <path
                                    d="M18.4573 12.2932C18.3645 12.2003 18.2543 12.1265 18.133 12.0762C18.0117 12.0259 17.8817 12 17.7503 12C17.619 12 17.489 12.0259 17.3676 12.0762C17.2463 12.1265 17.1361 12.2003 17.0433 12.2932L15.4493 13.8872C14.7103 13.6672 13.3313 13.1672 12.4573 12.2932C11.5833 11.4192 11.0833 10.0402 10.8633 9.3012L12.4573 7.7072C12.5503 7.61441 12.624 7.50421 12.6743 7.38289C12.7246 7.26158 12.7505 7.13153 12.7505 7.0002C12.7505 6.86887 12.7246 6.73882 12.6743 6.61751C12.624 6.49619 12.5503 6.38599 12.4573 6.2932L8.45733 2.2932C8.36455 2.20026 8.25434 2.12652 8.13303 2.07621C8.01171 2.0259 7.88167 2 7.75033 2C7.619 2 7.48896 2.0259 7.36764 2.07621C7.24633 2.12652 7.13612 2.20026 7.04333 2.2932L4.33133 5.0052C3.95133 5.3852 3.73733 5.9072 3.74533 6.4402C3.76833 7.8642 4.14533 12.8102 8.04333 16.7082C11.9413 20.6062 16.8873 20.9822 18.3123 21.0062H18.3403C18.8683 21.0062 19.3673 20.7982 19.7453 20.4202L22.4573 17.7082C22.5503 17.6154 22.624 17.5052 22.6743 17.3839C22.7246 17.2626 22.7505 17.1325 22.7505 17.0012C22.7505 16.8699 22.7246 16.7398 22.6743 16.6185C22.624 16.4972 22.5503 16.387 22.4573 16.2942L18.4573 12.2932ZM18.3303 19.0052C17.0823 18.9842 12.8123 18.6492 9.45733 15.2932C6.09133 11.9272 5.76533 7.6422 5.74533 6.4192L7.75033 4.4142L10.3363 7.0002L9.04333 8.2932C8.9258 8.41065 8.83938 8.55554 8.79189 8.71477C8.7444 8.874 8.73733 9.04256 8.77133 9.2052C8.79533 9.3202 9.38233 12.0472 11.0423 13.7072C12.7023 15.3672 15.4293 15.9542 15.5443 15.9782C15.7069 16.0132 15.8756 16.0067 16.035 15.9593C16.1944 15.9119 16.3393 15.8252 16.4563 15.7072L17.7503 14.4142L20.3363 17.0002L18.3303 19.0052Z"
                                    fill="white" />
                            </svg>
                            <p class="text-white">Contact</p>
                        </a>
                        <a href="https://wa.me/31612345678?text=Hallo%20MTF%20Automobielen,%20Ik%20wou%20graag%20meer%20info%20over%20$voertuig"
                            class="flex py-3 px-6 justify-center items-center gap-3 flex-1 bg-orange rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12.75 3C7.7793 3 3.75 7.0293 3.75 12C3.75 13.701 4.2225 15.294 5.0442 16.6512L4.2414 19.38C4.19531 19.5367 4.19227 19.7029 4.23262 19.8611C4.27297 20.0194 4.3552 20.1638 4.47068 20.2793C4.58616 20.3948 4.73062 20.477 4.88887 20.5174C5.04713 20.5577 5.21332 20.5547 5.37 20.5086L8.0988 19.7058C9.50161 20.5546 11.1104 21.0022 12.75 21C17.7207 21 21.75 16.9707 21.75 12C21.75 7.0293 17.7207 3 12.75 3ZM10.7142 14.0367C12.5349 15.8565 14.2728 16.0968 14.8866 16.1193C15.8199 16.1535 16.7289 15.4407 17.0826 14.6136C17.1272 14.5107 17.1435 14.3977 17.1295 14.2864C17.1156 14.1751 17.072 14.0696 17.0034 13.9809C16.5102 13.3509 15.8433 12.8982 15.1917 12.4482C15.0556 12.3541 14.8885 12.3164 14.7252 12.3429C14.5619 12.3694 14.4153 12.4581 14.316 12.5904L13.776 13.4139C13.7476 13.4582 13.7034 13.4899 13.6523 13.5026C13.6013 13.5153 13.5473 13.5081 13.5015 13.4823C13.1352 13.2726 12.6015 12.9162 12.2181 12.5328C11.8347 12.1494 11.4999 11.64 11.3118 11.2971C11.2885 11.2535 11.2817 11.203 11.2928 11.1548C11.3039 11.1067 11.3321 11.0642 11.3721 11.0352L12.2037 10.4178C12.3224 10.3146 12.399 10.1714 12.4189 10.0154C12.4388 9.85937 12.4006 9.70149 12.3117 9.5718C11.9085 8.9814 11.4387 8.2308 10.7574 7.7331C10.6695 7.66938 10.5665 7.62965 10.4585 7.61782C10.3506 7.60598 10.2414 7.62245 10.1418 7.6656C9.3138 8.0202 8.5974 8.9292 8.6316 9.8643C8.6541 10.4781 8.8944 12.216 10.7142 14.0367Z"
                                    fill="white" />
                            </svg>
                            <p class="text-white">Whatsapp</p>
                        </a>
                    </div>
                    <Button class="border border-black w-full py-3" label="Proefrit aanvragen" severity="secondary" />
                </div>
            </div>

            <div class="relative hidden md:grid grid-cols-2 md:grid-cols-5 gap-5 flex-col lg:flex-row md:order-2">
                <img     
                v-for="(img, index) in filteredImg2" 
                :key="index" 
                class="rounded-lg h-full w-full object-cover aspect-square col-span-2 md:col-span-3 row-span-2"
                :src="'storage/images/' + img.name  " alt="holder1">
                <img  
                v-for="(img, index) in filteredImg3" 
                :key="index" 
                 class="rounded-lg h-full w-full object-cover aspect-square md:col-span-2"   
                 :src="'storage/images/' + img.name  " 
                    alt="holder3">
                <img 
                 v-for="(img, index) in filteredImg4" 
                :key="index" 
                class="rounded-lg h-full w-full object-cover aspect-square md:col-span-2"   :src="'storage/images/' + img.name  " 
                    alt="holder2">
                <div class="absolute bottom-4 right-3">
                    <Galleria class="text-white bg-transparent " v-model:visible="displayBasic" :value="imgs"
                        :responsiveOptions="responsiveOptionsDesktop" :numVisible="9" containerStyle="max-width: 1024px"
                        :circular="true" :fullScreen="true" :showItemNavigators="true">
                        <template #item="slotProps">
                            <img class="rounded-lg" :src="'storage/images/' + slotProps.item.name" :alt="slotProps.item.alt"
                                style="width: 100%; display: block" />
                        </template>
                        <template #thumbnail="slotProps">
                            <img class="rounded-lg" :src="'storage/images/' + slotProps.item.name" :alt="slotProps.item.alt"
                                style="display: block" />
                        </template>
                    </Galleria>

                    <Button class="grey-button" label="Alle Foto's" icon="" @click="displayBasic = true" />
                </div>
            </div>
            <div class="flex lg:grid grid-cols-5 flex-col gap-5 md:order-4">
                <div class="flex w-full lg:col-span-3 gap-6 flex-1 flex-col">
                    <div class="flex flex-col gap-8">
                        <div class="flex flex-col gap-2">
                            <div class="flex flex-row flex-wrap gap-x-2">
                                <h2>{{ dataSet.carinfo.merk }}</h2>
                                <h2>{{ dataSet.carinfo.model }}</h2>
                                <h2>{{ dataSet.carinfo.type }}</h2>
                            </div>
                            <div class="flex flex-row flex-wrap gap-x-2">
                                <h5>{{ dataSet.condition.bouwjaar }}</h5>
                                <h5>{{ dataSet.techinfo.brandstof }}</h5>
                                <h5>{{ dataSet.techinfo.transmissie }}</h5>
                                <h5>{{ dataSet.carinfo.carrosserie }}</h5>
                                <h5>{{ dataSet.looks.basiskleur }}</h5>
                            </div>
                        </div>
                        <div class="flex flex-col gap-8">
                            <p> {{ dataSet.opmerkingen }} </p>
                        </div>
                    </div>
                    <h4 class="md:hidden flex border-b border-black">Details</h4>
                    <!--basis gegevens phone-->
                    <Disclosure v-slot="{ open }">
                        <DisclosureButton class="flex w-full justify-between rounded-lg bg-white
                             text-black items-center md:hidden">
                            <div class="flex text-left gap-3 w-full border-b border-black pb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M20.772 10.156L19.404 6.051C19.2056 5.45348 18.8238 4.9337 18.3131 4.56551C17.8024 4.19732 17.1886 3.99944 16.559 4H7.441C6.81139 3.99944 6.19761 4.19732 5.68688 4.56551C5.17615 4.9337 4.79445 5.45348 4.596 6.051L3.228 10.156C2.86461 10.3085 2.55428 10.5648 2.33584 10.8928C2.11741 11.2208 2.00059 11.6059 2 12V17C2 17.753 2.423 18.402 3.039 18.743C3.026 18.809 3 18.869 3 18.938V21C3 21.2652 3.10536 21.5196 3.29289 21.7071C3.48043 21.8946 3.73478 22 4 22H5C5.26522 22 5.51957 21.8946 5.70711 21.7071C5.89464 21.5196 6 21.2652 6 21V19H18V21C18 21.2652 18.1054 21.5196 18.2929 21.7071C18.4804 21.8946 18.7348 22 19 22H20C20.2652 22 20.5196 21.8946 20.7071 21.7071C20.8946 21.5196 21 21.2652 21 21V18.938C21 18.869 20.974 18.808 20.961 18.743C21.2744 18.5721 21.5362 18.3202 21.7189 18.0136C21.9017 17.707 21.9988 17.357 22 17V12C22 11.171 21.492 10.459 20.772 10.156ZM4 17V12H20L20.002 17H4ZM7.441 6H16.558C16.989 6 17.371 6.274 17.507 6.684L18.613 10H5.387L6.492 6.684C6.55835 6.4848 6.68572 6.31153 6.85605 6.18876C7.02638 6.06599 7.23104 5.99995 7.441 6Z"
                                        fill="black" />
                                    <path
                                        d="M6.5 16C7.32843 16 8 15.3284 8 14.5C8 13.6716 7.32843 13 6.5 13C5.67157 13 5 13.6716 5 14.5C5 15.3284 5.67157 16 6.5 16Z"
                                        fill="black" />
                                    <path
                                        d="M17.5 16C18.3284 16 19 15.3284 19 14.5C19 13.6716 18.3284 13 17.5 13C16.6716 13 16 13.6716 16 14.5C16 15.3284 16.6716 16 17.5 16Z"
                                        fill="black" />
                                </svg>
                                <p class="font-bold w-full">Basis gegevens</p>
                                <ChevronUpIcon :class="open ? 'rotate-180 transform' : ''" class="h-6 w-6  " />
                            </div>

                        </DisclosureButton>
                        <DisclosurePanel class=" text-gray-700">
                            <div
                                class="flex flex-col items-center md:items-start md:flex-row border-b-[1px] border-black justify-between">
                                <div class="flex w-full md:pt-0 pb-5">
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>Carrosserietype</p>
                                        <p>Categorie</p>
                                        <p>Aandrijving</p>
                                        <p>Stoelen</p>
                                        <p>Deuren</p>
                                        <p>Kenteken</p>
                                        <p>Belasting</p>
                                    </div>
                                    <div class="flex flex-col gap-1 w-1/2 ">
                                        <p>{{ dataSet.carinfo.carrosserie }}</p>
                                        <p   v-if="dataSet.condition.nieuw_voertuig == '0'">Gebruikt</p>
                                        <p>{{ dataSet.carinfo.aandrijving}}</p>
                                        <p>{{ dataSet.carinfo.aantal_zitplaatsen }}</p>
                                        <p>{{ dataSet.carinfo.aantal_deuren }}</p>
                                        <p>{{ dataSet.docu.kenteken }}</p>
                                        <p class=" text-nowrap">± €{{ dataSet.docu.belasting }} per kwartaal</p>

                                    </div>
                                </div>
                            </div>
                        </DisclosurePanel>
                    </Disclosure>
                    <!--voertuig gegevens phone-->
                    <Disclosure v-slot="{ open }">
                        <DisclosureButton class="flex w-full justify-between rounded-lg bg-white
                             text-black items-center md:hidden">
                            <div class="flex text-left gap-3 w-full pb-2 border-b border-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path d="M12 8.00012V13.0001H17V11.0001H14V8.00012H12Z" fill="black" />
                                    <path
                                        d="M21.292 8.49712C20.8409 7.42717 20.1861 6.45514 19.364 5.63512C18.1196 4.39069 16.5377 3.53823 14.814 3.18312C13.6176 2.93961 12.3844 2.93961 11.188 3.18312C9.46267 3.53596 7.87947 4.38912 6.636 5.63612C5.81589 6.45701 5.16133 7.42798 4.708 8.49612C4.23911 9.60473 3.99832 10.7964 4 12.0001L4.001 12.0251H2L5 16.0001L8 12.0251H6.001L6 12.0001C5.99712 10.6055 6.41346 9.2422 7.195 8.08712C7.69912 7.34181 8.34095 6.69964 9.086 6.19512C9.84394 5.68453 10.6941 5.32652 11.589 5.14112C13.4075 4.76723 15.3001 5.13075 16.8507 6.15179C18.4013 7.17283 19.483 8.76782 19.858 10.5861C20.0466 11.518 20.0466 12.4782 19.858 13.4101C19.675 14.3058 19.3168 15.1564 18.804 15.9131C18.554 16.2841 18.267 16.6331 17.95 16.9491C17.3112 17.5872 16.5558 18.0967 15.725 18.4501C15.3018 18.629 14.862 18.7657 14.412 18.8581C13.4804 19.0466 12.5206 19.0466 11.589 18.8581C10.6943 18.6747 9.84447 18.3169 9.088 17.8051C8.71595 17.5537 8.36871 17.2674 8.051 16.9501L6.637 18.3641C7.47212 19.2004 8.46403 19.8637 9.5559 20.316C10.6478 20.7683 11.8181 21.0008 13 21.0001C14.2031 20.9996 15.3939 20.7593 16.503 20.2931C18.1106 19.613 19.486 18.4804 20.462 17.0331C21.4665 15.547 22.0022 13.7938 22 12.0001C22.0025 10.7967 21.7617 9.60514 21.292 8.49712Z"
                                        fill="black" />
                                </svg>
                                <p class="font-bold w-full">Voertuig gegevens</p>
                                <ChevronUpIcon :class="open ? 'rotate-180 transform' : ''" class="h-6 w-6 " />
                            </div>
                        </DisclosureButton>
                        <DisclosurePanel class=" text-gray-700">
                            <div
                                class="flex flex-col items-center md:items-start md:flex-row border-b-[1px] border-black  justify-between">

                                <div class="flex w-full pb-5 md:pt-0">
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>Kilometerstand</p>
                                        <p>Bouwjaar</p>
                                        <p>APK</p>
                                        <p>BTW auto</p>
                                    </div>
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>{{ dataSet.condition.tellerstand}}</p>
                                        <p>{{ dataSet.condition.bouwjaar }}</p>
                                        <p>{{ dataSet.docu.apk_tot }}</p>
                                        <p>{{ dataSet.docu.btw_marge }}</p>
                                   

                                    </div>
                                </div>
                            </div>
                        </DisclosurePanel>
                    </Disclosure>
                    <!--technische gegevens phone-->
                    <Disclosure v-slot="{ open }">
                        <DisclosureButton class="flex w-full justify-between rounded-lg bg-white
                             text-black items-center md:hidden">
                            <div class="flex py-0 text-left gap-3 w-full pb-2 border-b border-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M5.1222 21C5.5002 21.378 6.0022 21.586 6.5362 21.586C7.0702 21.586 7.5722 21.378 7.9502 21L12.2862 16.664C13.0043 16.8855 13.7517 16.9978 14.5032 16.997C15.4882 17 16.464 16.8076 17.3741 16.4308C18.2843 16.054 19.1106 15.5004 19.8052 14.802C20.8539 13.7563 21.5687 12.4229 21.8592 10.9707C22.1498 9.51846 22.0029 8.0127 21.4372 6.64401L20.8672 5.25601L16.6232 9.49901L14.5022 7.37701L18.7452 3.13401L17.3562 2.56301C16.45 2.18994 15.4792 1.99865 14.4992 2.00001C12.4962 2.00001 10.6132 2.78001 9.1982 4.19601C8.23119 5.15982 7.54645 6.36995 7.21822 7.6952C6.88999 9.02046 6.93079 10.4103 7.3362 11.714L3.0002 16.05C2.6255 16.4252 2.41504 16.9338 2.41504 17.464C2.41504 17.9943 2.6255 18.5028 3.0002 18.878L5.1222 21ZM9.6702 12.209L9.4162 11.593C9.00086 10.5894 8.89281 9.48502 9.10572 8.4199C9.31864 7.35479 9.84294 6.37685 10.6122 5.61001C11.1839 5.03462 11.8765 4.59383 12.6399 4.31966C13.4032 4.04549 14.2181 3.94483 15.0252 4.02501L11.6722 7.37801L16.6212 12.328L19.9762 8.97301C20.0544 9.78062 19.9527 10.5955 19.6783 11.3591C19.4039 12.1227 18.9636 12.8159 18.3892 13.389C16.8392 14.939 14.4252 15.416 12.4052 14.585L11.7902 14.33L6.5362 19.586H6.5372L6.5362 20.586V19.586L4.4142 17.464L9.6702 12.209Z"
                                        fill="black" />
                                </svg>
                                <p class="font-bold break-keep w-full">Technische gegevens</p>
                                <ChevronUpIcon :class="open ? 'rotate-180 transform' : ''" class="h-6 w-6 " />
                            </div>
                        </DisclosureButton>
                        <DisclosurePanel class=" text-gray-700">
                            <div
                                class="flex flex-col items-center md:items-start md:flex-row border-b-[1px] border-black  justify-between">

                                <div class="flex w-full pb-5 md:pt-0">
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>Topsnelheid</p>
                                        <p>Acceleratie</p>
                                        <p>Motorvermogen</p>
                                        <p>Transmissie</p>
                                        <p>Cilinderinhoud</p>
                                        <p>Versnellingen</p>
                                        <p>Cilinders</p>
                                        <p>Leeggewicht</p>
                                    </div>
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>{{ dataSet.techinfo.topsnelheid }} km/u</p>
                                        <p>0-100 {{ dataSet.techinfo.acceleratie }} sec</p>
                                        <p>{{ dataSet.techinfo.vermogen_motor_kw }}kW</p>
                                        <p>{{ dataSet.techinfo.transmissie }}</p>
                                        <p>{{ dataSet.techinfo.cilinder_inhoud }}cm³</p>
                                        <p>{{ dataSet.techinfo.aantal_versnellingen }}</p>
                                        <p>{{ dataSet.techinfo.cilinder_aantal }}</p>
                                        <p>{{ dataSet.carinfo.massa }} kg</p>
                                    </div>
                                </div>
                            </div>
                        </DisclosurePanel>
                    </Disclosure>
                    <!--Energie phone-->
                    <Disclosure v-slot="{ open }">
                        <DisclosureButton class="flex w-full justify-between rounded-lg bg-white
                             text-black items-center md:hidden">
                            <div class="flex py-0 text-left gap-3 w-full pb-2 border-b border-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M21.8798 2.1499L20.6798 2.5499C18.6232 3.26445 16.427 3.48372 14.2698 3.1899C12.0029 2.83811 9.68267 3.15072 7.58975 4.0899C6.48023 4.56235 5.50651 5.30482 4.75723 6.24971C4.00795 7.19461 3.50692 8.31191 3.29975 9.4999C3.08902 10.6424 3.11058 11.8155 3.36314 12.9495C3.6157 14.0834 4.09408 15.1549 4.76975 16.0999C4.70975 16.3099 4.64975 16.5199 4.59975 16.7299C4.19359 18.4569 3.99221 20.2258 3.99975 21.9999H5.99975C6.09375 20.5477 6.29092 19.1041 6.58975 17.6799C7.97719 18.4291 9.5331 18.8112 11.1098 18.7899C12.5802 18.7889 14.0356 18.4931 15.3898 17.9199C22.9998 14.6699 21.9998 3.8599 21.9998 3.4099L21.8798 2.1499ZM14.6098 16.0799C11.9998 17.1899 8.87975 16.9999 7.12975 15.6299C7.42552 14.6409 7.8314 13.6883 8.33975 12.7899C8.73495 12.1433 9.20118 11.5429 9.72975 10.9999C10.2699 10.4511 10.8782 9.97386 11.5398 9.5799C12.9068 8.76245 14.423 8.22535 15.9998 7.9999V6.9999C14.1855 6.9371 12.3824 7.30731 10.7398 8.0799C9.06017 8.89945 7.63578 10.1614 6.61975 11.7299C6.24292 12.329 5.90876 12.9539 5.61975 13.5999C5.15627 12.4143 5.02489 11.1247 5.23975 9.8699C5.38053 8.99144 5.74265 8.16328 6.292 7.46347C6.84135 6.76366 7.55984 6.21524 8.37975 5.8699C9.57537 5.31106 10.88 5.02418 12.1998 5.0299C12.8198 5.0299 13.4298 5.0899 14.0698 5.1399C16.0741 5.3985 18.1091 5.2798 20.0698 4.7899C19.9998 7.5499 19.4998 13.9999 14.6098 16.0799Z"
                                        fill="black" />
                                </svg>
                                <p class="font-bold break-keep w-full">Energie verbruik</p>
                                <ChevronUpIcon :class="open ? 'rotate-180 transform' : ''" class="h-6 w-6 " />
                            </div>

                        </DisclosureButton>
                        <DisclosurePanel class=" text-gray-700">
                            <div
                                class="flex flex-col items-center md:items-start md:flex-row  border-b-[1px] border-black  justify-between">

                                <div class="flex w-full pb-5 md:pt-0">
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>Brandstof</p>
                                        <p>gemiddeld verbruik</p>
                                        <p>Verbruik stad</p>
                                        <p>Verbruik snelweg</p>
                                        <p>CO2-emissie</p>
                                        <p>Emissieklasse</p>
                                    </div>
                                    <div class="flex flex-col  gap-1 w-1/2">
                                        <p>{{ dataSet.techinfo.brandstof}}</p>
                                        <p class="text-nowrap">{{ dataSet.techinfo.gemiddeld_verbruik}} L/ 100km (gem.)</p>
                                        <div class="flex flex-row w-fill justify-between">
                                            <p class="text-nowrap">{{ dataSet.techinfo.verbruik_stad}} L / 100km</p>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M19 2H9C7.897 2 7 2.897 7 4V10H5C3.897 10 3 10.897 3 12V21C3 21.2652 3.10536 21.5196 3.29289 21.7071C3.48043 21.8946 3.73478 22 4 22H20C20.2652 22 20.5196 21.8946 20.7071 21.7071C20.8946 21.5196 21 21.2652 21 21V4C21 2.897 20.103 2 19 2ZM5 12H11V20H5V12ZM19 20H13V12C13 10.897 12.103 10 11 10H9V4H19V20Z"
                                                    fill="black" />
                                                <path
                                                    d="M11 6H13V8H11V6ZM15 6H17V8H15V6ZM15 10.031H17V12H15V10.031ZM15 14H17V16H15V14ZM7 14.001H9V16.001H7V14.001Z"
                                                    fill="black" />
                                            </svg>
                                        </div>
                                        <div class="flex flex-row w-fill justify-between">
                                            <p class="text-nowrap">{{dataSet.techinfo.verbruik_snelweg}}L / 100km</p>
                                           <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	 width="24px" height="24px" viewBox="0 0 496 496" xml:space="preserve">
<g>
	<g>
		<polygon points="119.178,72.985 0,423.015 60.237,423.015 146.667,72.985 		"/>
		<polygon points="376.822,72.985 349.333,72.985 435.763,423.015 496,423.015 		"/>
		<path d="M170.176,72.985L83.93,423.015h127.624l3.514-51.512h65.864l3.514,51.512H412.07L325.827,72.985H170.176z M236.651,76.998
			h22.699l3.596,49.085h-29.893L236.651,76.998z M229.458,175.167h37.086l3.597,49.084h-44.283L229.458,175.167z M218.667,322.417
			l3.596-49.082h51.475l3.599,49.082H218.667z"/>
	</g>
</g>
</svg>
                                        </div>
                                        <p>{{ dataSet.techinfo.co2_uitstoot }}L g/km </p>
                                        <p>Euro {{ dataSet.techinfo.emissieklasse }}</p>
                                    </div>
                                </div>
                            </div>
                        </DisclosurePanel>
                    </Disclosure>
                    <!--Kleur en interieur phone-->
                    <Disclosure v-slot="{ open }">
                        <DisclosureButton class="flex w-full justify-between rounded-lg bg-white
                             text-black items-center md:hidden">
                            <div class="flex py-0 text-left gap-3 w-full pb-2 border-b border-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none">
                                    <path
                                        d="M3 1H7C7.53043 1 8.03914 1.21071 8.41421 1.58579C8.78929 1.96086 9 2.46957 9 3V15C9 16.0609 8.57857 17.0783 7.82843 17.8284C7.07828 18.5786 6.06087 19 5 19C3.93913 19 2.92172 18.5786 2.17157 17.8284C1.42143 17.0783 1 16.0609 1 15V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1Z"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M8.99964 5.35022L10.9996 3.35022C11.3747 2.97528 11.8833 2.76465 12.4136 2.76465C12.944 2.76465 13.4526 2.97528 13.8276 3.35022L16.6556 6.17822C17.0306 6.55328 17.2412 7.06189 17.2412 7.59222C17.2412 8.12255 17.0306 8.63117 16.6556 9.00622L7.65564 18.0062"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M14.7 11H17C17.5304 11 18.0391 11.2107 18.4142 11.5858C18.7893 11.9609 19 12.4696 19 13V17C19 17.5304 18.7893 18.0391 18.4142 18.4142C18.0391 18.7893 17.5304 19 17 19H5M5 15V15.01"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <p class="font-bold text-nowrap w-full">Kleur en interieur</p>
                                <ChevronUpIcon :class="open ? 'rotate-180 transform' : ''" class="h-6 w-6 " />
                            </div>

                        </DisclosureButton>
                        <DisclosurePanel class=" text-gray-700 border-b border-black pb-2 ">
                            <div class="flex flex-col items-center md:items-start md:flex-row  justify-between ">

                                <div class="flex w-full pb-5 md:pt-0">
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>Kleur</p>
                                        <p>Soort kleur</p>
                                        <p>Kleur interieur</p>
                                        <p class="text-nowrap">Materiaal interieur</p>
                                    </div>
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>{{ dataSet.looks.basiskleur}}</p>
                                        <p>{{ dataSet.looks.laksoort}}</p>
                                        <p>{{ dataSet.looks.interieurkleur}}</p>
                                        <p>{{ dataSet.looks.bekleding}}</p>
                                    </div>
                                </div>
                            </div>
                        </DisclosurePanel>
                    </Disclosure>
                    <br>
                    <h4 class="md:hidden flex border-b border-black">Accessoires</h4>
                    <!--Comfort phone-->
                    <Disclosure v-slot="{ open }">
                        <DisclosureButton class="flex w-full justify-between rounded-lg bg-white
                             text-black items-center md:hidden">
                            <div class="flex py-0 text-left gap-3 w-full pb-2 border-b border-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M22 15C22 17.6 20.8 19.9 18.9 21.3L18.4 20.8L16.3 18.7L17.7 17.3L18.9 18.5C19.4 17.8 19.8 16.9 19.9 16H18V14H19.9C19.7 13.1 19.4 12.3 18.9 11.5L17.7 12.7L16.3 11.3L17.5 10.1C16.8 9.6 15.9 9.2 15 9.1V11H13V9.1C12.1 9.3 11.3 9.6 10.5 10.1L13.5 13.1C13.7 13.1 13.8 13 14 13C14.5304 13 15.0391 13.2107 15.4142 13.5858C15.7893 13.9609 16 14.4696 16 15C16 15.5304 15.7893 16.0391 15.4142 16.4142C15.0391 16.7893 14.5304 17 14 17C13.4696 17 12.9609 16.7893 12.5858 16.4142C12.2107 16.0391 12 15.5304 12 15C12 14.8 12 14.7 12.1 14.5L9.1 11.5C8.6 12.2 8.2 13.1 8.1 14H10V16H8.1C8.3 16.9 8.6 17.7 9.1 18.5L10.3 17.3L11.7 18.7L9.1 21.3C7.2 19.9 6 17.6 6 15C6 12.8783 6.84285 10.8434 8.34315 9.34315C9.84344 7.84285 11.8783 7 14 7C16.1217 7 18.1566 7.84285 19.6569 9.34315C21.1571 10.8434 22 12.8783 22 15ZM6.7 5.3L3.4 2L2 3.4L5.3 6.7L4 8H8V4L6.7 5.3Z"
                                        fill="black" />
                                </svg>
                                <p class="font-bold w-full">accesoires</p>
                                <ChevronUpIcon :class="open ? 'rotate-180 transform' : ''" class="h-6 w-6  " />
                            </div>
                        </DisclosureButton>
                        <DisclosurePanel class=" text-gray-700">
                            <p class="m-0">
                                <div v-for="accesoire in accessoires" key:index  class="inline-flex" >
                                    
                                    <div class="border rounded-lg px-6 py-3 text-center mx-1 my-1.5">{{ accesoire.name }} </div>
                                    
                                </div>  
                           
                                   
                          
                            </p>
                        </DisclosurePanel>
                    </Disclosure>
                
                    <br>
                    <h4 class="md:hidden flex border-b border-black">Extra informatie</h4>
                    <Disclosure v-slot="{ open }">
                        <DisclosureButton class="flex w-full justify-between rounded-lg bg-white
                             text-black items-center md:hidden">

                            <div class="flex py-0 text-left gap-3 w-full pb-2 border-b border-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path d="M19 11H13V5H11V11H5V13H11V19H13V13H19V11Z" fill="black" />
                                </svg>
                                <p class="font-bold text-nowrap w-full">Informatie</p>
                                <ChevronUpIcon :class="open ? 'rotate-180 transform' : ''" class="h-6 w-6 " />
                            </div>

                        </DisclosureButton>
                        <DisclosurePanel class=" text-gray-700">
                            <div
                                class="flex flex-col items-center md:items-start md:flex-row border-b-[0px] border-black  justify-between">

                                <div class="flex flex-col gap-2 w-full border-b border-b-black pb-8">
                                    <p>{{ dataSet.opmerkingen}}</p>
                                </div>
                            </div>
                        </DisclosurePanel>
                    </Disclosure>
                    <TabView class="md:block hidden">
                        <TabPanel header="Details">
                            <p class="m-0">

                            <div
                                class="flex flex-col items-center md:items-start md:flex-row py-2 border-b-[1px] border-black  justify-between">
                                <div class="flex py-0 items-center gap-3 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"
                                        fill="none">
                                        <path d="M18 12.0004V19.5004H25.5V16.5004H21V12.0004H18Z" fill="black" />
                                        <path
                                            d="M31.938 12.7459C31.2614 11.141 30.2792 9.68295 29.046 8.45293C27.1793 6.58628 24.8066 5.30758 22.221 4.77493C20.4264 4.40966 18.5766 4.40966 16.782 4.77493C14.194 5.30418 11.8192 6.58392 9.954 8.45443C8.72383 9.68576 7.742 11.1422 7.062 12.7444C6.35866 14.4073 5.99748 16.1949 6 18.0004L6.0015 18.0379H3L7.5 24.0004L12 18.0379H9.0015L9 18.0004C8.99568 15.9085 9.62019 13.8635 10.7925 12.1309C11.5487 11.013 12.5114 10.0497 13.629 9.29293C14.7659 8.52704 16.0412 7.99003 17.3835 7.71193C20.1113 7.15108 22.9502 7.69637 25.2761 9.22794C27.602 10.7595 29.2245 13.152 29.787 15.8794C30.07 17.2773 30.07 18.7176 29.787 20.1154C29.5126 21.4589 28.9753 22.7348 28.206 23.8699C27.831 24.4264 27.4005 24.9499 26.925 25.4239C25.9668 26.381 24.8338 27.1453 23.5875 27.6754C22.9527 27.9438 22.293 28.1487 21.618 28.2874C20.2207 28.5702 18.7808 28.5702 17.3835 28.2874C16.0414 28.0123 14.7667 27.4756 13.632 26.7079C13.0739 26.3308 12.5531 25.9014 12.0765 25.4254L9.9555 27.5464C11.2082 28.8008 12.696 29.7958 14.3338 30.4743C15.9716 31.1528 17.7272 31.5015 19.5 31.5004C21.3046 31.4997 23.0909 31.1392 24.7545 30.4399C27.1659 29.4197 29.229 27.7208 30.693 25.5499C32.1997 23.3208 33.0033 20.691 33 18.0004C33.0038 16.1953 32.6425 14.408 31.938 12.7459Z"
                                            fill="black" />
                                    </svg>
                                    <p class="font-bold">Basis gegevens</p>
                                </div>
                                <div class="flex w-full pt-7 md:pt-0">
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>Carrosserietype</p>
                                        <p>Categorie</p>
                                        <p>Aandrijving</p>
                                        <p>Stoelen</p>     
                                        <p>Deuren</p>
                                        <p>Kenteken</p>
                                        <p>Belasting</p>

                                    </div>
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>{{ dataSet.carinfo.carrosserie}}</p>
                                       <p v-if="dataSet.condition.nieuw_voertuig == '0'">Gebruikt</p>
                                        <p>{{ dataSet.carinfo.aandrijving }}</p>
                                        <p> {{ dataSet.carinfo.aantal_zitplaatsen }}</p>
                                        <p>{{ dataSet.carinfo.aantal_deuren }}</p>
                                            <p>{{ dataSet.docu.kenteken }}</p>
                                        <p>€{{ dataSet.docu.belasting }} per kwartaal</p>
                       
                                    </div>
                                </div>
                            </div>
                            <!--Voertuig gegevens-->
                            <div
                                class="flex flex-col items-center md:items-start md:flex-row py-2 border-b-[1px] border-black  justify-between">
                                <div class="flex py-0 items-center gap-3 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"
                                        fill="none">
                                        <path d="M18 12.0004V19.5004H25.5V16.5004H21V12.0004H18Z" fill="black" />
                                        <path
                                            d="M31.938 12.7459C31.2614 11.141 30.2792 9.68295 29.046 8.45293C27.1793 6.58628 24.8066 5.30758 22.221 4.77493C20.4264 4.40966 18.5766 4.40966 16.782 4.77493C14.194 5.30418 11.8192 6.58392 9.954 8.45443C8.72383 9.68576 7.742 11.1422 7.062 12.7444C6.35866 14.4073 5.99748 16.1949 6 18.0004L6.0015 18.0379H3L7.5 24.0004L12 18.0379H9.0015L9 18.0004C8.99568 15.9085 9.62019 13.8635 10.7925 12.1309C11.5487 11.013 12.5114 10.0497 13.629 9.29293C14.7659 8.52704 16.0412 7.99003 17.3835 7.71193C20.1113 7.15108 22.9502 7.69637 25.2761 9.22794C27.602 10.7595 29.2245 13.152 29.787 15.8794C30.07 17.2773 30.07 18.7176 29.787 20.1154C29.5126 21.4589 28.9753 22.7348 28.206 23.8699C27.831 24.4264 27.4005 24.9499 26.925 25.4239C25.9668 26.381 24.8338 27.1453 23.5875 27.6754C22.9527 27.9438 22.293 28.1487 21.618 28.2874C20.2207 28.5702 18.7808 28.5702 17.3835 28.2874C16.0414 28.0123 14.7667 27.4756 13.632 26.7079C13.0739 26.3308 12.5531 25.9014 12.0765 25.4254L9.9555 27.5464C11.2082 28.8008 12.696 29.7958 14.3338 30.4743C15.9716 31.1528 17.7272 31.5015 19.5 31.5004C21.3046 31.4997 23.0909 31.1392 24.7545 30.4399C27.1659 29.4197 29.229 27.7208 30.693 25.5499C32.1997 23.3208 33.0033 20.691 33 18.0004C33.0038 16.1953 32.6425 14.408 31.938 12.7459Z"
                                            fill="black" />
                                    </svg>
                                    <p class="font-bold">Voertuig gegevens</p>
                                </div>
                                <div class="flex w-full pt-7 md:pt-0">
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>Kilometerstand</p>
                                        <p>Bouwjaar</p>
                                        <p>APK</p>
                                        <p>BTW auto</p>
                                    </div>
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>{{ dataSet.condition.tellerstand}} km</p>
                                        <p>{{ dataSet.condition.bouwjaar }}</p>
                                        <p>{{ dataSet.docu.apk_tot }}</p>
                                      <p>{{ dataSet.docu.btw_marge }}</p>
                                    </div>
                                </div>
                            </div>
                            <!--Technische gegevens-->
                            <div
                                class="flex flex-col items-center md:items-start md:flex-row py-2 border-b-[1px] border-black  justify-between">
                                <div class="flex py-0 items-center gap-3 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"
                                        fill="none">
                                        <path
                                            d="M7.68379 31.5C8.25079 32.067 9.00379 32.379 9.80479 32.379C10.6058 32.379 11.3588 32.067 11.9258 31.5L18.4298 24.996C19.507 25.3283 20.628 25.4967 21.7553 25.4955C23.2328 25.5 24.6965 25.2113 26.0617 24.6462C27.4269 24.081 28.6663 23.2506 29.7083 22.203C31.2813 20.6344 32.3536 18.6343 32.7894 16.456C33.2251 14.2777 33.0048 12.0191 32.1563 9.96601L31.3013 7.88401L24.9353 14.2485L21.7538 11.0655L28.1183 4.70101L26.0348 3.84451C24.6754 3.28491 23.{{ dataSet.techinfo.topsnelheid }}3 2.99797 21.7493 3.00001C18.7448 3.00001 15.9203 4.17001 13.7978 6.29401C12.3473 7.73973 11.3202 9.55492 10.8278 11.5428C10.3355 13.5307 10.3967 15.6154 11.0048 17.571L4.50079 24.075C3.93874 24.6378 3.62305 25.4006 3.62305 26.196C3.62305 26.9914 3.93874 27.7542 4.50079 28.317L7.68379 31.5ZM14.5058 18.3135L14.1248 17.3895C13.5018 15.884 13.3397 14.2275 13.6591 12.6299C13.9784 11.0322 14.7649 9.56528 15.9188 8.41501C16.7763 7.55193 17.8153 6.89074 18.9603 6.47949C20.1053 6.06823 21.3276 5.91725 22.5383 6.03751L17.5088 11.067L24.9323 18.492L29.9648 13.4595C30.0821 14.6709 29.9295 15.8933 29.5179 17.0387C29.1063 18.184 28.4459 19.2239 27.5843 20.0835C25.2593 22.4085 21.6383 23.124 18.6083 21.8775L17.6858 21.495L9.80479 29.379H9.80629L9.80479 30.879V29.379L6.62179 26.196L14.5058 18.3135Z"
                                            fill="black" />
                                    </svg>
                                    <p class="font-bold break-keep">Technische gegevens</p>
                                </div>
                                <div class="flex w-full pt-7 md:pt-0">
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>Topsnelheid</p>
                                        <p>Acceleratie</p>
                                        <p>Motorvermogen</p>
                                        <p>Transmissie</p>
                                        <p>Cilinderinhoud</p>
                                        <p>Versnellingen</p>
                                        <p>Cilinders</p>
                                        <p>Leeggewicht</p>
                                    </div>
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>{{ dataSet.techinfo.topsnelheid }} km/u</p>
                                        <p>0-100 {{ dataSet.techinfo.acceleratie }} sec</p>
                                        <p>{{ dataSet.techinfo.vermogen_motor_kw }} kW (174 pk)</p>
                                        <p>{{ dataSet.techinfo.transmissie }}</p>
                                        <p>{{ dataSet.techinfo.cilinder_inhoud }} cm³</p>
                                        <p>{{ dataSet.techinfo.aantal_versnellingen }}</p>
                                        <p>{{ dataSet.techinfo.cilinder_aantal }}</p>
                                        <p>{{ dataSet.techinfo.massa}} kg</p>
                                    </div>
                                </div>
                            </div>

                            <!--Energie gebruik-->
                            <div
                                class="flex flex-col items-center md:items-start md:flex-row py-2 border-b-[1px] border-black  justify-between">
                                <div class="flex py-0 items-center gap-3 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"
                                        fill="none">
                                        <path
                                            d="M32.8196 3.22461L31.0196 3.82461C27.9348 4.89643 24.6405 5.22534 21.4046 4.78461C18.0043 4.25693 14.524 4.72583 11.3846 6.13461C9.72035 6.84328 8.25976 7.95698 7.13584 9.37432C6.01192 10.7917 5.26038 12.4676 4.94963 14.2496C4.63353 15.9633 4.66587 17.7231 5.0447 19.424C5.42354 21.1249 6.14112 22.7321 7.15463 24.1496C7.06463 24.4646 6.97463 24.7796 6.89963 25.0946C6.29039 27.6852 5.98831 30.3384 5.99963 32.9996H8.99963C9.14063 30.8214 9.43637 28.6559 9.88463 26.5196C11.9658 27.6434 14.2997 28.2166 16.6646 28.1846C18.8703 28.1831 21.0534 27.7393 23.0846 26.8796C34.4996 22.0046 32.9996 5.78961 32.9996 5.11461L32.8196 3.22461ZM21.9146 24.1196C17.9996 25.7846 13.3196 25.4996 10.6946 23.4446C11.1383 21.9612 11.7471 20.5322 12.5096 19.1846C13.1024 18.2147 13.8018 17.3141 14.5946 16.4996C15.4048 15.6764 16.3172 14.9605 17.3096 14.3696C19.3602 13.1434 21.6344 12.3378 23.9996 11.9996V10.4996C21.2783 10.4054 18.5737 10.9607 16.1096 12.1196C13.5903 13.3489 11.4537 15.2418 9.92963 17.5946C9.36438 18.4932 8.86314 19.4305 8.42963 20.3996C7.73441 18.6211 7.53734 16.6867 7.85963 14.8046C8.07079 13.4869 8.61398 12.2447 9.438 11.195C10.262 10.1452 11.3398 9.32262 12.5696 8.80461C14.3631 7.96635 16.32 7.53603 18.2996 7.54461C19.2296 7.54461 20.1446 7.63461 21.1046 7.70961C24.1111 8.09751 27.1636 7.91945 30.1046 7.18461C29.9996 11.3246 29.2496 20.9996 21.9146 24.1196Z"
                                            fill="black" />
                                    </svg>
                                    <p class="font-bold break-keep">Energie verbruik</p>
                                </div>
                                <div class="flex w-full pt-7 md:pt-0">
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>Brandstof</p>
                                        <p>Brandstofverbruik</p>
                                        <br>
                                        <br>
                                        <p>CO2-emissie</p>
                                        <p>Emissieklasse</p>
                                    </div>
                                    <div class="flex flex-col  gap-1 w-1/2">
                                        <p>{{ dataSet.techinfo.brandstof}}</p>
                                        <p class="text-nowrap">{{ dataSet.techinfo.gemiddeld_verbruik}} L/ 100km (gem.)</p>
                                        <div class="flex flex-row w-fill justify-between">
                                            <p class="text-nowrap">{{ dataSet.techinfo.verbruik_stad}} L / 100km</p>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M19 2H9C7.897 2 7 2.897 7 4V10H5C3.897 10 3 10.897 3 12V21C3 21.2652 3.10536 21.5196 3.29289 21.7071C3.48043 21.8946 3.73478 22 4 22H20C20.2652 22 20.5196 21.8946 20.7071 21.7071C20.8946 21.5196 21 21.2652 21 21V4C21 2.897 20.103 2 19 2ZM5 12H11V20H5V12ZM19 20H13V12C13 10.897 12.103 10 11 10H9V4H19V20Z"
                                                    fill="black" />
                                                <path
                                                    d="M11 6H13V8H11V6ZM15 6H17V8H15V6ZM15 10.031H17V12H15V10.031ZM15 14H17V16H15V14ZM7 14.001H9V16.001H7V14.001Z"
                                                    fill="black" />
                                            </svg>
                                        </div>
                                        <div class="flex flex-row w-fill justify-between">
                                            <p class="text-nowrap">{{ dataSet.techinfo.verbruik_snelweg}}L / 100km</p>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M3 20H21C21.176 20.0001 21.3488 19.9537 21.5011 19.8656C21.6534 19.7774 21.7798 19.6507 21.8674 19.4981C21.955 19.3456 22.0009 19.1726 22.0003 18.9966C21.9997 18.8207 21.9527 18.648 21.864 18.496L14.864 6.496C14.505 5.881 13.495 5.883 13.135 6.496L9.866 12.1L8.846 10.468C8.75619 10.3247 8.63144 10.2066 8.48346 10.1247C8.33548 10.0429 8.16912 9.99994 8 10C7.83057 10.0002 7.66295 10.0434 7.5148 10.1256C7.36664 10.2078 7.2418 10.3263 7.152 10.47L2.152 18.47C2.05739 18.6214 2.00503 18.7953 2.00034 18.9738C1.99566 19.1522 2.03882 19.3286 2.12536 19.4848C2.21189 19.6409 2.33864 19.771 2.49244 19.8616C2.64625 19.9522 2.8215 20 3 20ZM14 8.985L19.259 18H13.555L11.069 14.013L14 8.985ZM8.001 12.885L11.197 18H4.805L8.001 12.885ZM6 8C7.654 8 9 6.654 9 5C9 3.346 7.654 2 6 2C4.346 2 3 3.346 3 5C3 6.654 4.346 8 6 8ZM6 4C6.26522 4 6.51957 4.10536 6.70711 4.29289C6.89465 4.48043 7 4.73478 7 5C7 5.26522 6.89465 5.51957 6.70711 5.70711C6.51957 5.89464 6.26522 6 6 6C5.73479 6 5.48043 5.89464 5.2929 5.70711C5.10536 5.51957 5 5.26522 5 5C5 4.73478 5.10536 4.48043 5.2929 4.29289C5.48043 4.10536 5.73479 4 6 4Z"
                                                    fill="black" />
                                            </svg>
                                        </div>
                                        <p>116 g/km (gem.)</p>
                                        <p>Euro 6</p>
                                    </div>
                                </div>
                            </div>
                            <!--Kleur en intrieur-->
                            <div
                                class="flex flex-col items-center md:items-start md:flex-row py-2 border-b-[0px] border-black  justify-between">
                                <div class="flex py-0 items-center gap-3 w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                                        fill="none">
                                        <path
                                            d="M4.5 1.5H10.5C1{{ dataSet.techinfo.massa}}6 1.5 12.0587 1.81607 12.6213 2.37868C13.1839 2.94129 13.5 3.70435 13.5 4.5V22.5C13.5 24.0913 12.8679 25.6174 11.7426 26.7426C10.6174 27.8679 9.0913 28.5 7.5 28.5C5.9087 28.5 4.38258 27.8679 3.25736 26.7426C2.13214 25.6174 1.5 24.0913 1.5 22.5V4.5C1.5 3.70435 1.81607 2.94129 2.37868 2.37868C2.94129 1.81607 3.70435 1.5 4.5 1.5Z"
                                            stroke="black" stroke-width="3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M13.499 8.02533L16.499 5.02533C17.0616 4.46292 17.8245 4.14697 18.62 4.14697C19.4155 4.14697 20.1784 4.46292 20.741 5.02533L24.983 9.26733C25.5454 9.82992 25.8613 10.5928 25.8613 11.3883C25.8613 12.1838 25.5454 12.9467 24.983 13.5093L11.483 27.0093"
                                            stroke="black" stroke-width="3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M22.05 16.5H25.5C26.2956 16.5 27.0587 16.8161 27.6213 17.3787C28.1839 17.9413 28.5 18.7044 28.5 19.5V25.5C28.5 26.2956 28.1839 27.0587 27.6213 27.6213C27.0587 28.1839 26.2956 28.5 25.5 28.5H7.5M7.5 22.5V22.515"
                                            stroke="black" stroke-width="3" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <p class="font-bold text-nowrap">Kleur en interieur</p>
                                </div>
                                <div class="flex w-full pt-7 md:pt-0">
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>Kleur</p>
                                        <p>Soort kleur</p>
                                        <p>Kleur interieur</p>
                                    <p class="text-nowrap">Materiaal interieur</p>
                                    </div>
                                    <div class="flex flex-col gap-1 w-1/2">
                                        <p>{{ dataSet.looks.basiskleur}}</p>
                                        <p>{{ dataSet.looks.laksoort}}</p>
                                        <p>{{ dataSet.looks.interieurkleur}}</p>
                                        <p>{{ dataSet.looks.bekleding}}</p>
                                    </div>
                                </div>
                            </div>

                            </p>
                        </TabPanel>
                        <TabPanel header="Opties & Accessoires">
                            <p class="m-0">
                                <div v-for="accesoire in accessoires" key:index  class="inline-flex" >
                                    
                                    <div class="border rounded-lg px-6 py-3 text-center mx-1 my-1.5">{{ accesoire.name }} </div>
                                    
                                </div>  
                           
                                   
                          
                            </p>
                        </TabPanel>
                        <TabPanel header="Extra informatie">
                            <p class="m-0">
                            <div class="flex flex-col gap-2 w-full border-b-2 border-b-black pb-8">
                                <p>{{ dataSet.opmerkingen }}</p>
                            </div>
                            </p>
                        </TabPanel>
                    </TabView>
                </div>
                <section id="pricesticky" class="bg-white md:hidden bottom-0 py-4 w-full z-20 sticky ">
                    <div class="w-full max-w-6xl flex flex-col mx-auto gap-6">
                        <div class="flex flex-col items-start gap-4 w-full">
                            <div class="flex flex-row items-start gap-4 w-full">
                                <a class="flex py-3 px-4 justify-center items-center gap-3 flex-1 bg-orange rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24"
                                        fill="none">
                                        <path
                                            d="M18.4573 12.2932C18.3645 12.2003 18.2543 12.1265 18.133 12.0762C18.0117 12.0259 17.8817 12 17.7503 12C17.619 12 17.489 12.0259 17.3676 12.0762C17.2463 12.1265 17.1361 12.2003 17.0433 12.2932L15.4493 13.8872C14.7103 13.6672 13.3313 13.1672 12.4573 12.2932C11.5833 11.4192 11.0833 10.0402 10.8633 9.3012L12.4573 7.7072C12.5503 7.61441 12.624 7.50421 12.6743 7.38289C12.7246 7.26158 12.7505 7.13153 12.7505 7.0002C12.7505 6.86887 12.7246 6.73882 12.6743 6.61751C12.624 6.49619 12.5503 6.38599 12.4573 6.2932L8.45733 2.2932C8.36455 2.20026 8.25434 2.12652 8.13303 2.07621C8.01171 2.0259 7.88167 2 7.75033 2C7.619 2 7.48896 2.0259 7.36764 2.07621C7.24633 2.12652 7.13612 2.20026 7.04333 2.2932L4.33133 5.0052C3.95133 5.3852 3.73733 5.9072 3.74533 6.4402C3.76833 7.8642 4.14533 12.8102 8.04333 16.7082C11.9413 20.6062 16.8873 20.9822 18.3123 21.0062H18.3403C18.8683 21.0062 19.3673 20.7982 19.7453 20.4202L22.4573 17.7082C22.5503 17.6154 22.624 17.5052 22.6743 17.3839C22.7246 17.2626 22.7505 17.1325 22.7505 17.0012C22.7505 16.8699 22.7246 16.7398 22.6743 16.6185C22.624 16.4972 22.5503 16.387 22.4573 16.2942L18.4573 12.2932ZM18.3303 19.0052C17.0823 18.9842 12.8123 18.6492 9.45733 15.2932C6.09133 11.9272 5.76533 7.6422 5.74533 6.4192L7.75033 4.4142L10.3363 7.0002L9.04333 8.2932C8.9258 8.41065 8.83938 8.55554 8.79189 8.71477C8.7444 8.874 8.73733 9.04256 8.77133 9.2052C8.79533 9.3202 9.38233 12.0472 11.0423 13.7072C12.7023 15.3672 15.4293 15.9542 15.5443 15.9782C15.7069 16.0132 15.8756 16.0067 16.035 15.9593C16.1944 15.9119 16.3393 15.8252 16.4563 15.7072L17.7503 14.4142L20.3363 17.0002L18.3303 19.0052Z"
                                            fill="white" />
                                    </svg>
                                    <p class="text-white">Contact</p>
                                </a>
                                <a href="https://wa.me/31612345678?text=Hallo%20MTF%20Automobielen,%20Ik%20wou%20graag%20meer%20info%20over%20$voertuig"
                                    class="flex py-3 px-6 justify-center items-center gap-3 flex-1 bg-orange rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M12.75 3C7.7793 3 3.75 7.0293 3.75 12C3.75 13.701 4.2225 15.294 5.0442 16.6512L4.2414 19.38C4.19531 19.5367 4.19227 19.7029 4.23262 19.8611C4.27297 20.0194 4.3552 20.1638 4.47068 20.2793C4.58616 20.3948 4.73062 20.477 4.88887 20.5174C5.04713 20.5577 5.21332 20.5547 5.37 20.5086L8.0988 19.7058C9.50161 20.5546 11.1104 21.0022 12.75 21C17.7207 21 21.75 16.9707 21.75 12C21.75 7.0293 17.7207 3 12.75 3ZM10.7142 14.0367C12.5349 15.8565 14.2728 16.0968 14.8866 16.1193C15.8199 16.1535 16.7289 15.4407 17.0826 14.6136C17.1272 14.5107 17.1435 14.3977 17.1295 14.2864C17.1156 14.1751 17.072 14.0696 17.0034 13.9809C16.5102 13.3509 15.8433 12.8982 15.1917 12.4482C15.0556 12.3541 14.8885 12.3164 14.7252 12.3429C14.5619 12.3694 14.4153 12.4581 14.316 12.5904L13.776 13.4139C13.7476 13.4582 13.7034 13.4899 13.6523 13.5026C13.6013 13.5153 13.5473 13.5081 13.5015 13.4823C13.1352 13.2726 12.6015 12.9162 12.2181 12.5328C11.8347 12.1494 11.4999 11.64 11.3118 11.2971C11.2885 11.2535 11.2817 11.203 11.2928 11.1548C11.3039 11.1067 11.3321 11.0642 11.3721 11.0352L12.2037 10.4178C12.3224 10.3146 12.399 10.1714 12.4189 10.0154C12.4388 9.85937 12.4006 9.70149 12.3117 9.5718C11.9085 8.9814 11.4387 8.2308 10.7574 7.7331C10.6695 7.66938 10.5665 7.62965 10.4585 7.61782C10.3506 7.60598 10.2414 7.62245 10.1418 7.6656C9.3138 8.0202 8.5974 8.9292 8.6316 9.8643C8.6541 10.4781 8.8944 12.216 10.7142 14.0367Z"
                                            fill="white" />
                                    </svg>
                                    <p class="text-white">Whatsapp</p>
                                </a>
                            </div>
                            <Button class="border border-black w-full py-3" label="Proefrit aanvragen"
                                severity="secondary" />
                        </div>
                    </div>
                </section>
                <div class="relative w-full col-span-2">
                    <div class="hidden col-span-2 lg:flex flex-col gap-5 sticky top-28">
                        <div class="flex w-full flex-row flex-wrap gap-2 justify-between items-baseline">
                            <h3>€{{ dataSet.verkoopprijs_particulier }}</h3>
                            <a href="#lease" class="flex gap-2 underline lg:no-underline hover:underline text-nowrap">
                                <p>Financiering <span class="text-orange font-semibold">€{{ dataSet.lease_maandbedrag }} p/m </span></p>
                            </a>
                        </div>
                        <div class="flex flex-col items-start gap-4 w-full pb-2">
                            <Button class="grey-button sm:w-full" label="Berekenen" severity="secondary" />
                            <div class="flex flex-row gap-4 w-full">
                                <a class="w-full">
                                    <Button label="Contact" icon="pi pi-phone" class="orange-button md:w-full" />
                                </a>
                                <a class="w-full">
                                    <Button label="Whatsapp" icon="pi pi-whatsapp" class="orange-button md:w-full " />
                                </a>
                            </div>
                            <Button class="clear-black-button sm:w-full" label="Proefrit aanvragen"
                                severity="secondary" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:grid grid-cols-5 gap-5 md:order-5 w-full">
                <div class="flex flex-col gap-6 w-full col-span-3">
                    <h3 class="font-bold">Vraag nu een proefrit aan!</h3>
                    <p>Neem direct contact met ons op indien u intresse heeft in dit voertuig</p>
                </div>
                <div class="flex flex-col gap-2 flex-1 col-span-2">
                    <div class="flex flex-row gap-4 w-full">
                        <a class="w-full">
                            <Button label="Contact" icon="pi pi-phone" class="orange-button md:w-full" />
                        </a>
                        <a class="w-full">
                            <Button label="Whatsapp" icon="pi pi-whatsapp" class="orange-button md:w-full " />
                        </a>
                    </div>
                    <div class="flex gap-4">
                        <input class="rounded-lg flex p-3 items-center w-full min-w-[60%]" type="text"
                            placeholder="Of laat je nummer {{ dataSet.techinfo.aandrijving}}">
                        <a class="grey-button">
                            Verstuur
                        </a>
                    </div>
                    <p class="text-xs">Wij proberen dan je zo snel mogelijk contact op te nemen</p>
                </div>
            </div>
        </section>
        <section id="lease" class="flex py-8 md:py-20 lg:py-28 items-start gap-20 bg-blue">
            <div class="w-11/12 px:0 md:px-6 xl:px-0 px-6 max-w-6xl mx-auto">
                <div class="flex flex-col lg:flex-row items-center gap-16 lg:gap-0 justify-between flex-1">
                    <div class="flex flex-col items-start w-full lg:w-7/12 gap-6">
                        <div class="flex flex-col items-start gap-8">
                            <div class="flex flex-col items-start gap-4 text-white">
                                <p>Lease calculator</p>
                                <h1>De beste lease opties voor jou</h1>
                                <p>Bepaal zelf hoeveel maanden jou leaseplan loopt en kies daaruit wat het beste bij je
                                    wensen past</p>
                            </div>
                        </div>
                        <div class="flex h-12 justify-center items-center gap-2 border-2 w-full font-bold bg-white">
                            <p>Let op! Geld lenen kost geld</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="20" viewBox="0 0 27 20"
                                fill="none">
                                <path
                                    d="M22.3303 3.61448C23.1924 3.61448 23.8911 2.91701 23.8911 2.05558C23.8911 1.19403 23.1924 0.497147 22.3303 0.497147C21.4693 0.497147 20.7707 1.19403 20.7707 2.05558C20.7707 2.91701 21.4693 3.61448 22.3303 3.61448ZM26.7233 9.14473C26.6339 8.97148 26.4798 8.82904 26.2822 8.75424L23.4335 7.69886L22.4244 5.19949C22.3738 4.9859 22.2891 4.78371 22.175 4.59858C22.1398 4.53566 22.0986 4.4745 22.0504 4.42392C22.0457 4.4171 22.0409 4.41251 22.0362 4.40463C22.0339 4.4024 22.0339 4.39875 22.0304 4.3964C21.7881 4.09918 21.4623 3.86477 21.0694 3.7408C20.6166 3.59695 20.1532 3.61989 19.7415 3.77526C19.6886 3.78079 19.638 3.7922 19.5851 3.80737L16.2318 4.9018C16.0636 4.95826 15.9237 5.06035 15.8225 5.19126C15.7037 5.31523 15.6179 5.47613 15.5908 5.65985L15.0968 9.15296C15.0298 9.61567 15.3497 10.042 15.8155 10.1095C16.2777 10.1739 16.7047 9.85361 16.7717 9.39055L17.1986 6.36414L18.396 5.97L17.3457 9.00465C17.1234 9.70529 17.2{{ dataSet.techinfo.vermogen_motor_kw }} 10.4289 17.6632 10.9471L17.1739 12.0268L14.277 18.459C14.2558 18.4485 14.2335 18.4416 14.2076 18.4416L13.7419 18.43C13.716 18.3442 13.6842 18.2637 13.6337 18.1957C13.5525 18.0809 13.4172 17.9913 13.2573 17.9936L12.5081 17.9996C12.3469 18.0019 12.214 18.0961 12.1352 18.2109C12.0917 18.2738 12.0599 18.3442 12.0388 18.4199L11.9341 18.4177C11.9317 18.4131 11.9317 18.4095 11.9317 18.4062C11.9106 18.2661 11.8353 18.1236 11.6883 18.0533L11.0167 17.718C10.872 17.6491 10.7132 17.671 10.5874 17.7377C10.5227 17.7744 10.4639 17.8214 10.4109 17.8802L10.3368 17.8388C10.3557 17.7537 10.3627 17.6674 10.3486 17.5847C10.3251 17.4437 10.2498 17.3035 10.1051 17.2323L9.43236 16.8969C9.28887 16.828 9.{{ dataSet.techinfo.vermogen_motor_kw }}93 16.8487 9.0066 16.9176C8.89487 16.9773 8.80194 17.0738 8.72902 17.1933H8.52907C8.50555 17.1{{ dataSet.techinfo.vermogen_motor_kw }} 8.47378 17.0371 8.42791 16.9728C8.34558 16.8564 8.21385 16.7646 8.05625 16.7646H7.30233C7.14355 16.7646 7.01062 16.8564 6.92829 16.9728C6.88477 17.0347 6.85185 17.106 6.82951 17.1818H6.72599C6.72599 17.0807 6.65895 16.9887 6.5578 16.959C6.43195 16.9208 6.30022 16.992 6.26376 17.1184L6.11203 17.6307C6.07557 17.757 6.14733 17.8893 6.27318 17.9247C6.39903 17.9629 6.53076 17.8916 6.56722 17.7653L6.60837 17.6274H6.83419C6.85418 17.6995 6.88712 17.7653 6.92829 17.8227C7.01062 17.9398 7.14355 18.0304 7.30233 18.0304H8.05625C8.21385 18.0304 8.34558 17.9398 8.42791 17.8227C8.46672 17.7684 8.4973 17.7055 8.5173 17.6375H8.62317C8.62552 17.6527 8.6255 17.6665 8.62785 17.6802C8.64902 17.8204 8.7243 17.9614 8.86897 18.0318L9.54174 18.3671C9.68641 18.4384 9.84521 18.4153 9.97224 18.3473C10.0263 18.3167 10.0769 18.2762 10.1228 18.2302L10.2134 18.2808C10.1992 18.3557 10.1969 18.4292 10.2087 18.5004C10.2334 18.6414 10.3098 18.7816 10.4521 18.8528L11.1272 19.1882C11.2695 19.2594 11.4283 19.2364 11.5518 19.1689C11.6742 19.1032 11.773 18.9966 11.8459 18.8619L12.0458 18.8657C12.0693 18.9378 12.1011 19.0034 12.1446 19.0618C12.2281 19.1781 12.3587 19.2685 12.5198 19.2663L13.2726 19.2594C13.429 19.2562 13.5619 19.1643 13.6454 19.0471C13.6795 18.9942 13.7066 18.9378 13.7254 18.8757L14.1665 18.8863C14.1476 19.302 14.3805 19.7074 14.784 19.8879C15.3109 20.1268 15.9331 19.8911 16.1742 19.3627L19.1382 12.7826L20.5896 14.6558L21.1153 19.0747C21.1823 19.649 21.7034 20.0624 22.2797 19.9922C22.8572 19.9255 23.2677 19.4032 23.2018 18.8265L22.6679 14.318C22.6502 14.1779 22.602 13.8311 22.3056 13.4373L20.5613 11.157C20.5731 11.1387 20.6284 11.0078 20.7107 10.8116C21.0377 10.0191 21.7904 8.15004 21.7904 8.15004L21.968 8.58334C22.0139 8.70049 22.0868 8.79929 22.1727 8.88056C22.2597 8.97477 22.3679 9.05287 22.4938 9.10109L23.7782 9.57803L25.3213 10.1522L25.6553 10.2749L25.7071 10.2956C26.1329 10.4532 26.601 10.2382 26.7645 9.81691V9.8155L26.8174 9.5077C26.815 9.38043 26.7809 9.25635 26.7233 9.14473ZM8.10211 17.6375H8.12447C8.09507 17.671 8.07154 17.6789 8.05625 17.6789H7.30233C7.28351 17.6802 7.25409 17.6688 7.22233 17.6274H7.43993C7.53873 17.6274 7.61754 17.5273 7.61754 17.4055C7.61754 17.2815 7.53873 17.1818 7.43993 17.1818H7.21059C7.21294 17.1795 7.21294 17.1781 7.21529 17.1772C7.25176 17.1266 7.28351 17.1161 7.30233 17.1161H8.05625C8.07389 17.1161 8.10682 17.1266 8.14328 17.1772C8.14564 17.1818 8.148 17.1873 8.1527 17.1933H8.10211C8.00331 17.1933 7.92686 17.2929 7.92686 17.4161C7.92686 17.5387 8.00331 17.6375 8.10211 17.6375ZM9.91225 17.5962C9.82757 17.5471 9.7076 17.5939 9.64761 17.7009C9.58763 17.8089 9.60643 17.9339 9.68876 17.9812L9.79228 18.0419C9.74641 18.0625 9.71465 18.0593 9.70054 18.0524L9.02541 17.717C9.0113 17.7088 8.99131 17.6872 8.9772 17.6375H9.09364C9.19126 17.6375 9.27124 17.5387 9.27124 17.4161C9.27124 17.3334 9.23478 17.2622 9.18185 17.224C9.23008 17.2025 9.25711 17.2047 9.27592 17.214L9.94872 17.5479C9.96989 17.5563 9.98988 17.5792 9.99929 17.6399C10.0016 17.6435 9.99929 17.6445 10.0016 17.6467L9.91225 17.5962ZM11.4189 18.4062C11.3225 18.4039 11.2425 18.5013 11.2425 18.6254C11.2378 18.7425 11.306 18.839 11.3977 18.8496C11.3966 18.8505 11.3919 18.8551 11.3895 18.8573C11.3343 18.8863 11.2989 18.8817 11.2813 18.8735L10.6109 18.538C10.5944 18.5312 10.5756 18.5151 10.5662 18.4806C10.6474 18.5151 10.7579 18.4683 10.8144 18.3671C10.8744 18.2615 10.8567 18.1352 10.7709 18.0868L10.732 18.0625C10.7391 18.0579 10.7462 18.0533 10.7556 18.0501C10.8097 18.0212 10.8403 18.0258 10.8579 18.035L11.5318 18.368C11.5448 18.374 11.5589 18.3878 11.5683 18.4094L11.4189 18.4062ZM13.2067 18.8619L13.3373 18.8657C13.3079 18.8978 13.2843 18.907 13.2655 18.907L12.5175 18.9139C12.4963 18.9139 12.474 18.9047 12.441 18.8711C12.5198 18.8505 12.581 18.7623 12.5833 18.6566C12.5857 18.5334 12.5104 18.4338 12.414 18.43C12.4163 18.4232 12.421 18.4177 12.4234 18.4131C12.4598 18.3635 12.4892 18.3519 12.5104 18.3519L13.2608 18.3442C13.282 18.3442 13.3114 18.3533 13.349 18.4025C13.3537 18.4085 13.3572 18.4153 13.362 18.4199L13.2173 18.4177C13.1185 18.4153 13.0385 18.5{{ dataSet.techinfo.vermogen_motor_kw }} 13.0362 18.6368C13.0315 18.7585 13.1114 18.861 13.2067 18.8619Z"
                                    fill="#231F20" />
                                <path d="M6.29235 19.8774H0.530273V14.1151H6.29235V19.8774Z" fill="#ED1C24" />
                                <path
                                    d="M4.52293 16.0105C4.22418 16.0105 4.09481 15.6752 3.67021 15.6752C3.25031 15.6752 3.03154 15.9462 2.90334 16.3207H3.98541C4.13714 16.3207 4.27946 16.3299 4.27946 16.5191C4.27946 16.709 4.14773 16.7351 3.98541 16.7351H2.8269C2.8222 16.7765 2.81748 16.8201 2.81748 16.8615V17.0291H3.75253C3.90426 17.0291 4.04893 17.042 4.04893 17.2291C4.04893 17.4188 3.91837 17.4449 3.75253 17.4449H2.86805C2.98096 17.8654 3.21033 18.1653 3.67963 18.1653C4.05835 18.1653 4.27947 17.8562 4.5594 17.8562C4.75465 17.8562 4.8699 18.017 4.8699 18.203C4.8699 18.713 4.01246 18.8394 3.62903 18.8394C2.71749 18.8394 2.18118 18.3238 2.03063 17.4449H1.9083C1.76{{ dataSet.techinfo.vermogen_motor_kw }} 17.4449 1.61897 17.4234 1.61897 17.2405C1.61897 17.0199 1.82361 17.0291 1.98827 17.0291V16.8821C1.98827 16.8339 1.98828 16.7825 1.99063 16.7351H1.89653C1.74951 16.7351 1.61426 16.7158 1.61426 16.5297C1.61426 16.278 1.87654 16.3207 2.05061 16.3207C2.2388 15.4946 2.79748 14.9722 3.66314 14.9722C4.03834 14.9722 4.87814 15.1248 4.87814 15.6155C4.87814 15.8208 4.73817 16.0105 4.52293 16.0105Z"
                                    fill="white" />
                            </svg>
                        </div>

                    </div>
                    <div class="flex md:p-8 p-5 flex-col items-center w-full lg:w-4/12 gap-8 bg-white rounded-lg">
                        <!--Price-->
                        <p class="font-bold">Bereken jouw maandlasten</p>

                        <div class="flex flex-wrap gap-3">
                            <div class="flex align-items-center">
                                <RadioButton v-model="ingredient" inputId="ingredient1" name="pizza" value="Cheese" />
                                <label for="ingredient1" class="ml-2">Zakelijk</label>
                            </div>
                            <div class="flex align-items-center">
                                <RadioButton v-model="ingredient" inputId="ingredient2" name="pizza" value="Mushroom" />
                                <label for="ingredient2" class="ml-2">Pariculier</label>
                            </div>
                            <div class="flex align-items-center">
                                <RadioButton v-model="ingredient" inputId="ingredient3" name="pizza" value="Pepper" />
                                <label for="ingredient3" class="ml-2">marge</label>
                            </div>
                        </div>
                        <div class="flex px-0 py-2 flex-col gap-4 w-full border-t-[1px] border-b-[1px] border-black">
                            <div class="flex justify-between">
                                <p>Aanschafprijs</p>
                                <p>€{{ dataSet.verkoopprijs_particulier }}</p>
                            </div>
                            <div class="flex justify-between">
                                <p>BTW</p>
                                <p>€{{ dataSet.docu.belasting }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-start gap-5 w-full">
                            <div class="flex flex-col items-start gap-3 w-full">
                                <p>Leasebedrag</p>
                                <input class="rounded-lg w-full h-12 p-3 items-center bg-newwhite" type="select"
                                    name="option" placeholder="€8264">
                            </div>
                            <div class="flex flex-col items-start gap-3 w-full">
                                <p>Looptijd</p>
                                <input class="rounded-lg w-full h-12 p-3 items-center bg-newwhite" type="select"
                                    name="option" placeholder="5 jaar (60 maanden)">
                            </div>
                            <div class="flex flex-col items-start gap-3 w-full">
                                <p>Slottermijn</p>
                                <input class="rounded-lg w-full h-12 p-3 items-center bg-newwhite" type="select"
                                    name="option" placeholder="1653">
                            </div>
                            <div class="w-full ">
                                <Button class="bg-orange w-full py-3 rounded-lg text-white" label="Vraag offerte aan"
                                    severity="warning" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <faq />
        <subfooter />
        <!--        <Slider />-->
    </main>
</template>
