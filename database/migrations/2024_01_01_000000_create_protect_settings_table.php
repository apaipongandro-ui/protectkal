<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProtectSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('protect_settings', function (Blueprint $table) {
            $table->id();
            
            // 14 Proteksi Toggles
            $table->boolean('protect1')->default(false)->comment('Anti Delete Server');
            $table->boolean('protect2')->default(false)->comment('Anti Hapus/Ubah User');
            $table->boolean('protect3')->default(false)->comment('Anti Akses Location');
            $table->boolean('protect4')->default(false)->comment('Anti Akses Nodes');
            $table->boolean('protect5')->default(false)->comment('Nests + Branding + Welcome Banner');
            $table->boolean('protect6')->default(false)->comment('Anti Akses Settings');
            $table->boolean('protect7')->default(false)->comment('Anti Akses Server File');
            $table->boolean('protect8')->default(false)->comment('Anti Akses Server Controller');
            $table->boolean('protect9')->default(false)->comment('Anti Modifikasi Server');
            $table->boolean('protect10')->default(false)->comment('Anti Tautan Server v1');
            $table->boolean('protect11')->default(false)->comment('Anti Tautan Server v2');
            $table->boolean('protect12')->default(false)->comment('Konsolidasi Proteksi');
            $table->boolean('protect13')->default(false)->comment('Proteksi Application API');
            $table->boolean('protect14')->default(false)->comment('Anti Create/Delete Admin');
            
            // Branding Configuration
            $table->string('brand_name')->default('ProtectKal')->comment('Nama brand di footer');
            $table->string('panel_title')->default('Pterodactyl Panel')->comment('Judul panel di tab browser');
            $table->string('protection_text')->default('🛡️ Protected by ProtectKal')->comment('Teks proteksi badge');
            $table->text('abort_message')->nullable()->comment('Custom pesan akses ditolak');
            
            // Telegram Integration
            $table->string('telegram_admin1')->nullable()->comment('Username Telegram Admin 1');
            $table->string('telegram_admin2')->nullable()->comment('Username Telegram Admin 2');
            $table->string('telegram_bot_username')->nullable()->comment('Username Bot Telegram');
            $table->string('label_brand')->default('ProtectKal')->comment('Label brand');
            
            // Welcome Banner
            $table->string('welcome_title')->default('Selamat Datang!')->comment('Judul welcome banner');
            $table->text('welcome_message')->nullable()->comment('Pesan welcome banner');
            $table->boolean('show_banner')->default(false)->comment('Tampilkan welcome banner');
            
            $table->timestamps();
        });
        
        // Insert default settings jika tabel kosong
        if (DB::table('protect_settings')->count() === 0) {
            DB::table('protect_settings')->insert([
                'brand_name' => 'ProtectKal',
                'panel_title' => 'Pterodactyl Panel - Protected by ProtectKal',
                'protection_text' => '🛡️ Protected by ProtectKal',
                'label_brand' => 'ProtectKal',
                'welcome_title' => 'Selamat Datang di Panel!',
                'welcome_message' => 'Terima kasih telah menggunakan layanan kami. Hubungi admin jika ada kendala.',
                'show_banner' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('protect_settings');
    }
}
