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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 15)->nullable();
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('picture_id')->nullable();
            $table->integer('age')->nullable();
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('picture_id')->references('id')->on('pictures')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['address_id']);
            $table->dropForeign(['picture_id']);
        });

        Schema::dropIfExists('clients');
    }
};
