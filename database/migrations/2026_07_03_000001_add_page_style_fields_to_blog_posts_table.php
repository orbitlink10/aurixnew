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
        Schema::table('blog_posts', function (Blueprint $table) {
            if (! Schema::hasColumn('blog_posts', 'image_alt_text')) {
                $table->string('image_alt_text')->nullable()->after('cover_image');
            }

            if (! Schema::hasColumn('blog_posts', 'heading')) {
                $table->string('heading')->nullable()->after('image_alt_text');
            }

            if (! Schema::hasColumn('blog_posts', 'content_type')) {
                $table->string('content_type')->default('Post')->after('heading');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            if (Schema::hasColumn('blog_posts', 'content_type')) {
                $table->dropColumn('content_type');
            }

            if (Schema::hasColumn('blog_posts', 'heading')) {
                $table->dropColumn('heading');
            }

            if (Schema::hasColumn('blog_posts', 'image_alt_text')) {
                $table->dropColumn('image_alt_text');
            }
        });
    }
};
