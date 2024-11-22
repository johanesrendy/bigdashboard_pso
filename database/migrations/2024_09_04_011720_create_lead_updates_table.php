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
        Schema::create('lead_updates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('admin_id');
            $table->enum('status', ['Hot Leads', 'Warm Leads', 'Cold Leads']);
            $table->date('follow_up_date')->nullable(); // Kolom untuk tanggal follow-up
            $table->text('notes')->nullable(); // Kolom untuk catatan tambahan
            $table->unsignedBigInteger('pic_assigned')->nullable(); // Kolom untuk PIC yang ditugaskan
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pic_assigned')->references('id')->on('users')->onDelete('set null'); // Menetapkan null jika PIC dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_updates');
    }
};
