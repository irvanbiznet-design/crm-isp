<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('olt_id')->constrained('olts')->onDelete('cascade');
            $table->string('serial_number')->unique();
            $table->integer('port');
            $table->enum('status', ['online', 'offline', 'los'])->default('offline');
            $table->float('rx_power')->nullable();
            $table->float('tx_power')->nullable();
            $table->boolean('los')->default(false);
            $table->float('temperature')->nullable();
            $table->float('voltage')->nullable();
            $table->float('distance')->nullable();
            $table->timestamp('last_online')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onus');
    }
};
