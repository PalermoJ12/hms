<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patients;
use App\Models\Doctors;

class Appointments extends Model
{
    use HasFactory;



    protected $fillable = [
        'patients_id',
        'doctors_id',
        'appointment_date',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patients::class, 'patients_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctors::class, 'doctors_id');
    }
}
