<script setup>
//primevue imports
import Dropdown from "primevue/dropdown";
import Slider from "primevue/slider";
import ToggleButton from "primevue/togglebutton";
import InputText from "primevue/inputtext";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import Button from "primevue/button";
import InputSwitch from "primevue/inputswitch";
import MultiSelect from "primevue/multiselect";
import "primeicons/primeicons.css";
import Model from "./components/Model.vue";

//vue imports
import { Head } from "@inertiajs/vue3";
import {
    ref,
    watch,
    defineProps,
    computed,
    onMounted,
    onBeforeUnmount,
} from "vue";

//andere imports
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";

import axios from "axios";

const props = defineProps({ posts: Array });
const customPosts = ref(props.posts);

//put the input from filters in the url
const filterData = async () => {
    try {
        const baseUrl = new URL("http://mtf-website-vue.test/aanbod");
        let decodedUrl = decodeURI(window.location.search);
        let currentParams = new URLSearchParams(decodedUrl);

        const params = new URLSearchParams(currentParams);
        //handle all inputs
        const filterMerk = selectedMerk.value.map((option) => option.value);
        const filterModel = selectedModel.value.map((option) => option.value);
        const filterCarrosseries = carrosserieOptions.value
            .filter((option) => option.value === true)
            .map((option) => option.name);
        const filterBrandstof = brandstofOptions.value
            .filter((option) => option.value === true)
            .map((option) => option.name);
        const filterTransmissies = transmissieOptions.value
            .filter((option) => option.value === true)
            .map((option) => option.name);
        const filterPrice = price.value;
        const filterAge = age.value;
        const filterMileage = mileage.value;
        const direction = selectedSort.value === "asc" ? "asc" : "desc";

        params.forEach((value, key) => {
            params.delete(key);
        });
        //append params to url
        filterMerk.forEach((value) => params.append("merk", value));
        filterModel.forEach((value) => params.append("model", value));
        filterCarrosseries.forEach((value) =>
            params.append("carrosserie", value)
        );
        filterBrandstof.forEach((value) => params.append("brandstof", value));

        if (filterPrice && filterPrice.length === 2) {
            params.set("price_from", filterPrice[0].toString());
            params.set("price_to", filterPrice[1].toString());
        } else {
            params.delete("price_from");
            params.delete("price_to");
        }

        if (filterAge && filterAge.length === 2) {
            params.set("age_from", filterAge[0]);
            params.set("age_to", filterAge[1]);
        } else {
            params.delete("age_from");
            params.delete("age_to");
        }

        if (filterMileage && filterMileage.length === 2) {
            params.set("mileage_from", filterMileage[0]);
            params.set("mileage_to", filterMileage[1]);
        } else {
            params.delete("mileage_from");
            params.delete("mileage_to");
        }

        filterTransmissies.forEach((value) =>
            params.append("transmissie", value)
        );

        params.append("orderByColumn", "price");
        params.append("orderByDirection", direction);

        if (newChecked.value !== null && newChecked.value !== 0) {
            params.append("nieuw_voertuig", boolToNumber(newChecked.value));
        }

        if (
            discountedChecked.value !== null &&
            discountedChecked.value !== false
        ) {
            params.append("discounted", discountedChecked.value);
        }
        if (selectedSearch.value !== null && selectedSearch.value !== "") {
            params.set("search", selectedSearch.value);
        } else {
            params.delete("search");
        }

        const searchParamsString = params.toString();

        window.history.pushState(
            {},
            null,
            `${baseUrl.pathname}?${searchParamsString}`
        );
        getUrlData();
    } catch (error) {
        console.error("Error fetching filtered posts:", error);
    }
};

