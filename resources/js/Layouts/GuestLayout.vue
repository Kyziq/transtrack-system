<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div
    class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 dark:bg-gray-900 sm:justify-center sm:pt-0"
  >
    <div>
      <Link href="/">
        <img
          src="../../../public/icon.png"
          alt="transtrack"
          width="70"
          height="70"
        />
      </Link>
    </div>

    <div
      class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md dark:bg-gray-800 sm:max-w-md sm:rounded-lg"
    >
      <slot />
    </div>
  </div>
</template>
