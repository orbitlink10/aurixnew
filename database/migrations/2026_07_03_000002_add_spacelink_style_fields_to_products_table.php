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
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'marked_price')) {
                $table->decimal('marked_price', 12, 2)->nullable()->after('price');
            }

            if (! Schema::hasColumn('products', 'quantity')) {
                $table->unsignedInteger('quantity')->default(0)->after('marked_price');
            }

            if (! Schema::hasColumn('products', 'category_name')) {
                $table->string('category_name')->nullable()->after('quantity');
            }

            if (! Schema::hasColumn('products', 'subcategory_name')) {
                $table->string('subcategory_name')->nullable()->after('category_name');
            }

            if (! Schema::hasColumn('products', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('description');
            }

            if (! Schema::hasColumn('products', 'google_merchant')) {
                $table->boolean('google_merchant')->default(false)->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            foreach (['google_merchant', 'meta_description', 'subcategory_name', 'category_name', 'quantity', 'marked_price'] as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
