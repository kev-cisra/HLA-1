<template>
  <div v-if="links.length > 3">
    <div class="tw-flex tw-flex-wrap tw--mb-1">
      <template v-for="(link, k) in links" :key="k">
        <div v-if="link.url === null"  class="tw-px-4 tw-py-3 tw-mb-1 tw-mr-1 tw-text-sm tw-leading-4 tw-text-gray-400 tw-border tw-rounded" v-html="link.label" />
        <inertia-link v-else class="tw-px-4 tw-py-3 tw-mb-1 tw-mr-1 tw-text-sm tw-leading-4 tw-border tw-rounded-lg hover:tw-bg-white focus:tw-border-indigo-500 focus:tw-text-indigo-500" :class="{ 'tw-bg-gray-200 tw-text-white': link.active }" :href="link.url" v-html="link.label" />
      </template>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    links: Array,
  },
}
</script>
