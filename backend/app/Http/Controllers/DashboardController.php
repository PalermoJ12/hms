<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\MedicalRecords;
use App\Models\Patients;
use App\Models\Doctors;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $appointments = Appointments::where('status', 'booked')->count();
        $medicalRecords = MedicalRecords::all()->count();
        $patients = Patients::all()->count();
        $doctors = Doctors::all()->count();
        $users = User::all()->count();
        return response([
            'appointments' => $appointments,
            'medicalRecords' => $medicalRecords,
            'patients' => $patients,
            'doctors' => $doctors,
            'users' => $users
        ]);
    }

    public function doctorDashboard(Request $request)
    {

        $doctor = Doctors::where('user_id', $request->user()->id)->first();
        if (!$doctor) {
            return response([
                'message' => 'Doctor not found'
            ], 404);
        }
        $appointments = Appointments::where('doctors_id', $doctor->id)->where('status', 'booked')->count();
        $patients = Patients::all()->count();
        $records = Patients::whereHas('medicalRecords', function ($query) use ($doctor) {
            $query->where('doctors_id', $doctor->id);
        })->count();
        return response([
            'appointments' => $appointments,
            'records' => $records,
            'patients' => $patients
        ]);
    }
}
