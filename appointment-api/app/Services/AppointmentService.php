<?php

namespace App\Services;

use App\Models\Appointment;
use App\Repositories\AppointmentRepository;

class AppointmentService
{
    private AppointmentRepository $repository;

    public function __construct(AppointmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(int $page, int $limit, string $status)
    {
        return $this->repository->getAll($page, $limit, $status);
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {

        if (!$this->isDoctorAvailable($data['doctor_id'], $data['date'])) {
            throw new \Exception('Já existe um agendamento neste horário.');
        }

        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        if (!$this->isDoctorAvailable($data['doctor_id'], $data['date'], $data['id'])) {
            throw new \Exception('Já existe um agendamento neste horário.');
        }

        return $this->repository->update($id, $data);
    }

    public function delete(int $id)
    {

        return $this->repository->delete($id);
    }

    public function isDoctorAvailable(int $doctorId, string $date, ?int $excludeAppointmentId = null): bool
    {
        $query = Appointment::where('doctor_id', $doctorId)
            ->where('date', $date);

        if ($excludeAppointmentId) {
            $query->where('id', '!=', $excludeAppointmentId);
        }

        return $query->get()->isEmpty();
    }
}
