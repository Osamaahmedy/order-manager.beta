<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // احذف الجدول القديم
        Schema::dropIfExists('admin_branch');

        // أعد إنشاءه بالشكل الصحيح
        Schema::create('admin_branch', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_branch');

        // أعد الجدول الفارغ
        Schema::create('admin_branch', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};
