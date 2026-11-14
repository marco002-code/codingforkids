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
        Setting::set('session_1_time', '08:00 – 10:30 WIB');
        Setting::set('session_1_quota', 2);
        Setting::set('session_1_waitlist_quota', 2);

        Setting::set('session_2_name', 'Sesi 2 (Siang)');
        Setting::set('session_2_time', '12:30 – 14:00 WIB');
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
        $response->assertSee('08:00 – 10:30 WIB');
        $response->assertSee('12:30 – 14:00 WIB');
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
        $this->assertStringStartsWith('AI26-S1-', $participant->reg_code);

        $response->assertRedirect(route('ticket.show', $participant->reg_code));
    }

    public function test_quota_isolation_between_sessions(): void
    {
        // Fill Session 1 quota (limit 2)
        Participant::create([
            'reg_code' => 'AI26-S1-001',
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
            'reg_code' => 'AI26-S1-002',
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
            'reg_code' => 'AI26-S2-003',
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
        $response->assertSee('08:00 – 10:30 WIB');
        $response->assertSee('12:30 – 14:00 WIB');

        // Promote cadangan S2
        $promoteResponse = $this->post('/admin/participants/' . $cadanganS2->id . '/promote');
        $promoteResponse->assertSessionHas('success');

        $cadanganS2->refresh();
        $this->assertEquals('UTAMA', $cadanganS2->status);
        $this->assertEquals('2', $cadanganS2->session);
        $this->assertNull($cadanganS2->waitlist_order);
    }
}
