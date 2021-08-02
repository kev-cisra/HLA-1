<template>
    <div class="tw-w-full tw-mx-auto tw-my-8 sm:tw-px-6 lg:tw-px-8">
        <div class="tw-flex tw-items-center tw-gap-4">
            <div class="tw-flex-none">
                <select class="tw-block tw-w-full tw-font-semibold tw-text-gray-500 tw-bg-gray-200 tw-border tw-border-gray-300 tw-rounded-full tw-appearance-none focus:tw-outline-none focus:tw-shadow-outline">
                    <option>5</option>
                    <option>10</option>
                    <option>25</option>
                    <option>35</option>
                    <option>50</option>
                </select>
            </div>
                <div class="tw-block tw-relative tw-w-1/6">
                    <slot name="SelectB">

                    </slot>
                </div>
            <div class="tw-flex-grow">
                <div class="tw-block tw-relative">
                    <span class="tw-absolute tw-inset-y-0 tw-left-0 tw-flex tw-items-center tw-h-full tw-pl-4">
                        <svg viewBox="0 0 24 24" class="tw-w-4 tw-h-4 tw-text-gray-500 tw-fill-current">
                            <path
                                d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                            </path>
                        </svg>
                    </span>
                    <slot name="InputBusqueda">

                    </slot>
                </div>
            </div>
            <div class="">
                <slot name="BtnNuevo">

                </slot>
            </div>
        </div>
    </div>
</template>
