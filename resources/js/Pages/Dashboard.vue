<template>
    <app-layout>
        <template #header>
            <h2 class="tw-text-xl tw-font-semibold tw-leading-tight tw-text-gray-800">
                Dashboard
            </h2>
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
