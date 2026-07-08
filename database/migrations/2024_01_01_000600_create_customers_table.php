<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_number')->unique();
            $table->string('name');
            $table->string('nik')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->text('address');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 10, 8)->nullable();
            $table->foreignId('area_id')->nullable()->constrained('areas')->onDelete('set null');
            $table->foreignId('package_id')->nullable()->constrained('internet_packages')->onDelete('set null');
            $table->enum('status', ['active', 'suspend', 'inactive'])->default('active');
            $table->date('subscription_date');
            $table->date('due_date');
            $table->string('pppoe_username')->nullable();
            $table->string('pppoe_password')->nullable();
            $table->foreignId('router_id')->nullable()->constrained('routers')->onDelete('set null');
            $table->foreignId('olt_id')->nullable()->constrained('olts')->onDelete('set null');
            $table->foreignId('onu_id')->nullable()->constrained('onus')->onDelete('set null');
            $table->string('olt_port')->nullable();
            $table->string('vlan')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
