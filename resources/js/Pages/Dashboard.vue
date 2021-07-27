<template>
    <app-layout>
        <template #header>
            <div class="tw-mt-2 tw-text-center tw-text-white tw-bg-green-600 tw-shadow-xl tw-rounded-2xl">
                <h3 class="tw-p-2"><i class="fas fa-house-user tw-ml-3 tw-mr-3"></i>Hola</h3>
            </div>
        </template>

        <div class="tw-py-12">
            <div class="tw-mx-auto tw-max-w-7xl sm:tw-px-6 lg:tw-px-8">
                <div class="tw-overflow-hidden tw-bg-white tw-shadow-xl sm:tw-rounded-lg">
                    <welcome />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
    }
</script>
