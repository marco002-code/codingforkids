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
     * Admin Overview Dashboard.
     */
    public function index()
    {
        $maxMain = (int) Setting::get('max_main_quota', 50);
        $maxWaitlist = (int) Setting::get('max_waitlist_quota', 20);

        $totalAll = Participant::count();
        $countUtama = Participant::utama()->count();
        $countCadangan = Participant::cadangan()->count();
        $countDibatalkan = Participant::dibatalkan()->count();
        $countAttended = Participant::utama()->attended()->count();

        $remainingMain = max(0, $maxMain - $countUtama);
        $remainingWaitlist = max(0, $maxWaitlist - $countCadangan);

        $recentParticipants = Participant::orderBy('id', 'desc')->take(8)->get();
        $waitlistTop = Participant::cadangan()->take(5)->get();

        return view('admin.dashboard', compact(
            'maxMain',
            'maxWaitlist',
            'totalAll',
            'countUtama',
            'countCadangan',
            'countDibatalkan',
            'countAttended',
            'remainingMain',
            'remainingWaitlist',
            'recentParticipants',
            'waitlistTop'
        ));
    }

    /**
     * Participant List with Tabs & Search.
     */
    public function participants(Request $request)
    {
        $tab = $request->query('tab', 'utama'); // 'utama', 'cadangan', 'dibatalkan', 'all'
        $search = trim($request->query('search', ''));
        $gender = $request->query('gender', '');

        $query = Participant::query();

        if ($tab === 'utama') {
            $query->utama()->orderBy('id', 'asc');
        } elseif ($tab === 'cadangan') {
            $query->cadangan();
        } elseif ($tab === 'dibatalkan') {
            $query->dibatalkan()->orderBy('updated_at', 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

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

        $counts = [
            'utama' => Participant::utama()->count(),
            'cadangan' => Participant::cadangan()->count(),
            'dibatalkan' => Participant::dibatalkan()->count(),
            'all' => Participant::count(),
        ];

        return view('admin.participants', compact('participants', 'tab', 'search', 'gender', 'counts'));
    }

    /**
     * Promote a Cadangan (Waitlist) participant to Utama.
     */
    public function promote(Participant $participant)
    {
        if ($participant->status !== 'CADANGAN') {
            return back()->with('error', 'Hanya peserta dengan status CADANGAN yang dapat dipromosikan.');
        }

        $maxMain = (int) Setting::get('max_main_quota', 50);
        $currentUtama = Participant::utama()->count();

        DB::transaction(function () use ($participant) {
            $participant->update([
                'status' => 'UTAMA',
                'waitlist_order' => null,
            ]);

            // Re-sequence remaining waitlist order
            $cadanganList = Participant::cadangan()->get();
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
            'success' => "Peserta {$participant->student_name} ({$participant->reg_code}) berhasil dipromosikan menjadi PESERTA UTAMA!",
            'promoted_wa_url' => $waLink,
            'promoted_name' => $participant->student_name,
        ]);
    }

    /**
     * Cancel a participant.
     */
    public function cancel(Request $request, Participant $participant)
    {
        $reason = $request->input('reason', 'Dibatalkan oleh panitia/konfirmasi orang tua.');

        DB::transaction(function () use ($participant, $reason) {
            $wasCadangan = ($participant->status === 'CADANGAN');

            $participant->update([
                'status' => 'DIBATALKAN',
                'waitlist_order' => null,
                'cancellation_reason' => $reason,
            ]);

            // If a waitlist participant was canceled, re-sequence the remaining waitlist
            if ($wasCadangan) {
                $cadanganList = Participant::cadangan()->get();
                $order = 1;
                foreach ($cadanganList as $item) {
                    if ($item->waitlist_order !== $order) {
                        $item->update(['waitlist_order' => $order]);
                    }
                    $order++;
                }
            }
        });

        // Check if there is a next waitlist candidate to suggest promotion
        $nextWaitlist = Participant::cadangan()->first();

        $message = "Pendaftaran {$participant->student_name} ({$participant->reg_code}) telah berhasil dibatalkan.";

        if ($nextWaitlist) {
            return back()->with([
                'success' => $message,
                'suggest_promote_id' => $nextWaitlist->id,
                'suggest_promote_name' => $nextWaitlist->student_name,
                'suggest_promote_code' => $nextWaitlist->reg_code,
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Restore a canceled participant.
     */
    public function restore(Participant $participant)
    {
        if ($participant->status !== 'DIBATALKAN') {
            return back()->with('error', 'Peserta tidak berstatus dibatalkan.');
        }

        $maxMain = (int) Setting::get('max_main_quota', 50);
        $currentUtama = Participant::utama()->count();

        if ($currentUtama < $maxMain) {
            $participant->update([
                'status' => 'UTAMA',
                'waitlist_order' => null,
                'cancellation_reason' => null,
            ]);
            $msg = "Peserta {$participant->student_name} berhasil dipulihkan sebagai PESERTA UTAMA.";
        } else {
            $waitlistCount = Participant::cadangan()->count();
            $participant->update([
                'status' => 'CADANGAN',
                'waitlist_order' => $waitlistCount + 1,
                'cancellation_reason' => null,
            ]);
            $msg = "Kuota utama penuh. Peserta {$participant->student_name} dipulihkan sebagai PESERTA CADANGAN (#" . ($waitlistCount + 1) . ").";
        }

        return back()->with('success', $msg);
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
        return back()->with('success', "Status absensi {$participant->student_name} berhasil diubah: {$statusText}.");
    }

    /**
     * Quick Check-in via search bar / barcode scanner.
     */
    public function quickCheckIn(Request $request)
    {
        $query = trim($request->input('code', ''));

        if (empty($query)) {
            return back()->with('error', 'Masukkan Kode Registrasi atau Nama Siswa untuk check-in.');
        }

        $participant = Participant::where('reg_code', $query)
            ->orWhere('student_name', 'LIKE', "%{$query}%")
            ->first();

        if (!$participant) {
            return back()->with('error', "Peserta dengan kode/nama '{$query}' tidak ditemukan.");
        }

        if ($participant->status === 'DIBATALKAN') {
            return back()->with('error', "Pendaftaran {$participant->student_name} ({$participant->reg_code}) berstatus DIBATALKAN.");
        }

        $participant->update([
            'is_attended' => true,
            'attended_at' => now(),
        ]);

        return back()->with('success', "✅ CHECK-IN BERHASIL: {$participant->student_name} ({$participant->reg_code}) - Status: {$participant->status}");
    }

    /**
     * Export data to CSV with UTF-8 BOM for Excel.
     */
    public function export(Request $request): StreamedResponse
    {
        $tab = $request->query('tab', 'all');

        $query = Participant::query();
        if ($tab === 'utama') {
            $query->utama()->orderBy('id', 'asc');
        } elseif ($tab === 'cadangan') {
            $query->cadangan();
        } elseif ($tab === 'dibatalkan') {
            $query->dibatalkan()->orderBy('id', 'asc');
        } else {
            $query->orderBy('id', 'asc');
        }

        $participants = $query->get();
        $fileName = 'peserta_coding_for_kids_' . $tab . '_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($participants) {
            $output = fopen('php://output', 'w');

            // UTF-8 BOM so Excel opens indonesian characters correctly
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($output, [
                'No.',
                'Kode Registrasi',
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
     * Show event & quota settings form.
     */
    public function settings()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:150',
            'event_tagline' => 'nullable|string|max:200',
            'event_subtitle' => 'nullable|string|max:250',
            'event_date' => 'required|string|max:100',
            'event_time' => 'required|string|max:100',
            'event_location' => 'required|string|max:200',
            'max_main_quota' => 'required|integer|min:1',
            'max_waitlist_quota' => 'required|integer|min:0',
            'registration_status' => 'required|in:OPEN,CLOSED',
            'whatsapp_group_link' => 'nullable|url|max:200',
            'contact_whatsapp' => 'nullable|string|max:30',
            'contact_email' => 'nullable|email|max:100',
        ]);

        foreach ($request->only([
            'event_name',
            'event_tagline',
            'event_subtitle',
            'event_date',
            'event_time',
            'event_location',
            'max_main_quota',
            'max_waitlist_quota',
            'registration_status',
            'whatsapp_group_link',
            'contact_whatsapp',
            'contact_email',
        ]) as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan acara & kuota pendaftaran berhasil diperbarui.');
    }
}

