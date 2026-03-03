<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Committee;
use App\Models\Conference;
use App\Models\ImportantDate;
use App\Models\JournalPublication;
use App\Models\KeynoteSpeaker;
use App\Models\News;
use App\Models\Paper;
use App\Models\PaperFile;
use App\Models\Payment;
use App\Models\RegistrationPackage;
use App\Models\Review;
use App\Models\Role;
use App\Models\Slider;
use App\Models\Supporter;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    /**
     * Seed the application with dummy data for demo/testing purposes.
     * Run: php artisan db:seed --class=DummyDataSeeder
     */
    public function run(): void
    {
        $this->command->info('🚀 Memulai pengisian data dummy...');

        // 1. Create Conference
        $conference = $this->createConference();
        $this->command->info('✓ Conference dibuat: ' . $conference->name);

        // 2. Create Topics
        $topics = $this->createTopics($conference);
        $this->command->info('✓ ' . count($topics) . ' topik dibuat');

        // 3. Create Keynote Speakers
        $this->createKeynoteSpeakers($conference);
        $this->command->info('✓ Keynote speakers dibuat');

        // 4. Create Committee Members
        $this->createCommittees($conference);
        $this->command->info('✓ Committee members dibuat');

        // 5. Create Registration Packages
        $packages = $this->createRegistrationPackages($conference);
        $this->command->info('✓ ' . count($packages) . ' paket registrasi dibuat');

        // 6. Create Important Dates
        $this->createImportantDates($conference);
        $this->command->info('✓ Important dates dibuat');

        // 7. Create Journal Publications
        $this->createJournalPublications($conference);
        $this->command->info('✓ Journal publications dibuat');

        // 8. Create Supporters/Sponsors
        $this->createSupporters($conference);
        $this->command->info('✓ Sponsors dibuat');

        // 9. Create Users (Authors, Reviewers, Editors)
        $users = $this->createUsers();
        $this->command->info('✓ ' . count($users['authors']) . ' authors, ' . count($users['reviewers']) . ' reviewers dibuat');

        // 10. Create Papers with various statuses
        $papers = $this->createPapers($conference, $users, $topics);
        $this->command->info('✓ ' . count($papers) . ' papers dibuat');

        // 11. Create Reviews
        $this->createReviews($papers, $users['reviewers']);
        $this->command->info('✓ Reviews dibuat');

        // 12. Create Payments
        $this->createPayments($papers, $packages);
        $this->command->info('✓ Payments dibuat');

        // 13. Create News/Announcements
        $this->createNews($conference);
        $this->command->info('✓ News/Announcements dibuat');

        // 14. Create Sliders
        $this->createSliders($conference);
        $this->command->info('✓ Sliders dibuat');

        $this->command->newLine();
        $this->command->info('🎉 Data dummy berhasil dibuat!');
        $this->command->newLine();
        $this->printSummary($conference, $users);
    }

    private function createConference(): Conference
    {
        return Conference::create([
            'name' => 'Seminar Nasional Teknologi dan Inovasi Indonesia 2026',
            'acronym' => 'SNTII 2026',
            'theme' => 'Transformasi Digital untuk Indonesia Maju: Peran Teknologi dalam Pembangunan Berkelanjutan',
            'description' => '<p>Seminar Nasional Teknologi dan Inovasi Indonesia (SNTII) 2026 merupakan forum ilmiah tahunan yang menghimpun para akademisi, peneliti, praktisi, dan mahasiswa dari berbagai institusi di Indonesia.</p>
            <p>Konferensi ini bertujuan untuk:</p>
            <ul>
            <li>Mendiseminasikan hasil-hasil penelitian terbaru di bidang teknologi</li>
            <li>Memfasilitasi kolaborasi antar peneliti dari berbagai institusi</li>
            <li>Mendiskusikan tantangan dan solusi teknologi untuk pembangunan berkelanjutan</li>
            <li>Memberikan wadah publikasi ilmiah yang berkualitas</li>
            </ul>
            <p>Paper terbaik akan dipublikasikan di jurnal nasional terakreditasi SINTA 2-4.</p>',
            'start_date' => now()->addMonths(3)->startOfMonth(),
            'start_time' => '08:00:00',
            'end_date' => now()->addMonths(3)->startOfMonth()->addDays(1),
            'end_time' => '17:00:00',
            'venue' => 'Grand Ballroom Hotel Indonesia Kempinski Jakarta',
            'venue_type' => 'hybrid',
            'online_url' => 'https://zoom.us/j/1234567890',
            'city' => 'Jakarta',
            'organizer' => 'Asosiasi Perguruan Tinggi Indonesia (APTI) bekerja sama dengan Kementerian Riset dan Teknologi',
            'conference_type' => 'nasional',
            'status' => 'published',
            'is_active' => true,
            'payment_bank_name' => 'Bank Mandiri',
            'payment_bank_account' => '1234567890123',
            'payment_account_holder' => 'Panitia SNTII 2026',
            'payment_contact_phone' => '081234567890',
            'payment_instructions' => 'Transfer sesuai nominal yang tertera di invoice. Cantumkan kode invoice pada berita transfer. Konfirmasi pembayaran dengan upload bukti transfer.',
            'payment_methods' => ['bank_transfer', 'qris'],
            'wa_group_pemakalah' => 'https://chat.whatsapp.com/ABC123pemakalah',
            'wa_group_reviewer' => 'https://chat.whatsapp.com/XYZ789reviewer',
            'chairman_name' => 'Prof. Dr. Ir. Bambang Sudibyo, M.T.',
            'chairman_title' => 'Ketua Panitia',
            'secretary_name' => 'Dr. Siti Aminah, M.Kom.',
            'secretary_title' => 'Sekretaris Panitia',
            'created_by' => 1,
        ]);
    }

    private function createTopics(Conference $conference): array
    {
        $topicsData = [
            ['name' => 'Artificial Intelligence & Machine Learning', 'description' => 'Deep learning, neural networks, NLP, computer vision, dan aplikasi AI'],
            ['name' => 'Internet of Things (IoT)', 'description' => 'Smart devices, embedded systems, sensor networks, edge computing'],
            ['name' => 'Cyber Security & Privacy', 'description' => 'Network security, cryptography, data privacy, ethical hacking'],
            ['name' => 'Big Data & Data Science', 'description' => 'Data analytics, data mining, visualization, business intelligence'],
            ['name' => 'Cloud & Distributed Computing', 'description' => 'Cloud architecture, microservices, containerization, serverless'],
            ['name' => 'Software Engineering', 'description' => 'Software development, agile methodology, DevOps, quality assurance'],
            ['name' => 'Human-Computer Interaction', 'description' => 'UX/UI design, accessibility, usability studies'],
            ['name' => 'Information Systems', 'description' => 'Enterprise systems, e-government, digital transformation'],
            ['name' => 'Educational Technology', 'description' => 'E-learning, gamification, learning management systems'],
            ['name' => 'Green Computing & Sustainability', 'description' => 'Energy-efficient computing, sustainable IT practices'],
        ];

        $topics = [];
        foreach ($topicsData as $i => $data) {
            $topics[] = Topic::create([
                'conference_id' => $conference->id,
                'name' => $data['name'],
                'description' => $data['description'],
                'sort_order' => $i + 1,
            ]);
        }
        return $topics;
    }

    private function createKeynoteSpeakers(Conference $conference): void
    {
        $speakers = [
            [
                'name' => 'Prof. Dr. Ir. Nizam, M.Sc.',
                'title' => 'Direktur Jenderal Pendidikan Tinggi',
                'institution' => 'Kementerian Pendidikan dan Kebudayaan RI',
                'bio' => 'Profesor di bidang Teknik Elektro dengan pengalaman lebih dari 25 tahun dalam penelitian dan pengembangan teknologi. Aktif mendorong transformasi digital di perguruan tinggi Indonesia.',
                'topic' => 'Kebijakan Transformasi Digital Pendidikan Tinggi di Indonesia',
                'type' => 'keynote',
                'sort_order' => 1,
            ],
            [
                'name' => 'Dr. Onno W. Purbo',
                'title' => 'Pakar Teknologi Informasi',
                'institution' => 'Institut Teknologi Bandung',
                'bio' => 'Pionir internet Indonesia yang telah memberikan kontribusi besar dalam pengembangan infrastruktur IT di tanah air. Penulis puluhan buku tentang teknologi.',
                'topic' => 'Demokratisasi Teknologi: Membuka Akses untuk Semua',
                'type' => 'keynote',
                'sort_order' => 2,
            ],
            [
                'name' => 'Prof. Ir. Hammam Riza, M.Sc., Ph.D.',
                'title' => 'Kepala BRIN',
                'institution' => 'Badan Riset dan Inovasi Nasional',
                'bio' => 'Pakar AI dan NLP dengan berbagai publikasi internasional. Berpengalaman memimpin berbagai proyek riset nasional strategis.',
                'topic' => 'Roadmap Riset AI Indonesia 2030',
                'type' => 'keynote',
                'sort_order' => 3,
            ],
            [
                'name' => 'Dr. Ir. Setiaji, M.T.',
                'title' => 'Chief Digital Transformation Office',
                'institution' => 'Kementerian Kesehatan RI',
                'bio' => 'Arsitek utama transformasi digital sektor kesehatan Indonesia termasuk PeduliLindungi dan SATUSEHAT.',
                'topic' => 'Studi Kasus: Transformasi Digital di Sektor Kesehatan',
                'type' => 'invited',
                'sort_order' => 4,
            ],
            [
                'name' => 'Achmad Zaky',
                'title' => 'Founder & CEO',
                'institution' => 'Bukalapak (Alumnus)',
                'bio' => 'Entrepreneur teknologi yang sukses membangun unicorn Indonesia. Aktif dalam mentoring startup dan pengembangan ekosistem digital.',
                'topic' => 'Membangun Startup Teknologi Berdampak',
                'type' => 'invited',
                'sort_order' => 5,
            ],
        ];

        foreach ($speakers as $speaker) {
            KeynoteSpeaker::create(array_merge($speaker, ['conference_id' => $conference->id]));
        }
    }

    private function createCommittees(Conference $conference): void
    {
        $committees = [
            // Steering Committee
            ['name' => 'Prof. Dr. Ir. Reini Wirahadikusumah, M.Sc.', 'title' => 'Rektor ITB', 'institution' => 'Institut Teknologi Bandung', 'type' => 'steering', 'role' => 'Chair', 'sort_order' => 1],
            ['name' => 'Prof. Dr. Ir. Ari Purbayanto, M.Sc.', 'title' => 'Rektor IPB', 'institution' => 'Institut Pertanian Bogor', 'type' => 'steering', 'role' => 'Member', 'sort_order' => 2],
            ['name' => 'Prof. Ir. Nizam, M.Sc., D.Eng., IPU, ASEAN Eng.', 'title' => 'Rektor UGM', 'institution' => 'Universitas Gadjah Mada', 'type' => 'steering', 'role' => 'Member', 'sort_order' => 3],
            
            // Organizing Committee
            ['name' => 'Prof. Dr. Ir. Bambang Sudibyo, M.T.', 'title' => 'Ketua Panitia', 'institution' => 'Universitas Indonesia', 'type' => 'organizing', 'role' => 'General Chair', 'sort_order' => 1],
            ['name' => 'Dr. Siti Aminah, M.Kom.', 'title' => 'Sekretaris', 'institution' => 'Universitas Indonesia', 'type' => 'organizing', 'role' => 'Secretary', 'sort_order' => 2],
            ['name' => 'Dr. Ir. Ahmad Fauzi, M.T.', 'title' => 'Bendahara', 'institution' => 'Institut Teknologi Bandung', 'type' => 'organizing', 'role' => 'Treasurer', 'sort_order' => 3],
            ['name' => 'Dr. Rina Wijayanti, M.Kom.', 'title' => 'Koordinator Paper', 'institution' => 'Universitas Gadjah Mada', 'type' => 'organizing', 'role' => 'Paper Chair', 'sort_order' => 4],
            ['name' => 'Ir. Budi Santoso, M.T.', 'title' => 'Koordinator Acara', 'institution' => 'Institut Teknologi Sepuluh Nopember', 'type' => 'organizing', 'role' => 'Event Chair', 'sort_order' => 5],
            
            // Scientific Committee
            ['name' => 'Prof. Dr. Ir. Suhono Harso Supangkat', 'title' => 'Professor', 'institution' => 'Institut Teknologi Bandung', 'type' => 'scientific', 'role' => 'Chair', 'sort_order' => 1],
            ['name' => 'Prof. Dr. Wisnu Jatmiko', 'title' => 'Professor', 'institution' => 'Universitas Indonesia', 'type' => 'scientific', 'role' => 'Member', 'sort_order' => 2],
            ['name' => 'Prof. Dr. Mauridhi Hery Purnomo', 'title' => 'Professor', 'institution' => 'Institut Teknologi Sepuluh Nopember', 'type' => 'scientific', 'role' => 'Member', 'sort_order' => 3],
            ['name' => 'Dr. Eng. Herman Tolle', 'title' => 'Associate Professor', 'institution' => 'Universitas Brawijaya', 'type' => 'scientific', 'role' => 'Member', 'sort_order' => 4],
            ['name' => 'Dr. Teguh Bharata Adji', 'title' => 'Associate Professor', 'institution' => 'Universitas Gadjah Mada', 'type' => 'scientific', 'role' => 'Member', 'sort_order' => 5],
        ];

        foreach ($committees as $committee) {
            Committee::create(array_merge($committee, ['conference_id' => $conference->id]));
        }
    }

    private function createRegistrationPackages(Conference $conference): array
    {
        $packagesData = [
            [
                'name' => 'Pemakalah Mahasiswa',
                'price' => 500000,
                'currency' => 'IDR',
                'description' => 'Untuk mahasiswa S1/S2/S3 dengan menunjukkan KTM aktif',
                'features' => ['Sertifikat pemakalah', 'Seminar kit', 'Makan siang 2x', 'Prosiding ber-ISBN', 'Kesempatan publikasi jurnal'],
                'is_featured' => false,
                'is_free' => false,
                'require_payment_proof' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Pemakalah Umum',
                'price' => 1000000,
                'currency' => 'IDR',
                'description' => 'Untuk dosen, peneliti, dan profesional',
                'features' => ['Sertifikat pemakalah', 'Seminar kit premium', 'Makan siang 2x', 'Gala dinner', 'Prosiding ber-ISBN', 'Kesempatan publikasi jurnal'],
                'is_featured' => true,
                'is_free' => false,
                'require_payment_proof' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Peserta Non-Pemakalah',
                'price' => 300000,
                'currency' => 'IDR',
                'description' => 'Untuk peserta yang ingin menghadiri seminar tanpa presentasi',
                'features' => ['Sertifikat peserta', 'Seminar kit', 'Makan siang 2x', 'Akses semua sesi'],
                'is_featured' => false,
                'is_free' => false,
                'require_payment_proof' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Peserta Online',
                'price' => 0,
                'currency' => 'IDR',
                'description' => 'Registrasi gratis untuk mengikuti sesi secara online',
                'features' => ['Sertifikat peserta online', 'Akses live streaming', 'Recording akses 7 hari'],
                'is_featured' => false,
                'is_free' => true,
                'require_payment_proof' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        $packages = [];
        foreach ($packagesData as $data) {
            $packages[] = RegistrationPackage::create(array_merge($data, ['conference_id' => $conference->id]));
        }
        return $packages;
    }

    private function createImportantDates(Conference $conference): void
    {
        $dates = [
            ['title' => 'Pembukaan Submission', 'date' => now()->subMonths(2), 'description' => 'Sistem submission paper dibuka', 'is_active' => true, 'sort_order' => 1],
            ['title' => 'Deadline Abstrak', 'date' => now()->addWeeks(2), 'description' => 'Batas akhir pengiriman abstrak', 'is_active' => true, 'sort_order' => 2],
            ['title' => 'Notifikasi Abstrak', 'date' => now()->addWeeks(4), 'description' => 'Pengumuman penerimaan abstrak', 'is_active' => true, 'sort_order' => 3],
            ['title' => 'Deadline Full Paper', 'date' => now()->addMonths(2), 'description' => 'Batas akhir pengiriman paper lengkap', 'is_active' => true, 'sort_order' => 4],
            ['title' => 'Notifikasi Reviewe', 'date' => now()->addMonths(2)->addWeeks(2), 'description' => 'Pengumuman hasil review paper', 'is_active' => true, 'sort_order' => 5],
            ['title' => 'Deadline Camera Ready', 'date' => now()->addMonths(3)->subWeeks(2), 'description' => 'Batas akhir revisi final paper', 'is_active' => true, 'sort_order' => 6],
            ['title' => 'Early Bird Registration', 'date' => now()->addMonths(2)->addWeeks(3), 'description' => 'Batas registrasi dengan harga khusus', 'is_active' => true, 'sort_order' => 7],
            ['title' => 'Pelaksanaan Seminar', 'date' => $conference->start_date, 'description' => 'Hari pelaksanaan seminar', 'is_active' => true, 'sort_order' => 8],
        ];

        foreach ($dates as $date) {
            ImportantDate::create(array_merge($date, ['conference_id' => $conference->id]));
        }
    }

    private function createJournalPublications(Conference $conference): void
    {
        $journals = [
            [
                'name' => 'Jurnal Teknologi Informasi dan Ilmu Komputer (JTIIK)',
                'issn' => '2355-7699',
                'publisher' => 'Universitas Brawijaya',
                'indexing' => 'SINTA 2, DOAJ, Google Scholar',
                'url' => 'https://jtiik.ub.ac.id',
                'description' => 'Paper terbaik bidang AI dan Software Engineering',
                'sort_order' => 1,
            ],
            [
                'name' => 'Jurnal Ilmu Komputer dan Informasi (JIKI)',
                'issn' => '1979-0732',
                'publisher' => 'Universitas Indonesia',
                'indexing' => 'SINTA 2, Scopus Indexed',
                'url' => 'https://jiki.cs.ui.ac.id',
                'description' => 'Paper terbaik bidang Data Science dan Big Data',
                'sort_order' => 2,
            ],
            [
                'name' => 'Telkomnika',
                'issn' => '1693-6930',
                'publisher' => 'Universitas Ahmad Dahlan',
                'indexing' => 'SINTA 1, Scopus Q3',
                'url' => 'https://telkomnika.uad.ac.id',
                'description' => 'Paper terbaik bidang IoT dan Telecommunications',
                'sort_order' => 3,
            ],
            [
                'name' => 'Jurnal Sistem Informasi (JSI)',
                'issn' => '1858-4667',
                'publisher' => 'Institut Teknologi Sepuluh Nopember',
                'indexing' => 'SINTA 3, Google Scholar',
                'url' => 'https://jsi.its.ac.id',
                'description' => 'Paper bidang Information Systems',
                'sort_order' => 4,
            ],
        ];

        foreach ($journals as $journal) {
            JournalPublication::create(array_merge($journal, ['conference_id' => $conference->id, 'is_active' => true]));
        }
    }

    private function createSupporters(Conference $conference): void
    {
        $supporters = [
            ['name' => 'Kementerian Riset dan Teknologi', 'type' => 'organizer', 'url' => 'https://ristekdikti.go.id', 'sort_order' => 1],
            ['name' => 'Telkom Indonesia', 'type' => 'sponsor_gold', 'url' => 'https://telkom.co.id', 'sort_order' => 1],
            ['name' => 'Tokopedia', 'type' => 'sponsor_gold', 'url' => 'https://tokopedia.com', 'sort_order' => 2],
            ['name' => 'Gojek', 'type' => 'sponsor_silver', 'url' => 'https://gojek.com', 'sort_order' => 1],
            ['name' => 'Bukalapak', 'type' => 'sponsor_silver', 'url' => 'https://bukalapak.com', 'sort_order' => 2],
            ['name' => 'Microsoft Indonesia', 'type' => 'sponsor_bronze', 'url' => 'https://microsoft.com/id-id', 'sort_order' => 1],
            ['name' => 'Google Indonesia', 'type' => 'sponsor_bronze', 'url' => 'https://google.co.id', 'sort_order' => 2],
            ['name' => 'IEEE Indonesia Section', 'type' => 'media_partner', 'url' => 'https://ieee.org', 'sort_order' => 1],
            ['name' => 'APTIKOM', 'type' => 'media_partner', 'url' => 'https://aptikom.org', 'sort_order' => 2],
        ];

        foreach ($supporters as $supporter) {
            Supporter::create(array_merge($supporter, ['conference_id' => $conference->id, 'is_active' => true]));
        }
    }

    private function createUsers(): array
    {
        $reviewerRole = Role::where('name', 'reviewer')->first();
        $editorRole = Role::where('name', 'editor')->first();
        $authorRole = Role::where('name', 'author')->first();

        // Create Authors
        $authorsData = [
            ['name' => 'Dr. Aditya Pratama', 'email' => 'aditya.pratama@ui.ac.id', 'institution' => 'Universitas Indonesia', 'phone' => '081234567001'],
            ['name' => 'Sinta Dewi, M.Kom.', 'email' => 'sinta.dewi@itb.ac.id', 'institution' => 'Institut Teknologi Bandung', 'phone' => '081234567002'],
            ['name' => 'Ir. Budi Setiawan, M.T.', 'email' => 'budi.setiawan@ugm.ac.id', 'institution' => 'Universitas Gadjah Mada', 'phone' => '081234567003'],
            ['name' => 'Rina Kartika, S.Kom., M.Cs.', 'email' => 'rina.kartika@its.ac.id', 'institution' => 'Institut Teknologi Sepuluh Nopember', 'phone' => '081234567004'],
            ['name' => 'Ahmad Rizki Mahasiswa', 'email' => 'ahmad.rizki@student.ub.ac.id', 'institution' => 'Universitas Brawijaya', 'phone' => '081234567005'],
            ['name' => 'Dewi Safitri, M.Kom.', 'email' => 'dewi.safitri@unpad.ac.id', 'institution' => 'Universitas Padjadjaran', 'phone' => '081234567006'],
            ['name' => 'Dr. Fahmi Abdullah', 'email' => 'fahmi.abdullah@undip.ac.id', 'institution' => 'Universitas Diponegoro', 'phone' => '081234567007'],
            ['name' => 'Gilang Ramadhan, S.T.', 'email' => 'gilang.ramadhan@telkomuniversity.ac.id', 'institution' => 'Telkom University', 'phone' => '081234567008'],
            ['name' => 'Hana Permata, M.Ti.', 'email' => 'hana.permata@binus.ac.id', 'institution' => 'Binus University', 'phone' => '081234567009'],
            ['name' => 'Irfan Maulana, S.Kom.', 'email' => 'irfan.maulana@upi.edu', 'institution' => 'Universitas Pendidikan Indonesia', 'phone' => '081234567010'],
        ];

        $authors = [];
        foreach ($authorsData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'institution' => $data['institution'],
                'phone' => $data['phone'],
                'email_verified_at' => now(),
            ]);
            if ($authorRole) {
                $user->roles()->attach($authorRole);
            }
            $authors[] = $user;
        }

        // Create Reviewers
        $reviewersData = [
            ['name' => 'Prof. Dr. Joko Susilo', 'email' => 'joko.susilo@reviewer.ac.id', 'institution' => 'Universitas Indonesia', 'expertise' => 'Artificial Intelligence'],
            ['name' => 'Dr. Kartini Wulandari', 'email' => 'kartini.wulandari@reviewer.ac.id', 'institution' => 'Institut Teknologi Bandung', 'expertise' => 'Data Science'],
            ['name' => 'Dr. Lukman Hakim', 'email' => 'lukman.hakim@reviewer.ac.id', 'institution' => 'Universitas Gadjah Mada', 'expertise' => 'Cyber Security'],
            ['name' => 'Dr. Mega Puspita', 'email' => 'mega.puspita@reviewer.ac.id', 'institution' => 'Institut Teknologi Sepuluh Nopember', 'expertise' => 'Software Engineering'],
            ['name' => 'Dr. Nugroho Santoso', 'email' => 'nugroho.santoso@reviewer.ac.id', 'institution' => 'Universitas Brawijaya', 'expertise' => 'IoT'],
        ];

        $reviewers = [];
        foreach ($reviewersData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'institution' => $data['institution'],
                'phone' => '0812345678' . rand(10, 99),
                'email_verified_at' => now(),
            ]);
            if ($reviewerRole) {
                $user->roles()->attach($reviewerRole);
            }
            $reviewers[] = $user;
        }

        // Create Editor
        $editor = User::create([
            'name' => 'Dr. Olivia Editor',
            'email' => 'olivia.editor@prosiding.test',
            'password' => Hash::make('password'),
            'institution' => 'Panitia SNTII 2026',
            'phone' => '081234567099',
            'email_verified_at' => now(),
        ]);
        if ($editorRole) {
            $editor->roles()->attach($editorRole);
        }

        return [
            'authors' => $authors,
            'reviewers' => $reviewers,
            'editor' => $editor,
        ];
    }

    private function createPapers(Conference $conference, array $users, array $topics): array
    {
        $paperTitles = [
            'Implementasi Deep Learning untuk Deteksi Penyakit Tanaman Padi Menggunakan Citra Drone',
            'Analisis Sentimen Media Sosial terhadap Kebijakan Pemerintah Menggunakan LSTM-CNN',
            'Pengembangan Sistem Smart Home Berbasis IoT dengan Protokol MQTT',
            'Keamanan Data pada Aplikasi E-Government: Studi Kasus Portal Layanan Publik',
            'Prediksi Harga Saham dengan Ensemble Machine Learning',
            'Perancangan Microservices Architecture untuk Sistem Informasi Akademik',
            'Evaluasi User Experience Aplikasi M-Banking di Indonesia',
            'Sistem Pendukung Keputusan Pemilihan Beasiswa dengan Metode AHP-TOPSIS',
            'Pengembangan Platform E-Learning Adaptif Berbasis AI',
            'Analisis Green Computing pada Data Center Perguruan Tinggi',
            'Natural Language Processing untuk Chatbot Layanan Kesehatan',
            'Blockchain untuk Transparansi Supply Chain Produk Halal',
            'Computer Vision untuk Sistem Parkir Cerdas',
            'Pengembangan API Gateway dengan Rate Limiting untuk Fintech',
            'Gamifikasi dalam Pembelajaran Pemrograman untuk Siswa SMA',
        ];

        $statuses = [
            'submitted', 'submitted', 
            'screening',
            'in_review', 'in_review', 'in_review',
            'revision_required', 'revised',
            'accepted', 'accepted', 'accepted',
            'payment_pending', 'payment_uploaded',
            'payment_verified',
            'completed',
        ];

        $papers = [];
        foreach ($paperTitles as $i => $title) {
            $author = $users['authors'][$i % count($users['authors'])];
            $topic = $topics[$i % count($topics)];
            $status = $statuses[$i] ?? 'submitted';

            $paper = Paper::create([
                'user_id' => $author->id,
                'conference_id' => $conference->id,
                'assigned_editor_id' => $users['editor']->id,
                'title' => $title,
                'abstract' => $this->generateAbstract($title),
                'keywords' => $this->generateKeywords($topic->name),
                'topic' => $topic->name,
                'authors_meta' => [
                    [
                        'name' => $author->name,
                        'email' => $author->email,
                        'institution' => $author->institution,
                        'is_corresponding' => true,
                    ],
                    [
                        'name' => 'Dr. ' . fake()->name('male'),
                        'email' => fake()->email(),
                        'institution' => fake()->randomElement(['Universitas Indonesia', 'Institut Teknologi Bandung', 'Universitas Gadjah Mada']),
                        'is_corresponding' => false,
                    ],
                ],
                'status' => $status,
                'submitted_at' => now()->subDays(rand(5, 30)),
                'accepted_at' => in_array($status, ['accepted', 'payment_pending', 'payment_uploaded', 'payment_verified', 'completed']) ? now()->subDays(rand(1, 5)) : null,
            ]);

            // Create paper file
            PaperFile::create([
                'paper_id' => $paper->id,
                'type' => 'original',
                'file_path' => 'papers/dummy-paper-' . $paper->id . '.pdf',
                'file_name' => Str::slug($title) . '.pdf',
                'file_size' => rand(500000, 2000000),
                'uploaded_by' => $author->id,
            ]);

            $papers[] = $paper;
        }

        return $papers;
    }

    private function generateAbstract(string $title): string
    {
        return "Penelitian ini membahas tentang " . strtolower($title) . ". " .
            "Metode yang digunakan meliputi studi literatur, pengumpulan data, analisis, dan implementasi sistem. " .
            "Hasil penelitian menunjukkan peningkatan signifikan dalam hal efisiensi dan akurasi dibandingkan metode konvensional. " .
            "Kesimpulan dari penelitian ini memberikan kontribusi penting bagi pengembangan teknologi di Indonesia. " .
            "Penelitian lebih lanjut diperlukan untuk mengoptimalkan hasil yang telah dicapai.";
    }

    private function generateKeywords(string $topic): string
    {
        $baseKeywords = ['Indonesia', 'teknologi', 'inovasi', 'penelitian'];
        $topicKeywords = explode(' ', strtolower(str_replace(['&', '(', ')'], '', $topic)));
        $allKeywords = array_merge(array_slice($topicKeywords, 0, 3), array_slice($baseKeywords, 0, 2));
        return implode(', ', $allKeywords);
    }

    private function createReviews(array $papers, array $reviewers): void
    {
        $recommendations = ['accept', 'minor_revision', 'major_revision', 'reject'];
        
        foreach ($papers as $paper) {
            // Only create reviews for papers that have been reviewed
            if (!in_array($paper->status, ['submitted', 'screening'])) {
                // Assign 2 reviewers per paper
                $assignedReviewers = array_slice($reviewers, 0, 2);
                
                foreach ($assignedReviewers as $reviewer) {
                    $isCompleted = !in_array($paper->status, ['in_review']);
                    
                    Review::create([
                        'paper_id' => $paper->id,
                        'reviewer_id' => $reviewer->id,
                        'assigned_by' => 1, // Admin
                        'status' => $isCompleted ? 'completed' : 'assigned',
                        'comments' => $isCompleted ? $this->generateReviewComments() : null,
                        'comments_for_editor' => $isCompleted ? 'Paper ini memenuhi standar kualitas konferensi.' : null,
                        'recommendation' => $isCompleted ? $this->getRecommendationForStatus($paper->status) : null,
                        'score' => $isCompleted ? rand(60, 95) : null,
                        'reviewed_at' => $isCompleted ? now()->subDays(rand(1, 10)) : null,
                    ]);
                }
            }
        }
    }

    private function getRecommendationForStatus(string $status): string
    {
        return match($status) {
            'accepted', 'payment_pending', 'payment_uploaded', 'payment_verified', 'completed' => 'accept',
            'revision_required' => fake()->randomElement(['minor_revision', 'major_revision']),
            'revised' => 'minor_revision',
            'rejected' => 'reject',
            default => 'minor_revision',
        };
    }

    private function generateReviewComments(): string
    {
        $comments = [
            "Paper ini memiliki kontribusi yang baik dalam bidangnya. ",
            "Metodologi yang digunakan cukup jelas dan terstruktur. ",
            "Hasil penelitian didukung oleh data yang memadai. ",
            "Saran perbaikan: perkuat bagian kajian pustaka dengan referensi terbaru. ",
            "Secara keseluruhan paper layak untuk dipresentasikan di konferensi.",
        ];
        
        return implode('', array_slice($comments, 0, rand(3, 5)));
    }

    private function createPayments(array $papers, array $packages): void
    {
        $pemakalahPackage = $packages[1] ?? $packages[0]; // Pemakalah Umum
        
        foreach ($papers as $paper) {
            if (in_array($paper->status, ['payment_pending', 'payment_uploaded', 'payment_verified', 'completed'])) {
                $status = match($paper->status) {
                    'payment_pending' => 'pending',
                    'payment_uploaded' => 'uploaded',
                    'payment_verified', 'completed' => 'verified',
                    default => 'pending',
                };
                
                Payment::create([
                    'type' => 'paper',
                    'paper_id' => $paper->id,
                    'user_id' => $paper->user_id,
                    'registration_package_id' => $pemakalahPackage->id,
                    'invoice_number' => Payment::generateInvoiceNumber(),
                    'amount' => $pemakalahPackage->price,
                    'description' => 'Biaya registrasi pemakalah untuk paper: ' . Str::limit($paper->title, 50),
                    'status' => $status,
                    'payment_method' => 'bank_transfer',
                    'payment_proof' => $status !== 'pending' ? 'payments/dummy-proof-' . $paper->id . '.jpg' : null,
                    'paid_at' => $status !== 'pending' ? now()->subDays(rand(1, 5)) : null,
                    'verified_by' => $status === 'verified' ? 1 : null,
                    'verified_at' => $status === 'verified' ? now()->subDays(rand(0, 2)) : null,
                ]);
            }
        }
    }

    private function createNews(Conference $conference): void
    {
        $newsItems = [
            [
                'title' => 'Pembukaan Pendaftaran SNTII 2026',
                'content' => '<p>Dengan bangga kami mengumumkan pembukaan pendaftaran Seminar Nasional Teknologi dan Inovasi Indonesia (SNTII) 2026.</p><p>Segera daftarkan paper Anda dan jadilah bagian dari forum ilmiah nasional terbesar di bidang teknologi!</p>',
                'is_published' => true,
                'published_at' => now()->subWeeks(4),
            ],
            [
                'title' => 'Keynote Speaker Terungkap!',
                'content' => '<p>Kami dengan bangga mengumumkan keynote speaker untuk SNTII 2026. Para pakar terkemuka di bidang teknologi akan berbagi wawasan mereka.</p><p>Jangan lewatkan kesempatan emas untuk belajar dari yang terbaik!</p>',
                'is_published' => true,
                'published_at' => now()->subWeeks(3),
            ],
            [
                'title' => 'Early Bird Registration Diperpanjang',
                'content' => '<p>Menanggapi permintaan banyak peserta, kami memperpanjang periode early bird registration hingga akhir bulan ini.</p><p>Manfaatkan kesempatan ini untuk mendapatkan harga spesial!</p>',
                'is_published' => true,
                'published_at' => now()->subWeeks(1),
            ],
            [
                'title' => 'Template Paper Tersedia',
                'content' => '<p>Template paper dalam format Word dan LaTeX sudah tersedia untuk diunduh.</p><p>Pastikan paper Anda mengikuti format yang ditentukan untuk memperlancar proses review.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
        ];

        foreach ($newsItems as $news) {
            News::create(array_merge($news, [
                'conference_id' => $conference->id,
                'slug' => Str::slug($news['title']),
            ]));
        }

        // Create Announcements
        Announcement::create([
            'title' => 'Deadline Submission Diperpanjang',
            'content' => 'Deadline submission paper diperpanjang hingga tanggal ' . now()->addMonths(2)->format('d F Y') . '. Jangan lewatkan kesempatan ini!',
            'type' => 'info',
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addMonths(1),
        ]);
    }

    private function createSliders(Conference $conference): void
    {
        $sliders = [
            [
                'title' => 'SNTII 2026',
                'subtitle' => 'Seminar Nasional Teknologi dan Inovasi Indonesia',
                'description' => 'Transformasi Digital untuk Indonesia Maju',
                'button_text' => 'Daftar Sekarang',
                'button_url' => '/register',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Call for Papers',
                'subtitle' => 'Submit Your Research',
                'description' => 'Deadline: ' . now()->addMonths(2)->format('d F Y'),
                'button_text' => 'Submit Paper',
                'button_url' => '/login',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create(array_merge($slider, ['conference_id' => $conference->id]));
        }
    }

    private function printSummary(Conference $conference, array $users): void
    {
        $this->command->table(
            ['Data', 'Jumlah'],
            [
                ['Conference', 1],
                ['Topics', Topic::where('conference_id', $conference->id)->count()],
                ['Keynote Speakers', KeynoteSpeaker::where('conference_id', $conference->id)->count()],
                ['Committee Members', Committee::where('conference_id', $conference->id)->count()],
                ['Registration Packages', RegistrationPackage::where('conference_id', $conference->id)->count()],
                ['Important Dates', ImportantDate::where('conference_id', $conference->id)->count()],
                ['Journal Publications', JournalPublication::where('conference_id', $conference->id)->count()],
                ['Authors', count($users['authors'])],
                ['Reviewers', count($users['reviewers'])],
                ['Papers', Paper::where('conference_id', $conference->id)->count()],
                ['Reviews', Review::whereIn('paper_id', Paper::where('conference_id', $conference->id)->pluck('id'))->count()],
                ['Payments', Payment::whereIn('paper_id', Paper::where('conference_id', $conference->id)->pluck('id'))->count()],
                ['News', News::where('conference_id', $conference->id)->count()],
            ]
        );

        $this->command->newLine();
        $this->command->info('📋 Akun yang tersedia untuk testing:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@prosiding.test', 'password'],
                ['Editor', 'olivia.editor@prosiding.test', 'password'],
                ['Reviewer', 'joko.susilo@reviewer.ac.id', 'password'],
                ['Author', 'aditya.pratama@ui.ac.id', 'password'],
            ]
        );
    }
}
