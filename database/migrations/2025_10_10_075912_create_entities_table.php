<?php

use App\Models\World;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('desc');
            $table->string('type');
            $table->foreignIdFor(World::class, 'world_id')->constrained('worlds')->cascadeOnDelete();
            $table->timestamps();

            $table->index('world_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};
