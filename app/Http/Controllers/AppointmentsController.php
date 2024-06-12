<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        return Appointment::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'doctor' => 'required|string',
            'patient_id' => 'required|exists:patients,id'
        ]);

        return Appointment::create($validated);
    }

    public function show($id)
    {
        return Appointment::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());
        return $appointment;
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return response()->noContent();
    }
}
