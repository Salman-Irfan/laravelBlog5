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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 30);
            $table->string('description');
            $table->enum('status', ['approved', 'rejected', 'makeModifications'])->default('makeModifications');
            $table->unsignedBigInteger('userId'); // Add the foreign key column
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade'); // Define the foreign key relationship
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
