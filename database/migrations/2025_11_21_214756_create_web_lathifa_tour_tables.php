<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 2. PACKAGES (Data Utama Paket)
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();

            // Harga Sederhana (Tanpa tabel varian)
            $table->decimal('price_quad', 15, 2)->default(0)->comment('Harga Sekamar Ber-4');
            $table->decimal('price_triple', 15, 2)->default(0)->comment('Harga Sekamar Ber-3');
            $table->decimal('price_double', 15, 2)->default(0)->comment('Harga Sekamar Ber-2');

            $table->date('departure_date');
            $table->integer('duration_days')->default(9);

            // Fasilitas (Text Only agar cepat)
            $table->string('hotel_makkah')->nullable();
            $table->string('hotel_madinah')->nullable();
            $table->string('airline_name')->nullable();

            $table->string('featured_image')->nullable(); // Gambar depan
            $table->text('description')->nullable();

            $table->boolean('is_featured')->default(false); // Untuk slider home
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. ITINERARIES (Detail Hari per Hari)
        Schema::create('itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->integer('day_number'); // Hari ke-1, ke-2, dst
            $table->string('title'); // Judul kegiatan hari itu
            $table->text('description'); // Detail kegiatan
            $table->timestamps();
        });

        // 4. PACKAGE GALLERIES (Slider Foto Paket)
        Schema::create('package_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->string('image_url');
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        // 5. PACKAGE INQUIRIES (Form Tanya Paket / Lead Gen)
        Schema::create('package_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();

            // Bisa null jika user belum login (Guest)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Kolom manual untuk Guest
            $table->string('guest_name')->nullable();
            $table->string('guest_phone')->nullable();

            $table->text('message')->nullable();
            $table->enum('status', ['new', 'contacted', 'spam'])->default('new');
            $table->timestamps();
        });

        // 6. BOOKMARKS (Wishlist User)
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();

            // Mencegah duplikasi bookmark
            $table->primary(['user_id', 'package_id']);
        });

        // 7. TESTIMONIALS (Kepercayaan)
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name'); // Nama yang ditampilkan
            $table->string('job_title')->nullable();
            $table->text('content');
            $table->integer('rating')->default(5);
            $table->string('avatar_url')->nullable();
            $table->boolean('is_show')->default(true); // Moderasi Admin
            $table->timestamps();
        });

        // 8. POSTS (Blog/Artikel)
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus urutan dari anak ke induk (kebalikan dari atas)
        Schema::dropIfExists('posts');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('package_inquiries');
        Schema::dropIfExists('package_galleries');
        Schema::dropIfExists('itineraries');
        Schema::dropIfExists('packages');
    }
};
