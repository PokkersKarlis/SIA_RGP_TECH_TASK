<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('search_histories', function (Blueprint $table) {
        $table->dropForeign(['session_id']);
    });
}

public function down(): void
{
    Schema::table('search_histories', function (Blueprint $table) {
        $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
    });
}
};
