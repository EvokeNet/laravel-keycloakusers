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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('realm');
            $table->text('client_id');
            $table->text('client_secret');
            $table->text('token')->nullable();
            $table->string('expires')->nullable();
            $table->integer('moodle_courseid')->nullable();
            $table->integer('moodle_coursetemplateid')->nullable();
            $table->string('moodle_courseshortname')->nullable();
            $table->string('moodle_coursefullname')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
