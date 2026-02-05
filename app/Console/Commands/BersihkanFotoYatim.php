<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\LaporanKegiatan;

class BersihkanFotoYatim extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'foto:bersihkan';

    /**
     * The console command description.
     */
    protected $description = 'Menghapus foto laporan yang tidak lagi tercatat di database';

    public function handle()
    {
        $this->info('🔍 Mengumpulkan foto dari database...');

        // 1️⃣ Ambil semua path foto dari database
        $fotoDB = LaporanKegiatan::pluck('foto')
            ->filter()
            ->flatMap(function ($item) {
                return is_array($item) ? $item : json_decode($item, true);
            })
            ->filter()
            ->values()
            ->toArray();

        $this->info('📦 Total foto tercatat di DB: ' . count($fotoDB));

        // 2️⃣ Ambil semua file di folder storage
        $this->info('📂 Membaca folder storage/app/public/laporan_kegiatan ...');

        $files = Storage::disk('public')->files('laporan_kegiatan');

        $this->info('📁 Total file di storage: ' . count($files));

        // 3️⃣ Bandingkan & hapus yang tidak ada di DB
        $deleted = 0;

        foreach ($files as $file) {
            if (!in_array($file, $fotoDB)) {
                Storage::disk('public')->delete($file);
                $deleted++;
                $this->line("❌ Dihapus: {$file}");
            }
        }

        $this->info("✅ Selesai. Total foto yatim dihapus: {$deleted}");

        return Command::SUCCESS;
    }
}
