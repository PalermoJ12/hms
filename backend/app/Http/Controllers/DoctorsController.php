<?php

namespace App\Http\Controllers;

use App\Models\Doctors;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorsController extends Controller
{
    public function index()
    {
        $doctors = Doctors::all();
        return response()->json($doctors);
    }

    public function store(Request $request)
    {        
        $doctor = Doctors::create($request->all());

        return response()->json($doctor);
    }

    public function show($id)
    {
        $doctor = Doctors::findOrFail($id);
        return response()->json($doctor);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'specialization' => 'required|string|max:255',
        //     'phone' => 'required|string|max:15',
        //     'email' => 'required|email|unique:doctors,email,' . $id,
        // ]);

        $doctor = Doctors::findOrFail($id);
        $doctor->update($request->all());

        return response()->json($doctor, 200);
    }

    public function destroy($id)
    {
        $doctor = Doctors::findOrFail($id);
        $doctor->delete();

        return response()->json(null, 204);
    }
}