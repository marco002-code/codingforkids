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
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@codingforkids.id'],
            [
                'name' => 'Administrator Panitia',
                'password' => Hash::make('admin12345'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Default Settings
        $settings = [
            ['key' => 'event_name', 'value' => 'Coding for Kids and A.I. for Learning', 'group' => 'event', 'label' => 'Nama Kegiatan'],
            ['key' => 'event_tagline', 'value' => 'Kenalkan Dunia Coding & Kecerdasan Buatan (A.I.) Sejak Dini!', 'group' => 'event', 'label' => 'Tagline / Headline'],
            ['key' => 'event_subtitle', 'value' => 'Workshop seru, interaktif, dan 100% GRATIS khusus untuk siswa SD Kelas 6.', 'group' => 'event', 'label' => 'Sub Headline'],
            ['key' => 'target_audience', 'value' => 'Siswa SD Kelas 6 (Tahun Ajaran 2026/2027)', 'group' => 'event', 'label' => 'Target Peserta'],
            ['key' => 'event_date', 'value' => 'Senin, 21 Desember 2026', 'group' => 'event', 'label' => 'Tanggal Pelaksanaan'],
            ['key' => 'event_time', 'value' => '08.30 – 12.30 WIB', 'group' => 'event', 'label' => 'Waktu Pelaksanaan'],
            ['key' => 'event_location', 'value' => 'Lab Komputer & Auditorium Gedung Edukasi Teknologi, Lt. 3', 'group' => 'event', 'label' => 'Lokasi Kegiatan'],
            ['key' => 'max_main_quota', 'value' => '50', 'group' => 'quota', 'label' => 'Batas Kuota Utama'],
            ['key' => 'max_waitlist_quota', 'value' => '20', 'group' => 'quota', 'label' => 'Batas Kuota Cadangan (Waitlist)'],
            ['key' => 'registration_status', 'value' => 'OPEN', 'group' => 'quota', 'label' => 'Status Pendaftaran (OPEN / CLOSED)'],
            ['key' => 'whatsapp_group_link', 'value' => 'https://chat.whatsapp.com/CodingKidsAI2026', 'group' => 'contact', 'label' => 'Link Grup WhatsApp Koordinasi'],
            ['key' => 'contact_whatsapp', 'value' => '081234567890', 'group' => 'contact', 'label' => 'Nomor WhatsApp Hotline Panitia'],
            ['key' => 'contact_email', 'value' => 'panitia@codingforkids.id', 'group' => 'contact', 'label' => 'Email Panitia'],
        ];

        foreach ($settings as $setting) {
            Setting::set($setting['key'], $setting['value'], $setting['group'], $setting['label']);
        }

        // 3. Realistic Demo Participants
        $demoParticipants = [
            // Peserta Utama (10 siswa)
            [
                'student_name' => 'Muhammad Rizky Pratama',
                'nickname' => 'Rizky',
                'school_name' => 'SD Negeri Menteng 01',
                'gender' => 'L',
                'experience_level' => 'Pernah Sedikit',
                'parent_name' => 'Budi Pratama',
                'whatsapp' => '081234567801',
                'email' => 'budi.pratama@example.com',
                'status' => 'UTAMA',
                'waitlist_order' => null,
                'is_attended' => true,
                'attended_at' => now()->subMinutes(15),
            ],
            [
                'student_name' => 'Aisyah Putri Rahmadani',
                'nickname' => 'Aisyah',
                'school_name' => 'SDIT Al-Azhar Rawamangun',
                'gender' => 'P',
                'experience_level' => 'Belum Pernah',
                'parent_name' => 'Siti Rahmawati',
                'whatsapp' => '081234567802',
                'email' => 'siti.rahma@example.com',
                'status' => 'UTAMA',
                'waitlist_order' => null,
                'is_attended' => true,
                'attended_at' => now()->subMinutes(10),
            ],
            [
                'student_name' => 'Jonathan Nicholas Wijaya',
                'nickname' => 'Nathan',
                'school_name' => 'SD Kristen Penabur 3',
                'gender' => 'L',
                'experience_level' => 'Sudah Terbiasa',
                'parent_name' => 'Hendrik Wijaya',
                'whatsapp' => '081234567803',
                'email' => 'hendrik.wijaya@example.com',
                'status' => 'UTAMA',
                'waitlist_order' => null,
                'is_attended' => false,
            ],
            [
                'student_name' => 'Farhan Aditia Putra',
                'nickname' => 'Farhan',
                'school_name' => 'SD Negeri Cempaka Putih 03',
                'gender' => 'L',
                'experience_level' => 'Belum Pernah',
                'parent_name' => 'Agus Santoso',
                'whatsapp' => '081234567804',
                'email' => 'agus.santoso@example.com',
                'status' => 'UTAMA',
                'waitlist_order' => null,
                'is_attended' => false,
            ],
            [
                'student_name' => 'Karin Naura Safitri',
                'nickname' => 'Naura',
                'school_name' => 'SD Islam Dian Didaktika',
                'gender' => 'P',
                'experience_level' => 'Pernah Sedikit',
                'parent_name' => 'Dewi Safitri',
                'whatsapp' => '081234567805',
                'email' => 'dewi.safitri@example.com',
                'status' => 'UTAMA',
                'waitlist_order' => null,
                'is_attended' => false,
            ],
            [
                'student_name' => 'David Kevin Sinaga',
                'nickname' => 'David',
                'school_name' => 'SD Santa Ursula',
                'gender' => 'L',
                'experience_level' => 'Pernah Sedikit',
                'parent_name' => 'Robert Sinaga',
                'whatsapp' => '081234567806',
                'email' => 'robert.sinaga@example.com',
                'status' => 'UTAMA',
                'waitlist_order' => null,
                'is_attended' => false,
            ],
            [
                'student_name' => 'Zahra Almira Shaqueena',
                'nickname' => 'Zahra',
                'school_name' => 'MIN 1 Jakarta Pusat',
                'gender' => 'P',
                'experience_level' => 'Belum Pernah',
                'parent_name' => 'Ahmad Fauzi',
                'whatsapp' => '081234567807',
                'email' => 'ahmad.fauzi@example.com',
                'status' => 'UTAMA',
                'waitlist_order' => null,
                'is_attended' => false,
            ],
            [
                'student_name' => 'Kenzo Bryan Tanujaya',
                'nickname' => 'Kenzo',
                'school_name' => 'SD Gandhi Memorial',
                'gender' => 'L',
                'experience_level' => 'Sudah Terbiasa',
                'parent_name' => 'Steven Tanujaya',
                'whatsapp' => '081234567808',
                'email' => 'steven.t@example.com',
                'status' => 'UTAMA',
                'waitlist_order' => null,
                'is_attended' => false,
            ],
            [
                'student_name' => 'Nabila Khairunnisa',
                'nickname' => 'Nabila',
                'school_name' => 'SD Negeri Duren Sawit 07',
                'gender' => 'P',
                'experience_level' => 'Belum Pernah',
                'parent_name' => 'Nurul Hidayah',
                'whatsapp' => '081234567809',
                'email' => 'nurul.hidayah@example.com',
                'status' => 'UTAMA',
                'waitlist_order' => null,
                'is_attended' => false,
            ],
            [
                'student_name' => 'Raditya Bayu Anggoro',
                'nickname' => 'Radit',
                'school_name' => 'SD Tarakanita 1',
                'gender' => 'L',
                'experience_level' => 'Pernah Sedikit',
                'parent_name' => 'Hendra Anggoro',
                'whatsapp' => '081234567810',
                'email' => 'hendra.anggoro@example.com',
                'status' => 'UTAMA',
                'waitlist_order' => null,
                'is_attended' => false,
            ],

            // Peserta Cadangan (3 siswa)
            [
                'student_name' => 'Clarissa Aurelia Chandra',
                'nickname' => 'Clarissa',
                'school_name' => 'SD Ipeka Pluit',
                'gender' => 'P',
                'experience_level' => 'Belum Pernah',
                'parent_name' => 'Yuliana Chandra',
                'whatsapp' => '081234567811',
                'email' => 'yuliana.chandra@example.com',
                'status' => 'CADANGAN',
                'waitlist_order' => 1,
                'is_attended' => false,
            ],
            [
                'student_name' => 'Rayhan Fadhil Ramadhan',
                'nickname' => 'Rayhan',
                'school_name' => 'SD Muhammadiyah 04',
                'gender' => 'L',
                'experience_level' => 'Pernah Sedikit',
                'parent_name' => 'Fadhil Baswedan',
                'whatsapp' => '081234567812',
                'email' => 'fadhil.b@example.com',
                'status' => 'CADANGAN',
                'waitlist_order' => 2,
                'is_attended' => false,
            ],
            [
                'student_name' => 'Tasya Amanda Putri',
                'nickname' => 'Tasya',
                'school_name' => 'SD Negeri Kebon Jeruk 11',
                'gender' => 'P',
                'experience_level' => 'Sudah Terbiasa',
                'parent_name' => 'Bambang Irawan',
                'whatsapp' => '081234567813',
                'email' => 'bambang.irawan@example.com',
                'status' => 'CADANGAN',
                'waitlist_order' => 3,
                'is_attended' => false,
            ],

            // Peserta Dibatalkan (1 siswa)
            [
                'student_name' => 'Bagas Arya Wicaksono',
                'nickname' => 'Bagas',
                'school_name' => 'SD Global Mandiri',
                'gender' => 'L',
                'experience_level' => 'Belum Pernah',
                'parent_name' => 'Joko Wicaksono',
                'whatsapp' => '081234567814',
                'email' => 'joko.wicaksono@example.com',
                'status' => 'DIBATALKAN',
                'waitlist_order' => null,
                'is_attended' => false,
                'cancellation_reason' => 'Ada acara keluarga ke luar kota bertepatan dengan tanggal acara.',
            ],
        ];

        $codeNum = 1;
        foreach ($demoParticipants as $data) {
            $regCode = 'AI26-' . str_pad($codeNum, 3, '0', STR_PAD_LEFT);
            $data['reg_code'] = $regCode;
            Participant::create($data);
            $codeNum++;
        }
    }
}
