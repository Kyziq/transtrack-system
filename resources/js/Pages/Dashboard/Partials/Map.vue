<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { GoogleMap, Marker, InfoWindow } from 'vue3-google-map';
import { Vehicle } from '@/types/Vehicle';

const center = { lat: 3.06834, lng: 101.506318 };
const vehicles = usePage().props.vehicles as unknown as Vehicle[];
const markerList = vehicles.map((vehicle) => ({
  id: vehicle.id,
  position: {
    lat: vehicle.latitude,
    lng: vehicle.longitude,
  },
  vehicle: {
    plateNumber: vehicle.plateNumber,
    brand: vehicle.brand,
    model: vehicle.model,
    color: vehicle.color,
  },
}));
</script>

<template>
  <GoogleMap
    api-key="AIzaSyAlOC3BikppdLBZA1yP2akQEmAhQok9F9Y"
    :center="center"
    :zoom="15"
    class="h-[500px] w-full"
  >
    <Marker
      v-for="marker of markerList"
      :key="marker.id"
      :options="{
        position: { lat: marker.position.lat, lng: marker.position.lng },
      }"
    >
      <InfoWindow>
        <div class="space-y-4 rounded p-2 dark:bg-gray-800">
          <div class="rounded-lg border-4 border-white bg-black p-2">
            <span class="text-3xl font-bold text-white"
              >{{ marker.vehicle.plateNumber }}
            </span>
          </div>
          <div class="flex flex-col">
            <div class="flex items-center space-x-2">
              <span class="text-lg font-semibold">{{
                marker.vehicle.brand
              }}</span>
              <span>{{ marker.vehicle.model }}</span>
            </div>
          </div>
        </div>
      </InfoWindow>
    </Marker>
  </GoogleMap>
</template>
