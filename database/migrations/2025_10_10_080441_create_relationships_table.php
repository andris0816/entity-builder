<?php

use App\Models\Entity;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Entity::class, 'entity_from')->constrained('entities')->cascadeOnDelete();
            $table->foreignIdFor(Entity::class, 'entity_to')->constrained('entities')->cascadeOnDelete();
            $table->string('type');
            $table->text('desc');
            $table->timestamps();

            $table->index(['entity_from', 'entity_to']);
            $table->unique(['entity_from', 'entity_to', 'type']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
