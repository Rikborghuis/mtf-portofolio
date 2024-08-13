<script setup>
//vue imports
import { ref, reactive, defineProps, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";

//component en include imports
import Subfooter from "./Includes/Subfooter.vue";
import Slider from "./components/Slider.vue";

//primevue imports
import FaqNieuwsbrief from "./components/FaqNieuwsbrief.vue";
import Model from "./components/Model.vue";
import Button from "primevue/button";
import MultiSelect from "primevue/multiselect";
import InputNumber from "primevue/inputnumber";

//extra imports
import axios from "axios";

const props = defineProps({ posts: Array });
const customPosts = ref(props.posts);
console.log("tf", customPosts.value);

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
            ...new Set(data.posts.map((post) => post.carinfo.model)),
        ];
        modelOptions.value = uniqueModels.map((model) => ({
            name: model,
            value: model,
        }));

        const uniqueVariants = [
            ...new Set(data.posts.map((post) => post.carinfo.type)),
        ];
        variantOptions.value = uniqueVariants.map((type) => ({
            name: type,
            value: type,
        }));

        const uniqueCarrosseries = [
            ...new Set(data.posts.map((post) => post.carinfo.carrosserie)),
        ];
        carrosserieOptions.value = uniqueCarrosseries.map((carrosserie) => {
            return {
                name: carrosserie,
                value: carrosserie,
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
        const uniquetransmissies = [
            ...new Set(data.posts.map((post) => post.techinfo.transmissie)),
        ];
        transmissieOptions.value = uniquetransmissies.map((T) => {
            return {
                name: T,
                value: T,
                onLabel: T,
                offLabel: T,
            };
        });

        const uniqueAccessoires = [
            ...new Set(
                data.posts.flatMap((post) =>
                    post.carinfo.accessoires
                        .split(", ")
                        .map((accessoires) => accessoires.trim())
                )
            ),
        ];

        accessoiresOptions.value = uniqueAccessoires.map((A) => {
            return {
                name: A,
                value: A,
            };
        });

        const uniqueExteriorColors = [
            ...new Set(data.posts.map((post) => post.looks.basiskleur)),
        ];
        exteriorColorOptions.value = uniqueExteriorColors.map((excol) => {
            return {
                name: excol,
                value: excol,
            };
        });

        const uniqueExteriorMaterials = [
            ...new Set(data.posts.map((post) => post.looks.laksoort)),
        ];
        exteriorMaterialsOptions.value = uniqueExteriorMaterials.map(
            (exmat) => {
                return {
                    name: exmat,
                    value: exmat,
                };
            }
        );

        const uniqueInterieurKleur = [
            ...new Set(data.posts.map((post) => post.looks.interieurkleur)),
        ];
        interieurKleurOptions.value = uniqueInterieurKleur.map((incol) => {
            return {
                name: incol,
                value: incol,
            };
        });

        const uniqueBekleding = [
            ...new Set(data.posts.map((post) => post.looks.bekleding)),
        ];
        BekledingOptions.value = uniqueBekleding.map((inmat) => {
            return {
                name: inmat,
                value: inmat,
            };
        });

        const pricesMinMax = [
            ...new Set(data.posts.map((post) => post.verkoopprijs_particulier)),
        ];
        price.value[0] = Math.min(...pricesMinMax);
        price.value[1] = Math.max(...pricesMinMax);

        const agesMinMax = [
            ...new Set(data.posts.map((post) => post.condition.bouwjaar)),
        ];
        age.value[0] = Math.min(...agesMinMax);
        age.value[1] = Math.max(...agesMinMax);

        const mileagesMinMax = [
            ...new Set(data.posts.map((post) => post.condition.tellerstand)),
        ];
        mileage.value[0] = Math.min(...mileagesMinMax);
        mileage.value[1] = Math.max(...mileagesMinMax);
    } catch (error) {
        console.error("Error fetching merk options:", error);
    }
};

const merkOptions = ref([]);

const modelOptions = ref([]);

const transmissieOptions = ref([]);

const brandstofOptions = ref([]);

const price = ref([0, 50000]);

const age = ref([1990, 2024]);

const mileage = ref([0, 1000000]);
const carrosserieOptions = ref([]);

const variantOptions = ref([]);

const selectedAccessoires = ref([]);
const accessoiresOptions = ref([]);
const selectedExteriorColor = ref([]);
const exteriorColorOptions = ref([]);

const selectedExteriorMaterial = ref([]);
const exteriorMaterialsOptions = ref([]);

const selectedInterieurKleur = ref([]);
const interieurKleurOptions = ref([]);

const selectedBekleding = ref([]);
const BekledingOptions = ref([]);

const values = reactive({
    merk: [],
    model: [],
    transmissie: [],
    brandstof: [],
    carrosserie: [],
    type: [],
    verkoopprijs_particulier: price,
    bouwjaar: age,
    tellerstand: mileage,
    accessoires: selectedAccessoires,
    basiskleur: selectedExteriorColor,
    laksoort: selectedExteriorMaterial,
    interieurkleur: selectedInterieurKleur,
    bekleding: selectedBekleding,
});

function submit() {
    router.post("/zoeken", values);
    console.log("uitgebreid zoeken filter lolxd ", values);
    console;
}

onMounted(async () => {
    await getOptions();
});
</script>
<template>
    <Head>
        <title>Home</title>
        <meta
            name="description"
            content="Welkom op de website van MTF-automobielen! Bekijk ons aanbod en kom vandaag vandaag nog langs! "
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
        <meta name="msapplication-TileColor" content="#da532c" />
        <meta name="theme-color" content="#ffffff" />
    </Head>

    <section class="flex flex-col bg-blue -space-y-56">
        <!--hero-->
        <div
            id="hero"
            class="z-20 h-full bg-gradient-to-b from-blue/5 to-blue text-white relative"
        >
            <div class="h-screen flex flex-col max-h-[1200px]">
                <video
                    :src="'/videos/autovid.mov'"
                    autoplay="{true}"
                    loop
                    muted
                    class="opacity-75 absolute z-10 w-full h-full aspect-video object-cover"
                ></video>
                <div
                    class="z-20 flex justify-center h-screen w-screen min-h-96"
                >
                    <div class="w-11/12 px:0 md:px-6 xl:px-0 h-5/6 max-w-6xl">
                        <div class="flex flex-col gap-10 h-full justify-center">
                            <h1 class="w-full md:w-9/12 xl:w-7/12">
                                Vind jouw perfecte auto
                            </h1>
                            <p
                                class="hidden sm:block w-full md:w-9/12 xl:w-7/12"
                            >
                                Ontdek onze brede selectie van de nieuwste en
                                meest populaire voertuigen. Of je nu op zoek
                                bent naar een strakke sedan, een ruime SUV of
                                een krachtige sportwagen, wij hebben de perfecte
                                auto voor jou.
                            </p>
                            <div class="flex sm:flex-row flex-col gap-6">
                                <a href="/aanbod">
                                    <Button
                                        class="orange-button"
                                        label="Bekijk ons aanbod"
                                        severity="warning"
                                    />
                                </a>
                                <!-- <a href="/aanbod" class="orange-button">Bekijk ons aanbod</a> -->
                                <a href="/zoeken">
                                    <Button
                                        class="clear-white-button"
                                        label="Zoeken"
                                        severity="secondary"
                                    />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section
            id="sub-hero"
            class="flex justify-center py-8 md:py-20 lg:py-28 z-20 bg-gradient-to-b from-blue/5 to-10% to-blue text-white pt-20 md:pt-0"
        >
            <div
                class="w-11/12 px:0 md:px-6 xl:px-0 flex flex-col gap-10 max-w-6xl"
            >
                <div class="flex flex-col lg:flex-row gap-10">
                    <h2 class="w-full md:w-9/12 xl:w-7/12 text-balance">
                        Ontdek de perfecte auto voor jou bij MTF Automobielen
                    </h2>
                    <p class="w-full md:w-9/12 xl:w-7/12">
                        Bij MTF Automobielen bieden we een ruime keuze aan
                        voertuigen voor elke smaak en elk budget. Of je nu op
                        zoek bent naar een strakke sedan, een ruime SUV of een
                        betrouwbare bedrijfswagen, wij hebben de perfecte auto
                        voor je. Met flexibele financieringsmogelijkheden en een
                        team van vriendelijke experts maken wij het gemakkelijk
                        om in jouw droomauto naar huis te rijden. Ervaar
                        uitzonderlijke klantenservice en vind vandaag nog jouw
                        volgende voertuig bij ons.
                    </p>
                </div>
                <img
                    class="max-h-[46rem] w-full rounded-lg"
                    :src="'/img/heroauto2.webp'"
                />
            </div>
        </section>
    </section>

    <main class="flex flex-col py-10 md:py-20 lg:py-28 gap-28">
        <!--filters-->
        <section id="filters">
            <div class="flex justify-center">
                <div
                    class="grid grid-cols-1 justify-start w-11/12 px:0 md:px-6 xl:px-0 max-w-6xl space-y-2 lg:space-y-10"
                >
                    <h1>Vind jouw perfecte auto</h1>
                    <form
                        @submit.prevent="submit"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-4 gap-x-6 pt-7 lg:pt-0"
                    >
                        <div class="flex flex-row gap-4 w-full">
                            <div class="flex flex-col gap-4 w-full">
                                <p>Merk</p>
                                <MultiSelect
                                    v-model="values.merk"
                                    filter
                                    optionLabel="name"
                                    :options="merkOptions"
                                    placeholder="Selecteer een auto"
                                    :filterPlaceholder="'zoeken'"
                                    :emptyFilterMessage="'Geen resultaten gevonden'"
                                    :filterfocus="'border-grey'"
                                    class="w-full md:w-14rem border border-grey"
                                >
                                </MultiSelect>
                                <div class="flex flex-col gap-2">
                                    <p>carrosserie</p>
                                    <MultiSelect
                                        v-model="values.carrosserie"
                                        filter
                                        optionLabel="name"
                                        :options="carrosserieOptions"
                                        placeholder="Selecteer een carrosserie"
                                        :filterPlaceholder="'zoeken'"
                                        :emptyFilterMessage="'Geen resultaten gevonden'"
                                        :filterfocus="'border-grey'"
                                        class="w-full md:w-14rem border border-grey"
                                    >
                                    </MultiSelect>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <p>Prijs</p>
                                    <div
                                        class="flex flex-row -space-x-0.5 gap-4"
                                    >
                                        <InputNumber
                                            v-model="price[0]"
                                            inputId="minmax"
                                            :min="0"
                                            :max="50000"
                                            class="w-full"
                                        />
                                        <InputNumber
                                            v-model="price[1]"
                                            inputId="minmax"
                                            :min="0"
                                            :max="50000"
                                            class="w-full"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row gap-4 w-full">
                            <div class="flex flex-col gap-4 w-full">
                                <p>Model</p>
                                <MultiSelect
                                    v-model="values.model"
                                    filter
                                    optionLabel="name"
                                    :options="modelOptions"
                                    placeholder="Selecteer een model"
                                    :filterPlaceholder="'zoeken'"
                                    :emptyFilterMessage="'Geen resultaten gevonden'"
                                    :filterfocus="'border-grey'"
                                    class="w-full md:w-14rem border border-grey"
                                >
                                </MultiSelect>
                                <div class="flex flex-col gap-2">
                                    <p>Brandstof</p>
                                    <MultiSelect
                                        v-model="values.brandstof"
                                        filter
                                        optionLabel="name"
                                        :options="brandstofOptions"
                                        placeholder="Selecteer een auto"
                                        :filterPlaceholder="'zoeken'"
                                        :emptyFilterMessage="'Geen resultaten gevonden'"
                                        :filterfocus="'border-grey'"
                                        class="w-full md:w-14rem border border-grey"
                                    >
                                    </MultiSelect>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <p>Bouwjaar</p>
                                    <div class="flex flex-row gap-4">
                                        <InputNumber
                                            v-model="values.bouwjaar[0]"
                                            inputId="withoutgrouping"
                                            :useGrouping="false"
                                            class="w-full"
                                        />
                                        <InputNumber
                                            v-model="values.bouwjaar[1]"
                                            inputId="withoutgrouping"
                                            :useGrouping="false"
                                            class="w-full"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row gap-4 w-full">
                            <div class="flex flex-col gap-4 w-full">
                                <p>Variant</p>
                                <MultiSelect
                                    v-model="values.type"
                                    filter
                                    optionLabel="name"
                                    :options="variantOptions"
                                    placeholder="Selecteer een variant"
                                    :filterPlaceholder="'zoeken'"
                                    :emptyFilterMessage="'Geen resultaten gevonden'"
                                    :filterfocus="'border-grey'"
                                    class="w-full md:w-14rem border border-grey"
                                >
                                </MultiSelect>

                                <div class="flex flex-col gap-2">
                                    <p>Kilometerstand</p>
                                    <div class="flex flex-row gap-4">
                                        <InputNumber
                                            v-model="values.tellerstand[0]"
                                            inputId="withoutgrouping"
                                            :useGrouping="false"
                                            class="w-full"
                                        />
                                        <InputNumber
                                            v-model="values.tellerstand[1]"
                                            inputId="withoutgrouping"
                                            :useGrouping="false"
                                            class="w-full"
                                        />
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <p>Transmissie</p>
                                    <MultiSelect
                                        v-model="values.transmissie"
                                        filter
                                        optionLabel="name"
                                        :options="transmissieOptions"
                                        placeholder="Selecteer een transmissie"
                                        :filterPlaceholder="'zoeken'"
                                        :emptyFilterMessage="'Geen resultaten gevonden'"
                                        :filterfocus="'border-grey'"
                                        class="w-full md:w-14rem border border-grey"
                                    >
                                    </MultiSelect>
                                </div>
                            </div>
                        </div>

                        <a
                            href="/uitgebreidzoeken"
                            class="lg:col-span-2 order-last md:order-none mt-auto hover:underline text-base"
                            >Meer filters</a
                        >
                        <button
                            class="orange-button md:w-full h-full mt-auto"
                            type="submit"
                        >
                            Resultaten tonen
                        </button>
                    </form>
                </div>
            </div>
        </section>
        <div class="flex place-content-center">
            <div
                class="flex flex-wrap w-11/12 px:0 md:px-6 xl:px-0 max-w-6xl mx-auto gap-9"
            >
                <h1 class="font-bold">Beste Modellen</h1>
                <!--stuur data voor homepage naar model.vue-->
                <Model :customPosts="customPosts" :xlColumn="4" :mdColumn="3" />
                <a href="/aanbod" class="orange-button ml-auto mt-auto"
                    >Bekijk alles</a
                >
            </div>
        </div>
    </main>
    <FaqNieuwsbrief />
    <Subfooter />

    <!--    <Slider />-->
</template>
