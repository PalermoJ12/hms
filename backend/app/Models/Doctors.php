<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Appointments;
use App\Models\MedicalRecords;


class Doctors extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'profile',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointments::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecords::class);
    }
}
