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
    Schema::table('panen', function (Blueprint $table) {
        // Menambahkan kolom foto_bukti (string/varchar)
        $table->string('foto_bukti')->nullable()->after('keterangan');
    });
}

public function down()
{
    Schema::table('panen', function (Blueprint $table) {
        $table->dropColumn('foto_bukti');
    });
}
};
