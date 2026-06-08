<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    // Mengubah status menjadi VARCHAR(20) agar bisa menerima 'Pending', 'Verified', 'Rejected'
    Schema::table('panen', function (Blueprint $table) {
        $table->string('status', 20)->default('Pending')->change();
    });
}

public function down()
{
    // Opsional: kembalikan ke ENUM jika perlu
    Schema::table('panen', function (Blueprint $table) {
        $table->enum('status', ['Pending', 'Verified'])->default('Pending')->change();
    });
}
};
