<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('panen', function (Blueprint $table) {
            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('panen', 'catatan_penolakan')) {
                $table->text('catatan_penolakan')->nullable()->after('status');
            }
        });
    }

    public function down()
    {
        Schema::table('panen', function (Blueprint $table) {
            $table->dropColumn('catatan_penolakan');
        });
    }
};