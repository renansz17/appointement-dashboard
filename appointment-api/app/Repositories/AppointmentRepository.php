<?php

namespace App\Repositories;

use App\Models\Appointment;

class AppointmentRepository
{
    public function getAll(int $page, int $limit, string $status) {
        $query = Appointment::with(['patient:id,name', 'doctor:id,name']);

        if (!empty($status)) {
            $query->where('status', $status);
        }

        return $query->paginate($limit, ['*'], 'page', $page);
    }

    public function find(int $id)
    {
        return Appointment::with(['patient:id,name', 'doctor:id,name'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Appointment::create($data);
    }

    public function update(int $id, array $data)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->update($data);
    }

    public function delete(int $id)
    {
        $appointment = Appointment::findOrFail($id);

        return $appointment->delete();
    }
}
