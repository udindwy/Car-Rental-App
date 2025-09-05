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
            Schema::table('bookings', function (Blueprint $table) {
                // Menambahkan foreign key untuk kupon, bisa null.
                // nullOnDelete berarti jika kupon dihapus, nilai di sini menjadi NULL, bukan menghapus booking.
                $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete()->after('grand_total');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('bookings', function (Blueprint $table) {
                // Cara yang benar untuk menghapus foreign key dan kolomnya
                $table->dropForeign(['coupon_id']);
                $table->dropColumn('coupon_id');
            });
        }
    };
