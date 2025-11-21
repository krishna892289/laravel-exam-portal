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
            // 1. ADD the column first. Make it nullable to avoid conflicts
            //    with existing rows that don't have a value yet.
            $table->unsignedBigInteger('test_id')->nullable()->after('id');
        });

        // 2. CLEAN UP the invalid data (now the column exists)
        //    We must also check for NULL values if we plan to make it NOT NULL later.
        DB::statement("
            DELETE FROM take_answers
            WHERE test_id IS NOT NULL
            AND test_id NOT IN (SELECT id FROM assigned_tests)
        ");

        Schema::table('take_answers', function (Blueprint $table) {
            // 3. ADD the Foreign Key constraint
            $table->foreign('test_id')
                  ->on('assigned_tests')
                  ->references('id')
                  ->cascadeOnDelete();

            // OPTIONAL: If test_id must be required, change it to NOT NULL now.
            // $table->unsignedBigInteger('test_id')->nullable(false)->change();
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
