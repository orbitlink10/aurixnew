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
        Schema::table('leads', function (Blueprint $table) {
            if (! Schema::hasColumn('leads', 'company')) {
                $table->string('company')->nullable()->after('name');
            }

            if (! Schema::hasColumn('leads', 'product_name')) {
                $table->string('product_name')->nullable()->after('service_id');
            }

            if (! Schema::hasColumn('leads', 'quantity')) {
                $table->string('quantity')->nullable()->after('product_name');
            }

            if (! Schema::hasColumn('leads', 'customization')) {
                $table->text('customization')->nullable()->after('quantity');
            }

            if (! Schema::hasColumn('leads', 'deadline')) {
                $table->string('deadline')->nullable()->after('customization');
            }

            if (! Schema::hasColumn('leads', 'delivery_location')) {
                $table->string('delivery_location')->nullable()->after('deadline');
            }

            if (! Schema::hasColumn('leads', 'file_path')) {
                $table->string('file_path')->nullable()->after('delivery_location');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            foreach (['file_path', 'delivery_location', 'deadline', 'customization', 'quantity', 'product_name', 'company'] as $column) {
                if (Schema::hasColumn('leads', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
