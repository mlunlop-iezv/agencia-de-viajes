<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iduser');
            $table->foreignId('idvacacion');
            $table->text('texto');
            $table->timestamps();

            $table->foreign('iduser')->references('id')->on('users');
            $table->foreign('idvacacion')->references('id')->on('vacacion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentario');
    }
};