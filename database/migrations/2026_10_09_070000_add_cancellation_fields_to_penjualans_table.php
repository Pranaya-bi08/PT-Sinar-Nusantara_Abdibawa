<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->string('status')->default('aktif');
            $table->timestamp('dibatalkan_pada')->nullable();
            $table->text('alasan_pembatalan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->dropColumn(['status', 'dibatalkan_pada', 'alasan_pembatalan']);
        });
    }
};