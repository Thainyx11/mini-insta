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
    Schema::table('follows', function (Blueprint $table) {
        $table->foreignId('follower_id')->constrained('users');
        $table->foreignId('followed_id')->constrained('users');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('follows', function (Blueprint $table) {
        $table->dropForeign(['follower_id']);
        $table->dropForeign(['followed_id']);
        $table->dropColumn(['follower_id', 'followed_id']);
    });
}


};
