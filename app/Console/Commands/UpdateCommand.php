<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateCommand extends Command
{
    protected $signature = 'update';
    protected $description = 'Memperbarui aplikasi ke versi terbaru';

    public function handle()
    {
        $this->info('🔄 Memulai pembaruan aplikasi...');

        // Simpan hash composer.json sebelum git pull
        $beforeHash = file_exists('composer.json') ? md5_file('composer.json') : null;

        // Jalankan git pull
        exec('git pull origin main', $output, $resultCode);

        if ($resultCode !== 0) {
            $this->error('❌ Gagal memperbarui aplikasi. Silakan coba lagi.');
            return;
        }

        // Simpan hash setelah git pull
        $afterHash = file_exists('composer.json') ? md5_file('composer.json') : null;

        // Jika composer.json berubah, jalankan composer install
        if ($beforeHash !== $afterHash) {
            $this->info('📦 Menginstal pembaruan dependensi...');
            exec('composer install --no-interaction --prefer-dist --optimize-autoloader', $composerOutput, $composerResult);

            if ($composerResult !== 0) {
                $this->error('❌ Gagal memperbarui dependensi.');
                return;
            }
        }

        // Jalankan migrasi
        $this->info('🗄️ Memperbarui struktur database...');
        $this->call('migrate', ['--force' => true]);

        $this->info('✅ Aplikasi berhasil diperbarui ke versi terbaru.');
    }
}
