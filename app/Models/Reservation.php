<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        "firstName",
        "lastName",
        "email",
        "mobile",
        "locked",
        "verified",
        "verified_at"
    ];

    public function Time()
    {
        return $this->belongsTo(Time::class);
    }

    public function Doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function scopeVerified($query)
    {
        return $query->where("verify", true);
    }

    public function VerificationRequests()
    {
        return $this->hasMany(VerificationRequest::class);
    }
}
