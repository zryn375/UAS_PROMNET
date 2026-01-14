<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama jika ada
        Article::query()->delete();
        User::query()->delete();

        // Create admin user
        $admin = User::create([
            'name' => 'Admin Edukasi',
            'email' => 'admin@edublog.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'bio' => 'Administrator blog edukasi dengan pengalaman 5 tahun dalam dunia pendidikan.',
            'profile_picture' => 'default-avatar.png',
            'email_verified_at' => now(),
        ]);

        // Create author user
        $author = User::create([
            'name' => 'Dr. Ilmu Pengetahuan',
            'email' => 'author@edublog.test',
            'password' => Hash::make('password123'),
            'role' => 'author',
            'bio' => 'Penulis artikel edukasi dan ilmu pengetahuan dengan spesialisasi fisika kuantum dan astronomi.',
            'profile_picture' => 'author-avatar.png',
            'email_verified_at' => now(),
        ]);

        // Create reader user
        User::create([
            'name' => 'John Doe',
            'email' => 'reader@edublog.test',
            'password' => Hash::make('password123'),
            'role' => 'reader',
            'bio' => 'Mahasiswa yang tertarik dengan ilmu pengetahuan dan teknologi.',
            'profile_picture' => 'reader-avatar.png',
            'email_verified_at' => now(),
        ]);

        // Create sample articles
        $articles = [
            [
                'title' => 'Mengenal Konsep Machine Learning untuk Pemula',
                'slug' => 'mengenal-konsep-machine-learning',
                'content' => '<h2>Apa itu Machine Learning?</h2>
                <p>Machine Learning adalah cabang dari kecerdasan buatan yang memungkinkan komputer untuk belajar dari data tanpa diprogram secara eksplisit. Konsep ini telah merevolusi banyak industri, dari kesehatan hingga keuangan.</p>
                
                <h3>Jenis-jenis Machine Learning</h3>
                <ul>
                    <li><strong>Supervised Learning:</strong> Model belajar dari data yang sudah dilabeli</li>
                    <li><strong>Unsupervised Learning:</strong> Model menemukan pola dari data tanpa label</li>
                    <li><strong>Reinforcement Learning:</strong> Model belajar melalui trial and error</li>
                </ul>
                
                <h3>Contoh Penerapan</h3>
                <p>Machine Learning digunakan dalam berbagai aplikasi seperti:</p>
                <ol>
                    <li>Rekomendasi produk di e-commerce</li>
                    <li>Deteksi penipuan transaksi keuangan</li>
                    <li>Diagnosis penyakit medis</li>
                    <li>Kendaraan otonom</li>
                </ol>',
                'summary' => 'Pengenalan dasar tentang machine learning untuk pemula, mencakup definisi, jenis-jenis, dan contoh penerapannya dalam kehidupan sehari-hari.',
                'category' => 'Teknologi',
                'reading_time' => '5 menit',
                'view_count' => 150,
                'user_id' => $author->id,
                'published_at' => now(),
            ],
            [
                'title' => 'Tips Belajar Matematika dengan Menyenangkan',
                'slug' => 'tips-belajar-matematika',
                'content' => '<h2>Matematika Bukan Momok</h2>
                <p>Banyak siswa yang menganggap matematika sulit karena cara pembelajarannya yang membosankan. Padahal, matematika bisa menjadi sangat menyenangkan jika dipelajari dengan cara yang tepat.</p>
                
                <h3>Tips Belajar Matematika</h3>
                <p>Berikut beberapa tips untuk belajar matematika dengan cara yang menyenangkan:</p>
                
                <h4>1. Gunakan Aplikasi Pembelajaran</h4>
                <p>Aplikasi seperti Khan Academy, Photomath, atau GeoGebra dapat membuat belajar matematika lebih interaktif.</p>
                
                <h4>2. Belajar melalui Permainan</h4>
                <p>Permainan seperti Sudoku, teka-teki matematika, atau board games edukatif dapat melatih kemampuan berpikir logis.</p>
                
                <h4>3. Praktik dalam Kehidupan Sehari-hari</h4>
                <p>Gunakan matematika dalam situasi nyata seperti menghitung diskon belanja, mengukur bahan masakan, atau merencanakan anggaran.</p>
                
                <h4>4. Bergabung dengan Komunitas Belajar</h4>
                <p>Bergabung dengan grup belajar atau forum online dapat memberikan dukungan dan motivasi.</p>',
                'summary' => 'Cara belajar matematika yang efektif dan menyenangkan dengan menggunakan teknologi, permainan, dan penerapan dalam kehidupan sehari-hari.',
                'category' => 'Pendidikan',
                'reading_time' => '7 menit',
                'view_count' => 89,
                'user_id' => $author->id,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Misteri Alam Semesta yang Belum Terpecahkan',
                'slug' => 'misteri-alam-semesta',
                'content' => '<h2>Keajaiban Kosmos</h2>
                <p>Alam semesta menyimpan banyak misteri yang masih membuat para ilmuwan bingung. Meskipun teknologi telah berkembang pesat, masih banyak pertanyaan yang belum terjawab.</p>
                
                <h3>Misteri Besar Alam Semesta</h3>
                
                <h4>1. Materi Gelap (Dark Matter)</h4>
                <p>Materi gelap diperkirakan menyusun sekitar 27% alam semesta, namun kita belum bisa mendeteksinya secara langsung. Materi ini hanya diketahui melalui pengaruh gravitasinya terhadap benda langit lainnya.</p>
                
                <h4>2. Energi Gelap (Dark Energy)</h4>
                <p>Energi gelap diyakini sebagai penyebab percepatan ekspansi alam semesta. Kita tidak tahu apa sebenarnya energi gelap ini, hanya tahu bahwa ia menyusun sekitar 68% alam semesta.</p>
                
                <h4>3. Paralel Universe</h4>
                <p>Teori multiverse menyatakan bahwa mungkin ada banyak alam semesta paralel di luar alam semesta kita. Setiap alam semesta mungkin memiliki hukum fisika yang berbeda.</p>
                
                <h4>4. Singularitas Big Bang</h4>
                <p>Apa yang terjadi sebelum Big Bang? Apa yang menyebabkan Big Bang? Pertanyaan-pertanyaan ini masih menjadi misteri terbesar dalam kosmologi.</p>',
                'summary' => 'Penjelasan tentang misteri alam semesta yang masih diteliti oleh para ilmuwan, termasuk materi gelap, energi gelap, dan teori multiverse.',
                'category' => 'Ilmu Pengetahuan',
                'reading_time' => '10 menit',
                'view_count' => 210,
                'user_id' => $author->id,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Efektivitas Pembelajaran Online di Era Digital',
                'slug' => 'efektivitas-pembelajaran-online',
                'content' => '<h2>Revolusi Pendidikan Digital</h2>
                <p>Pembelajaran online telah menjadi norma baru dalam dunia pendidikan. Namun, seberapa efektif metode ini dibandingkan pembelajaran tatap muka?</p>
                
                <h3>Keuntungan Pembelajaran Online</h3>
                <ul>
                    <li><strong>Fleksibilitas waktu dan tempat</strong></li>
                    <li><strong>Akses ke materi yang beragam</strong></li>
                    <li><strong>Biaya yang lebih terjangkau</strong></li>
                    <li><strong>Belajar sesuai kecepatan sendiri</strong></li>
                </ul>
                
                <h3>Tantangan Pembelajaran Online</h3>
                <ul>
                    <li>Kurangnya interaksi sosial</li>
                    <li>Kebutuhan disiplin diri yang tinggi</li>
                    <li>Masalah koneksi internet</li>
                    <li>Keterbatasan praktik langsung</li>
                </ul>
                
                <h3>Tips Sukses Belajar Online</h3>
                <p>Untuk memaksimalkan pembelajaran online:</p>
                <ol>
                    <li>Buat jadwal belajar yang konsisten</li>
                    <li>Siapkan ruang belajar yang nyaman</li>
                    <li>Manfaatkan forum diskusi online</li>
                    <li>Jangan ragu bertanya kepada pengajar</li>
                </ol>',
                'summary' => 'Analisis efektivitas pembelajaran online di era digital, mencakup keuntungan, tantangan, dan tips untuk sukses belajar secara online.',
                'category' => 'Pendidikan',
                'reading_time' => '8 menit',
                'view_count' => 120,
                'user_id' => $admin->id,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Perkembangan Teknologi 5G dan Dampaknya',
                'slug' => 'perkembangan-teknologi-5g',
                'content' => '<h2>Era Konektivitas Super Cepat</h2>
                <p>Teknologi 5G bukan sekadar upgrade dari 4G, tetapi revolusi dalam konektivitas yang akan mengubah banyak aspek kehidupan.</p>
                
                <h3>Keunggulan Teknologi 5G</h3>
                <ul>
                    <li><strong>Kecepatan:</strong> Hingga 100x lebih cepat dari 4G</li>
                    <li><strong>Latensi rendah:</strong> Hanya 1-10 milidetik</li>
                    <li><strong>Kapasitas besar:</strong> Mendukung jutaan perangkat per km²</li>
                    <li><strong>Efisiensi energi:</strong> Mengurangi konsumsi daya hingga 90%</li>
                </ul>
                
                <h3>Aplikasi Teknologi 5G</h3>
                <p>5G akan mendukung berbagai teknologi masa depan:</p>
                <ol>
                    <li>Internet of Things (IoT) secara masif</li>
                    <li>Kendaraan otonom yang terhubung</li>
                    <li>Operasi bedah jarak jauh</li>
                    <li>Realitas virtual dan augmented reality</li>
                    <li>Smart cities yang terintegrasi</li>
                </ol>
                
                <h3>Tantangan Implementasi 5G</h3>
                <p>Meski menjanjikan, implementasi 5G menghadapi beberapa tantangan:</p>
                <ul>
                    <li>Infrastruktur yang mahal</li>
                    <li>Kekhawatiran keamanan siber</li>
                    <li>Isu kesehatan dan radiasi</li>
                    <li>Kesenjangan digital antara daerah</li>
                </ul>',
                'summary' => 'Tinjauan lengkap tentang teknologi 5G, termasuk keunggulan, aplikasi praktis, dan tantangan implementasinya di berbagai sektor.',
                'category' => 'Teknologi',
                'reading_time' => '9 menit',
                'view_count' => 180,
                'user_id' => $author->id,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Fenomena Perubahan Iklim Global',
                'slug' => 'fenomena-perubahan-iklim',
                'content' => '<h2>Bumi yang Semakin Panas</h2>
                <p>Perubahan iklim adalah salah satu tantangan terbesar yang dihadapi umat manusia saat ini. Dampaknya sudah terasa di berbagai belahan dunia.</p>
                
                <h3>Penyebab Perubahan Iklim</h3>
                <ul>
                    <li><strong>Emisi gas rumah kaca:</strong> Dari industri, transportasi, dan deforestasi</li>
                    <li><strong>Penggunaan energi fosil:</strong> Batu bara, minyak, dan gas alam</li>
                    <li><strong>Perubahan penggunaan lahan:</strong> Urbanisasi dan alih fungsi hutan</li>
                    <li><strong>Polusi industri:</strong> Limbah dan emisi pabrik</li>
                </ul>
                
                <h3>Dampak yang Sudah Terjadi</h3>
                <ol>
                    <li>Meningkatnya suhu global rata-rata</li>
                    <li>Mencairnya es di kutub dan gletser</li>
                    <li>Naiknya permukaan air laut</li>
                    <li>Frekuensi cuaca ekstrem yang meningkat</li>
                    <li>Gangguan ekosistem dan kepunahan spesies</li>
                </ol>
                
                <h3>Solusi yang Bisa Dilakukan</h3>
                <p>Beberapa langkah untuk mitigasi perubahan iklim:</p>
                <ul>
                    <li>Transisi ke energi terbarukan</li>
                    <li>Efisiensi energi dan konservasi</li>
                    <li>Reforestasi dan penghijauan</li>
                    <li>Pola konsumsi yang berkelanjutan</li>
                    <li>Dukungan kebijakan pemerintah</li>
                </ul>',
                'summary' => 'Analisis mendalam tentang fenomena perubahan iklim global, termasuk penyebab, dampak yang sudah terjadi, dan solusi yang bisa diterapkan.',
                'category' => 'Ilmu Pengetahuan',
                'reading_time' => '11 menit',
                'view_count' => 95,
                'user_id' => $admin->id,
                'published_at' => now()->subDays(7),
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin Login: admin@edublog.test / password123');
        $this->command->info('Author Login: author@edublog.test / password123');
        $this->command->info('Reader Login: reader@edublog.test / password123');
    }
}