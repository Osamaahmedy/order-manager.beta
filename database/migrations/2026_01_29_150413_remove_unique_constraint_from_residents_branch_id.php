<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            // 1. حذف الـ foreign key أولاً
            $table->dropForeign(['branch_id']); // أو استخدم اسم الـ constraint الكامل

            // 2. حذف الـ unique constraint
            $table->dropUnique('residents_branch_id_unique');

            // 3. إعادة إضافة الـ foreign key بدون unique
            $table->foreign('branch_id')
                  ->references('id')
                  ->on('branches')
                  ->onDelete('cascade'); // أو حسب احتياجك

            // 4. إضافة index عادي للأداء
            $table->index('branch_id');
        });
    }

    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            // عكس العمليات
            $table->dropForeign(['branch_id']);
            $table->dropIndex(['branch_id']);

            // إعادة الـ unique constraint
            $table->unique('branch_id');

            // إعادة الـ foreign key
            $table->foreign('branch_id')
                  ->references('id')
                  ->on('branches')
                  ->onDelete('cascade');
        });
    }
};
