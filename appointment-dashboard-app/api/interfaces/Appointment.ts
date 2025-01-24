import { type Doctor } from "./Doctor";
import { type Patient } from "./Patient";

export  interface Appointment {
    id?: number;
    date?: string;
    status?: string;
    patient_id?: number;
    doctor_id?: number;
    patient?: Patient;
    doctor?: Doctor;
}

export interface AppointmentPaginate{
    current_page?:number;
    data?:Appointment[];
    per_page?:number;
    last_page?:number;
    total?:number;
}

enum AppointmentStatus {
    COMPLETED = "Concluído",
    SCHEDULED = "Agendado",
    CANCELED = "Cancelado",
}

export function translateStatus(status: string): string {
    const statusTranslations: Record<string, string> = {
      completed: "Concluído",
      scheduled: "Agendado",
      canceled: "Cancelado",
    };
  
    return statusTranslations[status] || "Status desconhecido";
}

export function translateStatusToEnglish(status: string): string {
    const statusTranslations: Record<string, string> = {
      "Concluído": "completed",
      "Agendado": "scheduled",
      "Cancelado": "canceled",
    };
  
    return statusTranslations[status] || "unknown status";
  }