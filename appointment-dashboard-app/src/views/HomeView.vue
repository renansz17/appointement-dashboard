<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { RouterLink, RouterView, useRouter } from 'vue-router'
import DataTable from 'primevue/datatable';
import InputText from 'primevue/inputtext';
import Column from 'primevue/column';
import Menu from 'primevue/menu';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import AppointmentDetailModal from '@/components/Appointment/AppointmentDetail/AppointmentDetailModal.vue';

import { format } from 'date-fns';
import { is, pt } from 'date-fns/locale';
import { PhPlus } from '@phosphor-icons/vue';
import { PhDotsThreeVertical } from '@phosphor-icons/vue';
import { type AppointmentPaginate, translateStatus } from "../../api/interfaces/Appointment.ts"
import { getAppointments, deleteAppointment } from "../../api/service/appointment.ts"


const value = ref(null);
const appointments = ref<AppointmentPaginate>();
const selectedAppointment = ref<number>();
const appointmentDetailsId = ref<number>();
const visibleModalDelete = ref<boolean>(false);
const visibleModal = ref<boolean>(false);
const router = useRouter();


onMounted(async () => {
  fetchAppointments();
});

async function fetchAppointments(page: number = 1) {
  try {
    const response = await getAppointments(1, 100);
    appointments.value = response;
    console.log(appointments.value);
  } catch (error) {
    console.error('Erro ao buscar compromissos:', error);
  }
}

const menu = ref();
const items = ref([
    {
      label: 'Ações',
      items: [
          {
            label: 'Editar',
            icon: 'pi pi-pencil',
            command: () => goToAppointmentDetails(selectedAppointment.value)
            
          },
          {
            label: 'Excluir',
            icon: 'pi pi-trash',
            command: () => visibleModalDelete.value = true
          }
      ]
    }
]);

const toggle = (event: MouseEvent, id: number) => {
  selectedAppointment.value = id;
  menu.value.toggle(event);
};
const formatDate = (date: string) => {
  const parsedDate = new Date(date);
  return format(parsedDate, "dd/MM/yyyy - HH:mm", { locale: pt });
};

async function onDeleteAppointment() {
  try {
    const response = await deleteAppointment(selectedAppointment.value);
    console.log(response.data);
    await fetchAppointments(1);
    visibleModalDelete.value = false;
    
  } catch (error) {
    console.error('Erro ao buscar compromissos:', error);
  }
}

function goToAppointmentDetails (id?: number)  {
  router.push(`/appointment/edit/${id}`);  
};

function openAppointmentModal(id?:number) {
  
  appointmentDetailsId.value = id;
  
  visibleModal.value = true;
}
function closeAppointmentModal() {
  visibleModal.value = false;
  appointmentDetailsId.value = undefined;
}
</script>

<template>
    <div class="container">
      <div class="filters">
        <div class="title">
          <h2>Consultas</h2>
          <RouterLink to="/appointment/create">
            <PhPlus size="22" />
          </RouterLink>
        </div>
        <InputText type="text" v-model="value" variant="filled" placeholder="Busque o nome do paciente" class="filterInput"/>
      </div>
      <div class="table">
        <DataTable removableSort tableStyle="min-width: 50rem;height:32rem " size="large" 
          :value="appointments?.data" paginator :total-records="appointments?.total" :rows="10">
          <Column header="ID">
            <template #body="slotProps">
              <span style="cursor: pointer;" @click="openAppointmentModal(slotProps.data.id)">{{ slotProps.data.id }}</span>
            </template>
          </Column>
          <Column field="patient.name" sortable header="Paciente"></Column>
          <Column field="doctor.name" sortable header="Médico"></Column>
          <Column header="Data">
            <template #body="slotProps">
              <span>{{ formatDate(slotProps.data.date) }}</span>
            </template>
          </Column>
          <Column header="Status" sortable>
            <template #body="slotProps">
              <span :class="['status-badge', slotProps.data.status]">
                {{ translateStatus(slotProps.data.status) }}
              </span>
            </template>
          </Column>
          <Column>
            <template #body="appointment">
              <div @click="toggle($event, appointment.data.id)" class="menuActions">
                <PhDotsThreeVertical :size="32" color="white" />
              </div>
              <Menu 
                ref="menu" 
                id="overlay_menu" 
                :model="items" 
                :popup="true" 
              />
            </template>
          </Column>
        </DataTable>
      </div>
    </div>
    <div class="dialog">
      <Dialog v-model:visible="visibleModalDelete" modal header="Deletar" :style="{ width: '20rem', display: 'flex' }" :draggable="false">
          <p class="centered-p">Deseja excluir a consulta?</p>
          <div class="dialogButton">
            <Button label="Sim" severity="success" @click="onDeleteAppointment"/>
            <Button label="Não" severity="danger" @click="visibleModalDelete = false"/>
          </div>
      </Dialog>
    </div>
    <AppointmentDetailModal :visible-modal="visibleModal" :appointment-id="appointmentDetailsId" :close-modal="closeAppointmentModal"/>

</template>

<style lang="scss">
  .container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    
    .filters {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: flex-start;
      height: 30px;
    }
    .title {
      display: flex;
      align-items: center;
      h2 {
        padding-right: 10px;
        color: #f8fafc;
        font-weight: bold;
      }
      svg {
        cursor: pointer;
        position: relative;
        top: 2px;
      }
    }
  }
  .filterInput {
    width: 230px;
  }
  .table {
    margin-top: 40px;
  }
  .status-badge {
  padding: 0.4rem 0.8rem;
  border-radius: 0.5rem;
  font-size: 0.85rem;
  text-align: center;
  color: white;
}

.status-badge.completed {
  background-color: #28a745;
}

.status-badge.scheduled {
  background-color: #ffc107;
  color: #212529;
}

.status-badge.canceled {
  background-color: #dc3545;
}

.menuActions {
  cursor: pointer;
}

.p-datatable-tbody > tr {
background: none !important;

}
.p-datatable-header-cell {
  background: none !important;
}
.p-paginator {
  background: none !important;
}
.dialogButton {
  display: flex;
  justify-content: space-around;
}
.p-button-success {
  background: #28a745 !important;
  border: 1px solid #28a745 !important;
  color: white !important;
}

.p-button-danger {
  background: #dc3545 !important;
  border: 1px solid #dc3545 !important;
  color: white !important;
}

.centered-p {
  display: flex;
  align-items: center;
  justify-content: center;
  padding-bottom: 10px;
}

</style>
