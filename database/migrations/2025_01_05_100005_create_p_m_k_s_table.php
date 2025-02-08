<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('p_m_k_s', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->constrained('data_karyawans', 'nik')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('departemen_id');
            $table->datetime('tanggal');
            $table->string('no_pmk');
            $table->string('mutasi');
            $table->string('uraian');
            $table->string('catatan');
            $table->tinyInteger('approved_by_leader')->default(0);
            $table->tinyInteger('approved_by_asst_manager')->default(0);
            $table->tinyInteger('approved_by_hrd')->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('p_m_k_s', function (Blueprint $table) {
            $table->dropColumn(['approved_by_leader', 'approved_by_asst_manager', 'approved_by_hrd', 'status']);
        });
    }
};
