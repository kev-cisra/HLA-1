<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-blueGray-600 tw-shadow-2xl tw-rounded-2xl tw-mr-16 tw-ml-16">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Menu Administrador</h3>
            </div>
        </template>

        <section class="Contenedor">
            <div class="MenuModulos">
                <!-- Modulo Sistema-->
                <div class="Modulo">
                    <Link href="/Admin/Modulos" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fab fa-laravel"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Modulos del Sistema</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Usuarios Sistema-->
                <div class="Modulo">
                    <Link href="/Admin/Usuarios" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fab fa-laravel"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">Usuarios del Sistema</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo ROLES-->
                <div class="Modulo">
                    <Link href="Admin/RolesUsuarios" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">ROLES DE USUARIO</h4>
                            <span class="linea"></span>
                        </div>
                    </Link>
                </div>

                <!-- Modulo Laravel Spatie-->
                <div class="Modulo">
                    <Link href="Admin/Spatie" class="LinkModulo">
                        <div class="IconoModulo">
                            <i class="fa-solid fa-ghost"></i>
                        </div>
                        <div>
                            <h4 class="TituloModulo">LARAVEL SPATIE</h4>
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
    import Welcome from '@/Jetstream/Welcome'
    import Canvas from "@/Components/Canvas";

    export default {
        components: {
            AppLayout,
            Link,
        },
    }
</script>
