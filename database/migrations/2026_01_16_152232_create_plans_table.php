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
       // Migration: create_plans_table
Schema::create('plans', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2);
    $table->enum('interval', ['monthly', 'yearly', 'lifetime']);
    $table->integer('max_branches')->nullable(); // عدد الفروع المسموح
    $table->integer('max_residents')->nullable(); // عدد المقيمين المسموح
    $table->integer('max_orders_per_month')->nullable();
    $table->json('features')->nullable();
    $table->boolean('is_active')->default(true);
    $table->integer('trial_days')->default(0);
    $table->timestamps();
});

// Migration: create_subscriptions_table
Schema::create('subscriptions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('admin_id')->constrained()->cascadeOnDelete();
    $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
    $table->timestamp('trial_ends_at')->nullable();
    $table->timestamp('starts_at');
    $table->timestamp('ends_at')->nullable();
    $table->timestamp('canceled_at')->nullable();
    $table->enum('status', ['active', 'canceled', 'expired', 'suspended'])->default('active');
    $table->timestamps();
    $table->softDeletes();
});

// Migration: create_subscription_usage_table
Schema::create('subscription_usage', function (Blueprint $table) {
    $table->id();
    $table->foreignId('subscription_id')->constrained()->cascadeOnDelete();
    $table->string('feature'); // 'branches', 'residents', 'orders'
    $table->integer('used')->default(0);
    $table->date('reset_at')->nullable(); // لإعادة تعيين الاستخدام شهرياً
    $table->timestamps();
});

// Migration: إضافة حقل is_active للفروع والمقيمين
Schema::table('branches', function (Blueprint $table) {
    $table->boolean('is_active')->default(true)->after('location');
});

Schema::table('residents', function (Blueprint $table) {
    $table->boolean('is_active')->default(true)->after('branch_id');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
