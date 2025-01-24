<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import InputText from "primevue/inputtext";
import Select from "primevue/select";
import DatePicker from "primevue/datepicker";
import Button from "primevue/button";
import { updateAppointment, createAppointment, getAppointmentById } from "../../api/service/appointment.ts";
import type { Appointment } from "../../api/interfaces/Appointment.ts";
import { translateStatus, translateStatusToEnglish } from "../../api/interfaces/Appointment.ts";

const route = useRoute();
const patientName = ref<string | null>(null);
const doctorName = ref<string | null>(null);
const status = ref<string | null>(null);
const appointmentDate = ref<Date | null>(null);

const statusOptions = [
  { label: "Agendado", value: "scheduled" },
  { label: "Concluído", value: "completed" },
  { label: "Cancelado", value: "canceled" },
];

const appointmentId = ref<number | null>(Number(route.params.id));

onMounted(async () => {
  if (appointmentId.value) {
    await fetchAppointment(appointmentId.value);
  }
});

async function fetchAppointment(id: number) {
  try {
    const appointment = await getAppointmentById(id);
    patientName.value = appointment.patient.name;
    doctorName.value = appointment.doctor.name;
    status.value = translateStatus(appointment.status);
    appointmentDate.value = new Date(appointment.date);
  } catch (error) {
    console.error("Erro ao buscar a consulta:", error);
    alert("Erro ao buscar a consulta. Verifique o ID e tente novamente.");
  }
}

async function saveChanges() {
  if (!patientName.value || !doctorName.value || !status.value || !appointmentDate.value) {
    alert("Por favor, preencha todos os campos.");
    return;
  }
  
  const data: Appointment = {
    patient: { name: patientName.value },
    doctor: { name: doctorName.value },
    status: status.value.value,
    date: appointmentDate.value.toISOString(),
  };
  
  try {
    if (!isNaN(appointmentId.value)) {
      await updateAppointment(appointmentId.value, data);
      alert("Consulta atualizada com sucesso!");
    } else {
      await createAppointment(data);
      alert("Consulta criada com sucesso!");
    }
  } catch (error) {
    console.error("Erro ao salvar a consulta:", error);
    alert("Erro ao salvar a consulta. Verifique os dados e tente novamente.");
  }
}

function cancelEdit() {
  
}
</script>

<template>
  <div class="edit-form-container">
    <h2>{{ appointmentId ? 'Editar Consulta' : 'Criar Consulta' }}</h2>
    <form class="edit-form">
      <div class="form-field">
        <label for="patientName">Nome do Paciente</label>
        <InputText id="patientName" v-model="patientName" placeholder="Digite o nome do paciente" />
      </div>

      <div class="form-field">
        <label for="doctorName">Nome do Médico</label>
        <InputText id="doctorName" v-model="doctorName" placeholder="Digite o nome do médico" />
      </div>

      <div class="form-field">
        <label for="status">Status</label>
        <Select id="status"
        :options="statusOptions"
        placeholder="Selecione o status" 
        v-model:="status"
        optionLabel="label"
        />
      
      </div>

      <div class="form-field">
        <label for="appointmentDate">Data e Hora</label>
        <DatePicker
          id="appointmentDate"
          v-model="appointmentDate"
          showTime
          hourFormat="24"
          placeholder="Selecione a data e hora"
        />
      </div>

      <div class="form-actions">
        <Button label="Salvar" icon="pi pi-check" class="p-button-success" @click.prevent="saveChanges" />
        <Button label="Cancelar" icon="pi pi-times" class="p-button-danger" @click.prevent="cancelEdit" />
      </div>
    </form>
  </div>
</template>

<style lang="scss">
.edit-form-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 2rem;

  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);

  h2 {
    text-align: center;
    margin-bottom: 1.5rem;
    font-weight: bold;
  }
}

.edit-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-field {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;

  label {
    font-weight: bold;
    color: #555;
  }

  input,
  .p-select,
  .p-datepicker {
    width: 100%;
  }
}

.form-actions {
  display: flex;
  justify-content: space-between;

  .p-button {
    width: 48%;
  }
}
</style>
