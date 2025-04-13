<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('backup_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('frequency'); // hourly, daily, weekly, monthly
            $table->string('time')->nullable(); // Pour daily/weekly/monthly
            $table->string('day')->nullable(); // Pour weekly/monthly
            $table->json('folders')->nullable();
            $table->string('storage_type');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_run_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('backup_schedules');
    }
}; 