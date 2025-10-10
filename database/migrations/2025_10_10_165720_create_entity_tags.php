<?php

use App\Models\Entity;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('entity_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tag::class, 'tag_id')->constrained('tags')->cascadeOnDelete();
            $table->foreignIdFor(Entity::class, 'entity_id')->constrained('entities')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['entity_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entity_tags');
    }
};
