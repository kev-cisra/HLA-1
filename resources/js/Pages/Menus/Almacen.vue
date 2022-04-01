<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-cyan-600 tw-shadow-2xl tw-rounded-2xl tw-mr-16 tw-ml-16">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Menu Almacen</h3>
            </div>
        </template>

        <section class="Contenedor">
            <div class="MenuModulos">
                <!-- Modulo Requisiciones-->
                <div class="Modulo">
                    <Link href="/Almacen/Requisiciones" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">REQUISICIONES SOLICITADAS</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Proveedores-->
                <div class="Modulo">
                    <Link href="/Compras/Proveedores" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">PROVEEDORES</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo ValesSalida-->
                <div class="Modulo">
                    <Link href="/Almacen/ValesSalida" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fa-solid fa-note-sticky"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">VALES SALIDA</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo INSUMOS-->
                <div class="Modulo">
                    <Link href="/Almacen/EntregaInsumos" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">ENTREGA DE INSUMOS</h4>
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
