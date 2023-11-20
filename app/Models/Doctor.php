<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "subtitle",
        "specialty",
        "image",
    ];

    public function Times()
    {
        return $this->hasMany(Time::class);
    }

    public function Reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
