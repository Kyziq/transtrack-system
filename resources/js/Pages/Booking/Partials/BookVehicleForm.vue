<script setup lang="ts">
import InputLabel from '@/Components/InputLabel.vue';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/Components/ui/select';
import { Vehicle } from '@/types/Vehicle';
import { useForm, usePage } from '@inertiajs/vue3';
import { Ref, ref } from 'vue';
import { Calendar as CalendarIcon } from 'lucide-vue-next';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/Components/ui/popover';
import { cn } from '@/lib/utils';
import {
  DateFormatter,
  getLocalTimeZone,
  CalendarDate,
} from '@internationalized/date';
import { Button } from '@/Components/ui/button';
import { RangeCalendar } from '@/Components/ui/range-calendar';
import type { DateRange } from 'radix-vue';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';

const df = new DateFormatter('en-MY', {
  dateStyle: 'long',
});

const today = new Date();

const rangeDate = ref({
  start: new CalendarDate(
    today.getFullYear(),
    today.getMonth() + 1,
    today.getDate(),
  ),
  end: new CalendarDate(
    today.getFullYear(),
    today.getMonth() + 1,
    today.getDate(),
  ).add({ days: 1 }),
}) as Ref<DateRange>;
const vehicles = usePage().props.vehicles as unknown as Vehicle[];
const selectedVehicleId = ref<string | undefined>(undefined);

const form = useForm({
  start_date: '',
  end_date: '',
  vehicle_id: '',
  notes: '',
  booked_by: 0,
});

const createBooking = () => {
  form.booked_by = usePage().props.auth.user.id;

  if (!rangeDate.value.start || !rangeDate.value.end) {
    console.log('rangeDate.value.start or rangeDate.value.end is not defined');
    return;
  }

  if (!selectedVehicleId.value) {
    console.log('selectedVehicleId.value is not defined');
    return;
  }

  form.start_date = rangeDate.value.start
    .toDate(getLocalTimeZone())
    .toISOString()
    .slice(0, 19)
    .replace('T', ' ');
  form.end_date = rangeDate.value.end
    .toDate(getLocalTimeZone())
    .toISOString()
    .slice(0, 19)
    .replace('T', ' ');
  form.vehicle_id = selectedVehicleId.value;

  console.log(form);
  form.post(route('booking.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
    onError: () => {
      if (form.errors.vehicle_id) {
        console.log('form.errors.vehicle_id');
      }

      if (form.errors.notes) {
        console.log('form.errors.notes');
      }

      if (form.errors.start_date) {
        console.log('form.errors.start_date');
      }

      if (form.errors.end_date) {
        console.log('form.errors.end_date');
      }

      if (form.errors.booked_by) {
        console.log('form.errors.booked_by');
      }
    },
  });
};
</script>

<template>
  <section>
    <form class="mt-4 space-y-4" @submit.prevent="createBooking">
      <div>
        <InputLabel for="vehicleId">Vehicle</InputLabel>
      </div>
      <Select v-model="selectedVehicleId">
        <SelectTrigger>
          <SelectValue placeholder="Select a vehicle" />
        </SelectTrigger>
        <SelectContent>
          <SelectGroup>
            <SelectItem
              v-for="vehicle in vehicles"
              :key="vehicle.id"
              :value="vehicle.id.toString()"
            >
              {{ vehicle.plateNumber }}
            </SelectItem>
          </SelectGroup>
        </SelectContent>
      </Select>

      <div class="space-y-4">
        <Label> Booking Date </Label>
        <Popover>
          <PopoverTrigger as-child>
            <Button
              variant="outline"
              :class="
                cn(
                  'w-full justify-start text-left font-normal',
                  !rangeDate && 'text-muted-foreground',
                )
              "
            >
              <CalendarIcon class="mr-2 size-4" />
              <template v-if="rangeDate.start">
                <template v-if="rangeDate.end">
                  {{ df.format(rangeDate.start.toDate(getLocalTimeZone())) }} -
                  {{ df.format(rangeDate.end.toDate(getLocalTimeZone())) }}
                </template>

                <template v-else>
                  {{ df.format(rangeDate.start.toDate(getLocalTimeZone())) }}
                </template>
              </template>
              <template v-else> Pick a date range </template>
            </Button>
          </PopoverTrigger>
          <PopoverContent class="w-auto p-0">
            <RangeCalendar
              v-model="rangeDate"
              :number-of-months="2"
              :disabled-dates="{
                before: today,
              }"
              @update:start-value="(startDate) => rangeDate.start"
            />
          </PopoverContent>
        </Popover>
      </div>

      <div>
        <InputLabel for="notes" value="Notes" />

        <Textarea
          id="notes"
          v-model="form.notes"
          type="text"
          required
          autocomplete="notes"
          class="mt-1 block w-full"
        />
      </div>

      <div class="flex items-center gap-4">
        <Button variant="outline" :disabled="form.processing">Save</Button>

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p
            v-if="form.recentlySuccessful"
            class="text-sm text-gray-600 dark:text-gray-400"
          >
            Saved.
          </p>
        </Transition>
      </div>
    </form>
  </section>
</template>