//get the parameters from the url and put them in a get request
const getUrlData = async () => {
    try {
        let currentUrl = window.location.href;
        let urlDecoded = decodeURIComponent(currentUrl);
        let searchparams = new URLSearchParams(urlDecoded.split("?")[1]);

        const merkArray = [];
        searchparams.forEach((value, key) => {
            if (key.startsWith("merk")) {
                merkArray.push(value);
            }
        });

        selectedMerk.value = merkArray.map((merk) => {
            return { name: merk, value: merk };
        });

        const modelArray = [];
        searchparams.forEach((value, key) => {
            if (key.startsWith("model")) {
                modelArray.push(value);
            }
        });

        if (selectedMerk.value.length === 0) {
            isDisabled.value = true;
        } else {
            isDisabled.value = false;
        }

        selectedModel.value = modelArray.map((model) => {
            return { name: model, value: model };
        });

        const carrosserieArray = [];
        searchparams.forEach((value, key) => {
            if (key.startsWith("carrosserie")) {
                carrosserieArray.push(value);
            }
        });

        carrosserieOptions.value.forEach((option) => {
            option.value = carrosserieArray.includes(option.name);
        });

        const typeArray = [];
        searchparams.forEach((value, key) => {
            if (key.startsWith("type")) {
                typeArray.push(value);
            }
        });

        const brandstofArray = [];
        searchparams.forEach((value, key) => {
            if (key.startsWith("brandstof")) {
                brandstofArray.push(value);
            }
        });

        brandstofOptions.value.forEach((option) => {
            option.value = brandstofArray.includes(option.name);
        });
        const transmissieArray = [];
        searchparams.forEach((value, key) => {
            if (key.startsWith("transmissie")) {
                transmissieArray.push(value);
            }
        });

        transmissieOptions.value.forEach((option) => {
            option.value = transmissieArray.includes(option.name);
        });
        const accessoiresArray = [];
        searchparams.forEach((value, key) => {
            if (key.startsWith("accessoires")) {
                accessoiresArray.push(value);
            }
        });

        const basiskleurArray = [];
        searchparams.forEach((value, key) => {
            if (key.startsWith("basiskleur")) {
                basiskleurArray.push(value);
            }
        });
        const laksoortArray = [];
        searchparams.forEach((value, key) => {
            if (key.startsWith("laksoort")) {
                laksoortArray.push(value);
            }
        });
        const interieurKleurArray = [];
        searchparams.forEach((value, key) => {
            if (key.startsWith("interieurkleur")) {
                interieurKleurArray.push(value);
            }
        });
        const BekledingArray = [];
        searchparams.forEach((value, key) => {
            if (key.startsWith("bekleding")) {
                BekledingArray.push(value);
            }
        });

        let priceFrom = searchparams.get("price_from");
        let priceTo = searchparams.get("price_to");

        let ageFrom = searchparams.get("age_from");
        let ageTo = searchparams.get("age_to");

        let mileageFrom = searchparams.get("mileage_from");
        let mileageTo = searchparams.get("mileage_to");

        const searchArray = searchparams.get("search");

        const direction = searchparams.get("orderByDirection");
        const newCheckedValue = searchparams.get("nieuw_voertuig");
        const discountedCheckedValue = searchparams.get("discounted");

        const getparams = {
            merk: merkArray,
            model: modelArray,
            type: typeArray,
            carrosserie: carrosserieArray,
            brandstof: brandstofArray,
            transmissie: transmissieArray,
            accessoires: accessoiresArray,
            basiskleur: basiskleurArray,
            laksoort: laksoortArray,
            interieurkleur: interieurKleurArray,
            bekleding: BekledingArray,
            price_from: priceFrom,
            price_to: priceTo,
            age_from: ageFrom,
            age_to: ageTo,
            mileage_from: mileageFrom,
            mileage_to: mileageTo,
            orderByDirection: direction,
            nieuw_voertuig: newCheckedValue,
            actieprijs: discountedCheckedValue,
        };

        if (searchArray) {
            getparams.search = searchArray;
        }

        const queryString = Object.keys(getparams)
            .map((key) => {
                if (Array.isArray(getparams[key])) {
                    return getparams[key]
                        .map((val) => `${key}[]=${encodeURIComponent(val)}`)
                        .join("&");
                }
                return `${key}=${encodeURIComponent(getparams[key])}`;
            })
            .join("&");

        const response = await axios.get("/aanbodapi", {
            params: getparams,
        });
        customPosts.value = response.data;

        console.log("filter", customPosts.value);
    } catch (error) {
        console.error("Error fetching filtered posts:", error);
    }
};
//clear params and refresh page
function clearParams() {
    const baseUrl = window.location.origin + window.location.pathname;
    window.history.replaceState({}, document.title, baseUrl);
    window.location.reload();
    return baseUrl;
}

