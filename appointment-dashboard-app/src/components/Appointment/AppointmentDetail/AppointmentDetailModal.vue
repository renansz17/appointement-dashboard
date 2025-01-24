<script setup lang="ts">
import { ref, watch } from 'vue';
import Dialog from 'primevue/dialog';
import { getAppointmentById } from "../../../../api/service/appointment.ts";
import type { Appointment } from '../../../../api/interfaces/Appointment.ts';
import { translateStatus } from '../../../../api/interfaces/Appointment.ts';
import { format } from 'date-fns';
import { pt } from 'date-fns/locale';

const props = defineProps<{
  appointmentId?: number;
  visibleModal: boolean;
  closeModal: () => void;
}>();

const appointment = ref<Appointment | null>(null);

watch(
  () => props.appointmentId,
  async (newId) => {
    if (newId !== undefined) {
      await fetchAppointment(newId);
    }
  },
  { immediate: true }
);

async function fetchAppointment(id: number) {
  try {
    const response = await getAppointmentById(id);
    appointment.value = response;
  } catch (error) {
    console.error('Erro ao buscar consulta:', error);
  }
}
const formatDate = (date: string) => {
  const parsedDate = new Date(date);
  return format(parsedDate, "dd/MM/yyyy - HH:mm", { locale: pt });
};

</script>

<template>
  <div class="dialog">
    <Dialog
      :visible="props.visibleModal"
      modal
      header="Informações da consulta"
      :style="{ width: '30rem', display: 'flex' }"
      @update:visible="props.closeModal"
      :draggable="false"
    >
      <template #default>
        <div v-if="appointment">
          <p>ID da Consulta: {{ appointment.id }}</p>
          <p>Paciente: {{ appointment.patient?.name }}</p>
          <p>Médico: {{ appointment.doctor?.name }}</p>
          <p>Data: {{ formatDate(appointment.date)}}</p>
          <p>Status: {{ translateStatus(appointment.status) }}</p>
        </div>
        <p v-else>Carregando informações...</p>
      </template>
    </Dialog>
  </div>
</template>

<style>
</style>
