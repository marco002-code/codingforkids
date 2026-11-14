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

        // 2. Delete utama -> system should suggest promoting remaining waitlist
        $delUtamaResponse = $this->delete(route('admin.participants.destroy', $utama->id));
        $delUtamaResponse->assertSessionHas('success');
        $delUtamaResponse->assertSessionHas('suggest_promote_id', $cadangan2->id);
        $this->assertDatabaseMissing('participants', ['id' => $utama->id]);
    }

    public function test_admin_settings_tabs_and_rundown_stacks_management(): void
    {
        $admin = User::create([
            'name' => 'Admin Panitia',
            'email' => 'admin_settings@test.com',
            'password' => bcrypt('password123'),
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
    }
}
