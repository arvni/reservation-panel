<?php

use App\Models\Doctor;
use App\Models\Time;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid("id")->primary()->index()->unique();
            $table->foreignIdFor(Doctor::class)->constrained();
            $table->foreignIdFor(Time::class)->nullable()->constrained();
            $table->string("name");
            $table->string("mobile")->unique();
            $table->string("email")->nullable();
            $table->timestamp("verified_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
