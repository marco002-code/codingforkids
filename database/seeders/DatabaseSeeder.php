<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\Participant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin Users
        User::updateOrCreate(
            ['email' => 'admin@muhijunior.id'],
            [
                'name' => 'Administrator Panitia Muhijunior',
                'password' => Hash::make('admin12345'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@codingforkids.id'],
            [
                'name' => 'Administrator Panitia',
                'password' => Hash::make('admin12345'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Default Settings with Dual Session (90 seats each)
        $settings = [
            ['key' => 'event_name', 'value' => 'Coding for Kids and A.I. for Learning', 'group' => 'event', 'label' => 'Nama Kegiatan'],
            ['key' => 'event_tagline', 'value' => 'Petualangan Seru Belajar Logika Coding & Eksplorasi A.I. Khusus Siswa SD Kelas 6', 'group' => 'event', 'label' => 'Tagline / Headline'],
            ['key' => 'event_subtitle', 'value' => 'Workshop interaktif, fun, dan 100% GRATIS dengan 2 pilihan sesi (Kapasitas terbatas 90 siswa per sesi).', 'group' => 'event', 'label' => 'Sub Headline'],
            ['key' => 'target_audience', 'value' => 'Siswa SD Kelas 6 (Tahun Ajaran 2026/2027)', 'group' => 'event', 'label' => 'Target Peserta'],
            ['key' => 'event_date', 'value' => 'Senin, 21 Desember 2026', 'group' => 'event', 'label' => 'Tanggal Pelaksanaan'],
            ['key' => 'event_location', 'value' => 'Lab Komputer & Auditorium Utama Kampus Muhijunior', 'group' => 'event', 'label' => 'Lokasi Kegiatan'],
            
            // Session 1 Config
            ['key' => 'session_1_name', 'value' => 'Sesi 1 (Pagi)', 'group' => 'session', 'label' => 'Nama Sesi 1'],
            ['key' => 'session_1_time', 'value' => '08:00 – 10:30 WIB', 'group' => 'session', 'label' => 'Waktu Sesi 1'],
            ['key' => 'session_1_quota', 'value' => '90', 'group' => 'quota', 'label' => 'Batas Kuota Utama Sesi 1'],
            ['key' => 'session_1_waitlist_quota', 'value' => '30', 'group' => 'quota', 'label' => 'Batas Kuota Cadangan Sesi 1'],
            
            // Session 2 Config
            ['key' => 'session_2_name', 'value' => 'Sesi 2 (Siang)', 'group' => 'session', 'label' => 'Nama Sesi 2'],
            ['key' => 'session_2_time', 'value' => '12:30 – 14:00 WIB', 'group' => 'session', 'label' => 'Waktu Sesi 2'],
            ['key' => 'session_2_quota', 'value' => '90', 'group' => 'quota', 'label' => 'Batas Kuota Utama Sesi 2'],
            ['key' => 'session_2_waitlist_quota', 'value' => '30', 'group' => 'quota', 'label' => 'Batas Kuota Cadangan Sesi 2'],

            ['key' => 'registration_status', 'value' => 'OPEN', 'group' => 'quota', 'label' => 'Status Pendaftaran (OPEN / CLOSED)'],
            ['key' => 'whatsapp_group_link', 'value' => 'https://chat.whatsapp.com/CodingKidsAI2026', 'group' => 'contact', 'label' => 'Link Grup WhatsApp Koordinasi'],
            ['key' => 'contact_whatsapp', 'value' => '081234567890', 'group' => 'contact', 'label' => 'Nomor WhatsApp Hotline Panitia'],
            ['key' => 'contact_email', 'value' => 'panitia@muhijunior.id', 'group' => 'contact', 'label' => 'Email Panitia'],
        ];

        foreach ($settings as $setting) {
            Setting::set($setting['key'], $setting['value'], $setting['group'], $setting['label']);
        }

        // 3. Demo Participants for Session 1 (08:00 - 10:30 WIB)
        $session1Participants = [
            ['student_name' => 'Muhammad Rizky Pratama', 'nickname' => 'Rizky', 'school_name' => 'SD Negeri Menteng 01', 'gender' => 'L', 'experience_level' => 'Pernah Sedikit', 'parent_name' => 'Budi Pratama', 'whatsapp' => '081234567801', 'email' => 'budi.pratama@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => true, 'attended_at' => now()->subMinutes(20)],
            ['student_name' => 'Aisyah Putri Rahmadani', 'nickname' => 'Aisyah', 'school_name' => 'SDIT Al-Azhar Rawamangun', 'gender' => 'P', 'experience_level' => 'Belum Pernah', 'parent_name' => 'Siti Rahmawati', 'whatsapp' => '081234567802', 'email' => 'siti.rahma@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => true, 'attended_at' => now()->subMinutes(15)],
            ['student_name' => 'Jonathan Nicholas Wijaya', 'nickname' => 'Nathan', 'school_name' => 'SD Kristen Penabur 3', 'gender' => 'L', 'experience_level' => 'Sudah Terbiasa', 'parent_name' => 'Hendrik Wijaya', 'whatsapp' => '081234567803', 'email' => 'hendrik.wijaya@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => false],
            ['student_name' => 'Farhan Aditia Putra', 'nickname' => 'Farhan', 'school_name' => 'SD Negeri Cempaka Putih 03', 'gender' => 'L', 'experience_level' => 'Belum Pernah', 'parent_name' => 'Agus Santoso', 'whatsapp' => '081234567804', 'email' => 'agus.santoso@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => false],
            ['student_name' => 'Karin Naura Safitri', 'nickname' => 'Naura', 'school_name' => 'SD Islam Dian Didaktika', 'gender' => 'P', 'experience_level' => 'Pernah Sedikit', 'parent_name' => 'Dewi Safitri', 'whatsapp' => '081234567805', 'email' => 'dewi.safitri@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => false],
            ['student_name' => 'David Kevin Sinaga', 'nickname' => 'David', 'school_name' => 'SD Santa Ursula', 'gender' => 'L', 'experience_level' => 'Pernah Sedikit', 'parent_name' => 'Robert Sinaga', 'whatsapp' => '081234567806', 'email' => 'robert.sinaga@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => false],
            ['student_name' => 'Zahra Almira Shaqueena', 'nickname' => 'Zahra', 'school_name' => 'MIN 1 Jakarta Pusat', 'gender' => 'P', 'experience_level' => 'Belum Pernah', 'parent_name' => 'Ahmad Fauzi', 'whatsapp' => '081234567807', 'email' => 'ahmad.fauzi@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => false],
            ['student_name' => 'Kenzo Bryan Tanujaya', 'nickname' => 'Kenzo', 'school_name' => 'SD Gandhi Memorial', 'gender' => 'L', 'experience_level' => 'Sudah Terbiasa', 'parent_name' => 'Steven Tanujaya', 'whatsapp' => '081234567808', 'email' => 'steven.t@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => false],
            // Cadangan Sesi 1
            ['student_name' => 'Clarissa Aurelia Chandra', 'nickname' => 'Clarissa', 'school_name' => 'SD Ipeka Pluit', 'gender' => 'P', 'experience_level' => 'Belum Pernah', 'parent_name' => 'Yuliana Chandra', 'whatsapp' => '081234567811', 'email' => 'yuliana.chandra@example.com', 'status' => 'CADANGAN', 'waitlist_order' => 1, 'is_attended' => false],
            ['student_name' => 'Rayhan Fadhil Ramadhan', 'nickname' => 'Rayhan', 'school_name' => 'SD Muhammadiyah 04', 'gender' => 'L', 'experience_level' => 'Pernah Sedikit', 'parent_name' => 'Fadhil Baswedan', 'whatsapp' => '081234567812', 'email' => 'fadhil.b@example.com', 'status' => 'CADANGAN', 'waitlist_order' => 2, 'is_attended' => false],
            // Batal Sesi 1
            ['student_name' => 'Bagas Arya Wicaksono', 'nickname' => 'Bagas', 'school_name' => 'SD Global Mandiri', 'gender' => 'L', 'experience_level' => 'Belum Pernah', 'parent_name' => 'Joko Wicaksono', 'whatsapp' => '081234567814', 'email' => 'joko.wicaksono@example.com', 'status' => 'DIBATALKAN', 'waitlist_order' => null, 'is_attended' => false, 'cancellation_reason' => 'Ada acara keluarga ke luar kota.'],
        ];

        $s1Index = 1;
        foreach ($session1Participants as $data) {
            $data['session'] = '1';
            $data['reg_code'] = 'AI26-S1-' . str_pad($s1Index, 3, '0', STR_PAD_LEFT);
            Participant::create($data);
            $s1Index++;
        }

        // 4. Demo Participants for Session 2 (12:30 - 14:00 WIB)
        $session2Participants = [
            ['student_name' => 'Nabila Khairunnisa', 'nickname' => 'Nabila', 'school_name' => 'SD Negeri Duren Sawit 07', 'gender' => 'P', 'experience_level' => 'Belum Pernah', 'parent_name' => 'Nurul Hidayah', 'whatsapp' => '081234567809', 'email' => 'nurul.hidayah@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => true, 'attended_at' => now()->subMinutes(5)],
            ['student_name' => 'Raditya Bayu Anggoro', 'nickname' => 'Radit', 'school_name' => 'SD Tarakanita 1', 'gender' => 'L', 'experience_level' => 'Pernah Sedikit', 'parent_name' => 'Hendra Anggoro', 'whatsapp' => '081234567810', 'email' => 'hendra.anggoro@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => false],
            ['student_name' => 'Tasya Amanda Putri', 'nickname' => 'Tasya', 'school_name' => 'SD Negeri Kebon Jeruk 11', 'gender' => 'P', 'experience_level' => 'Sudah Terbiasa', 'parent_name' => 'Bambang Irawan', 'whatsapp' => '081234567813', 'email' => 'bambang.irawan@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => false],
            ['student_name' => 'Alvino Surya Wardhana', 'nickname' => 'Vino', 'school_name' => 'SD Muhammadiyah 2 Jakarta', 'gender' => 'L', 'experience_level' => 'Pernah Sedikit', 'parent_name' => 'Surya Wardhana', 'whatsapp' => '081234567815', 'email' => 'surya.w@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => false],
            ['student_name' => 'Felicia Amanda Tan', 'nickname' => 'Feli', 'school_name' => 'SD Bina Bangsa', 'gender' => 'P', 'experience_level' => 'Sudah Terbiasa', 'parent_name' => 'Amanda Tan', 'whatsapp' => '081234567816', 'email' => 'amanda.tan@example.com', 'status' => 'UTAMA', 'waitlist_order' => null, 'is_attended' => false],
            // Cadangan Sesi 2
            ['student_name' => 'Gibran Arka Mahendra', 'nickname' => 'Gibran', 'school_name' => 'SD Al-Ikhlas Cipete', 'gender' => 'L', 'experience_level' => 'Belum Pernah', 'parent_name' => 'Arka Mahendra', 'whatsapp' => '081234567817', 'email' => 'arka.m@example.com', 'status' => 'CADANGAN', 'waitlist_order' => 1, 'is_attended' => false],
        ];

        $s2Index = 1;
        foreach ($session2Participants as $data) {
            $data['session'] = '2';
            $data['reg_code'] = 'AI26-S2-' . str_pad($s2Index, 3, '0', STR_PAD_LEFT);
            Participant::create($data);
            $s2Index++;
        }
    }
}
