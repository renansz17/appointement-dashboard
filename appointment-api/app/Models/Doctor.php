<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
