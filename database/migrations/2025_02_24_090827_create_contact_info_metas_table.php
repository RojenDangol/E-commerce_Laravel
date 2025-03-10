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
        Schema::create('contact_info_metas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_info_id');
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->foreign('contact_info_id')
              ->references('id')
              ->on('contact_information')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_info_metas');
    }
};
