<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('storage_backups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->string('storage_type'); // local, s3, ftp, etc.
            $table->json('folders')->nullable(); // Liste des dossiers sauvegardés
            $table->json('metadata')->nullable(); // Informations supplémentaires
            $table->timestamp('created_at');
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('storage_backups');
    }
}; 