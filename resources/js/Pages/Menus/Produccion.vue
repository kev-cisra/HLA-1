<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-green-600 tw-shadow-2xl tw-rounded-2xl tw-mr-16 tw-ml-16">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Menu Produccion</h3>
            </div>
        </template>
        <section id="menu" class="tw-flex tw-justify-center tw-min-h-screen tw-mt-8 tw-min-w-screen">

            <div class="container">
                <div class="row">
                    <!-- For --><!---- clase tw-w-1/6 tw-p-0 tw-mt-2 tw-text-center tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110-->
                    <div v-for="modulo in modelos" :key="modulo.id" class="col-sm-12 col-md-4 col-lg-2 tw-text-center tw-p-0 tw-mt-2 mb-3 tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110 tw-h-16">
                        <Link :href="modulo.Ruta" class="tw-no-underline icono">
                            <div class="tw-flex tw-justify-center tw-mb-4">
                                <i :class="modulo.Icono"></i>
                            </div>
                            <div>
                                <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">{{ modulo.NombreModulo }}</h4>
                                <span class="linea"></span>
                            </div>
                        </Link>
                    </div>
                    <!-- Fin for -->
                </div>
            </div>

        </section>
    </app-layout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout.vue';
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        props: [
            'usuario',
            'modelos'
        ],
        components: {
            AppLayout,
            Link,
        },
    }
</script>

