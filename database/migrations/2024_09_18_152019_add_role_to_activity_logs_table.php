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
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->string('role')->after('activity'); // Kolom untuk jabatan pengguna
        });
    }

    public function down()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
