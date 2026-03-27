<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Stadium;
use Carbon\Carbon;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 1. إنشاء مستخدم ليقوم بالحجز
        $user = User::factory()->create([
            'name' => 'أحمد المبرمج',
            'email' => 'ahmed@example.com',
        ]);

        // 2. إنشاء طبيب
        $doctor = Doctor::create([
            'name' => 'د. خالد عبدالله',
            'specialization' => 'طبيب أسنان',
        ]);

        // 3. إنشاء ملعب
        $stadium = Stadium::create([
            'name' => 'ملعب الأبطال الخماسي',
            'location' => 'وسط المدينة',
        ]);

        // 4. حجز موعد للطبيب (لاحظ كيف نستخدم العلاقة appointments مباشرة!)
        $doctor->appointments()->create([
            'user_id' => $user->id,
            'start_time' => Carbon::tomorrow()->setTime(10, 0), // غداً الساعة 10 صباحاً
            'end_time' => Carbon::tomorrow()->setTime(10, 30),  // غداً الساعة 10:30 صباحاً
            'status' => 'confirmed',
            'total_price' => 100,
        ]);

        // 5. حجز موعد للملعب
        $stadium->appointments()->create([
            'user_id' => $user->id,
            'start_time' => Carbon::tomorrow()->setTime(18, 0), // غداً الساعة 6 مساءً
            'end_time' => Carbon::tomorrow()->setTime(20, 0),   // غداً الساعة 8 مساءً
            'status' => 'confirmed',
            'total_price' => 150.00,
        ]);
    }
}
