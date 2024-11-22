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
        Schema::table('lead_updates', function (Blueprint $table) {
            $table->date('follow_up_date')->nullable()->after('status');
            $table->text('notes')->nullable()->after('follow_up_date'); 
            $table->unsignedBigInteger('pic_assigned')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('lead_updates', function (Blueprint $table) {
            $table->dropColumn(['follow_up_date', 'notes', 'pic_assigned']); // Menghapus kolom yang ditambahkan
        });
    }
};
