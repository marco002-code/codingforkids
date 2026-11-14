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
        Setting::set('max_main_quota', 2);
        Setting::set('max_waitlist_quota', 2);
        Setting::set('registration_status', 'OPEN');
        Setting::set('event_name', 'Coding for Kids Test');
        Setting::set('event_date', 'Senin, 21 Desember 2026');
    }

    public function test_landing_page_can_be_rendered(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Coding for Kids');
        $response->assertSee('Senin, 21 Desember 2026');
    }

    public function test_registration_creates_utama_participant_when_quota_available(): void
    {
        $response = $this->post('/register', [
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
        $this->assertEquals('UTAMA', $participant->status);
        $this->assertNull($participant->waitlist_order);
        $this->assertStringStartsWith('AI26-', $participant->reg_code);

        $response->assertRedirect(route('ticket.show', $participant->reg_code));
    }

    public function test_registration_switches_to_waitlist_when_main_quota_is_full(): void
    {
        // Fill main quota (max 2)
        Participant::create([
            'reg_code' => 'AI26-001',
            'student_name' => 'Siswa 1',
            'nickname' => 'S1',
            'school_name' => 'SD 1',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Ortu 1',
            'whatsapp' => '0811111111',
            'status' => 'UTAMA',
        ]);

        Participant::create([
            'reg_code' => 'AI26-002',
            'student_name' => 'Siswa 2',
            'nickname' => 'S2',
            'school_name' => 'SD 2',
            'gender' => 'P',
            'experience_level' => 'Pernah Sedikit',
            'parent_name' => 'Ortu 2',
            'whatsapp' => '0822222222',
            'status' => 'UTAMA',
        ]);

        // Register 3rd student -> should go to Waitlist #1
        $response = $this->post('/register', [
            'student_name' => 'Siswa Cadangan Pertama',
            'nickname' => 'Cadangan1',
            'school_name' => 'SD 3',
            'gender' => 'L',
            'experience_level' => 'Belum Pernah',
            'parent_name' => 'Ortu 3',
            'whatsapp' => '0833333333',
            'terms_agreement' => '1',
            'waitlist_agreement' => '1',
        ]);

        $waitlistParticipant = Participant::where('student_name', 'Siswa Cadangan Pertama')->first();
        $this->assertNotNull($waitlistParticipant);
        $this->assertEquals('CADANGAN', $waitlistParticipant->status);
        $this->assertEquals(1, $waitlistParticipant->waitlist_order);
        $response->assertRedirect(route('ticket.show', $waitlistParticipant->reg_code));
    }

    public function test_ticket_page_shows_correct_information(): void
    {
        $participant = Participant::create([
            'reg_code' => 'AI26-999',
            'student_name' => 'Bintang Perkasa',
            'nickname' => 'Bintang',
            'school_name' => 'SD Permata Hati',
            'gender' => 'L',
            'experience_level' => 'Sudah Terbiasa',
            'parent_name' => 'Surya Perkasa',
            'whatsapp' => '0899999999',
            'status' => 'UTAMA',
        ]);

        $response = $this->get('/ticket/' . $participant->reg_code);
        $response->assertStatus(200);
        $response->assertSee('AI26-999');
        $response->assertSee('Bintang Perkasa');
        $response->assertSee('PESERTA UTAMA');
    }

    public function test_admin_dashboard_and_promotion_feature(): void
    {
        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);

        $cadangan = Participant::create([
            'reg_code' => 'AI26-003',
            'student_name' => 'Ananda Cadangan',
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
        $response->assertSee('Ringkasan Sistem Pendaftaran');

        // Promote cadangan
        $promoteResponse = $this->post('/admin/participants/' . $cadangan->id . '/promote');
        $promoteResponse->assertSessionHas('success');

        $cadangan->refresh();
        $this->assertEquals('UTAMA', $cadangan->status);
        $this->assertNull($cadangan->waitlist_order);
    }
}

