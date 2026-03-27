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
        Schema::create('schedule_exceptions', function (Blueprint $table) {
            $table->id();
            $table->morphs('bookable'); // المورد (طبيب، ملعب، الخ)

            // استبدال exception_date بنطاق زمني
            $table->date('start_date'); // بداية الإجازة/الاستثناء
            $table->date('end_date');   // نهاية الإجازة/الاستثناء

            $table->boolean('is_closed')->default(true);
            $table->time('start_time')->nullable(); // يستخدم فقط إذا لم يكن مغلقاً بالكامل
            $table->time('end_time')->nullable();   // يستخدم فقط إذا لم يكن مغلقاً بالكامل

            $table->string('reason')->nullable();
            $table->timestamps();

            // منع تكرار نفس الاستثناء لنفس المورد في نفس النطاق الزمني
            $table->unique(['bookable_id', 'bookable_type', 'start_date', 'end_date'], 'bookable_exception_range_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_exceptions');
    }
};
