<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    private AppointmentService $service;

    public function __construct(AppointmentService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request): JsonResponse {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 10);
        $status = $request->query('status', '');
        $appointments = $this->service->getAll($page, $limit, $status);

        return response()->json($appointments, 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $appointment = $this->service->create($data);
            return response()->json($appointment, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(int $id)
    {
        $appointment = $this->service->find($id);
        return response()->json($appointment, 200);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->all();
        $appointment = $this->service->update($id, $data);
        return response()->json([
            'message' => 'Agendamento atualizado com sucesso!',
            'data' => $appointment
        ], 200);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Appointment deleted successfully'], 200);
    }
}
