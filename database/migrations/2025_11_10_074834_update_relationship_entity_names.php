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
        Schema::table('relationships', function (Blueprint $table) {
            $table->dropForeign(['entity_from']);
            $table->dropForeign(['entity_to']);

            $table->renameColumn('entity_from', 'source');
            $table->renameColumn('entity_to', 'target');
        });

        Schema::table('relationships', function (Blueprint $table) {
            $table->foreign('source')->references('id')->on('entities')->cascadeOnDelete();
            $table->foreign('target')->references('id')->on('entities')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relationships', function (Blueprint $table) {
            $table->dropForeign(['source']);
            $table->dropForeign(['target']);

            $table->renameColumn('source', 'entity_from');
            $table->renameColumn('target', 'entity_to');
        });

        Schema::table('relationships', function (Blueprint $table) {
            $table->foreign('entity_from')->references('id')->on('entities')->cascadeOnDelete();
            $table->foreign('entity_to')->references('id')->on('entities')->cascadeOnDelete();
        });
    }
};
