<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('take_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('test_id')->nullable()->after('id');
        });
        DB::statement("
            DELETE FROM take_answers
            WHERE test_id IS NOT NULL
            AND test_id NOT IN (SELECT id FROM assigned_tests)
        ");

        Schema::table('take_answers', function (Blueprint $table) {
            $table->foreign('test_id')
                  ->on('assigned_tests')
                  ->references('id')
                  ->cascadeOnDelete()
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('take_answers', function (Blueprint $table) {
            $table->dropForeign(['test_id']);
            $table->dropColumn('test_id');
        });
    }
};
