<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('comentario', function (Blueprint $table) {
            $table->integer('estrellas')->default(5)->after('texto');
        });
    }

    public function down(): void
    {
        Schema::table('comentario', function (Blueprint $table) {
            $table->dropColumn('estrellas');
        });
    }
};
