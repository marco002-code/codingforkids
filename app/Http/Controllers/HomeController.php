<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page with live quota information.
     */
    public function index()
    {
        $maxMain = (int) Setting::get('max_main_quota', 50);
        $maxWaitlist = (int) Setting::get('max_waitlist_quota', 20);
        $registrationStatus = Setting::get('registration_status', 'OPEN');

        $activeMainCount = Participant::utama()->count();
        $activeWaitlistCount = Participant::cadangan()->count();

        $remainingMain = max(0, $maxMain - $activeMainCount);
        $remainingWaitlist = max(0, $maxWaitlist - $activeWaitlistCount);
        $totalQuota = $maxMain + $maxWaitlist;
        $totalFilled = $activeMainCount + $activeWaitlistCount;

        // Is registration completely full?
        $isFull = ($activeMainCount >= $maxMain) && ($activeWaitlistCount >= $maxWaitlist);
        $isOpen = ($registrationStatus === 'OPEN') && !$isFull;

        // Quota percentage for progress bar
        $percentMain = $maxMain > 0 ? min(100, round(($activeMainCount / $maxMain) * 100)) : 100;

        return view('landing', compact(
            'maxMain',
            'maxWaitlist',
            'registrationStatus',
            'activeMainCount',
            'activeWaitlistCount',
            'remainingMain',
            'remainingWaitlist',
            'totalQuota',
            'totalFilled',
            'isFull',
            'isOpen',
            'percentMain'
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
            'query.required' => 'Masukkan Kode Registrasi (AI26-XXX) atau Nomor WhatsApp.',
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
