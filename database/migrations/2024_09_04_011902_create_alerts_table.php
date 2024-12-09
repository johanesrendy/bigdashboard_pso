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
    Schema::create('alerts', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('admin_id');
        $table->string('alert_type'); // Jenis alert (contoh: 'Import Error', 'Lead Follow-up')
        $table->text('message'); // Pesan detail notifikasi
        $table->timestamps();

        // Foreign key constraint
        $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
