<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctors;
use App\Models\Patients;

class MedicalRecords extends Model
{
    use HasFactory;
    protected $fillable = [
        'patients_id',
        'doctors_id',
        'record',
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
