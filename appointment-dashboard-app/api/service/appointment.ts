import { api } from "../axios/api";
import type { Appointment } from "../interfaces/Appointment.ts";

const BASE_URL = 'appointments';

export async function getAppointments(
    page?: number,
    limit?: number,
    status?: string 
): Promise<any> {
    try {
        const response = await api.get('appointments', {
            params: { page, limit, status },
        });
        return response.data;
    } catch (error) {
        throw error;
    }
}


export async function createAppointment(data: Appointment): Promise<any> {
    try {
        const response = await api.post('appointments', data);
        return response.data;
    } catch (error) {
        throw error;
    }
}


export async function getAppointmentById(id?: number): Promise<any> {
    try {
        const response = await api.get(`appointments/${id}`);
        return response.data;
    } catch (error) {
        throw error;
    }
}


export async function updateAppointment(id: number, data: Appointment): Promise<any> {
    try {
        const response = await api.put(`appointments/${id}`, data);
        return response.data;
    } catch (error) {
        throw error;
    }
}

export async function deleteAppointment(id?: number): Promise<any> {
    try {
        const response = await api.delete(`appointments/${id}`);
        return response.data;
    } catch (error) {
        throw error;
    }
}