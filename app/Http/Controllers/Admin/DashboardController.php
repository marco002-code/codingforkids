<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    /**
     * Admin Overview Dashboard with Dual Session Breakdown.
     */
    public function index()
    {
        // Session 1 (07:30 - 10:00 WIB)
        $s1Max = (int) Setting::get('session_1_quota', 90);
        $s1WaitlistMax = (int) Setting::get('session_1_waitlist_quota', 30);
        $s1Utama = Participant::session('1')->utama()->count();
        $s1Cadangan = Participant::session('1')->cadangan()->count();
        $s1Attended = Participant::session('1')->utama()->attended()->count();
        $s1Remaining = max(0, $s1Max - $s1Utama);

        // Session 2 (10:30 - 12:00 WIB)
        $s2Max = (int) Setting::get('session_2_quota', 90);
        $s2WaitlistMax = (int) Setting::get('session_2_waitlist_quota', 30);
        $s2Utama = Participant::session('2')->utama()->count();
        $s2Cadangan = Participant::session('2')->cadangan()->count();
        $s2Attended = Participant::session('2')->utama()->attended()->count();
        $s2Remaining = max(0, $s2Max - $s2Utama);

        // Global Totals
        $totalMax = $s1Max + $s2Max;
        $totalAll = Participant::count();
        $totalUtama = $s1Utama + $s2Utama;
        $totalCadangan = $s1Cadangan + $s2Cadangan;
        $totalDibatalkan = Participant::dibatalkan()->count();
        $totalAttended = $s1Attended + $s2Attended;
        $totalRemaining = $s1Remaining + $s2Remaining;

        $recentParticipants = Participant::orderBy('id', 'desc')->take(10)->get();
        $waitlistS1 = Participant::session('1')->cadangan()->take(4)->get();
        $waitlistS2 = Participant::session('2')->cadangan()->take(4)->get();

        return view('admin.dashboard', compact(
            's1Max', 's1WaitlistMax', 's1Utama', 's1Cadangan', 's1Attended', 's1Remaining',
            's2Max', 's2WaitlistMax', 's2Utama', 's2Cadangan', 's2Attended', 's2Remaining',
            'totalMax', 'totalAll', 'totalUtama', 'totalCadangan', 'totalDibatalkan', 'totalAttended', 'totalRemaining',
            'recentParticipants', 'waitlistS1', 'waitlistS2'
        ));
    }

    /**
     * Participant List with Session Filters & Search.
     */
    public function participants(Request $request)
    {
        $tab = $request->query('tab', 'utama'); // 'utama', 'cadangan', 'dibatalkan', 'all'
        $sessionFilter = $request->query('session', ''); // '', '1', '2'
        $search = trim($request->query('search', ''));
        $gender = $request->query('gender', '');

        $query = Participant::query();

        // Filter Session
        if ($sessionFilter && in_array($sessionFilter, ['1', '2'])) {
            $query->where('session', $sessionFilter);
        }

        // Filter Tab Status
        if ($tab === 'utama') {
            $query->utama()->orderBy('session', 'asc')->orderBy('id', 'asc');
        } elseif ($tab === 'cadangan') {
            $query->cadangan()->orderBy('session', 'asc');
        } elseif ($tab === 'dibatalkan') {
            $query->dibatalkan()->orderBy('updated_at', 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

        // Search
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('reg_code', 'LIKE', "%{$search}%")
                  ->orWhere('student_name', 'LIKE', "%{$search}%")
                  ->orWhere('nickname', 'LIKE', "%{$search}%")
                  ->orWhere('parent_name', 'LIKE', "%{$search}%")
                  ->orWhere('whatsapp', 'LIKE', "%{$search}%")
                  ->orWhere('school_name', 'LIKE', "%{$search}%");
            });
        }

        if ($gender && in_array($gender, ['L', 'P'])) {
            $query->where('gender', $gender);
        }

        $participants = $query->paginate(25)->withQueryString();

        // Calculate dynamic counts based on session filter
        $countQuery = function ($status = null) use ($sessionFilter) {
            $q = Participant::query();
            if ($sessionFilter && in_array($sessionFilter, ['1', '2'])) {
                $q->where('session', $sessionFilter);
            }
            if ($status) {
                $q->where('status', $status);
            }
            return $q->count();
        };

        $counts = [
            'utama' => $countQuery('UTAMA'),
            'cadangan' => $countQuery('CADANGAN'),
            'dibatalkan' => $countQuery('DIBATALKAN'),
            'all' => $countQuery(),
        ];

        return view('admin.participants', compact('participants', 'tab', 'sessionFilter', 'search', 'gender', 'counts'));
    }

    /**
     * Dedicated Attendance & Live Check-in workstation for Event Day.
     */
    public function attendance(Request $request)
    {
        $sessionFilter = $request->query('session', ''); // '', '1', '2'
        $statusFilter = $request->query('status', ''); // '', 'attended', 'unattended'
        $search = trim($request->query('search', ''));

        // Attendance stats
        $s1Max = (int) Setting::get('session_1_quota', 90);
        $s2Max = (int) Setting::get('session_2_quota', 90);

        $s1TotalUtama = Participant::session('1')->utama()->count();
        $s1Attended = Participant::session('1')->utama()->attended()->count();
        $s1Percent = $s1TotalUtama > 0 ? round(($s1Attended / $s1TotalUtama) * 100) : 0;

        $s2TotalUtama = Participant::session('2')->utama()->count();
        $s2Attended = Participant::session('2')->utama()->attended()->count();
        $s2Percent = $s2TotalUtama > 0 ? round(($s2Attended / $s2TotalUtama) * 100) : 0;

        $totalAttended = $s1Attended + $s2Attended;
        $totalUtama = $s1TotalUtama + $s2TotalUtama;
        $totalPercent = $totalUtama > 0 ? round(($totalAttended / $totalUtama) * 100) : 0;

        // Query participants (exclude DIBATALKAN by default)
        $query = Participant::where('status', '!=', 'DIBATALKAN');

        if ($sessionFilter && in_array($sessionFilter, ['1', '2'])) {
            $query->where('session', $sessionFilter);
        }

        if ($statusFilter === 'attended') {
            $query->where('is_attended', true)->orderBy('attended_at', 'desc');
        } elseif ($statusFilter === 'unattended') {
            $query->where('is_attended', false)->orderBy('student_name', 'asc');
        } else {
            $query->orderBy('is_attended', 'desc')->orderBy('attended_at', 'desc')->orderBy('id', 'desc');
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('reg_code', 'LIKE', "%{$search}%")
                  ->orWhere('student_name', 'LIKE', "%{$search}%")
                  ->orWhere('school_name', 'LIKE', "%{$search}%")
                  ->orWhere('whatsapp', 'LIKE', "%{$search}%");
            });
        }

        $participants = $query->paginate(25)->withQueryString();

        $recentCheckIns = Participant::where('is_attended', true)
            ->orderBy('attended_at', 'desc')
            ->take(8)
            ->get();

        return view('admin.attendance', compact(
            'participants',
            'sessionFilter',
            'statusFilter',
            'search',
            's1Max', 's1TotalUtama', 's1Attended', 's1Percent',
            's2Max', 's2TotalUtama', 's2Attended', 's2Percent',
            'totalAttended', 'totalUtama', 'totalPercent',
            'recentCheckIns'
        ));
    }

    /**
     * Promote a Cadangan (Waitlist) participant to Utama within their session.
     */
    public function promote(Participant $participant)
    {
        if ($participant->status !== 'CADANGAN') {
            return back()->with('error', 'Hanya peserta dengan status CADANGAN yang dapat dipromosikan.');
        }

        $session = $participant->session;

        DB::transaction(function () use ($participant, $session) {
            $participant->update([
                'status' => 'UTAMA',
                'waitlist_order' => null,
            ]);

            // Re-sequence remaining waitlist order for this session
            $cadanganList = Participant::session($session)->cadangan()->get();
            $order = 1;
            foreach ($cadanganList as $item) {
                if ($item->waitlist_order !== $order) {
                    $item->update(['waitlist_order' => $order]);
                }
                $order++;
            }
        });

        $waLink = $participant->whatsapp_promoted_url;

        return back()->with([
            'success' => "Peserta {$participant->student_name} ({$participant->reg_code}) berhasil dipromosikan menjadi PESERTA UTAMA {$participant->session_label}!",
            'promoted_wa_url' => $waLink,
            'promoted_name' => $participant->student_name,
        ]);
    }

    /**
     * Cancel a participant.
     */
    public function cancel(Request $request, Participant $participant)
    {
        $reason = $request->input('reason', 'Dibatalkan oleh panitia / konfirmasi orang tua.');
        $session = $participant->session;

        DB::transaction(function () use ($participant, $reason, $session) {
            $wasCadangan = ($participant->status === 'CADANGAN');

            $participant->update([
                'status' => 'DIBATALKAN',
                'waitlist_order' => null,
                'cancellation_reason' => $reason,
            ]);

            // If a waitlist participant was canceled, re-sequence the remaining waitlist for this session
            if ($wasCadangan) {
                $cadanganList = Participant::session($session)->cadangan()->get();
                $order = 1;
                foreach ($cadanganList as $item) {
                    if ($item->waitlist_order !== $order) {
                        $item->update(['waitlist_order' => $order]);
                    }
                    $order++;
                }
            }
        });

        // Suggest promote next candidate in THIS session
        $nextWaitlist = Participant::session($session)->cadangan()->first();

        $message = "Pendaftaran {$participant->student_name} ({$participant->reg_code}) telah berhasil dibatalkan.";

        if ($nextWaitlist) {
            return back()->with([
                'success' => $message,
                'suggest_promote_id' => $nextWaitlist->id,
                'suggest_promote_name' => $nextWaitlist->student_name,
                'suggest_promote_code' => $nextWaitlist->reg_code,
                'suggest_promote_session' => $nextWaitlist->session_label,
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Restore a canceled participant into their session.
     */
    public function restore(Participant $participant)
    {
        if ($participant->status !== 'DIBATALKAN') {
            return back()->with('error', 'Peserta tidak berstatus dibatalkan.');
        }

        $session = $participant->session;
        $maxMain = (int) Setting::get("session_{$session}_quota", 90);
        $currentUtama = Participant::session($session)->utama()->count();

        if ($currentUtama < $maxMain) {
            $participant->update([
                'status' => 'UTAMA',
                'waitlist_order' => null,
                'cancellation_reason' => null,
            ]);
            $msg = "Peserta {$participant->student_name} berhasil dipulihkan sebagai PESERTA UTAMA ({$participant->session_label}).";
        } else {
            $waitlistCount = Participant::session($session)->cadangan()->count();
            $participant->update([
                'status' => 'CADANGAN',
                'waitlist_order' => $waitlistCount + 1,
                'cancellation_reason' => null,
            ]);
            $msg = "Kuota utama penuh. Peserta {$participant->student_name} dipulihkan sebagai PESERTA CADANGAN (Antrean #{$participant->waitlist_order} {$participant->session_label}).";
        }

        return back()->with('success', $msg);
    }

    /**
     * Delete a participant permanently.
     */
    public function destroy(Participant $participant)
    {
        $name = $participant->student_name;
        $regCode = $participant->reg_code;
        $session = $participant->session;
        $wasUtama = ($participant->status === 'UTAMA');
        $wasCadangan = ($participant->status === 'CADANGAN');

        DB::transaction(function () use ($participant, $session, $wasCadangan) {
            $participant->delete();

            // If a waitlist participant was deleted, re-sequence the remaining waitlist for this session
            if ($wasCadangan) {
                $cadanganList = Participant::session($session)->cadangan()->get();
                $order = 1;
                foreach ($cadanganList as $item) {
                    if ($item->waitlist_order !== $order) {
                        $item->update(['waitlist_order' => $order]);
                    }
                    $order++;
                }
            }
        });

        $message = "Data pendaftaran {$name} ({$regCode}) telah berhasil dihapus secara permanen dari sistem.";

        // If an UTAMA participant was deleted and there's a CADANGAN candidate available, suggest promotion
        if ($wasUtama) {
            $nextWaitlist = Participant::session($session)->cadangan()->first();
            if ($nextWaitlist) {
                return back()->with([
                    'success' => $message,
                    'suggest_promote_id' => $nextWaitlist->id,
                    'suggest_promote_name' => $nextWaitlist->student_name,
                    'suggest_promote_code' => $nextWaitlist->reg_code,
                    'suggest_promote_session' => $nextWaitlist->session_label,
                ]);
            }
        }

        return back()->with('success', $message);
    }

    /**
     * Toggle Check-in status.
     */
    public function toggleCheckIn(Participant $participant)
    {
        $newStatus = !$participant->is_attended;
        $participant->update([
            'is_attended' => $newStatus,
            'attended_at' => $newStatus ? now() : null,
        ]);

        $statusText = $newStatus ? 'Hadir' : 'Batal Hadir';
        return back()->with('success', "Status absensi {$participant->student_name} ({$participant->session_label}) berhasil diubah: {$statusText}.");
    }

    /**
     * Quick Check-in via search bar / QR scanner / Camera scanner with session awareness.
     */
    public function quickCheckIn(Request $request)
    {
        $rawQuery = trim($request->input('code', ''));

        if (empty($rawQuery)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Masukkan Kode Registrasi atau Nama Siswa.'], 400);
            }
            return back()->with('error', 'Masukkan Kode Registrasi atau Nama Siswa untuk check-in.');
        }

        // Clean query: if full URL was scanned, extract the code
        $code = $rawQuery;
        if (preg_match('#/(?:ticket)/([A-Za-z0-9\-]+)#', $rawQuery, $matches)) {
            $code = $matches[1];
        } elseif (preg_match('/[?&]code=([A-Za-z0-9\-]+)/', $rawQuery, $matches)) {
            $code = $matches[1];
        }

        $codeUpper = strtoupper($code);

        $participant = Participant::where('reg_code', $codeUpper)
            ->orWhere('reg_code', $code)
            ->orWhere('student_name', 'LIKE', "%{$rawQuery}%")
            ->first();

        if (!$participant) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Peserta dengan kode/nama '{$rawQuery}' tidak ditemukan."
                ], 404);
            }
            return back()->with('error', "Peserta dengan kode/nama '{$rawQuery}' tidak ditemukan.");
        }

        if ($participant->status === 'DIBATALKAN') {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Pendaftaran {$participant->student_name} ({$participant->reg_code}) berstatus DIBATALKAN."
                ], 422);
            }
            return back()->with('error', "Pendaftaran {$participant->student_name} ({$participant->reg_code}) berstatus DIBATALKAN.");
        }

        $alreadyAttended = $participant->is_attended;
        $participant->update([
            'is_attended' => true,
            'attended_at' => now(),
        ]);

        $statusMsg = $alreadyAttended
            ? "ℹ️ SUDAH PERNAH CHECK-IN SEBELUMNYA: {$participant->student_name} ({$participant->reg_code}) &bull; [{$participant->session_label}]"
            : "✅ CHECK-IN BERHASIL: {$participant->student_name} ({$participant->reg_code}) &bull; [{$participant->session_label}] &bull; Status: {$participant->status}";

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'already_attended' => $alreadyAttended,
                'student_name' => $participant->student_name,
                'reg_code' => $participant->reg_code,
                'session_label' => $participant->session_label,
                'status' => $participant->status,
                'message' => $statusMsg,
            ]);
        }

        return back()->with('success', $statusMsg);
    }

    /**
     * Export data to CSV with UTF-8 BOM, including session breakdown.
     */
    public function export(Request $request): StreamedResponse
    {
        $tab = $request->query('tab', 'all');
        $session = $request->query('session', '');

        $query = Participant::query();

        if ($session && in_array($session, ['1', '2'])) {
            $query->where('session', $session);
        }

        if ($tab === 'utama') {
            $query->utama()->orderBy('session', 'asc')->orderBy('id', 'asc');
        } elseif ($tab === 'cadangan') {
            $query->cadangan()->orderBy('session', 'asc');
        } elseif ($tab === 'dibatalkan') {
            $query->dibatalkan()->orderBy('session', 'asc')->orderBy('id', 'asc');
        } else {
            $query->orderBy('session', 'asc')->orderBy('id', 'asc');
        }

        $participants = $query->get();
        $sessionSuffix = $session ? "_sesi{$session}" : "_semuasesi";
        $fileName = 'peserta_codingkids_' . $tab . $sessionSuffix . '_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($participants) {
            $output = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($output, [
                'No.',
                'Kode Registrasi',
                'Pilihan Sesi',
                'Waktu Sesi',
                'Status Pendaftaran',
                'Nomor Antrean Cadangan',
                'Nama Lengkap Siswa',
                'Nama Panggilan (Name Tag)',
                'Asal Sekolah',
                'Jenis Kelamin',
                'Pengalaman Coding',
                'Nama Orang Tua / Wali',
                'No. WhatsApp',
                'Email',
                'Kehadiran Hari-H',
                'Waktu Check-in',
                'Waktu Mendaftar',
                'Keterangan / Alasan Pembatalan',
            ]);

            $no = 1;
            foreach ($participants as $p) {
                fputcsv($output, [
                    $no++,
                    $p->reg_code,
                    'Sesi ' . $p->session,
                    $p->session_time,
                    $p->status,
                    $p->waitlist_order ?? '-',
                    $p->student_name,
                    $p->nickname,
                    $p->school_name,
                    $p->gender === 'L' ? 'Laki-laki' : 'Perempuan',
                    $p->experience_level,
                    $p->parent_name,
                    $p->whatsapp,
                    $p->email ?? '-',
                    $p->is_attended ? 'HADIR' : 'BELUM',
                    $p->attended_at ? $p->attended_at->format('d/m/Y H:i') : '-',
                    $p->created_at->format('d/m/Y H:i:s'),
                    $p->cancellation_reason ?? $p->notes ?? '-',
                ]);
            }

            fclose($output);
        }, 200, $headers);
    }

    /**
     * Show event & dual-session settings.
     */
    public function settings(Request $request)
    {
        $settings = Setting::all()->keyBy('key');
        $activeTab = $request->query('tab', 'event');
        $activeSession = (int) $request->query('session', 1);
        if (!in_array($activeSession, [1, 2])) {
            $activeSession = 1;
        }

        $session1Rundown = Setting::getRundown(1);
        $session2Rundown = Setting::getRundown(2);

        return view('admin.settings', compact('settings', 'activeTab', 'activeSession', 'session1Rundown', 'session2Rundown'));
    }

    /**
     * Update dual-session and event settings.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:150',
            'event_tagline' => 'nullable|string|max:200',
            'event_subtitle' => 'nullable|string|max:250',
            'event_date' => 'required|string|max:100',
            'event_location' => 'required|string|max:200',
            
            'session_1_name' => 'required|string|max:100',
            'session_1_time' => 'required|string|max:100',
            'session_1_quota' => 'required|integer|min:1',
            'session_1_waitlist_quota' => 'required|integer|min:0',

            'session_2_name' => 'required|string|max:100',
            'session_2_time' => 'required|string|max:100',
            'session_2_quota' => 'required|integer|min:1',
            'session_2_waitlist_quota' => 'required|integer|min:0',

            'registration_status' => 'required|in:OPEN,CLOSED',
            'publish_selected_participants' => 'nullable|in:0,1',
            'whatsapp_group_link' => 'nullable|url|max:200',
            'contact_whatsapp' => 'nullable|string|max:30',
            'contact_email' => 'nullable|email|max:100',
        ]);

        Setting::set('publish_selected_participants', $request->input('publish_selected_participants', '0'), 'announcement', 'Publikasi Daftar Peserta Terpilih');

        foreach ($request->only([
            'event_name',
            'event_tagline',
            'event_subtitle',
            'event_date',
            'event_location',
            'session_1_name',
            'session_1_time',
            'session_1_quota',
            'session_1_waitlist_quota',
            'session_2_name',
            'session_2_time',
            'session_2_quota',
            'session_2_waitlist_quota',
            'registration_status',
            'whatsapp_group_link',
            'contact_whatsapp',
            'contact_email',
        ]) as $key => $value) {
            Setting::set($key, $value);
        }

        $tab = $request->input('redirect_tab', 'event');

        return redirect()->route('admin.settings', ['tab' => $tab])
            ->with('success', 'Pengaturan sesi kegiatan & kuota pendaftaran berhasil diperbarui.');
    }

    /**
     * Update or reset stack materi / rundown for a session.
     */
    public function updateRundown(Request $request)
    {
        $session = (int) $request->input('session', 1);
        if (!in_array($session, [1, 2])) {
            $session = 1;
        }

        // Reset to default 5 stacks if requested
        if ($request->has('reset_default')) {
            $default = Setting::defaultRundown($session);
            Setting::set("session_{$session}_rundown", json_encode($default, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), 'rundown', "Stack Materi Sesi {$session}");
            return redirect()->route('admin.settings', ['tab' => 'rundown', 'session' => $session])
                ->with('success', "Stack materi Sesi {$session} berhasil direset ke format default 5 stack.");
        }

        $items = $request->input('items', []);
        $cleaned = [];

        if (is_array($items)) {
            foreach ($items as $item) {
                $time = trim($item['time'] ?? '');
                $title = trim($item['title'] ?? '');
                $description = trim($item['description'] ?? '');
                $duration = trim($item['duration'] ?? '');
                $type = trim($item['type'] ?? 'default');

                if (!empty($time) || !empty($title)) {
                    $cleaned[] = [
                        'time' => $time,
                        'title' => $title,
                        'description' => $description,
                        'duration' => $duration,
                        'type' => in_array($type, ['default', 'blue', 'amber', 'purple', 'emerald']) ? $type : 'default',
                    ];
                }
            }
        }

        if (empty($cleaned)) {
            return back()->with('error', 'Minimal harus ada 1 stack materi yang disimpan.');
        }

        Setting::set("session_{$session}_rundown", json_encode($cleaned, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), 'rundown', "Stack Materi Sesi {$session}");

        return redirect()->route('admin.settings', ['tab' => 'rundown', 'session' => $session])
            ->with('success', "Stack materi rundown Sesi {$session} berhasil diperbarui (" . count($cleaned) . " stack materi).");
    }

    /**
     * Toggle publishing status for selected participants announcement.
     */
    public function togglePublishSelected()
    {
        $current = Setting::get('publish_selected_participants', '0');
        $newStatus = ($current === '1' || $current === 1 || $current === true) ? '0' : '1';
        Setting::set('publish_selected_participants', $newStatus, 'announcement', 'Publikasi Daftar Peserta Terpilih');

        $msg = ($newStatus === '1')
            ? '✅ Pengumuman Daftar Peserta Terpilih Berhasil DIPUBLIKASIKAN ke publik!'
            : '🔒 Pengumuman Daftar Peserta Terpilih diubah menjadi DRAF (Masyarakat umum melihat pesan: "Data Pendaftar dalam Proses Konfirmasi dan Validasi").';

        return back()->with('success', $msg);
    }
}
