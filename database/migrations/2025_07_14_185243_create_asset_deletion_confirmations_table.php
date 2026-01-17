<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('asset_deletion_confirmations', function (Blueprint $table) {
        $table->foreignId('requested_by')->nullable()->constrained('users')->cascadeOnDelete();
    });
}

public function down()
{
    Schema::table('asset_deletion_confirmations', function (Blueprint $table) {
        $table->dropForeign(['requested_by']);
        $table->dropColumn('requested_by');
    });
}

};
