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

        $this->call([
            RoleSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 1. إنشاء مستخدم ليقوم بالحجز
        $user = User::factory()->create([
            'name' => 'أحمد المبرمج',
            'email' => 'ahmed@example.com',
        ]);
        $user->assignRole('user');

        $doctor = User::factory()->create([
            'name' => 'khalid',
            'email' => 'khalid@example.com',
        ]);
        $doctor->assignRole('provider');

        // 2. إنشاء طبيب
        $doctorProfile = Doctor::create([
            'name' => 'د. خالد عبدالله',
            'specialization' => 'طبيب أسنان',
        ]);

        $doctor->profile()->associate($doctorProfile);
        $doctor->save();

        // 3. إنشاء ملعب
        $stadium = Stadium::create([
            'name' => 'ملعب الأبطال الخماسي',
            'location' => 'وسط المدينة',
        ]);

        // 4. حجز موعد للطبيب (لاحظ كيف نستخدم العلاقة appointments مباشرة!)
        // $doctor->appointments()->create([
        //     'user_id' => $user->id,
        //     'start_time' => Carbon::tomorrow()->setTime(10, 0), // غداً الساعة 10 صباحاً
        //     'end_time' => Carbon::tomorrow()->setTime(10, 30),  // غداً الساعة 10:30 صباحاً
        //     'status' => 'confirmed',
        //     'total_price' => 100,
        // ]);

        // 5. حجز موعد للملعب
        // $stadium->appointments()->create([
        //     'user_id' => $user->id,
        //     'start_time' => Carbon::tomorrow()->setTime(18, 0), // غداً الساعة 6 مساءً
        //     'end_time' => Carbon::tomorrow()->setTime(20, 0),   // غداً الساعة 8 مساءً
        //     'status' => 'confirmed',
        //     'total_price' => 150.00,
        // ]);

        // 3. إعدادات الجدولة (فترات ثابتة، كل 30 دقيقة)
        // $doctor->schedulingSetting()->create([
        //     'scheduling_type' => 'fixed_slots',
        //     'slot_duration' => 30,
        // ]);

        // 4. أوقات العمل (نحدد يوم الإثنين كمثال، رقمه 1 في Carbon)
        // $doctor->workingHours()->create([
        //     'day_of_week' => 1, // الإثنين
        //     'start_time' => '09:00:00',
        //     'end_time' => '12:00:00',
        //     'is_closed' => false,
        // ]);

        // تاريخ محدد للتجربة (يصادف يوم إثنين) لكي نستخدمه في الرابط
        $testDate = Carbon::parse('2026-04-06');

        // 5. الفخ! حجز موعد في منتصف الدوام (من 10:00 إلى 10:30)
        // $doctor->appointments()->create([
        //     'user_id' => $user->id,
        //     'start_time' => $testDate->copy()->setTime(10, 0),
        //     'end_time' => $testDate->copy()->setTime(10, 30),
        //     'status' => 'confirmed',
        //     'total_price' => 150.00,
        // ]);




        $this->command->info('✅ تم زرع البيانات بنجاح! جرب فحص التوافر ليوم 2026-04-06');
    }
}
