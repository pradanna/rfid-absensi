<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['nip', 'name', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'no_hp', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(ScheduleSubject::class);
    }
}
