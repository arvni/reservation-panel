<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FirstPageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('Welcome', ["doctors" => DoctorResource::collection(Doctor::with("Times")->get())]);
    }
}
