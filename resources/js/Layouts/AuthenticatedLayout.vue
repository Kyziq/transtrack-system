<script setup lang="ts">
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import { Moon, Sun } from 'lucide-vue-next';
import { useDark, useToggle } from '@vueuse/core';
import { Toaster } from 'vue-sonner';

const isDark = useDark();
const toggleDark = useToggle(isDark);
const showingNavigationDropdown = ref(false);
</script>

<template>
  <Toaster :richColors="true" />
  <div>
    <div class="flex min-h-screen flex-col bg-gray-100 dark:bg-gray-900">
      <nav
        class="border-b border-gray-100 bg-white dark:border-gray-700 dark:bg-gray-800"
      >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex h-16 justify-between">
            <div class="flex">
              <div class="flex shrink-0 items-center">
                <Link :href="route('dashboard')">
                  <img src="../../../public/icon.png" width="40" height="40" />
                </Link>
              </div>

              <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <NavLink
                  :href="route('dashboard')"
                  :active="route().current('dashboard')"
                >
                  Dashboard
                </NavLink>
                <NavLink
                  :href="route('vehicle.view')"
                  :active="route().current('vehicle.view')"
                >
                  Vehicle
                </NavLink>
                <NavLink
                  :href="route('booking.view')"
                  :active="route().current('booking.view')"
                >
                  Booking
                </NavLink>
                <NavLink
                  :href="route('maintenance.view')"
                  :active="route().current('maintenance.view')"
                >
                  Maintenance
                </NavLink>
                <NavLink
                  v-if="$page.props.auth.user.role === 'admin'"
                  :href="route('admin.index')"
                  :active="route().current('admin.index')"
                >
                  Admin
                </NavLink>
              </div>
            </div>

            <div class="flex items-center">
              <button
                class="rounded-md p-2 hover:bg-gray-200 dark:text-white hover:dark:bg-gray-600"
                @click="toggleDark()"
              >
                <Moon v-if="!isDark" :size="18" />
                <Sun v-if="isDark" :size="18" />
              </button>
              <div class="hidden sm:ms-6 sm:flex sm:items-center">
                <div class="relative ms-3">
                  <Dropdown align="right" width="48">
                    <template #trigger>
                      <span class="inline-flex rounded-md">
                        <button
                          type="button"
                          class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300"
                        >
                          {{ $page.props.auth.user.name }}

                          <svg
                            class="-me-0.5 ms-2 h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd"
                            />
                          </svg>
                        </button>
                      </span>
                    </template>

                    <template #content>
                      <DropdownLink :href="route('profile.edit')">
                        Profile
                      </DropdownLink>
                      <DropdownLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                      >
                        Log Out
                      </DropdownLink>
                    </template>
                  </Dropdown>
                </div>
              </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
              <button
                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-900 dark:hover:text-gray-400 dark:focus:bg-gray-900 dark:focus:text-gray-400"
                @click="showingNavigationDropdown = !showingNavigationDropdown"
              >
                <svg
                  class="h-6 w-6"
                  stroke="currentColor"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <path
                    :class="{
                      hidden: showingNavigationDropdown,
                      'inline-flex': !showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    :class="{
                      hidden: !showingNavigationDropdown,
                      'inline-flex': showingNavigationDropdown,
                    }"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div
          :class="{
            block: showingNavigationDropdown,
            hidden: !showingNavigationDropdown,
          }"
          class="sm:hidden"
        >
          <div class="space-y-1 pb-3 pt-2">
            <ResponsiveNavLink
              :href="route('dashboard')"
              :active="route().current('dashboard')"
            >
              Dashboard
            </ResponsiveNavLink>
          </div>

          <div class="border-t border-gray-200 pb-1 pt-4 dark:border-gray-600">
            <div class="px-4">
              <div
                class="text-base font-medium text-gray-800 dark:text-gray-200"
              >
                {{ $page.props.auth.user.name }}
              </div>
              <div class="text-sm font-medium text-gray-500">
                {{ $page.props.auth.user.email }}
              </div>
            </div>

            <div class="mt-3 space-y-1">
              <ResponsiveNavLink :href="route('profile.edit')">
                Profile
              </ResponsiveNavLink>
              <ResponsiveNavLink
                :href="route('logout')"
                method="post"
                as="button"
              >
                Log Out
              </ResponsiveNavLink>
            </div>
          </div>
        </div>
      </nav>

      <header v-if="$slots.header" class="bg-white shadow dark:bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <main class="flex flex-1 flex-col">
        <slot />
      </main>
    </div>
  </div>
</template>
