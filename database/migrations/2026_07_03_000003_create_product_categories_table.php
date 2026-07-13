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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('meta_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'product_category_id')) {
                $table->foreignId('product_category_id')
                    ->nullable()
                    ->after('quantity')
                    ->constrained('product_categories')
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'product_category_id')) {
                $table->dropConstrainedForeignId('product_category_id');
            }
        });

        Schema::dropIfExists('product_categories');
    }
};
