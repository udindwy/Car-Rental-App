<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Coupon;
use App\Models\Extra;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin & Customer
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'role' => 'customer',
        ]);

        // Buat 10 customer acak lainnya
        User::factory(10)->create();

        // 2. Buat Data Master Armada
        Branch::factory(3)->create();
        Brand::factory(5)->create();
        Category::factory(4)->create();
        Feature::factory(8)->create();

        Extra::create(['name' => 'Supir Profesional', 'type' => 'per_day', 'price' => 300000]);
        Extra::create(['name' => 'GPS Navigasi', 'type' => 'per_booking', 'price' => 50000]);
        Extra::create(['name' => 'Baby Car Seat', 'type' => 'per_booking', 'price' => 75000]);
        Extra::create(['name' => 'Asuransi Penuh', 'type' => 'per_day', 'price' => 150000]);

        // 3. Buat Kendaraan
        Vehicle::factory(40)->create();

        // 4. Buat Data Transaksional
        Booking::factory(50)->create();

        // 1. Ambil booking yang statusnya 'completed' dan belum punya review.
        $bookingsToReview = Booking::where('status', 'completed')
            ->doesntHave('review')
            ->inRandomOrder()
            ->limit(30) 
            ->get();

        // 3. Looping untuk membuat ulasan satu per satu untuk  setiap booking yang valid.
        foreach ($bookingsToReview as $booking) {
            Review::factory()->create([
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'vehicle_id' => $booking->vehicle_id,
            ]);
        }

        Payment::factory(40)->create();
        Coupon::factory(10)->create();

        // 5. Buat Halaman Statis
        Page::create([
            'title' => 'Tentang Kami',
            'slug' => 'tentang-kami',
            'content' =>
            '<p><strong>CarRental</strong> adalah pilihan utama Anda untuk jasa sewa mobil di Yogyakarta. Berdiri dengan semangat untuk memberikan pengalaman perjalanan yang tak terlupakan, kami berkomitmen untuk menyediakan layanan transportasi yang aman, nyaman, dan terpercaya bagi setiap pelanggan, baik untuk keperluan wisata, bisnis, maupun acara pribadi.</p>' .
                '<h3>Visi & Misi Kami</h3>' .
                '<p>Visi kami adalah menjadi penyedia jasa rental mobil terdepan di Yogyakarta yang dikenal karena kualitas armada dan pelayanan prima. Misi kami adalah memastikan setiap perjalanan Anda berjalan lancar dengan menyediakan kendaraan yang terawat baik dan dukungan pelanggan yang siap sedia 24/7.</p>' .
                '<h3>Mengapa Memilih Kami?</h3>' .
                '<ul>' .
                '<li><strong>Armada Terbaik & Terawat:</strong> Kami hanya menyediakan unit-unit mobil terbaru yang selalu dalam kondisi prima. Setiap kendaraan melewati inspeksi rutin untuk menjamin keamanan dan kenyamanan Anda di jalan.</li>' .
                '<li><strong>Driver Profesional & Berpengalaman:</strong> Untuk layanan sewa dengan pengemudi, kami memiliki tim driver yang tidak hanya ahli mengemudi tetapi juga memahami rute terbaik di Yogyakarta dan sekitarnya, serta ramah dan sopan.</li>' .
                '<li><strong>Harga Jujur & Kompetitif:</strong> Kami menawarkan harga sewa yang transparan tanpa biaya tersembunyi. Dapatkan penawaran terbaik yang sesuai dengan anggaran dan kebutuhan perjalanan Anda.</li>' .
                '<li><strong>Proses Pemesanan Mudah:</strong> Dengan sistem pemesanan yang sederhana dan responsif, Anda dapat merencanakan perjalanan Anda dengan cepat dan tanpa repot.</li>' .
                '</ul>' .
                '<p>Percayakan kebutuhan transportasi Anda kepada kami dan nikmati keindahan Yogyakarta dengan tenang. Hubungi kami kapan saja, tim kami siap membantu Anda!</p>',
            'published' => true,
        ]);

        Page::create([
            'title' => 'Syarat & Ketentuan',
            'slug' => 'syarat-ketentuan',
            'content' => '<h2>1. Ketentuan Umum</h2>' .
                '<ul>' .
                '<li><strong>Definisi:</strong><ul><li><strong>Kami:</strong> CarRental, sebagai penyedia jasa sewa kendaraan.</li><li><strong>Penyewa:</strong> Pelanggan perorangan atau badan hukum yang menyewa kendaraan dari Kami.</li><li><strong>Kendaraan:</strong> Unit mobil yang disewakan, lengkap dengan surat-surat (STNK) yang sah.</li></ul></li>' .
                '<li><strong>Objek Sewa:</strong> Perjanjian ini adalah untuk sewa kendaraan lepas kunci (self-drive) atau dengan pengemudi (with driver), sesuai dengan paket yang dipesan.</li>' .
                '<li><strong>Wilayah Penggunaan:</strong> Kendaraan hanya boleh digunakan di dalam wilayah Daerah Istimewa Yogyakarta dan sekitarnya, kecuali ada perjanjian tertulis sebelumnya untuk penggunaan di luar provinsi.</li>' .
                '</ul>' .

                '<h2>2. Syarat Penyewa dan Dokumen</h2>' .
                '<ul>' .
                '<li>Penyewa wajib berusia minimal <strong>21 tahun</strong>.</li>' .
                '<li>Penyewa wajib memiliki dan menunjukkan dokumen asli yang masih berlaku saat serah terima kendaraan, yaitu: e-KTP dan SIM A yang aktif.</li>' .
                '<li>Sebagai jaminan tambahan, Penyewa bersedia meninggalkan <strong>satu (1) dokumen identitas asli lainnya</strong> (NPWP, Kartu Pegawai, Paspor, atau Kartu Keluarga) selama masa sewa.</li>' .
                '<li>Kami berhak <strong>menolak transaksi</strong> jika Penyewa tidak dapat memenuhi persyaratan dokumen atau menunjukkan perilaku yang mencurigakan.</li>' .
                '</ul>' .

                '<h2>3. Pemesanan dan Pembayaran</h2>' .
                '<ul>' .
                '<li><strong>Reservasi:</strong> Pemesanan dianggap sah setelah Penyewa melakukan pembayaran <strong>Uang Muka (DP) sebesar 50%</strong> dari total biaya sewa.</li>' .
                '<li><strong>Pelunasan:</strong> Sisa pembayaran wajib dilunasi <strong>secara penuh saat serah terima kendaraan</strong>.</li>' .
                '<li><strong>Harga:</strong> Harga sewa tidak termasuk biaya bahan bakar (BBM), tol, parkir, dan denda tilang lalu lintas.</li>' .
                '</ul>' .

                '<h2>4. Penggunaan Kendaraan</h2>' .
                '<p>Penyewa <strong>dilarang keras</strong> untuk:</p>' .
                '<ul>' .
                '<li>Menggunakan kendaraan untuk tujuan melanggar hukum.</li>' .
                '<li>Menyewakan kembali (mengalihkan sewa) kendaraan kepada pihak ketiga.</li>' .
                '<li>Mengangkut penumpang atau barang melebihi kapasitas maksimal kendaraan.</li>' .
                '<li>Mengemudikan kendaraan di bawah pengaruh alkohol atau obat-obatan terlarang.</li>' .
                '<li>Merokok atau membawa barang berbau menyengat di dalam kabin. Denda kebersihan sebesar <strong>Rp 300.000</strong> akan dikenakan jika ditemukan pelanggaran.</li>' .
                '</ul>' .

                '<h2>5. Durasi Sewa dan Pengembalian</h2>' .
                '<ul>' .
                '<li><strong>Durasi:</strong> Durasi sewa dihitung selama <strong>24 jam</strong> per hari.</li>' .
                '<li><strong>Keterlambatan:</strong> Keterlambatan pengembalian akan dikenakan biaya <strong>overtime</strong> sebesar <strong>10% dari harga sewa harian per jam</strong>. Keterlambatan lebih dari 5 jam dihitung sebagai tambahan sewa satu hari penuh.</li>' .
                '<li><strong>Bahan Bakar:</strong> Level bahan bakar saat pengembalian harus sama dengan level saat serah terima.</li>' .
                '</ul>' .

                '<h2>6. Tanggung Jawab dan Asuransi</h2>' .
                '<ul>' .
                '<li><strong>Tanggung Jawab Penyewa:</strong> Penyewa bertanggung jawab penuh atas segala kerusakan, kehilangan, atau biaya yang timbul akibat kelalaian penggunaan.</li>' .
                '<li><strong>Asuransi Kendaraan:</strong> Jika terjadi kecelakaan, Penyewa wajib menanggung biaya klaim asuransi (<strong>Beban Risiko Sendiri / Own Risk</strong>) sebesar <strong>Rp 500.000 per kejadian</strong>. Asuransi tidak berlaku jika kerusakan disebabkan oleh kelalaian atau pelanggaran ketentuan.</li>' .
                '</ul>' .

                '<h2>7. Pembatalan dan Perubahan Jadwal</h2>' .
                '<ul>' .
                '<li><strong>Pembatalan oleh Penyewa:</strong> Pembatalan kurang dari 24 jam sebelum waktu sewa, Uang Muka (DP) dianggap <strong>hangus</strong>.</li>' .
                '<li><strong>Pembatalan oleh Kami:</strong> Jika kami harus membatalkan pemesanan, seluruh pembayaran akan dikembalikan 100%.</li>' .
                '</ul>' .

                '<h2>8. Penyelesaian Sengketa</h2>' .
                '<p>Segala perselisihan akan diselesaikan secara musyawarah. Apabila tidak tercapai kesepakatan, maka kedua belah pihak setuju untuk menyelesaikannya melalui jalur hukum di <strong>Pengadilan Negeri Sleman</strong>.</p>',
            'published' => true,
        ]);

        // 6. Buat Pengaturan Situs Awal (SESUAI MIGRASI ANDA)
        Setting::create([
            'site_name' => 'Car Rental',
            'whatsapp' => '6281234567890',
            'email' => 'kontak@carrental.com',
            'address' => 'Jl. Malioboro No. 1, Yogyakarta',
            'phone' => '0274123456',
            'facebook_url' => 'https://facebook.com',
            'instagram_url' => 'https://instagram.com',
        ]);
    }
}
