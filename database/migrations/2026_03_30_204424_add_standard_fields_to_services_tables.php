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
        // 1. تحديث جدول الأطباء
        Schema::table('doctors', function (Blueprint $table)
        {
            $table->string('location')->nullable()->after('specialization');
            $table->text('bio')->nullable()->after('location');
            $table->jsonb('details')->nullable()->after('bio');
        });

        // 2. تحديث جدول الملاعب (يمتلك location مسبقاً)
        Schema::table('stadiums', function (Blueprint $table)
        {
            $table->text('bio')->nullable()->after('location');
            $table->jsonb('details')->nullable()->after('bio');
        });

        // 3. تحديث جدول الخدمات المخصصة (يمتلك details مسبقاً)
        Schema::table('custom_services', function (Blueprint $table)
        {
            $table->string('location')->nullable()->after('category_name');
            $table->text('bio')->nullable()->after('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table)
        {
            $table->dropColumn(['location', 'bio', 'details']);
        });

        Schema::table('stadiums', function (Blueprint $table)
        {
            $table->dropColumn(['bio', 'details']);
        });

        Schema::table('custom_services', function (Blueprint $table)
        {
            $table->dropColumn(['location', 'bio']);
        });
    }
};
