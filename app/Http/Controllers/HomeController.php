<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page with live dual-session quota information.
     */
    public function index()
    {
        $registrationStatus = Setting::get('registration_status', 'OPEN');

        // Session 1 (07:30 - 10:00 WIB)
        $s1Name = Setting::get('session_1_name', 'Sesi 1 (Pagi)');
        $s1Time = Setting::get('session_1_time', '07:30 – 10:00 WIB');
        $s1Max = (int) Setting::get('session_1_quota', 90);
        $s1WaitlistMax = (int) Setting::get('session_1_waitlist_quota', 30);
        $s1MainCount = Participant::session('1')->utama()->count();
        $s1WaitlistCount = Participant::session('1')->cadangan()->count();
        $s1RemainingMain = max(0, $s1Max - $s1MainCount);
        $s1RemainingWaitlist = max(0, $s1WaitlistMax - $s1WaitlistCount);
        $s1Percent = $s1Max > 0 ? min(100, round(($s1MainCount / $s1Max) * 100)) : 100;
        $s1IsFull = ($s1MainCount >= $s1Max) && ($s1WaitlistCount >= $s1WaitlistMax);
        $s1IsOpen = ($registrationStatus === 'OPEN') && !$s1IsFull;

        // Session 2 (10:30 - 12:00 WIB)
        $s2Name = Setting::get('session_2_name', 'Sesi 2 (Siang)');
        $s2Time = Setting::get('session_2_time', '10:30 – 12:00 WIB');
        $s2Max = (int) Setting::get('session_2_quota', 90);
        $s2WaitlistMax = (int) Setting::get('session_2_waitlist_quota', 30);
        $s2MainCount = Participant::session('2')->utama()->count();
        $s2WaitlistCount = Participant::session('2')->cadangan()->count();
        $s2RemainingMain = max(0, $s2Max - $s2MainCount);
        $s2RemainingWaitlist = max(0, $s2WaitlistMax - $s2WaitlistCount);
        $s2Percent = $s2Max > 0 ? min(100, round(($s2MainCount / $s2Max) * 100)) : 100;
        $s2IsFull = ($s2MainCount >= $s2Max) && ($s2WaitlistCount >= $s2WaitlistMax);
        $s2IsOpen = ($registrationStatus === 'OPEN') && !$s2IsFull;

        // Global Totals
        $totalSeats = $s1Max + $s2Max;
        $totalMainFilled = $s1MainCount + $s2MainCount;
        $totalMainRemaining = $s1RemainingMain + $s2RemainingMain;
        $isGlobalFull = $s1IsFull && $s2IsFull;
        $isGlobalOpen = ($registrationStatus === 'OPEN') && !$isGlobalFull;

        $eventDate = Setting::get('event_date', 'Senin, 21 Desember 2026');
        $eventLocation = Setting::get('event_location', 'Laboratorium Komputer SMP Muhammadiyah 1 Yogyakarta');
        $contactWhatsapp = Setting::get('contact_whatsapp', '081234567890');
        $isPublished = (bool) Setting::get('publish_selected_participants', '0');

        $session1Rundown = Setting::getRundown(1);
        $session2Rundown = Setting::getRundown(2);

        return view('landing', compact(
            'registrationStatus',
            'isPublished',
            's1Name', 's1Time', 's1Max', 's1WaitlistMax', 's1MainCount', 's1WaitlistCount', 's1RemainingMain', 's1RemainingWaitlist', 's1Percent', 's1IsFull', 's1IsOpen',
            's2Name', 's2Time', 's2Max', 's2WaitlistMax', 's2MainCount', 's2WaitlistCount', 's2RemainingMain', 's2RemainingWaitlist', 's2Percent', 's2IsFull', 's2IsOpen',
            'totalSeats', 'totalMainFilled', 'totalMainRemaining', 'isGlobalFull', 'isGlobalOpen',
            'eventDate', 'eventLocation', 'contactWhatsapp',
            'session1Rundown', 'session2Rundown'
        ));
    }

    /**
     * Display the official list of selected/confirmed participants (Peserta Terpilih).
     */
    public function selectedParticipants(Request $request)
    {
        $session = (string) $request->query('session', 'all');
        $search = trim($request->query('search', ''));

        $query = Participant::utama()->orderBy('session')->orderBy('id');

        if (in_array($session, ['1', '2'])) {
            $query->where('session', $session);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('school_name', 'like', "%{$search}%")
                  ->orWhere('reg_code', 'like', "%{$search}%");
            });
        }

        $participants = $query->paginate(30)->withQueryString();

        $s1Total = Participant::session('1')->utama()->count();
        $s2Total = Participant::session('2')->utama()->count();
        $totalSelected = $s1Total + $s2Total;

        $eventDate = Setting::get('event_date', 'Senin, 21 Desember 2026');
        $eventLocation = Setting::get('event_location', 'Laboratorium Komputer SMP Muhammadiyah 1 Yogyakarta');
        $contactWhatsapp = Setting::get('contact_whatsapp', '081234567890');
        $isPublished = (bool) Setting::get('publish_selected_participants', '0');

        return view('peserta-terpilih', compact(
            'participants', 'session', 'search', 's1Total', 's2Total', 'totalSelected', 'eventDate', 'eventLocation', 'contactWhatsapp', 'isPublished'
        ));
    }

    /**
     * Check registration status / search ticket.
     */
    public function checkTicket(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:3',
        ], [
            'query.required' => 'Masukkan 5 Huruf Kode Registrasi (misal: KMPXW) atau Nomor WhatsApp.',
            'query.min' => 'Pencarian minimal 3 karakter.',
        ]);

        $query = trim($request->input('query'));
        $cleanPhone = preg_replace('/[^0-9]/', '', $query);

        $participants = Participant::where('reg_code', 'LIKE', "%{$query}%")
            ->when($cleanPhone, function ($q) use ($cleanPhone) {
                $q->orWhere('whatsapp', 'LIKE', "%{$cleanPhone}%");
            })
            ->get();

        if ($participants->isEmpty()) {
            return back()->with('search_error', "Data pendaftaran untuk '{$query}' tidak ditemukan. Pastikan Kode Registrasi atau No. WhatsApp sudah sesuai.");
        }

        if ($participants->count() === 1) {
            return redirect()->route('ticket.show', $participants->first()->reg_code);
        }

        return back()->with('search_results', $participants);
    }
}
