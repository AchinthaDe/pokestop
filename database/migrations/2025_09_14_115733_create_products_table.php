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
    Schema::create('products', function (Blueprint $t) {
        $t->id();
        $t->foreignId('category_id')->nullable()->constrained('product_categories')->nullOnDelete();
        $t->string('pokemon_name');
        $t->string('card_name')->nullable();
        $t->string('grader')->nullable();
        $t->unsignedSmallInteger('grade')->nullable();
        $t->string('set_name')->nullable();
        $t->string('card_number')->nullable();
        $t->year('release_year')->nullable();
        $t->string('edition')->nullable();
        $t->string('rarity')->nullable();
        $t->string('holofoil_type')->nullable();
        $t->string('art_style')->nullable();
        $t->string('artist_name')->nullable();
        $t->string('language')->nullable();
        $t->text('collector_info')->nullable();
        $t->decimal('price', 10, 2)->default(0);
        $t->integer('stock')->default(0);
        $t->string('image_url')->nullable();
        $t->timestamps();

        $t->index(['pokemon_name']);
        $t->index(['card_name']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('products');
    }
};
