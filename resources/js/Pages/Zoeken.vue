<script setup>
import MultiSelect from "primevue/multiselect";
import Inplace from "primevue/inplace";
import InputNumber from "primevue/inputnumber";
import { ref, onMounted, reactive } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import { Head } from "@inertiajs/vue3";

//get options voor filters
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

const age = ref([1990, 2024]);

const mileage = ref([0, 1000000]);

const values = reactive({
    merk: [],
    model: [],
    transmissie: [],
    brandstof: [],

    age: age,
    mileage: mileage,
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
        <title>Zoeken</title>
        <meta
            name="description"
            content="Zoek naar jouw ideale auto bij MTF-Automobielen . Gebruik onze eenvoudige zoekfunctie met filters om snel nieuwe en gebruikte auto's te vinden die aan jouw wensen voldoen. Begin vandaag met zoeken!"
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
    <div class="flex flex-col bg-blue text-white -space-y-44 md:-space-y-80">
        <!--hero-->
        <div
            class="z-20 h-full bg-gradient-to-b from-blue/5 to-blue text-white relative"
        >
            <div
                class="h-screen min-h-96 flex flex-col max-h-[1200px] bg-info-2 bg-bottom"
            >
                <div class="z-20 flex justify-center">
                    <div
                        class="w-11/12 px:0 md:px-6 xl:px-0 h-5/6 max-w-6xl min-h-96"
                    >
                        <div
                            class="flex flex-col gap-10 h-screen justify-center text-white"
                        >
                            <h1>Vind jouw perfecte auto</h1>
                            <form
                                @submit.prevent="submit"
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-4 gap-x-6"
                            >
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
                                <div class="flex flex-col gap-2">
                                    <div class="flex flex-row gap-4">
                                        <InputNumber
                                            v-model="values.age[0]"
                                            inputId="withoutgrouping"
                                            :useGrouping="false"
                                            class="w-full"
                                        />
                                        <InputNumber
                                            v-model="values.age[1]"
                                            inputId="withoutgrouping"
                                            :useGrouping="false"
                                            class="w-full"
                                        />
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <div class="flex flex-row gap-4">
                                        <InputNumber
                                            v-model="values.mileage[0]"
                                            inputId="withoutgrouping"
                                            :useGrouping="false"
                                            class="w-full"
                                        />
                                        <InputNumber
                                            v-model="values.mileage[1]"
                                            inputId="withoutgrouping"
                                            :useGrouping="false"
                                            class="w-full"
                                        />
                                    </div>
                                </div>
                                <MultiSelect
                                    v-model="values.brandstof"
                                    filter
                                    optionLabel="name"
                                    :options="brandstofOptions"
                                    placeholder="Selecteer brandstof"
                                    :filterPlaceholder="'zoeken'"
                                    :emptyFilterMessage="'Geen resultaten gevonden'"
                                    :filterfocus="'border-grey'"
                                    class="w-full md:w-14rem border border-grey"
                                >
                                </MultiSelect>
                                <a
                                    href="/uitgebreidzoeken"
                                    class="lg:col-span-2 order-last md:order-none mt-auto hover:underline text-base"
                                    >Meer filters</a
                                >
                                <a
                                    href="/aanbod"
                                    class="orange-button md:w-full h-full mt-auto"
                                    severity="warning"
                                    >Resultaten tonen</a
                                >
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="flex justify-center z-20 bg-gradient-to-b from-blue/5 to-35% to-blue text-white pb-20"
        >
            <div
                class="w-11/12 px:0 md:px-6 xl:px-0 flex flex-col gap-10 max-w-6xl"
            >
                <div class="flex flex-col gap-4 pb-6 pt-20">
                    <h2 class="lg:text-right max-w-6xl">
                        Populaire zoektermen
                    </h2>
                </div>
                <div
                    class="flex flex-col justify-center text-center items-center gap-4 w-auto"
                >
                    <div class="flex w-full bg-blue flex-col">
                        <div
                            class="text-white text-left text-nowrap mx-auto w-full max-w-6xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-10"
                        >
                            <a
                                href="#"
                                class="flex group gap-4 justify-start lg:justify-start"
                            >
                                <svg
                                    class="fill-current group-hover:text-orange"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="49"
                                    height="48"
                                    viewBox="0 0 49 48"
                                    fill="none"
                                >
                                    <path
                                        d="M22.6665 24H34.6665V36H22.6665V24Z"
                                        fill="current"
                                    />
                                    <path
                                        d="M38.6665 8H34.6665V4H30.6665V8H18.6665V4H14.6665V8H10.6665C8.4605 8 6.6665 9.794 6.6665 12V40C6.6665 42.206 8.4605 44 10.6665 44H38.6665C40.8725 44 42.6665 42.206 42.6665 40V12C42.6665 9.794 40.8725 8 38.6665 8ZM38.6685 40H10.6665V16H38.6665L38.6685 40Z"
                                        fill="current"
                                    />
                                </svg>
                                <div class="w-48 group-hover:text-orange">
                                    <h5>Bouwjaar</h5>
                                    <p>vanaf 2014</p>
                                </div>
                            </a>
                            <a
                                href="#"
                                class="flex group gap-4 justify-start lg:justify-center"
                            >
                                <svg
                                    class="fill-current group-hover:text-orange"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="49"
                                    height="48"
                                    viewBox="0 0 49 48"
                                    fill="none"
                                >
                                    <path
                                        d="M22.6665 24H34.6665V36H22.6665V24Z"
                                        fill="current"
                                    />
                                    <path
                                        d="M38.6665 8H34.6665V4H30.6665V8H18.6665V4H14.6665V8H10.6665C8.4605 8 6.6665 9.794 6.6665 12V40C6.6665 42.206 8.4605 44 10.6665 44H38.6665C40.8725 44 42.6665 42.206 42.6665 40V12C42.6665 9.794 40.8725 8 38.6665 8ZM38.6685 40H10.6665V16H38.6665L38.6685 40Z"
                                        fill="current"
                                    />
                                </svg>
                                <div class="w-48 group-hover:text-orange">
                                    <h5>Kilometerstand</h5>
                                    <p>tot 80.000</p>
                                </div>
                            </a>
                            <a
                                href="#"
                                class="flex group gap-4 justify-start lg:justify-end"
                            >
                                <svg
                                    class="fill-current group-hover:text-orange"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="49"
                                    height="48"
                                    viewBox="0 0 49 48"
                                    fill="none"
                                >
                                    <path
                                        d="M22.6665 24H34.6665V36H22.6665V24Z"
                                        fill="current"
                                    />
                                    <path
                                        d="M38.6665 8H34.6665V4H30.6665V8H18.6665V4H14.6665V8H10.6665C8.4605 8 6.6665 9.794 6.6665 12V40C6.6665 42.206 8.4605 44 10.6665 44H38.6665C40.8725 44 42.6665 42.206 42.6665 40V12C42.6665 9.794 40.8725 8 38.6665 8ZM38.6685 40H10.6665V16H38.6665L38.6685 40Z"
                                        fill="current"
                                    />
                                </svg>
                                <div class="w-48 group-hover:text-orange">
                                    <h5>Transmissie</h5>
                                    <p>Automaat</p>
                                </div>
                            </a>
                            <a
                                href="#"
                                class="hidden sm:flex group gap-4 justify-start lg:justify-start"
                            >
                                <svg
                                    class="fill-current group-hover:text-orange"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="49"
                                    height="48"
                                    viewBox="0 0 49 48"
                                    fill="none"
                                >
                                    <path
                                        d="M22.6665 24H34.6665V36H22.6665V24Z"
                                        fill="current"
                                    />
                                    <path
                                        d="M38.6665 8H34.6665V4H30.6665V8H18.6665V4H14.6665V8H10.6665C8.4605 8 6.6665 9.794 6.6665 12V40C6.6665 42.206 8.4605 44 10.6665 44H38.6665C40.8725 44 42.6665 42.206 42.6665 40V12C42.6665 9.794 40.8725 8 38.6665 8ZM38.6685 40H10.6665V16H38.6665L38.6685 40Z"
                                        fill="current"
                                    />
                                </svg>
                                <div class="w-48 group-hover:text-orange">
                                    <h5>Carroserie</h5>
                                    <p>SUV</p>
                                </div>
                            </a>
                            <a
                                href="#"
                                class="hidden md:flex group gap-4 justify-start lg:justify-center"
                            >
                                <svg
                                    class="fill-current group-hover:text-orange"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="49"
                                    height="48"
                                    viewBox="0 0 49 48"
                                    fill="none"
                                >
                                    <path
                                        d="M22.6665 24H34.6665V36H22.6665V24Z"
                                        fill="current"
                                    />
                                    <path
                                        d="M38.6665 8H34.6665V4H30.6665V8H18.6665V4H14.6665V8H10.6665C8.4605 8 6.6665 9.794 6.6665 12V40C6.6665 42.206 8.4605 44 10.6665 44H38.6665C40.8725 44 42.6665 42.206 42.6665 40V12C42.6665 9.794 40.8725 8 38.6665 8ZM38.6685 40H10.6665V16H38.6665L38.6685 40Z"
                                        fill="current"
                                    />
                                </svg>
                                <div class="w-48 group-hover:text-orange">
                                    <h5>Prijs</h5>
                                    <p>tot 25.000,-</p>
                                </div>
                            </a>
                            <a
                                href="#"
                                class="hidden md:flex group gap-4 justify-start lg:justify-end"
                            >
                                <svg
                                    class="fill-current group-hover:text-orange"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="49"
                                    height="48"
                                    viewBox="0 0 49 48"
                                    fill="none"
                                >
                                    <path
                                        d="M22.6665 24H34.6665V36H22.6665V24Z"
                                        fill="current"
                                    />
                                    <path
                                        d="M38.6665 8H34.6665V4H30.6665V8H18.6665V4H14.6665V8H10.6665C8.4605 8 6.6665 9.794 6.6665 12V40C6.6665 42.206 8.4605 44 10.6665 44H38.6665C40.8725 44 42.6665 42.206 42.6665 40V12C42.6665 9.794 40.8725 8 38.6665 8ZM38.6685 40H10.6665V16H38.6665L38.6685 40Z"
                                        fill="current"
                                    />
                                </svg>
                                <div class="w-48 group-hover:text-orange">
                                    <h5>Brandstof</h5>
                                    <p>Hybride</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Faq />
    <div class="bg-blue text-white flex justify-center">
        <div class="w-11/12 px:0 md:px-6 xl:px-0 max-w-6xl mx-auto">
            <div
                class="flex singe-item w-full py-12 md:py-20 lg:py-28 flex-col items-start gap-20"
            >
                <div
                    class="flex flex-col lg:flex-row items-center gap-20 self-stretch"
                >
                    <div class="flex flex-col items-start gap-6 flex-1">
                        <div class="flex flex-col gap-4">
                            <p class="font-semibold">Bezoek ons</p>
                            <h2>MTF Automobielen Almelo</h2>
                        </div>
                        <p>
                            Purus viverra nam lacus adipiscing lacus tortor
                            aliquet. Gravida sem sed suscipit sit est.
                            Pellentesque lectus arcu bibendum purus tempus odio
                            pellentesque et leo. Gravida enim congue at sit
                            morbi viverra. Placerat faucibus est vitae amet et
                            cras egestas semper pellentesque. Tincidunt
                            convallis scelerisque elit elit in blandit
                            tristique. Iaculis malesuada posuere luctus aenean
                            purus. Ac netus ridiculus felis a. Nec eleifend ac
                            augue sit risus tempus nisi. Nibh mauris habitant
                            feugiat neque et ultricies scelerisque tempor. Vitae
                            gravida vulputate sed amet amet fames ipsum
                            faucibus. Vitae facilisi at eu quam posuere.
                            Lobortis vel vitae varius in massa. Mi consequat
                            pharetra aliquam sodales egestas.
                        </p>
                        <div class="flex gap-6 pt-4">
                            <a
                                target="_blank"
                                href="https://www.google.com/maps/place/MTF+Automobielen/@52.3748333,6.6866339,17z/data=!3m1!4b1!4m6!3m5!1s0x47b80944fdf6ce63:0xae066dc37ab5966b!8m2!3d52.3748301!4d6.6892088!16s%2Fg%2F11q1vdhjkj?entry=ttu"
                            >
                                <Button
                                    class="orange-button font"
                                    label="Kom langs!"
                                    severity="warning"
                                />
                            </a>

                            <a href="/overons">
                                <Button
                                    class="grey-button"
                                    label="Contact"
                                    severity="warning"
                                />
                            </a>
                        </div>
                    </div>
                    <div class="lg:w-5/12">
                        <img
                            class="rounded-lg h-auto"
                            :src="'/img/mtfsubfooter.webp'"
                            alt="placeholder"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