//get filter oprions based on data in database
const getOptions = async () => {
    try {
        const response = await axios.get("/aanbodapi");
        const data = response.data;

        const uniqueMerks = [
            ...new Set(data.posts.map((post) => post.carinfo.merk)),
        ];
        merkOptions.value = uniqueMerks.map((merk) => ({
            name: merk,
            value: merk,
        }));

        const uniqueModels = [
            ...new Set(
                data.posts
                    .filter((post) => selectedMerk.value)
                    .map((post) => post.carinfo.model)
            ),
        ];

        modelOptions.value = uniqueModels.map((model) => ({
            name: model,
            value: model,
        }));

        const uniquecarrosseries = [
            ...new Set(data.posts.map((post) => post.carinfo.carrosserie)),
        ];
        carrosserieOptions.value = uniquecarrosseries.map((C) => {
            return {
                name: C,
                value: C,
                onLabel: C,
                offLabel: C,
            };
        });

        const uniqueBrandstof = [
            ...new Set(data.posts.map((post) => post.techinfo.brandstof)),
        ];
        brandstofOptions.value = uniqueBrandstof.map((B) => {
            return {
                name: B,
                value: B,
                onLabel: B,
                offLabel: B,
            };
        });
        const uniquetTransmissies = [
            ...new Set(data.posts.map((post) => post.techinfo.transmissie)),
        ];
        transmissieOptions.value = uniquetTransmissies.map((T) => {
            return {
                name: T,
                value: T,
                onLabel: T,
                offLabel: T,
            };
        });
    } catch (error) {
        console.error("Error fetching merk options:", error);
    }
};
//get the lowest and highest value for these inputs from the database
const getSliders = async () => {
    let pricesMinMax = customPosts.value.map(
        (post) => post.verkoopprijs_particulier
    );
    minPrice.value = Math.min(...pricesMinMax);
    maxPrice.value = Math.max(...pricesMinMax);
    price.value = [minPrice.value, maxPrice.value];

    let agesMinMax = customPosts.value.map((post) => post.condition.bouwjaar);
    minAge.value = Math.min(...agesMinMax);
    maxAge.value = Math.max(...agesMinMax);
    age.value = [minAge.value, maxAge.value];

    let mileagesMinMax = customPosts.value.map(
        (post) => post.condition.tellerstand
    );
    minMileage.value = Math.min(...mileagesMinMax);
    maxMileage.value = Math.max(...mileagesMinMax);
    mileage.value = [minMileage.value, maxMileage.value];
};

//variables
const selectedSearch = ref([]);

const selectedMerk = ref();
const merkOptions = ref([]);

const selectedModel = ref([]);
const modelOptions = ref([]);

const carrosserieOptions = ref([]);

const brandstofOptions = ref([]);

const sidebarOpen = ref(false);
const transmissieOptions = ref([]);

const price = ref([0, 0]);
const minPrice = ref(0);
const maxPrice = ref(0);

const age = ref([0, 0]);
const minAge = ref(0);
const maxAge = ref(0);

const mileage = ref([0, 0]);
const minMileage = ref(0);
const maxMileage = ref(0);

const newChecked = ref(0);
function boolToNumber(boolValue) {
    return boolValue ? 1 : 0;
}

const discountedChecked = ref(false);

//sorteer pagina
const sortOptions = ref([
    { label: "Prijs laag naar hoog", value: "asc" },
    { label: "prijs van hoog naar laag", value: "desc" },
]);

