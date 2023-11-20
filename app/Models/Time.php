<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "started_at",
        "ended_at",
        "disabled",
    ];

    protected $casts=[
        "disabled"=>"boolean"
    ];

    public function Doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function Reservation()
    {
        return $this->hasOne(Reservation::class);
    }

    public function scopeActive($query)
    {
        return $query->where("disabled", false);
    }
}
