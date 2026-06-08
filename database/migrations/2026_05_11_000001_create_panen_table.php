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
        // Pastikan tabel 'panen' sudah ada, jika belum gunakan Schema::create
        // Jika tabel sudah ada dan ingin menambah kolom, gunakan Schema::table
        Schema::table('panen', function (Blueprint $table) {
            // Menambahkan kolom foto bukti (disimpan sebagai string path)
            $table->string('foto_bukti')->nullable()->after('keterangan');
            
            // Menambahkan kolom catatan penolakan
            $table->text('catatan_penolakan')->nullable()->after('status');
            
            // Mengubah tipe enum status untuk menyertakan 'Rejected'
            // Catatan: DB MySQL/MariaDB mendukung perubahan ini
            $table->enum('status', ['Pending', 'Verified', 'Rejected'])->default('Pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('panen', function (Blueprint $table) {
            // Mengembalikan status ke semula jika di-rollback
            $table->enum('status', ['Pending', 'Verified'])->default('Pending')->change();
            
            // Menghapus kolom yang ditambahkan
            $table->dropColumn(['foto_bukti', 'catatan_penolakan']);
        });
    }
};