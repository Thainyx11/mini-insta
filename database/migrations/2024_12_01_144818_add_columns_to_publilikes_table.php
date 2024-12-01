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
    Schema::table('publilikes', function (Blueprint $table) {
        $table->foreignId('publication_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('publilikes', function (Blueprint $table) {
        $table->dropForeign(['publication_id']);
        $table->dropForeign(['user_id']);
        $table->dropColumn(['publication_id', 'user_id']);
    });
}
};
