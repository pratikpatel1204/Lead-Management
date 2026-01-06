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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('name');
            $table->string('role');
            $table->string('email')->unique();
            $table->string('password');

            $table->string('personal_email')->nullable();
            $table->string('mobile');
            $table->string('whatsapp_number')->nullable();

            $table->text('address');
            $table->foreignId('state_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->string('pincode');

            $table->foreignId('reporting_manager')->nullable()->references('id')->on('users');

            $table->string('pan_number')->nullable();
            $table->string('pan_image')->nullable();

            $table->string('aadhar_number')->nullable();
            $table->string('aadhar_image')->nullable();

            $table->string('profile_image')->nullable();
            $table->boolean('status')->default(1);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
