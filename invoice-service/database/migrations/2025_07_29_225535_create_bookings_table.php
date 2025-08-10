<?php
    // database/migrations/2024_01_20_create_bookings_table.php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->uuid()->unique();
                $table->string('client_name');
                $table->string('client_phone');
                $table->string('client_email')->nullable();
                $table->foreignId('service_id')->constrained()->onDelete('cascade');
                $table->date('booking_date');
                $table->time('booking_time');
                $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('bookings');
        }
    };
