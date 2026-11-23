<?php

namespace Tests\Feature;

use App\Models\Participant;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic settings
        Setting::set('session_1_name', 'Sesi 1 (Pagi)');
        Setting::set('session_1_time', '07:30 – 10:00 WIB');
        Setting::set('session_1_quota', 2);
        Setting::set('session_1_waitlist_quota', 2);

        Setting::set('session_2_name', 'Sesi 2 (Siang)');
        Setting::set('session_2_time', '10:30 – 12:00 WIB');
        Setting::set('session_2_quota', 2);
        Setting::set('session_2_waitlist_quota', 2);

        Setting::set('registration_status', 'OPEN');
        Setting::set('event_name', 'Coding for Kids Test');
        Setting::set('event_date', 'Senin, 21 Desember 2026');
    }

    public function test_landing_page_shows_dual_sessions(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('07:30 – 10:00 WIB');
        $response->assertSee('10:30 – 12:00 WIB');
    }

    public function test_registration_creates_utama_for_chosen_session(): void
    {
        $response = $this->post('/register', [
            'session' => '1',
            'student_name' => 'Aditya Pratama',
            'nickname' => 'Adit',
            'school_name' => 'SD Harapan Bangsa',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Bambang Pratama',
            'whatsapp' => '081234567890',
            'email' => 'adit@example.com',
            'terms_agreement' => '1',
            'waitlist_agreement' => '1',
        ]);

        $participant = Participant::where('student_name', 'Aditya Pratama')->first();
        $this->assertNotNull($participant);
        $this->assertEquals('1', $participant->session);
        $this->assertEquals('UTAMA', $participant->status);
        $this->assertNull($participant->waitlist_order);
        $this->assertMatchesRegularExpression('/^[A-Z]{5}$/', $participant->reg_code);

        $response->assertRedirect(route('ticket.show', $participant->reg_code));
    }

    public function test_quota_isolation_between_sessions(): void
    {
        // Fill Session 1 quota (limit 2)
        Participant::create([
            'reg_code' => 'ABCDE',
            'session' => '1',
            'student_name' => 'Siswa 1 Sesi 1',
            'nickname' => 'S1',
            'school_name' => 'SD 1',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Ortu 1',
            'whatsapp' => '0811111111',
            'status' => 'UTAMA',
        ]);

        Participant::create([
            'reg_code' => 'BCDEF',
            'session' => '1',
            'student_name' => 'Siswa 2 Sesi 1',
            'nickname' => 'S2',
            'school_name' => 'SD 2',
            'gender' => 'P',
            'experience_level' => 'Pernah Sedikit',
            'parent_name' => 'Ortu 2',
            'whatsapp' => '0822222222',
            'status' => 'UTAMA',
        ]);

        // Register student to Session 2 -> should still be UTAMA because Session 2 has 0 filled!
        $response = $this->post('/register', [
            'session' => '2',
            'student_name' => 'Siswa Sesi 2',
            'nickname' => 'S2A',
            'school_name' => 'SD 3',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Ortu 3',
            'whatsapp' => '0833333333',
            'terms_agreement' => '1',
            'waitlist_agreement' => '1',
        ]);

        $p2 = Participant::where('student_name', 'Siswa Sesi 2')->first();
        $this->assertNotNull($p2);
        $this->assertEquals('2', $p2->session);
        $this->assertEquals('UTAMA', $p2->status);

        // Register 3rd student to Session 1 -> should become CADANGAN Sesi 1
        $this->post('/register', [
            'session' => '1',
            'student_name' => 'Siswa Cadangan Sesi 1',
            'nickname' => 'CadS1',
            'school_name' => 'SD 4',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Ortu 4',
            'whatsapp' => '0844444444',
            'terms_agreement' => '1',
            'waitlist_agreement' => '1',
        ]);

        $cadanganS1 = Participant::where('student_name', 'Siswa Cadangan Sesi 1')->first();
        $this->assertNotNull($cadanganS1);
        $this->assertEquals('1', $cadanganS1->session);
        $this->assertEquals('CADANGAN', $cadanganS1->status);
        $this->assertEquals(1, $cadanganS1->waitlist_order);
    }

    public function test_admin_dashboard_and_promotion_within_session(): void
    {
        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        $cadanganS2 = Participant::create([
            'reg_code' => 'HIJKL',
            'session' => '2',
            'student_name' => 'Ananda Cadangan Sesi 2',
            'nickname' => 'Nanda',
            'school_name' => 'SD Budi Mulia',
            'gender' => 'P',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Ibu Nanda',
            'whatsapp' => '0877777777',
            'status' => 'CADANGAN',
            'waitlist_order' => 1,
        ]);

        // Login as admin
        $this->actingAs($admin);

        // Access dashboard
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('07:30 – 10:00 WIB');
        $response->assertSee('10:30 – 12:00 WIB');

        // Promote cadangan S2
        $promoteResponse = $this->post('/admin/participants/' . $cadanganS2->id . '/promote');
        $promoteResponse->assertSessionHas('success');

        $cadanganS2->refresh();
        $this->assertEquals('UTAMA', $cadanganS2->status);
        $this->assertEquals('2', $cadanganS2->session);
        $this->assertNull($cadanganS2->waitlist_order);
    }

    public function test_registration_with_student_whatsapp_and_optional_fields(): void
    {
        // Registration without nickname, parent_name, or email
        $response = $this->post('/register', [
            'session' => '1',
            'student_name' => 'Kurnia Ramadhan',
            'school_name' => 'SD Muhammadiyah Sapen',
            'gender' => 'L',
            'experience_level' => 'Pernah Sedikit',
            'whatsapp' => '081298765432',
            'student_whatsapp' => '081298765433',
            'terms_agreement' => '1',
            'waitlist_agreement' => '1',
        ]);

        $participant = Participant::where('student_name', 'Kurnia Ramadhan')->first();
        $this->assertNotNull($participant);
        $this->assertEquals('Kurnia', $participant->nickname);
        $this->assertEquals('081298765433', $participant->student_whatsapp);
        $this->assertEquals('081298765432', $participant->whatsapp);
        $response->assertRedirect(route('ticket.show', $participant->reg_code));
    }

    public function test_selected_participants_public_page(): void
    {
        // Set published to 1
        Setting::set('publish_selected_participants', '1');

        // Seed participant UTAMA Sesi 1
        $p1 = Participant::create([
            'reg_code' => 'JKLMN',
            'session' => '1',
            'student_name' => 'Fadhil Al Ghifari',
            'school_name' => 'SD Muhammadiyah Sukonandi',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'whatsapp' => '08111222333',
            'status' => 'UTAMA',
        ]);

        // Seed participant CADANGAN Sesi 1 (should NOT appear on selected list)
        $pCadangan = Participant::create([
            'reg_code' => 'OPQRS',
            'session' => '1',
            'student_name' => 'Budi Santoso Cadangan',
            'school_name' => 'SD Negeri 1',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'whatsapp' => '08111222444',
            'status' => 'CADANGAN',
            'waitlist_order' => 1,
        ]);

        // Test GET /peserta-terpilih
        $response = $this->get('/peserta-terpilih');
        $response->assertStatus(200);
        $response->assertSee('Daftar Peserta Terpilih');
        $response->assertSee('Fadhil Al Ghifari');
        $response->assertSee('SD Muhammadiyah Sukonandi');
        $response->assertDontSee('Budi Santoso Cadangan');

        // Test filter by session 1
        $responseS1 = $this->get('/peserta-terpilih?session=1');
        $responseS1->assertStatus(200);
        $responseS1->assertSee('Fadhil Al Ghifari');

        // Test filter by session 2 (should be empty for p1)
        $responseS2 = $this->get('/peserta-terpilih?session=2');
        $responseS2->assertStatus(200);
        $responseS2->assertDontSee('Fadhil Al Ghifari');
    }

    public function test_selected_participants_shows_validation_card_when_unpublished(): void
    {
        // Set unpublished (0)
        Setting::set('publish_selected_participants', '0');

        Participant::create([
            'reg_code' => 'KMPXW',
            'session' => '1',
            'student_name' => 'Peserta Belum Rilis',
            'school_name' => 'SD Muhammadiyah 1',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'whatsapp' => '08123456789',
            'status' => 'UTAMA',
        ]);

        // 1. Guest visitor should see "Data Pendaftar dalam Proses Konfirmasi dan Validasi"
        $response = $this->get('/peserta-terpilih');
        $response->assertStatus(200);
        $response->assertSee('Data Pendaftar dalam Proses Konfirmasi dan Validasi');
        $response->assertDontSee('Peserta Belum Rilis');

        // 2. Admin should see preview mode and student names
        $admin = User::create([
            'name' => 'Admin Pengumuman',
            'email' => 'admin_pengumuman@test.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($admin);
        $adminResponse = $this->get('/peserta-terpilih');
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('Mode Pratinjau Panitia');
        $adminResponse->assertSee('Peserta Belum Rilis');

        // 3. Admin toggles publish status
        $toggleResponse = $this->post('/admin/participants/toggle-publish');
        $toggleResponse->assertSessionHas('success');
        $this->assertEquals('1', Setting::get('publish_selected_participants'));

        // 4. Logout admin and check guest can now see published table
        auth()->logout();
        $publishedResponse = $this->get('/peserta-terpilih');
        $publishedResponse->assertStatus(200);
        $publishedResponse->assertSee('Peserta Belum Rilis');
        $publishedResponse->assertDontSee('Data Pendaftar dalam Proses Konfirmasi dan Validasi');
    }

    public function test_generate_reg_code_is_5_uppercase_letters(): void
    {
        $code1 = Participant::generateRegCode('1');
        $code2 = Participant::generateRegCode('2');

        $this->assertEquals(5, strlen($code1));
        $this->assertEquals(5, strlen($code2));
        $this->assertMatchesRegularExpression('/^[A-Z]{5}$/', $code1);
        $this->assertMatchesRegularExpression('/^[A-Z]{5}$/', $code2);
    }

    public function test_e_ticket_displays_qr_code_and_5_letter_code(): void
    {
        $code = Participant::generateRegCode('1');
        $participant = Participant::create([
            'reg_code' => $code,
            'session' => '1',
            'student_name' => 'Ahmad Dahlan Muda',
            'school_name' => 'SD Muhammadiyah 1',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'whatsapp' => '08123456789',
            'status' => 'UTAMA',
        ]);

        $response = $this->get(route('ticket.show', $participant->reg_code));
        $response->assertStatus(200);
        $response->assertSee($code);
        $response->assertSee('QR Code Presensi Hari-H');
        $response->assertSee('<svg', false); // SVG QR code rendered
        $response->assertSee('Simpan Gambar (JPG)');
        $response->assertSee('Cetak PDF (1 Halaman A4)');
        $response->assertSee('html2canvas.min.js');
        $response->assertSee('A4 portrait');
    }

    public function test_admin_quick_checkin_with_5_letter_code_and_json(): void
    {
        $admin = User::create([
            'name' => 'Admin Panitia',
            'email' => 'panitia@test.com',
            'password' => bcrypt('password123'),
        ]);

        $code = Participant::generateRegCode('1');
        $participant = Participant::create([
            'reg_code' => $code,
            'session' => '1',
            'student_name' => 'Siswa Presensi Cepat',
            'school_name' => 'SD Teladan',
            'gender' => 'P',
            'experience_level' => 'Pernah Sedikit',
            'whatsapp' => '08123456789',
            'status' => 'UTAMA',
        ]);

        $this->actingAs($admin);

        // Test lowercase input (e.g. kmpxw) -> should match uppercase KMPXW
        $response = $this->post('/admin/quick-check-in', [
            'code' => strtolower($code),
        ]);
        $response->assertSessionHas('success');

        $participant->refresh();
        $this->assertTrue((bool)$participant->is_attended);
        $this->assertNotNull($participant->attended_at);

        // Test JSON request (as sent by Camera Scanner)
        $responseJson = $this->postJson('/admin/quick-check-in', [
            'code' => $code,
        ]);
        $responseJson->assertStatus(200);
        $responseJson->assertJson([
            'success' => true,
            'reg_code' => $code,
            'already_attended' => true,
        ]);
    }

    public function test_admin_can_delete_participant_permanently_and_reorder_waitlist(): void
    {
        $admin = User::create([
            'name' => 'Admin Panitia',
            'email' => 'admin_del@test.com',
            'password' => bcrypt('password123'),
        ]);

        $utama = Participant::create([
            'reg_code' => 'ABCDE',
            'session' => '1',
            'student_name' => 'Siswa Utama 1',
            'school_name' => 'SD 1',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Ortu 1',
            'whatsapp' => '081234567891',
            'status' => 'UTAMA',
        ]);

        $cadangan1 = Participant::create([
            'reg_code' => 'BCDEF',
            'session' => '1',
            'student_name' => 'Siswa Cadangan 1',
            'school_name' => 'SD 2',
            'gender' => 'P',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Ortu 2',
            'whatsapp' => '081234567892',
            'status' => 'CADANGAN',
            'waitlist_order' => 1,
        ]);

        $cadangan2 = Participant::create([
            'reg_code' => 'CDEFG',
            'session' => '1',
            'student_name' => 'Siswa Cadangan 2',
            'school_name' => 'SD 3',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Ortu 3',
            'whatsapp' => '081234567893',
            'status' => 'CADANGAN',
            'waitlist_order' => 2,
        ]);

        $this->actingAs($admin);

        // 1. Delete cadangan 1 -> cadangan 2 should become waitlist_order 1
        $delResponse = $this->delete(route('admin.participants.destroy', $cadangan1->id));
        $delResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('participants', ['id' => $cadangan1->id]);

        $cadangan2->refresh();
        $this->assertEquals(1, $cadangan2->waitlist_order);

        // 2. Delete utama -> system automatically promotes remaining waitlist candidate to UTAMA
        $delUtamaResponse = $this->delete(route('admin.participants.destroy', $utama->id));
        $delUtamaResponse->assertSessionHas('success');
        $delUtamaResponse->assertSessionHas('promoted_wa_url');
        $this->assertDatabaseMissing('participants', ['id' => $utama->id]);

        $cadangan2->refresh();
        $this->assertEquals('UTAMA', $cadangan2->status);
        $this->assertNull($cadangan2->waitlist_order);
    }

    public function test_cancelling_utama_automatically_promotes_top_waitlist_to_utama_and_provides_wa_link(): void
    {
        $admin = User::create([
            'name' => 'Admin Panitia',
            'email' => 'admin_cancel_test@test.com',
            'password' => bcrypt('password123'),
        ]);

        $utama = Participant::create([
            'reg_code' => 'KMPX1',
            'session' => '2',
            'student_name' => 'Peserta Utama Mengundurkan Diri',
            'school_name' => 'SD Teladan',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Budi Santoso',
            'whatsapp' => '081234567890',
            'status' => 'UTAMA',
        ]);

        $cadangan1 = Participant::create([
            'reg_code' => 'KMPX2',
            'session' => '2',
            'student_name' => 'Siswa Cadangan Pertama',
            'school_name' => 'SD Karitas',
            'gender' => 'P',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Dewi Lestari',
            'whatsapp' => '085640001111',
            'status' => 'CADANGAN',
            'waitlist_order' => 1,
        ]);

        $cadangan2 = Participant::create([
            'reg_code' => 'KMPX3',
            'session' => '2',
            'student_name' => 'Siswa Cadangan Kedua',
            'school_name' => 'SD Negeri 1',
            'gender' => 'L',
            'experience_level' => 'Pernah Sedikit',
            'parent_name' => 'Agus Salim',
            'whatsapp' => '087788990011',
            'status' => 'CADANGAN',
            'waitlist_order' => 2,
        ]);

        $this->actingAs($admin);

        // Cancel the UTAMA participant with reason "Mengundurkan diri"
        $cancelRes = $this->post(route('admin.participants.cancel', $utama->id), [
            'reason' => 'Mengundurkan diri karena acara keluarga.',
        ]);

        $cancelRes->assertRedirect();
        $cancelRes->assertSessionHas('success');
        $cancelRes->assertSessionHas('promoted_wa_url');

        // Check utama is now DIBATALKAN
        $utama->refresh();
        $this->assertEquals('DIBATALKAN', $utama->status);
        $this->assertEquals('Mengundurkan diri karena acara keluarga.', $utama->cancellation_reason);

        // Check cadangan1 is AUTOMATICALLY PROMOTED to UTAMA
        $cadangan1->refresh();
        $this->assertEquals('UTAMA', $cadangan1->status);
        $this->assertNull($cadangan1->waitlist_order);

        // Check cadangan2 shifts to waitlist_order 1
        $cadangan2->refresh();
        $this->assertEquals('CADANGAN', $cadangan2->status);
        $this->assertEquals(1, $cadangan2->waitlist_order);

        // Check participants page displays direct wa.me link and reg_code
        $participantsPage = $this->get(route('admin.participants'));
        $participantsPage->assertStatus(200);
        $participantsPage->assertSee('KMPX2');
        $participantsPage->assertSee('https://wa.me/6285640001111', false);
        $participantsPage->assertSee('Dewi Lestari');
    }

    public function test_admin_settings_tabs_and_rundown_stacks_management(): void
    {
        $admin = User::create([
            'name' => 'Admin Panitia',
            'email' => 'admin_settings@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        // View settings tabs
        $resEvent = $this->get(route('admin.settings', ['tab' => 'event']));
        $resEvent->assertStatus(200);
        $resEvent->assertSee('Tanggal Pelaksanaan Kegiatan');

        $resSessions = $this->get(route('admin.settings', ['tab' => 'sessions']));
        $resSessions->assertStatus(200);
        $resSessions->assertSee('Jam / Waktu Pelaksanaan');

        $resRundown = $this->get(route('admin.settings', ['tab' => 'rundown', 'session' => 1]));
        $resRundown->assertStatus(200);
        $resRundown->assertSee('Daftar Stack Materi: Sesi 1');

        // Update Rundown Stacks
        $newStacks = [
            [
                'time' => '07:00 – 07:45',
                'title' => 'Check-in & Sambutan',
                'description' => 'Persiapan peserta di lab.',
                'duration' => '45 Menit',
                'type' => 'default',
            ],
            [
                'time' => '07:45 – 09:15',
                'title' => 'Coding Scratch Interaktif',
                'description' => 'Membuat game seru.',
                'duration' => '90 Menit',
                'type' => 'blue',
            ],
        ];

        $updateRundownRes = $this->post(route('admin.settings.updateRundown'), [
            'session' => 1,
            'items' => $newStacks,
        ]);
        $updateRundownRes->assertRedirect(route('admin.settings', ['tab' => 'rundown', 'session' => 1]));
        $updateRundownRes->assertSessionHas('success');

        // Verify landing page reflects updated rundown
        $landingRes = $this->get('/');
        $landingRes->assertStatus(200);
        $landingRes->assertSee('Coding Scratch Interaktif');
        $landingRes->assertSee('07:45 – 09:15');

        // Reset to default 5 stacks
        $resetRes = $this->post(route('admin.settings.updateRundown'), [
            'session' => 1,
            'reset_default' => 1,
        ]);
        $resetRes->assertSessionHas('success');

        $landingResAfterReset = $this->get('/');
        $landingResAfterReset->assertSee('Modul 1: Coding &amp; Praktik Membuat Game 🎮', false);

        // View dedicated WhatsApp settings tab
        $resWa = $this->get(route('admin.settings', ['tab' => 'whatsapp']));
        $resWa->assertStatus(200);
        $resWa->assertSee('Pengaturan WhatsApp &amp; Kontak Hotline Panitia', false);
        $resWa->assertSee('Tautan Undangan Grup WhatsApp Peserta');
        $resWa->assertSee('Nomor WhatsApp Panitia yang Siap Dihubungi');

        // Update WhatsApp settings via Tab whatsapp
        $updateWaRes = $this->post(route('admin.settings.update'), [
            'redirect_tab' => 'whatsapp',
            'event_name' => 'Coding for Kids and A.I. for Learning',
            'event_date' => 'Senin, 21 Desember 2026',
            'event_location' => 'Laboratorium Komputer SMP Muhammadiyah 1 Yogyakarta',
            'session_1_name' => 'Sesi 1 (Pagi)',
            'session_1_time' => '07:30 – 10:00 WIB',
            'session_1_quota' => 90,
            'session_1_waitlist_quota' => 30,
            'session_2_name' => 'Sesi 2 (Siang)',
            'session_2_time' => '10:30 – 12:00 WIB',
            'session_2_quota' => 90,
            'session_2_waitlist_quota' => 30,
            'registration_status' => 'OPEN',
            'whatsapp_group_link' => 'https://chat.whatsapp.com/GrupKoding2026Official',
            'contact_whatsapp' => '085640001234',
            'contact_email' => 'panitia_koding@muhijunior.id',
        ]);
        $updateWaRes->assertRedirect(route('admin.settings', ['tab' => 'whatsapp']));
        $updateWaRes->assertSessionHas('success');

        $this->assertEquals('https://chat.whatsapp.com/GrupKoding2026Official', Setting::get('whatsapp_group_link'));
        $this->assertEquals('085640001234', Setting::get('contact_whatsapp'));
        $this->assertEquals('panitia_koding@muhijunior.id', Setting::get('contact_email'));

        // Public page reflects new hotline
        $resHome = $this->get('/');
        $resHome->assertSee('WA Hotline: 085640001234');
    }

    public function test_admin_attendance_page_and_dedicated_checkin_menu(): void
    {
        $admin = User::create([
            'name' => 'Admin Panitia',
            'email' => 'admin_attendance@test.com',
            'password' => bcrypt('password123'),
        ]);

        $p = Participant::create([
            'reg_code' => 'XYZAB',
            'session' => '1',
            'student_name' => 'Peserta Uji Presensi',
            'school_name' => 'SD Muhammadiyah',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Ortu Uji',
            'whatsapp' => '081234567899',
            'status' => 'UTAMA',
            'is_attended' => false,
        ]);

        $this->actingAs($admin);

        // Access separate attendance page
        $res = $this->get(route('admin.attendance'));
        $res->assertStatus(200);
        $res->assertSee('Presensi Kehadiran Siswa');
        $res->assertSee('Peserta Uji Presensi');
        $res->assertSee('XYZAB');
        $res->assertSee('Buka Kamera QR');

        // Check dashboard doesn't have the huge input bar anymore, but links to attendance
        $resDash = $this->get(route('admin.dashboard'));
        $resDash->assertStatus(200);
        $resDash->assertSee('Buka Menu Presensi &rarr;', false);
        $resDash->assertDontSee('id="qrScannerModal"', false);

        // Toggle check-in from attendance
        $toggleRes = $this->post(route('admin.participants.checkin', $p->id));
        $toggleRes->assertSessionHas('success');

        $p->refresh();
        $this->assertTrue((bool)$p->is_attended);
        $this->assertNotNull($p->attended_at);
    }

    public function test_logged_out_admin_refreshing_dashboard_redirects_to_login_gracefully(): void
    {
        $admin = User::create([
            'name' => 'Admin Logout Test',
            'email' => 'logout_test@test.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($admin);

        // Verify dashboard is accessible while logged in
        $dashRes = $this->get('/admin/dashboard');
        $dashRes->assertStatus(200);

        // Admin logs out
        $logoutRes = $this->post(route('admin.logout'));
        $logoutRes->assertRedirect(route('admin.login'));
        $this->assertGuest();

        // Refreshing or visiting /admin/dashboard as logged out guest must redirect to /admin/login (not 500 error!)
        $refreshRes = $this->get('/admin/dashboard');
        $refreshRes->assertRedirect('/admin/login');

        // Also visiting /admin/participants or /admin/attendance as guest redirects to /admin/login
        $this->get('/admin/participants')->assertRedirect('/admin/login');
        $this->get('/admin/attendance')->assertRedirect('/admin/login');
    }

    public function test_admin_user_management_and_change_password_for_all_users(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Panitia',
            'email' => 'super@muhijunior.id',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $panitia2 = User::create([
            'name' => 'Panitia Dua',
            'email' => 'panitia2@muhijunior.id',
            'password' => bcrypt('password123'),
            'role' => 'panitia',
        ]);

        $this->actingAs($superAdmin);

        // 1. View User List
        $res = $this->get(route('admin.users.index'));
        $res->assertStatus(200);
        $res->assertSee('Manajemen Akun Panitia');
        $res->assertSee('Super Panitia');
        $res->assertSee('Panitia Dua');

        // 2. Create New Admin User
        $createRes = $this->post(route('admin.users.store'), [
            'name' => 'Panitia Tiga',
            'email' => 'panitia3@muhijunior.id',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);
        $createRes->assertRedirect(route('admin.users.index'));
        $createRes->assertSessionHas('success');

        $panitia3 = User::where('email', 'panitia3@muhijunior.id')->first();
        $this->assertNotNull($panitia3);
        $this->assertEquals('Panitia Tiga', $panitia3->name);

        // 3. Edit User Profile (Update Name & Email)
        $updateRes = $this->put(route('admin.users.update', $panitia3->id), [
            'name' => 'Panitia Tiga Updated',
            'email' => 'panitia3_baru@muhijunior.id',
        ]);
        $updateRes->assertRedirect(route('admin.users.index'));
        $panitia3->refresh();
        $this->assertEquals('Panitia Tiga Updated', $panitia3->name);
        $this->assertEquals('panitia3_baru@muhijunior.id', $panitia3->email);

        // 4. Change Password for Any User (Panitia Dua)
        $changePassRes = $this->post(route('admin.users.changePassword', $panitia2->id), [
            'password' => 'newPassword2026',
            'password_confirmation' => 'newPassword2026',
        ]);
        $changePassRes->assertRedirect(route('admin.users.index'));
        $changePassRes->assertSessionHas('success');

        $panitia2->refresh();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('newPassword2026', $panitia2->password));

        // 5. Change Password for Self (Super Admin)
        $changeSelfPassRes = $this->post(route('admin.users.changePassword', $superAdmin->id), [
            'password' => 'superNewPass2026',
            'password_confirmation' => 'superNewPass2026',
        ]);
        $changeSelfPassRes->assertSessionHas('success');
        $superAdmin->refresh();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('superNewPass2026', $superAdmin->password));

        // 6. Prevent Deleting Self
        $delSelfRes = $this->delete(route('admin.users.destroy', $superAdmin->id));
        $delSelfRes->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $superAdmin->id]);

        // 7. Delete Other User
        $delOtherRes = $this->delete(route('admin.users.destroy', $panitia3->id));
        $delOtherRes->assertRedirect(route('admin.users.index'));
        $delOtherRes->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $panitia3->id]);
    }

    public function test_dynamic_session_settings_and_auto_duration_calculation(): void
    {
        // 1. Test Duration helper methods in Setting
        $this->assertEquals(150, Setting::calculateMinutes('07:30 – 10:00 WIB'));
        $this->assertEquals('2.5 Jam (150 Menit)', Setting::calculateDuration('07:30 – 10:00 WIB'));
        $this->assertEquals('2.5 Jam', Setting::calculateDurationShort('07:30 – 10:00 WIB'));
        $this->assertEquals(65, Setting::calculateMinutes('07.30 - 08.35'));
        $this->assertEquals('1.1 Jam (65 Menit)', Setting::calculateDuration('07.30 - 08.35'));
        $this->assertEquals('1.1 Jam', Setting::calculateDurationShort('07.30 - 08.35'));
        $this->assertEquals(45, Setting::calculateMinutes('07:00 – 07:45'));
        $this->assertEquals('45 Menit', Setting::calculateDuration('07:00 – 07:45'));

        // 2. Set custom session times and names
        Setting::set('session_1_name', 'Sesi Pagi Ceria');
        Setting::set('session_1_time', '08:00 – 10:30 WIB');
        Setting::set('session_1_quota', 75);

        Setting::set('session_2_name', 'Sesi Siang Juara');
        Setting::set('session_2_time', '11:00 – 13:00 WIB');
        Setting::set('session_2_quota', 85);

        // 3. Verify landing page renders custom session names, times, quotas and calculated durations
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sesi Pagi Ceria');
        $response->assertSee('08:00 – 10:30 WIB');
        $response->assertSee('2.5 Jam (150 Menit)');
        $response->assertSee('Sesi Siang Juara');
        $response->assertSee('11:00 – 13:00 WIB');
        $response->assertSee('2 Jam (120 Menit)');
        $response->assertSee('75 Siswa per Sesi');

        // 4. Verify participant dynamic session attributes
        $participant = Participant::create([
            'reg_code' => 'TEST1',
            'session' => '1',
            'student_name' => 'Budi Santoso',
            'nickname' => 'Budi',
            'school_name' => 'SD Teladan',
            'gender' => 'L',
            'experience_level' => 'Pemula',
            'parent_name' => 'Santoso',
            'whatsapp' => '081234567899',
            'status' => 'UTAMA',
            'terms_agreement' => true,
            'waitlist_agreement' => true,
        ]);

        $this->assertEquals('Sesi Pagi Ceria: 08:00 – 10:30 WIB', $participant->session_label);
        $this->assertEquals('08:00 – 10:30 WIB', $participant->session_time);
        $this->assertEquals('Sesi Pagi Ceria', $participant->session_name);

        // 5. Test auto-calculation of duration when saving rundown with empty duration
        $admin = User::where('role', 'admin')->first() ?? User::create([
            'name' => 'Admin Test',
            'email' => 'admin_test_duration@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $this->post(route('admin.settings.updateRundown'), [
            'session' => 1,
            'items' => [
                [
                    'time' => '08:00 – 08:50',
                    'title' => 'Modul Baru Logika',
                    'description' => 'Belajar logika game.',
                    'duration' => '', // Left empty to test auto-calculation
                    'type' => 'blue',
                ],
            ],
        ]);

        $savedRundown = Setting::getRundown(1);
        $this->assertNotEmpty($savedRundown);
        $this->assertEquals('50 Menit', $savedRundown[0]['duration']);
    }

    public function test_panitia_role_permissions_and_restrictions(): void
    {
        // Setup Administrator & Panitia users
        $admin = User::where('role', 'admin')->first() ?? User::create([
            'name' => 'Admin Master',
            'email' => 'admin_master@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $panitia = User::create([
            'name' => 'Ahmad Panitia',
            'email' => 'panitia_ahmad@test.com',
            'password' => bcrypt('password123'),
            'role' => 'panitia',
        ]);

        $otherPanitia = User::create([
            'name' => 'Siti Panitia',
            'email' => 'panitia_siti@test.com',
            'password' => bcrypt('password123'),
            'role' => 'panitia',
        ]);

        // Login as Panitia
        $this->actingAs($panitia);

        // 1. Panitia CAN access Dashboard, Participants, Attendance, and Check-in (R & W)
        $dashRes = $this->get(route('admin.dashboard'));
        $dashRes->assertStatus(200);

        $partRes = $this->get(route('admin.participants'));
        $partRes->assertStatus(200);

        $attRes = $this->get(route('admin.attendance'));
        $attRes->assertStatus(200);

        $participant = Participant::create([
            'reg_code' => 'PNT01',
            'session' => '1',
            'student_name' => 'Peserta Uji Panitia',
            'school_name' => 'SD Negeri 1',
            'gender' => 'L',
            'parent_name' => 'Wali Murid',
            'whatsapp' => '081234567888',
            'status' => 'UTAMA',
            'terms_agreement' => true,
            'waitlist_agreement' => true,
        ]);

        // Panitia check-in write action
        $checkInRes = $this->post(route('admin.participants.checkin', $participant));
        $checkInRes->assertStatus(302);
        $this->assertTrue($participant->fresh()->is_attended);

        // 2. Panitia CAN view Settings in Read-Only Mode (R) with locked disabled fields
        $settingsRes = $this->get(route('admin.settings'));
        $settingsRes->assertStatus(200);
        $settingsRes->assertSee('Mode Baca Saja');
        $settingsRes->assertSee('Simpan Dinonaktifkan (Mode Baca Saja Panitia)');
        $settingsRes->assertSee('disabled', false);
        $settingsRes->assertSee('Terkunci', false);

        // 3. Panitia CANNOT POST to Settings (Blocked by 403)
        $updateSettingsRes = $this->post(route('admin.settings.update'), [
            'event_date' => 'Minggu, 1 Januari 2027',
        ]);
        $updateSettingsRes->assertStatus(403);

        $updateRundownRes = $this->post(route('admin.settings.updateRundown'), [
            'session' => 1,
            'items' => [],
        ]);
        $updateRundownRes->assertStatus(403);

        // 4. Pengelolaan Akun: Panitia can view index, but only sees self
        $usersIndexRes = $this->get(route('admin.users.index'));
        $usersIndexRes->assertStatus(200);
        $usersIndexRes->assertSee('Profil Akun & Ganti Password');
        $usersIndexRes->assertSee('panitia_ahmad@test.com');
        $usersIndexRes->assertDontSee('panitia_siti@test.com'); // Other user is hidden from panitia
        $usersIndexRes->assertDontSee('Tambah Akun Pengguna'); // Create button is hidden

        // 5. Panitia CAN change OWN password
        $selfPwdRes = $this->post(route('admin.users.changePassword', $panitia), [
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        $selfPwdRes->assertRedirect(route('admin.users.index'));
        $selfPwdRes->assertSessionHas('success');
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('newpassword123', $panitia->fresh()->password));

        // 6. Panitia CANNOT change ANOTHER user's password (403 Forbidden)
        $otherPwdRes = $this->post(route('admin.users.changePassword', $otherPanitia), [
            'password' => 'hackedpassword123',
            'password_confirmation' => 'hackedpassword123',
        ]);
        $otherPwdRes->assertStatus(403);

        // 7. Panitia CANNOT create new users (403 Forbidden)
        $createRes = $this->post(route('admin.users.store'), [
            'name' => 'Hacker Panitia',
            'email' => 'hacker@test.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);
        $createRes->assertStatus(403);

        // 8. Panitia CANNOT update other user (403 Forbidden)
        $updateUserRes = $this->put(route('admin.users.update', $otherPanitia), [
            'name' => 'Modified Name',
            'email' => 'modified@test.com',
        ]);
        $updateUserRes->assertStatus(403);

        // 9. Panitia CANNOT delete other user (403 Forbidden)
        $deleteUserRes = $this->delete(route('admin.users.destroy', $otherPanitia));
        $deleteUserRes->assertStatus(403);
    }
}
