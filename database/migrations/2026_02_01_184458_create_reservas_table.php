<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reserva', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iduser');
            $table->foreignId('idvacacion');
            $table->timestamps();

            $table->foreign('iduser')->references('id')->on('users');
            $table->foreign('idvacacion')->references('id')->on('vacacion');

            $table->unique(['iduser', 'idvacacion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserva');
    }
};