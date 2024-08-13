<script setup>
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import Button from "primevue/button";
</script>
<template>

    <div id="services" class="flex flex-col bg-blue text-white -space-y-56">
        <!--hero-->
        <section id="Droomauto">
            <div class="z-20 h-full bg-gradient-to-b from-blue/5 to-blue text-white relative">
                <div class="h-screen flex flex-col max-h-[1200px] bg-info-2 bg-bottom bg-opacity-35">
                    <div class="z-20 flex justify-center h-screen w-screen min-h-96">
                        <div class="w-11/12 px:0 md:px-6 xl:px-0 max-w-6xl mx-auto h-4/6 sm:h-5/6">
                            <div class="flex flex-col gap-10 h-full justify-center lg:items-center">
                                <div class="text-center space-y-5">
                                    <h2>Vind jou droomauto</h2>
                                    <p class="hidden sm:block lg:w-7/12 mx-auto text-pretty">Toch niet helemaal wat je zoekt? Wij helpen jouw om jouw droomauto te vinden. Neem contact met ons op dan kijken we samen naar de mogelijkheden.
                                    </p>
                                    <div class="flex flex-col sm:flex-row gap-4 justify-center w-full pt-6 md:pt-16">
                                        <a href="" class="orange-button">Contact</a>
                                        <a href="" class="grey-button">Meer info</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section
            class="flex justify-center py-8 md:py-20 lg:py-28 z-20 bg-gradient-to-b from-blue/5 to-15% to-blue text-white">
            <div class="w-11/12 px:0 md:px-6 xl:px-0 max-w-6xl mx-auto flex flex-col gap-10">
                <div class="flex flex-col gap-4 pb-6 md:pb-16 lg:pb-20">
                    <h2>Veelgestelde vragen</h2>
                    <p class="w-full text-balance">Lees hier de
                        meest
                        gevraagde stellingen. Nog
                        steeds
                        meer vragen dan antwoorden, neem dan contact op met ons.</p>
                </div>
                <section id="faq">
                    <Accordion :activeIndex="null">
                        <AccordionTab>
                            <template #header>
                                <p class="font-bold">Hoelang heb ik garantie op mijn aangekochte auto</p>
                            </template>
                            <p class="m-0">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
                                eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa
                                qui officia deserunt mollit anim id est
                                laborum.
                            </p>
                        </AccordionTab>
                        <AccordionTab>
                            <template #header>
                                <p class="font-bold">Kan ik bij jullie ook leasen?</p>
                            </template>
                            <p class="m-0">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna
                                aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
                                eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa
                                qui officia deserunt mollit anim id est
                                laborum.
                            </p>
                        </AccordionTab>
                        <AccordionTab>
                            <template #header>
                                <p class="font-bold">Kopen jullie ook auto's in?</p>
                            </template>
                            <p class="m-0">
                                At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium
                                voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint
                                occaecati cupiditate non provident, similique sunt in
                                culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum
                                quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis
                                est eligendi optio cumque nihil impedit qu.
                            </p>
                        </AccordionTab>
                        <AccordionTab>
                            <template #header>
                                <p class="font-bold">Kan ik langskomen voor een proefrit?</p>
                            </template>
                            <p class="m-0">
                                At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium
                                voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint
                                occaecati cupiditate non provident, similique sunt in
                                culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum
                                quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis
                                est eligendi optio cumque nihil impedit qu.
                            </p>
                        </AccordionTab>
                        <AccordionTab>
                            <template #header>
                                <p class="font-bold">Whats are your payment options?</p>
                            </template>
                            <p class="m-0">
                                At vero eos et accusamus et iusto odio dignissimos ducimus qui
                                blanditiis praesentium
                                voluptatum deleniti atque corrupti quos dolores et quas molestias
                                excepturi sint
                                occaecati cupiditate non provident, similique sunt in
                                culpa qui officia deserunt mollitia animi, id est laborum et dolorum
                                fuga. Et harum
                                quidem rerum facilis est et expedita distinctio. Nam libero tempore,
                                cum soluta nobis
                                est eligendi optio cumque nihil impedit qu.
                            </p>
                        </AccordionTab>
                    </Accordion>
                </section>
                <div class="flex flex-col sm:text-center pt-20 gap-4 w-auto">
                    <h2 class="text-white">Nog steeds vragen?</h2>
                    <p class="text-white">Kom langs of neem contact met ons op!</p>
                    <div class="flex flex-col w-full justify-center sm:flex-row gap-6">
                        <Button label="Contact" icon="pi pi-phone" class="orange-button" />
                        <a href="https://wa.me/31612345678" class=" icon-button-sm">
                            <Button label="Whatsapp" icon="pi pi-whatsapp" class="grey-button" />
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

</template>
