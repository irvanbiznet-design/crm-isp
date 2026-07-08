<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('olts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ip_address');
            $table->integer('port')->default(161);
            $table->string('username')->nullable();
            $table->text('password')->nullable();
            $table->enum('vendor', ['huawei', 'zte', 'fiberhome', 'vsol', 'c-data']);
            $table->string('model')->nullable();
            $table->enum('status', ['online', 'offline'])->default('offline');
            $table->float('cpu')->nullable();
            $table->float('memory')->nullable();
            $table->float('temperature')->nullable();
            $table->timestamp('last_sync')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('olts');
    }
};