const selectedSort = ref(null);

//navbar bounce
const showNavbar = ref(true);
const lastScrollPosition = ref(0);

const isDisabled = ref(true);

const onScroll = () => {
    // Get the current scroll position
    const currentScrollPosition =
        window.pageYOffset || document.documentElement.scrollTop;
    // Because of momentum scrolling on mobiles, we shouldn't continue if it is less than zero
    if (currentScrollPosition < 0) {
        return;
    }
    // Here we determine whether we need to show or hide the navbar
    showNavbar.value = currentScrollPosition < lastScrollPosition.value;
    // Set the current scroll position as the last scroll position
    lastScrollPosition.value = currentScrollPosition;
};

onMounted(() => {
    window.addEventListener("scroll", onScroll);
});

onBeforeUnmount(() => {
    window.removeEventListener("scroll", onScroll);
});

onMounted(async () => {
    await getSliders();
    await getUrlData();
    await getOptions();
});
</script>

<template>
    <Head>
        <title>Aanbod</title>
        <meta
            name="description"
            content="Bekijk en filter ons uitgebreide aanbod van nieuwe en gebruikte auto's bij [Naam Auto Dealer]. Vind de perfecte auto die aan al jouw wensen voldoet. Start je zoektocht vandaag nog!"
        />
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
    <main class="flex justify-center">
        <div class="w-11/12 px:0 md:px-6 xl:px-0 max-w-6xl space-y-5 mt-20">
            <!--filters top-->
            <div
                class="flex md:hidden flex-col sm:flex-row gap-2 justify-between"
            >
                <TransitionRoot as="template" :show="sidebarOpen">
                    <Dialog
                        as="div"
                        class="lg:hidden"
                        @close="sidebarOpen = false"
                    >
                        <TransitionChild
                            as="template"
                            enter="transition-opacity ease-linear duration-300"
                            enter-from="opacity-0"
                            enter-to="opacity-100"
                            leave="transition-opacity ease-linear duration-300"
                            leave-from="opacity-100"
                            leave-to="opacity-0"
                        >
                            <div class="fixed inset-0 bg-gray-900/80" />
                        </TransitionChild>

                        <div class="fixed inset-0 z-20">
                            <TransitionChild
                                as="template"
                                enter="transition ease-in-out duration-300 transform"
                                enter-from="-translate-y-full"
                                enter-to="translate-y-0"
                                leave="transition ease-in-out duration-300 transform"
                                leave-from="translate-y-0"
                                leave-to="-translate-y-full"
                            >
                                <DialogPanel class="w-full">
                                    <TransitionChild
                                        as="template"
                                        enter="ease-in-out duration-300"
                                        enter-from="opacity-0"
                                        enter-to="opacity-100"
                                        leave="ease-in-out duration-300"
                                        leave-from="opacity-100"
                                        leave-to="opacity-0"
                                    >
                                        <div class=""></div>
                                    </TransitionChild>

                                    <!-- Sidebar component, swap this element with another sidebar if you like -->

                                    <div class="relative bg-white h-dvh">
                                        <section
                                            id="pricesticky"
                                            class="absolute bottom-0 w-full z-20"
                                        >
                                            <div
                                                class="flex flex-col gap-6 w-11/12 mx-auto pb-4"
                                            >
                                                <Button
                                                    class="bg-orange p-3 w-full text-white"
                                                    label="Close"
                                                    @click="
                                                        sidebarOpen =
                                                            !sidebarOpen
                                                    "
                                                />
                                            </div>
                                        </section>
                                        <div
                                            class="h-dvh fixed w-full md:block py-20 overflow-visible"
                                        >
                                            <div
                                                class="relative h-full overflow-y-auto w-11/12 mx-auto pt-2 overflow-visible"
                                            >
                                                <div
                                                    class="flex justify-between items-center"
                                                >
                                                    <h6>Filters</h6>
                                                    <button
                                                        @click="clearParams"
                                                        class="text-base"
                                                    >
                                                        Verwijder alles
                                                    </button>
                                                </div>
                                                <br />

                                                <div
                                                    class="flex flex-col border-t pt-3 pb-3 gap-2"
                                                >
                                                    <p class="font-bold">
                                                        Merk en model
                                                    </p>
                                                    <div
                                                        class="card flex justify-content-center"
                                                    >
                                                        <MultiSelect
                                                            v-model="
                                                                selectedMerk
                                                            "
                                                            :options="
                                                                merkOptions
                                                            "
                                                            @change="filterData"
                                                            optionLabel="name"
                                                            placeholder="selecteer een"
                                                            :maxSelectedLabels="
                                                                3
                                                            "
                                                            class="w-full md:w-20rem"
                                                        />
                                                    </div>
                                                    <div
                                                        class="card flex justify-content-center"
                                                    >
                                                        <MultiSelect
                                                            v-model="
                                                                selectedModel
                                                            "
                                                            @change="filterData"
                                                            filter
                                                            optionLabel="name"
                                                            :options="
                                                                modelOptions
                                                            "
                                                            placeholder="Selecteer een model"
                                                            :filterPlaceholder="'zoeken'"
                                                            :emptyFilterMessage="'Geen resultaten gevonden'"
                                                            :filterfocus="'border-grey'"
                                                            class="w-full md:w-14rem border border-grey"
                                                        >
                                                        </MultiSelect>
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-col border-t pt-4 pb-3 w-full"
                                                >
                                                    <p class="font-bold">
                                                        Carrosserie
                                                    </p>
                                                    <div>
                                                        <ToggleButton
                                                            v-for="(
                                                                carrossiereOption,
                                                                index
                                                            ) in carrosserieOptions"
                                                            :key="index"
                                                            @change="filterData"
                                                            v-model="
                                                                carrossiereOption.value
                                                            "
                                                            :onLabel="
                                                                carrossiereOption.onLabel
                                                            "
                                                            :offLabel="
                                                                carrossiereOption.offLabel
                                                            "
                                                            class="border rounded-lg mx-1 my-1.5"
                                                        >
                                                            {{
                                                                carrossiereOption.label
                                                            }}
                                                        </ToggleButton>
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-col border-t pt-4 pb-3 w-full"
                                                >
                                                    <p class="font-bold">
                                                        Brandstof
                                                    </p>
                                                    <div>
                                                        <ToggleButton
                                                            v-for="(
                                                                brandstofOption,
                                                                index
                                                            ) in brandstofOptions"
                                                            :key="index"
                                                            @change="filterData"
                                                            v-model="
                                                                brandstofOption.value
                                                            "
                                                            :onLabel="
                                                                brandstofOption.onLabel
                                                            "
                                                            :offLabel="
                                                                brandstofOption.offLabel
                                                            "
                                                            class="border rounded-lg mx-1 my-1.5"
                                                        >
                                                            {{
                                                                brandstofOption.label
                                                            }}
                                                        </ToggleButton>
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-col border-t pt-3 pb-3 w-full gap-2"
                                                >
                                                    <p class="font-bold">
                                                        Prijs
                                                    </p>
                                                    <div class="w-full">
                                                        <div class="flex gap-4">
                                                            <InputText
                                                                v-model.number="
                                                                    price[0]
                                                                "
                                                                class="w-full mb-3 border"
                                                            />
                                                            <InputText
                                                                v-model.number="
                                                                    price[1]
                                                                "
                                                                class="w-full mb-3 border"
                                                            />
                                                        </div>
                                                        <Slider
                                                            v-model="price"
                                                            range
                                                            @change="filterData"
                                                            class="w-11/12 mx-auto"
                                                            :min="price[0]"
                                                            :max="price[1]"
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-col border-t pt-3 pb-3 w-full gap-2"
                                                >
                                                    <p class="font-bold">
                                                        Bouwjaar
                                                    </p>
                                                    <div class="w-full">
                                                        <div class="flex gap-4">
                                                            <InputText
                                                                v-model.number="
                                                                    age[0]
                                                                "
                                                                class="w-full mb-3 border"
                                                            />
                                                            <InputText
                                                                v-model.number="
                                                                    age[1]
                                                                "
                                                                class="w-full mb-3 border"
                                                            />
                                                        </div>
                                                        <Slider
                                                            :step="1"
                                                            v-model="age"
                                                            range
                                                            class="w-11/12 mx-auto"
                                                            :min="1990"
                                                            :max="2024"
                                                            @change="filterData"
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-col border-t pt-3 pb-3 w-full gap-2"
                                                >
                                                    <p class="font-bold">
                                                        Kilometerstand
                                                    </p>
                                                    <div class="w-full">
                                                        <div class="flex gap-4">
                                                            <InputText
                                                                v-model.number="
                                                                    mileage[0]
                                                                "
                                                                class="w-full mb-3 border"
                                                            />
                                                            <InputText
                                                                v-model.number="
                                                                    mileage[1]
                                                                "
                                                                class="w-full mb-3 border"
                                                            />
                                                        </div>
                                                        <Slider
                                                            :step="1000"
                                                            v-model="mileage"
                                                            range
                                                            @change="filterData"
                                                            class="w-11/12 mx-auto"
                                                            :min="0"
                                                            :max="100000"
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-col border-t pt-4 pb-3 w-full"
                                                >
                                                    <p class="font-bold">
                                                        Transmissie
                                                    </p>
                                                    <div>
                                                        <ToggleButton
                                                            v-for="(
                                                                transmissieOption,
                                                                index
                                                            ) in transmissieOptions"
                                                            :key="index"
                                                            @change="filterData"
                                                            v-model="
                                                                transmissieOption.value
                                                            "
                                                            :onLabel="
                                                                transmissieOption.onLabel
                                                            "
                                                            :offLabel="
                                                                transmissieOption.offLabel
                                                            "
                                                            class="border rounded-lg mx-1 my-1.5"
                                                        >
                                                            {{
                                                                transmissieOption.label
                                                            }}
                                                        </ToggleButton>
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex flex-col border-t pt-4 pb-3 w-full"
                                                >
                                                    <p class="font-bold">
                                                        Nieuw
                                                    </p>
                                                    <InputSwitch
                                                        v-model="newChecked"
                                                        @change="filterData"
                                                    />
                                                </div>
                                                <div
                                                    class="flex flex-col border-t pt-4 pb-3 w-full"
                                                >
                                                    <p class="font-bold">
                                                        Actie
                                                    </p>
                                                    <InputSwitch
                                                        v-model="
                                                            discountedChecked
                                                        "
                                                        @change="filterData"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </Dialog>
                </TransitionRoot>

                <!-- Static sidebar for desktop -->
                <header>
                    <div class="flex w-full">
                        <div class="flex w-full flex-col">
                            <div class="flex flex-row w-full gap-4">
                                <IconField class="w-10/12" iconPosition="left">
                                    <InputIcon class="pi pi-search">
                                    </InputIcon>
                                    <InputText
                                        class="px-8"
                                        v-model="selectedSearch"
                                        placeholder="zoeken"
                                    />
                                </IconField>

                                <button
                                    type="button"
                                    class="bg-transparent text-gray-700 lg:hidden"
                                    @click="sidebarOpen = !sidebarOpen"
                                >
                                    <div class="flex flex-row gap-3">
                                        <div
                                            class="bg-orange rounded-lg w-12 h-12 flex items-center justify-center"
                                        >
                                            <p v-if="!sidebarOpen">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                >
                                                    <path
                                                        d="M7 11H17V13H7V11ZM4 7H20V9H4V7ZM10 15H14V17H10V15Z"
                                                        fill="white"
                                                    />
                                                </svg>
                                            </p>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <div class="w-full flex justify-end pt-2">
                                <Dropdown
                                    class="flex border w-full"
                                    v-model="selectedSort"
                                    :options="sortOptions"
                                    optionLabel="label"
                                    optionValue="value"
                                    placeholder="Sorteer op"
                                    @change="filterData"
                                />
                            </div>
                        </div>
                    </div>
                </header>
            </div>
            <div class="flex flex-row gap-5 min-h-[90rem]">
                <!--filters side bar-->
                <div class="h-screen w-2/5 min-w-52 top-24 hidden md:block">
                    <div class="relative h-screen">
                        <div class="flex justify-between items-center">
                            <h6>Filters</h6>

                            <button @click="clearParams" class="text-base">
                                Verwijder alles
                            </button>
                        </div>
                        <br />
                        <div class="flex flex-col border-t pt-3 pb-3">
                            <IconField class="w-full" iconPosition="right">
                                <InputIcon class="pi pi-search"></InputIcon>
                                <InputText
                                    v-model="selectedSearch"
                                    @input="filterData"
                                    placeholder="Zoekterm"
                                />
                            </IconField>
                        </div>
                        <div class="flex flex-col border-t pt-3 pb-3 gap-2">
                            <p class="font-bold">Merk en model</p>
                            <div class="card flex justify-content-center">
                                <MultiSelect
                                    v-model="selectedMerk"
                                    @change="filterData"
                                    filter
                                    optionLabel="name"
                                    :options="merkOptions"
                                    placeholder="Selecteer een merk"
                                    :filterPlaceholder="'zoeken'"
                                    :emptyFilterMessage="'Geen resultaten gevonden'"
                                    :filterfocus="'border-grey'"
                                    class="w-full md:w-14rem border border-grey"
                                >
                                </MultiSelect>
                            </div>
                            <div class="card flex justify-content-center">
                                <MultiSelect
                                    v-model="selectedModel"
                                    filter
                                    @change="filterData"
                                    optionLabel="name"
                                    :options="modelOptions"
                                    placeholder="Selecteer een model"
                                    :filterPlaceholder="'zoeken'"
                                    :emptyFilterMessage="'Geen resultaten gevonden'"
                                    :filterfocus="'border-grey'"
                                    :disabled="isDisabled"
                                    class="w-full md:w-14rem border border-grey"
                                >
                                </MultiSelect>
                            </div>
                        </div>
                        <div class="flex flex-col border-t pt-4 pb-3 w-full">
                            <p class="font-bold">Carrosserie</p>
                            <div>
                                <ToggleButton
                                    v-for="(
                                        carrossiereOption, index
                                    ) in carrosserieOptions"
                                    :key="index"
                                    @change="filterData"
                                    v-model="carrossiereOption.value"
                                    :onLabel="carrossiereOption.onLabel"
                                    :offLabel="carrossiereOption.offLabel"
                                    class="border rounded-lg mx-1 my-1.5"
                                >
                                    {{ carrossiereOption.label }}
                                </ToggleButton>
                            </div>
                        </div>
                        <div class="flex flex-col border-t pt-4 pb-3 w-full">
                            <p class="font-bold">Brandstof</p>
                            <div>
                                <ToggleButton
                                    v-for="(
                                        brandstofOption, index
                                    ) in brandstofOptions"
                                    :key="index"
                                    @change="filterData"
                                    v-model="brandstofOption.value"
                                    :onLabel="brandstofOption.onLabel"
                                    :offLabel="brandstofOption.offLabel"
                                    class="border rounded-lg mx-1 my-1.5"
                                >
                                    {{ brandstofOption.label }}
                                </ToggleButton>
                            </div>
                        </div>
                        <div
                            class="flex flex-col border-t pt-3 pb-3 w-full gap-2"
                        >
                            <p class="font-bold">Prijs</p>
                            <div class="w-full">
                                <div class="flex gap-4">
                                    <InputText
                                        v-model.number="price[0]"
                                        @change="filterData"
                                        class="w-full mb-3 border"
                                    />
                                    <InputText
                                        v-model.number="price[1]"
                                        @change="filterData"
                                        class="w-full mb-3 border"
                                    />
                                </div>
                                <Slider
                                    v-model="price"
                                    :step="100"
                                    :min="minPrice"
                                    :max="maxPrice"
                                    @change="filterData"
                                    range
                                    class="w-14rem"
                                />
                            </div>
                        </div>
                        <div
                            class="flex flex-col border-t pt-3 pb-3 w-full gap-2"
                        >
                            <p class="font-bold">Bouwjaar</p>
                            <div class="w-full">
                                <div class="flex gap-4">
                                    <InputText
                                        v-model.number="age[0]"
                                        @change="filterData"
                                        class="w-full mb-3 border"
                                    />
                                    <InputText
                                        v-model.number="age[1]"
                                        @change="filterData"
                                        class="w-full mb-3 border"
                                    />
                                </div>
                                <Slider
                                    :step="1"
                                    v-model="age"
                                    @change="filterData"
                                    range
                                    class="w-11/12 mx-auto"
                                    :min="minAge"
                                    :max="maxAge"
                                />
                            </div>
                        </div>
                        <div
                            class="flex flex-col border-t pt-3 pb-3 w-full gap-2"
                        >
                            <p class="font-bold">Kilometerstand</p>
                            <div class="w-full">
                                <div class="flex gap-4">
                                    <InputText
                                        v-model.number="mileage[0]"
                                        @change="filterData"
                                        class="w-full mb-3 border"
                                    />
                                    <InputText
                                        v-model.number="mileage[1]"
                                        @change="filterData"
                                        class="w-full mb-3 border"
                                    />
                                </div>
                                <Slider
                                    :step="1000"
                                    v-model="mileage"
                                    @change="filterData"
                                    range
                                    class="w-11/12 mx-auto"
                                    :min="minMileage"
                                    :max="maxMileage"
                                />
                            </div>
                        </div>
                        <div class="flex flex-col border-t pt-4 pb-3 w-full">
                            <p class="font-bold">Transmissie</p>
                            <div>
                                <ToggleButton
                                    v-for="(
                                        transmissieOption, index
                                    ) in transmissieOptions"
                                    :key="index"
                                    v-model="transmissieOption.value"
                                    @change="filterData"
                                    :onLabel="transmissieOption.onLabel"
                                    :offLabel="transmissieOption.offLabel"
                                    class="border rounded-lg mx-1 my-1.5"
                                >
                                    {{ transmissieOption.label }}
                                </ToggleButton>
                            </div>
                        </div>
                        <div class="flex flex-col border-t pt-4 pb-3 w-full">
                            <p class="font-bold">Nieuw</p>
                            <InputSwitch
                                v-model="newChecked"
                                @change="filterData"
                            />
                        </div>
                        <div class="flex flex-col border-t pt-4 pb-3 w-full">
                            <p class="font-bold">Actie</p>
                            <InputSwitch
                                v-model="discountedChecked"
                                @change="filterData"
                            />
                        </div>
                    </div>
                </div>
                <!--loading models-->
                <div class="w-full flex flex-col gap-4">
                    <div class="hidden lg:flex w-full justify-end">
                        <div class="w-2/5 border rounded-lg">
                            <Dropdown
                                class="flex"
                                v-model="selectedSort"
                                :options="sortOptions"
                                optionLabel="label"
                                optionValue="value"
                                placeholder="Sorteer op"
                                @change="filterData"
                            />
                        </div>
                    </div>
                    <!--stuur data naar model-->
                    <Model
                        :customPosts="customPosts"
                        :xlColumn="3"
                        :mdColumn="2"
                    />
                </div>
            </div>
        </div>
    </main>
</template>
<style>
.navbar {
    transition: 0.5s all ease-out;
}

.navbar.navbar--hidden {
    transform: translate3d(0, -20%, 0);
}
</style>
