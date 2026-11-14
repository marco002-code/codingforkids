<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    /**
     * Handle incoming participant registration.
     */
    public function store(Request $request)
    {
        // 1. Check if registration is explicitly closed
        $registrationStatus = Setting::get('registration_status', 'OPEN');
        if ($registrationStatus !== 'OPEN') {
            return back()->withInput()->with('error', 'Mohon maaf, pendaftaran saat ini sedang ditutup oleh panitia.');
        }

        // 2. Validate input
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|max:120',
            'nickname' => 'required|string|max:60',
            'school_name' => 'required|string|max:150',
            'gender' => 'required|in:L,P',
            'experience_level' => 'required|in:Belum Pernah,Pernah Sedikit,Sudah Terbiasa',
            'parent_name' => 'required|string|max:120',
            'whatsapp' => 'required|string|min:8|max:20',
            'email' => 'nullable|email|max:120',
            'notes' => 'nullable|string|max:500',
            'terms_agreement' => 'required|accepted',
            'waitlist_agreement' => 'required|accepted',
        ], [
            'student_name.required' => 'Nama lengkap siswa wajib diisi.',
            'nickname.required' => 'Nama panggilan siswa wajib diisi untuk tanda pengenal (Name Tag).',
            'school_name.required' => 'Asal sekolah (SD/MI) wajib diisi.',
            'gender.required' => 'Pilih jenis kelamin siswa.',
            'experience_level.required' => 'Pilih tingkat pengalaman komputer/coding siswa.',
            'parent_name.required' => 'Nama lengkap orang tua/wali wajib diisi.',
            'whatsapp.required' => 'Nomor WhatsApp aktif orang tua wajib diisi untuk pengiriman tiket dan konfirmasi.',
            'whatsapp.min' => 'Nomor WhatsApp tidak valid (minimal 8 angka).',
            'email.email' => 'Format email tidak valid.',
            'terms_agreement.required' => 'Anda harus menyetujui izin keikutsertaan kegiatan.',
            'terms_agreement.accepted' => 'Anda harus menyetujui izin keikutsertaan kegiatan.',
            'waitlist_agreement.required' => 'Anda harus menyetujui ketentuan kuota utama dan sistem cadangan.',
            'waitlist_agreement.accepted' => 'Anda harus menyetujui ketentuan kuota utama dan sistem cadangan.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error_modal', 'Terdapat kolom formulir yang belum lengkap atau tidak valid.');
        }

        // 3. Process registration atomically with DB transaction
        try {
            $participant = DB::transaction(function () use ($request) {
                $maxMain = (int) Setting::get('max_main_quota', 50);
                $maxWaitlist = (int) Setting::get('max_waitlist_quota', 20);

                // Lock the participants table or count active registrations
                $activeMainCount = Participant::where('status', 'UTAMA')->lockForUpdate()->count();
                $activeWaitlistCount = Participant::where('status', 'CADANGAN')->lockForUpdate()->count();

                if ($activeMainCount < $maxMain) {
                    $status = 'UTAMA';
                    $waitlistOrder = null;
                } elseif ($activeWaitlistCount < $maxWaitlist) {
                    $status = 'CADANGAN';
                    $waitlistOrder = $activeWaitlistCount + 1;
                } else {
                    throw new \Exception('QUOTA_FULL');
                }

                // Generate Unique Code
                $regCode = Participant::generateRegCode();

                return Participant::create([
                    'reg_code' => $regCode,
                    'student_name' => trim($request->input('student_name')),
                    'nickname' => trim($request->input('nickname')),
                    'school_name' => trim($request->input('school_name')),
                    'gender' => $request->input('gender'),
                    'experience_level' => $request->input('experience_level'),
                    'parent_name' => trim($request->input('parent_name')),
                    'whatsapp' => trim($request->input('whatsapp')),
                    'email' => trim($request->input('email')),
                    'status' => $status,
                    'waitlist_order' => $waitlistOrder,
                    'is_attended' => false,
                    'notes' => $request->input('notes'),
                ]);
            });

            // Redirect to E-Ticket page
            $successMessage = $participant->status === 'UTAMA'
                ? "Selamat! Pendaftaran berhasil. Ananda {$participant->student_name} terdaftar sebagai PESERTA UTAMA."
                : "Pendaftaran berhasil dicatat! Karena kuota utama telah terisi penuh, ananda {$participant->student_name} masuk sebagai PESERTA CADANGAN (Nomor Urut #{$participant->waitlist_order}).";

            return redirect()->route('ticket.show', $participant->reg_code)->with('status_message', $successMessage);

        } catch (\Exception $e) {
            if ($e->getMessage() === 'QUOTA_FULL') {
                return back()->withInput()->with('error', 'Mohon maaf, kuota kursi utama dan batas antrean cadangan saat ini telah terpenuhi.');
            }

            return back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memproses data: ' . $e->getMessage());
        }
    }

    /**
     * Display the confirmation / E-Ticket page.
     */
    public function showTicket($reg_code)
    {
        $participant = Participant::where('reg_code', $reg_code)->firstOrFail();

        $eventName = Setting::get('event_name', 'Coding for Kids and A.I. for Learning');
        $eventDate = Setting::get('event_date', 'Senin, 21 Desember 2026');
        $eventTime = Setting::get('event_time', '08.30 – 12.30 WIB');
        $eventLocation = Setting::get('event_location', 'Lab Komputer & Auditorium Gedung Edukasi Teknologi, Lt. 3');
        $whatsappGroupLink = Setting::get('whatsapp_group_link', 'https://chat.whatsapp.com');
        $contactWhatsapp = Setting::get('contact_whatsapp', '081234567890');

        return view('ticket', compact(
            'participant',
            'eventName',
            'eventDate',
            'eventTime',
            'eventLocation',
            'whatsappGroupLink',
            'contactWhatsapp'
        ));
    }
}
