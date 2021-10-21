<template>
    <div class="tw-min-h-screen tw-flex tw-flex-col sm:tw-justify-center tw-items-center tw-pt-6 sm:tw-pt-0 tw-bg-gray-100">
        <div>
            <slot name="logo" />
        </div>

        <div class="tw-w-full sm:tw-max-w-md tw-mt-6 tw-px-6 tw-py-4 tw-overflow-hidden ">
            <slot />
        </div>
    </div>
</template>
