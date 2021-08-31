<template>
    <app-layout>
        <section id="menu" class="tw-flex tw-justify-center tw-min-h-screen tw-mt-8 tw-min-w-screen">
            <!-- For -->
            <div class="tw-w-1/6 tw-p-0 tw-mt-2 tw-text-center tw-transition tw-duration-700 tw-ease-in-out tw-transform tw-h-1/6 hover:tw--translate-y-1 hover:tw-scale-110">
                <Link href="/Compras/Requisiciones" class="tw-no-underline icono">
                    <div class="tw-flex tw-justify-center tw-mb-4">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <h4 class="tw-text-base tw-font-semibold tw-text-gray-400 tw-uppercase">Requisiciones</h4>
                        <span class="linea"></span>
                    </div>
                </Link>
            </div>
            <!-- Fin for -->
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
