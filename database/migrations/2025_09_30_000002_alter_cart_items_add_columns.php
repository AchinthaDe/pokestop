<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('cart_items', function (Blueprint $table) {
            if (!Schema::hasColumn('cart_items','cart_id')) {
                $table->foreignId('cart_id')->after('id')->constrained('carts')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('cart_items','product_id')) {
                $table->foreignId('product_id')->after('cart_id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('cart_items','quantity')) {
                $table->unsignedInteger('quantity')->default(1)->after('product_id');
            }
            if (!Schema::hasColumn('cart_items','price')) {
                $table->decimal('price',10,2)->default(0)->after('quantity');
            }
            // prevent duplicates
            $table->unique(['cart_id','product_id'],'cart_items_cart_product_unique');
        });
    }

    public function down(): void {
        Schema::table('cart_items', function (Blueprint $table) {
            if (Schema::hasColumn('cart_items','cart_id')) {
                $table->dropForeign(['cart_id']);
            }
            if (Schema::hasColumn('cart_items','product_id')) {
                $table->dropForeign(['product_id']);
            }
            if (Schema::hasTable('cart_items')) {
                $table->dropUnique('cart_items_cart_product_unique');
            }
            foreach (['price','quantity','product_id','cart_id'] as $col) {
                if (Schema::hasColumn('cart_items',$col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};