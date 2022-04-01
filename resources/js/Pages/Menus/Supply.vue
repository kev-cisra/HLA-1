<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-sky-500 tw-shadow-2xl tw-rounded-2xl tw-mr-16 tw-ml-16">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Menu Supply</h3>
            </div>
        </template>

        <section class="Contenedor">
            <div class="MenuModulos">
                <!-- Modulo AutorizaRequisiciones-->
                <div class="Modulo">
                    <Link href="Supply/AutorizaRequisiciones" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-stamp"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">AUTORIZA REQUISICIONES</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Autoriza Sistemas-->
                <div class="Modulo">
                    <Link href="Supply/AutorizaReqSistemas" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">COMPRAS SISTEMAS</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>
            </div>
        </section>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import { Link } from '@inertiajs/inertia-vue3'

    export default {
        props: [
            'usuario',
            'modulos'
        ],
        components: {
            AppLayout,
            Link
        },
    }
</script>
