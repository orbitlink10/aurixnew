<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            if (! Schema::hasColumn('product_categories', 'show_in_menu')) {
                $table->boolean('show_in_menu')->default(true)->after('image_path');
            }

            if (! Schema::hasColumn('product_categories', 'menu_sort_order')) {
                $table->unsignedInteger('menu_sort_order')->default(0)->after('show_in_menu');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            if (Schema::hasColumn('product_categories', 'menu_sort_order')) {
                $table->dropColumn('menu_sort_order');
            }

            if (Schema::hasColumn('product_categories', 'show_in_menu')) {
                $table->dropColumn('show_in_menu');
            }
        });
    }
};
