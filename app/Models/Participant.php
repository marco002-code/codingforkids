<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'reg_code',
        'session',
        'student_name',
        'nickname',
        'school_name',
        'student_whatsapp',
        'gender',
        'experience_level',
        'parent_name',
        'whatsapp',
        'email',
        'status',
        'waitlist_order',
        'is_attended',
        'attended_at',
        'cancellation_reason',
        'notes',
    ];

    protected $casts = [
        'is_attended' => 'boolean',
        'attended_at' => 'datetime',
        'waitlist_order' => 'integer',
    ];

    // Scopes
    public function scopeUtama(Builder $query): Builder
    {
        return $query->where('status', 'UTAMA');
    }

    public function scopeCadangan(Builder $query): Builder
    {
        return $query->where('status', 'CADANGAN')->orderBy('waitlist_order', 'asc');
    }

    public function scopeDibatalkan(Builder $query): Builder
    {
        return $query->where('status', 'DIBATALKAN');
    }

    public function scopeAttended(Builder $query): Builder
    {
        return $query->where('is_attended', true);
    }

    public function scopeSession(Builder $query, $session): Builder
    {
        return $query->where('session', (string) $session);
    }

    /**
     * Get human-readable session label with time.
     */
    public function getSessionLabelAttribute(): string
    {
        if ($this->session === '2') {
            return 'Sesi 2: 10:30 – 12:00 WIB';
        }
        return 'Sesi 1: 07:30 – 10:00 WIB';
    }

    public function getSessionTimeAttribute(): string
    {
        return $this->session === '2' ? '10:30 – 12:00 WIB' : '07:30 – 10:00 WIB';
    }

    /**
     * Format WhatsApp phone number to standard international 628xxx.
     */
    public function getFormattedWhatsappAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->whatsapp ?? '');
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }
        return $phone;
    }

    /**
     * Generate direct WhatsApp link.
     */
    public function getWhatsappUrlAttribute(): string
    {
        return "https://wa.me/" . $this->formatted_whatsapp;
    }

    /**
     * Generate WhatsApp link with ticket confirmation text.
     */
    public function getWhatsappConfirmationUrlAttribute(): string
    {
        $eventName = Setting::get('event_name', 'Coding for Kids & A.I. for Learning');
        $eventDate = Setting::get('event_date', 'Senin, 21 Desember 2026');
        $ticketUrl = route('ticket.show', $this->reg_code);
        $sessionInfo = $this->session_label;
        
        if ($this->status === 'UTAMA') {
            $text = "Halo Bapak/Ibu {$this->parent_name},\n\n"
                  . "Pendaftaran ananda *{$this->student_name}* untuk workshop *{$eventName}* telah *TERKONFIRMASI SEBAGAI PESERTA UTAMA* ✅\n\n"
                  . "📌 *Kode Registrasi:* {$this->reg_code}\n"
                  . "⏰ *Pilihan Sesi:* {$sessionInfo}\n"
                  . "📅 *Jadwal Acara:* {$eventDate}\n"
                  . "🎫 *Lihat E-Ticket:* {$ticketUrl}\n\n"
                  . "Mohon simpan tiket ini dan tunjukkan saat registrasi ulang. Sampai jumpa di lokasi acara!";
        } elseif ($this->status === 'CADANGAN') {
            $text = "Halo Bapak/Ibu {$this->parent_name},\n\n"
                  . "Terima kasih telah mendaftarkan *{$this->student_name}* untuk workshop *{$eventName}*.\n\n"
                  . "Saat ini ananda tercatat sebagai *PESERTA CADANGAN (Antrean #{$this->waitlist_order})* untuk *{$sessionInfo}* 📋\n"
                  . "📌 *Kode Registrasi:* {$this->reg_code}\n"
                  . "🎫 *Cek Status Antrean:* {$ticketUrl}\n\n"
                  . "Panitia akan menghubungi Anda paling lambat H-2 apabila terdapat peserta utama yang berhalangan hadir.";
        } else {
            $text = "Halo Bapak/Ibu {$this->parent_name},\n\n"
                  . "Status pendaftaran *{$this->student_name}* ({$this->reg_code}) untuk {$sessionInfo} saat ini adalah *DIBATALKAN*.\n"
                  . "Silakan hubungi panitia jika terdapat pertanyaan. Terima kasih.";
        }

        return "https://wa.me/" . $this->formatted_whatsapp . "?text=" . urlencode($text);
    }

    /**
     * Generate WhatsApp notification URL when promoted to UTAMA.
     */
    public function getWhatsappPromotedUrlAttribute(): string
    {
        $eventName = Setting::get('event_name', 'Coding for Kids & A.I. for Learning');
        $eventDate = Setting::get('event_date', 'Senin, 21 Desember 2026');
        $ticketUrl = route('ticket.show', $this->reg_code);
        $groupUrl = Setting::get('whatsapp_group_link', 'https://chat.whatsapp.com');
        $sessionInfo = $this->session_label;

        $text = "🎉 *KABAR GEMBIRA! PROMOSI PESERTA UTAMA*\n\n"
              . "Halo Bapak/Ibu {$this->parent_name},\n"
              . "Kami menginformasikan bahwa kursi utama telah tersedia untuk ananda *{$this->student_name}* dalam kegiatan *{$eventName}*!\n\n"
              . "Status ananda resmi *DIPROMOSIKAN MENJADI PESERTA UTAMA* ✅\n"
              . "📌 *Kode Registrasi:* {$this->reg_code}\n"
              . "⏰ *Jadwal Sesi:* {$sessionInfo}\n"
              . "📅 *Waktu:* {$eventDate}\n"
              . "🎫 *E-Ticket Resmi:* {$ticketUrl}\n\n"
              . "Mohon segera bergabung ke Grup WhatsApp Koordinasi Peserta:\n{$groupUrl}\n\n"
              . "Terima kasih dan sampai jumpa!";

        return "https://wa.me/" . $this->formatted_whatsapp . "?text=" . urlencode($text);
    }

    /**
     * Generate 5 unique random uppercase letters for registration code (e.g. KMPXW).
     * Easy to read, remember, and quick for panitia presensi.
     */
    public static function generateRegCode($session = '1'): string
    {
        $letters = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $maxIndex = strlen($letters) - 1;

        do {
            $code = '';
            for ($i = 0; $i < 5; $i++) {
                $code .= $letters[random_int(0, $maxIndex)];
            }
        } while (static::where('reg_code', $code)->exists());

        return $code;
    }
}
