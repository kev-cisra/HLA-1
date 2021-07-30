<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-green-600 tw-shadow-xl tw-rounded-2xl">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Hola</h3>
            </div>
        </template>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import comDangerButton from '@/Components/DangerButton'
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import Table from '@/Components/Table'

    export default {
        components: {
            AppLayout,
            Welcome,
            comDangerButton,
            Header,
            Accions,
            Table
        },
    }
</script>
