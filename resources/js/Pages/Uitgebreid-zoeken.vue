<script setup>
import Checkbox from "primevue/checkbox";

import MultiSelect from "primevue/multiselect";

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

        const uniqueInteriorColors = [
            ...new Set(data.posts.map((post) => post.looks.interieurkleur)),
        ];
        interiorColorsOptions.value = uniqueInteriorColors.map((incol) => {
            return {
                name: incol,
                value: incol,
            };
        });

        const uniqueInteriorMaterials = [
            ...new Set(data.posts.map((post) => post.looks.bekleding)),
        ];
        interiorMaterialsOptions.value = uniqueInteriorMaterials.map(
            (inmat) => {
                return {
                    name: inmat,
                    value: inmat,
                };
            }
        );

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

const selectedInteriorColor = ref([]);
const interiorColorsOptions = ref([]);

const selectedInteriorMaterial = ref([]);
const interiorMaterialsOptions = ref([]);

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
    interieurkleur: selectedInteriorColor,
    bekleding: selectedInteriorMaterial,
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
        <title>Uitgebreid zoeken</title>
        <meta
            name="description"
            content="Vind de ideale auto met de uitgebreide zoekopties van [Naam Auto Dealer]. Gebruik alle filters zoals merk, model, prijs, bouwjaar en meer om precies te vinden wat je zoekt. Begin nu met je zoektocht!"
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
    <div class="py-20">
        <form @submit.prevent="submit">
            <div
                class="sticky flex justify-center z-20 w-11/12 px:0 md:px-6 xl:px-0 mx-auto top-6/7"
            >
                <button class="orange-button" type="submit">Submit</button>
            </div>
            <div
                class="w-11/12 px:0 md:px-6 xl:px-0 max-w-6xl mx-auto p-5 pb-8 rounded-lg"
            >
                <div class="flex flex-col items-start gap-16 w-full">
                    <div class="flex flex-col items-start gap-6">
                        <p>Explore</p>
                        <h2>Vind jouw perfecte auto</h2>
                        <p>
                            Browse our wide selection of high-quality vehicles
                            to find your perfect match
                        </p>
                    </div>

                    <div
                        class="flex md:flex-row flex-col gap-4 w-full border-b border-grey pb-5"
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
                                        placeholder="Selecteer Brandstof"
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
                    </div>
                </div>
                <p class="font-bold py-10">Accessoires</p>
                <div
                    class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="(accessoiresOption, index) in accessoiresOptions"
                        :key="index"
                        class="flex align-items-center"
                    >
                        <Checkbox
                            v-model="selectedAccessoires"
                            name="category"
                            :value="accessoiresOption.name"
                            variant="filled"
                            class="rounded-lg"
                        />
                        <p
                            class="px-2 text-base"
                            :for="accessoiresOption.value"
                        >
                            {{ accessoiresOption.name }}
                        </p>
                    </div>
                </div>

                <p class="font-bold py-10">Exterieur kleuren</p>
                <div
                    class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="(
                            exteriorColorOption, index
                        ) in exteriorColorOptions"
                        :key="index"
                        class="flex align-items-center"
                    >
                        <Checkbox
                            v-model="selectedExteriorColor"
                            name="category"
                            :value="exteriorColorOption.name"
                            variant="filled"
                            class="rounded-lg"
                        />
                        <p
                            class="px-2 text-base"
                            :for="exteriorColorOption.value"
                        >
                            {{ exteriorColorOption.name }}
                        </p>
                    </div>
                </div>
                <p class="font-bold py-10">Materiaal</p>
                <div
                    class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="(
                            exteriorMaterialOption, index
                        ) in exteriorMaterialsOptions"
                        :key="index"
                        class="flex align-items-center"
                    >
                        <Checkbox
                            v-model="selectedExteriorMaterial"
                            name="category"
                            :value="exteriorMaterialOption.name"
                            variant="filled"
                            class="rounded-lg"
                        />
                        <p
                            class="px-2 text-base"
                            :for="exteriorMaterialOption.value"
                        >
                            {{ exteriorMaterialOption.name }}
                        </p>
                    </div>
                </div>
                <p class="font-bold py-10">Interieur kleur</p>
                <div
                    class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="(
                            interiorColorOption, index
                        ) in interiorColorsOptions"
                        :key="index"
                        class="flex align-items-center"
                    >
                        <Checkbox
                            v-model="selectedInteriorColor"
                            name="category"
                            :value="interiorColorOption.name"
                            variant="filled"
                            class="rounded-lg"
                        />
                        <p
                            class="px-2 text-base"
                            :for="interiorColorOption.value"
                        >
                            {{ interiorColorOption.name }}
                        </p>
                    </div>
                </div>
                <p class="font-bold py-10">Interieur kleur</p>
                <div
                    class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="(
                            interiorMaterialOption, index
                        ) in interiorMaterialsOptions"
                        :key="index"
                        class="flex align-items-center"
                    >
                        <Checkbox
                            v-model="selectedInteriorMaterial"
                            name="category"
                            :value="interiorMaterialOption.name"
                            variant="filled"
                            class="rounded-lg"
                        />
                        <p
                            class="px-2 text-base"
                            :for="interiorMaterialOption.value"
                        >
                            {{ interiorMaterialOption.name }}
                        </p>
                    </div>
                </div>
                <input
                    type="hidden"
                    name="_token"
                    :value="$page.props.csrfToken"
                />
            </div>
        </form>
    </div>
</template>
