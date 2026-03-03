-- ============================================
-- DUMMY DATA IMPORT FILE
-- Seminar Nasional Teknologi dan Inovasi Indonesia (SNTII) 2026
-- 
-- Import melalui: Admin Panel > Database Manager
-- atau via terminal: mysql -u root -p prosidingv1 < dummy_data.sql
-- ============================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET NAMES utf8mb4;

-- ============================================
-- CONFERENCES
-- ============================================
INSERT INTO `conferences` (`id`, `name`, `acronym`, `theme`, `description`, `start_date`, `start_time`, `end_date`, `end_time`, `venue`, `venue_type`, `online_url`, `city`, `organizer`, `conference_type`, `status`, `is_active`, `payment_bank_name`, `payment_bank_account`, `payment_account_holder`, `payment_contact_phone`, `payment_instructions`, `payment_methods`, `wa_group_pemakalah`, `wa_group_reviewer`, `chairman_name`, `chairman_title`, `secretary_name`, `secretary_title`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Seminar Nasional Teknologi dan Inovasi Indonesia 2026', 'SNTII 2026', 'Transformasi Digital untuk Indonesia Maju: Peran Teknologi dalam Pembangunan Berkelanjutan', '<p>Seminar Nasional Teknologi dan Inovasi Indonesia (SNTII) 2026 merupakan forum ilmiah tahunan yang menghimpun para akademisi, peneliti, praktisi, dan mahasiswa dari berbagai institusi di Indonesia.</p>\r\n<p>Konferensi ini bertujuan untuk:</p>\r\n<ul>\r\n<li>Mendiseminasikan hasil-hasil penelitian terbaru di bidang teknologi</li>\r\n<li>Memfasilitasi kolaborasi antar peneliti dari berbagai institusi</li>\r\n<li>Mendiskusikan tantangan dan solusi teknologi untuk pembangunan berkelanjutan</li>\r\n<li>Memberikan wadah publikasi ilmiah yang berkualitas</li>\r\n</ul>\r\n<p>Paper terbaik akan dipublikasikan di jurnal nasional terakreditasi SINTA 2-4.</p>', '2026-06-01', '08:00:00', '2026-06-02', '17:00:00', 'Grand Ballroom Hotel Indonesia Kempinski Jakarta', 'hybrid', 'https://zoom.us/j/1234567890', 'Jakarta', 'Asosiasi Perguruan Tinggi Indonesia (APTI) bekerja sama dengan Kementerian Riset dan Teknologi', 'nasional', 'published', 1, 'Bank Mandiri', '1234567890123', 'Panitia SNTII 2026', '081234567890', 'Transfer sesuai nominal yang tertera di invoice. Cantumkan kode invoice pada berita transfer. Konfirmasi pembayaran dengan upload bukti transfer.', '["bank_transfer", "qris"]', 'https://chat.whatsapp.com/ABC123pemakalah', 'https://chat.whatsapp.com/XYZ789reviewer', 'Prof. Dr. Ir. Bambang Sudibyo, M.T.', 'Ketua Panitia', 'Dr. Siti Aminah, M.Kom.', 'Sekretaris Panitia', 1, NOW(), NOW());

-- ============================================
-- TOPICS
-- ============================================
INSERT INTO `topics` (`id`, `conference_id`, `name`, `description`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Artificial Intelligence & Machine Learning', 'Deep learning, neural networks, NLP, computer vision, dan aplikasi AI', 1, NOW(), NOW()),
(2, 1, 'Internet of Things (IoT)', 'Smart devices, embedded systems, sensor networks, edge computing', 2, NOW(), NOW()),
(3, 1, 'Cyber Security & Privacy', 'Network security, cryptography, data privacy, ethical hacking', 3, NOW(), NOW()),
(4, 1, 'Big Data & Data Science', 'Data analytics, data mining, visualization, business intelligence', 4, NOW(), NOW()),
(5, 1, 'Cloud & Distributed Computing', 'Cloud architecture, microservices, containerization, serverless', 5, NOW(), NOW()),
(6, 1, 'Software Engineering', 'Software development, agile methodology, DevOps, quality assurance', 6, NOW(), NOW()),
(7, 1, 'Human-Computer Interaction', 'UX/UI design, accessibility, usability studies', 7, NOW(), NOW()),
(8, 1, 'Information Systems', 'Enterprise systems, e-government, digital transformation', 8, NOW(), NOW()),
(9, 1, 'Educational Technology', 'E-learning, gamification, learning management systems', 9, NOW(), NOW()),
(10, 1, 'Green Computing & Sustainability', 'Energy-efficient computing, sustainable IT practices', 10, NOW(), NOW());

-- ============================================
-- KEYNOTE SPEAKERS
-- ============================================
INSERT INTO `keynote_speakers` (`id`, `conference_id`, `name`, `title`, `institution`, `bio`, `topic`, `type`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Prof. Dr. Ir. Nizam, M.Sc.', 'Direktur Jenderal Pendidikan Tinggi', 'Kementerian Pendidikan dan Kebudayaan RI', 'Profesor di bidang Teknik Elektro dengan pengalaman lebih dari 25 tahun dalam penelitian dan pengembangan teknologi. Aktif mendorong transformasi digital di perguruan tinggi Indonesia.', 'Kebijakan Transformasi Digital Pendidikan Tinggi di Indonesia', 'keynote', 1, NOW(), NOW()),
(2, 1, 'Dr. Onno W. Purbo', 'Pakar Teknologi Informasi', 'Institut Teknologi Bandung', 'Pionir internet Indonesia yang telah memberikan kontribusi besar dalam pengembangan infrastruktur IT di tanah air. Penulis puluhan buku tentang teknologi.', 'Demokratisasi Teknologi: Membuka Akses untuk Semua', 'keynote', 2, NOW(), NOW()),
(3, 1, 'Prof. Ir. Hammam Riza, M.Sc., Ph.D.', 'Kepala BRIN', 'Badan Riset dan Inovasi Nasional', 'Pakar AI dan NLP dengan berbagai publikasi internasional. Berpengalaman memimpin berbagai proyek riset nasional strategis.', 'Roadmap Riset AI Indonesia 2030', 'keynote', 3, NOW(), NOW()),
(4, 1, 'Dr. Ir. Setiaji, M.T.', 'Chief Digital Transformation Office', 'Kementerian Kesehatan RI', 'Arsitek utama transformasi digital sektor kesehatan Indonesia termasuk PeduliLindungi dan SATUSEHAT.', 'Studi Kasus: Transformasi Digital di Sektor Kesehatan', 'invited', 4, NOW(), NOW()),
(5, 1, 'Achmad Zaky', 'Founder & CEO', 'Bukalapak (Alumnus)', 'Entrepreneur teknologi yang sukses membangun unicorn Indonesia. Aktif dalam mentoring startup dan pengembangan ekosistem digital.', 'Membangun Startup Teknologi Berdampak', 'invited', 5, NOW(), NOW());

-- ============================================
-- COMMITTEES
-- ============================================
INSERT INTO `committees` (`id`, `conference_id`, `name`, `title`, `institution`, `type`, `role`, `sort_order`, `created_at`, `updated_at`) VALUES
-- Steering Committee
(1, 1, 'Prof. Dr. Ir. Reini Wirahadikusumah, M.Sc.', 'Rektor ITB', 'Institut Teknologi Bandung', 'steering', 'Chair', 1, NOW(), NOW()),
(2, 1, 'Prof. Dr. Ir. Ari Purbayanto, M.Sc.', 'Rektor IPB', 'Institut Pertanian Bogor', 'steering', 'Member', 2, NOW(), NOW()),
(3, 1, 'Prof. Ir. Nizam, M.Sc., D.Eng., IPU, ASEAN Eng.', 'Rektor UGM', 'Universitas Gadjah Mada', 'steering', 'Member', 3, NOW(), NOW()),
-- Organizing Committee
(4, 1, 'Prof. Dr. Ir. Bambang Sudibyo, M.T.', 'Ketua Panitia', 'Universitas Indonesia', 'organizing', 'General Chair', 1, NOW(), NOW()),
(5, 1, 'Dr. Siti Aminah, M.Kom.', 'Sekretaris', 'Universitas Indonesia', 'organizing', 'Secretary', 2, NOW(), NOW()),
(6, 1, 'Dr. Ir. Ahmad Fauzi, M.T.', 'Bendahara', 'Institut Teknologi Bandung', 'organizing', 'Treasurer', 3, NOW(), NOW()),
(7, 1, 'Dr. Rina Wijayanti, M.Kom.', 'Koordinator Paper', 'Universitas Gadjah Mada', 'organizing', 'Paper Chair', 4, NOW(), NOW()),
(8, 1, 'Ir. Budi Santoso, M.T.', 'Koordinator Acara', 'Institut Teknologi Sepuluh Nopember', 'organizing', 'Event Chair', 5, NOW(), NOW()),
-- Scientific Committee
(9, 1, 'Prof. Dr. Ir. Suhono Harso Supangkat', 'Professor', 'Institut Teknologi Bandung', 'scientific', 'Chair', 1, NOW(), NOW()),
(10, 1, 'Prof. Dr. Wisnu Jatmiko', 'Professor', 'Universitas Indonesia', 'scientific', 'Member', 2, NOW(), NOW()),
(11, 1, 'Prof. Dr. Mauridhi Hery Purnomo', 'Professor', 'Institut Teknologi Sepuluh Nopember', 'scientific', 'Member', 3, NOW(), NOW()),
(12, 1, 'Dr. Eng. Herman Tolle', 'Associate Professor', 'Universitas Brawijaya', 'scientific', 'Member', 4, NOW(), NOW()),
(13, 1, 'Dr. Teguh Bharata Adji', 'Associate Professor', 'Universitas Gadjah Mada', 'scientific', 'Member', 5, NOW(), NOW());

-- ============================================
-- REGISTRATION PACKAGES
-- ============================================
INSERT INTO `registration_packages` (`id`, `conference_id`, `name`, `price`, `currency`, `description`, `features`, `is_featured`, `is_free`, `require_payment_proof`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pemakalah Mahasiswa', 500000, 'IDR', 'Untuk mahasiswa S1/S2/S3 dengan menunjukkan KTM aktif', '["Sertifikat pemakalah", "Seminar kit", "Makan siang 2x", "Prosiding ber-ISBN", "Kesempatan publikasi jurnal"]', 0, 0, 1, 1, 1, NOW(), NOW()),
(2, 1, 'Pemakalah Umum', 1000000, 'IDR', 'Untuk dosen, peneliti, dan profesional', '["Sertifikat pemakalah", "Seminar kit premium", "Makan siang 2x", "Gala dinner", "Prosiding ber-ISBN", "Kesempatan publikasi jurnal"]', 1, 0, 1, 1, 2, NOW(), NOW()),
(3, 1, 'Peserta Non-Pemakalah', 300000, 'IDR', 'Untuk peserta yang ingin menghadiri seminar tanpa presentasi', '["Sertifikat peserta", "Seminar kit", "Makan siang 2x", "Akses semua sesi"]', 0, 0, 1, 1, 3, NOW(), NOW()),
(4, 1, 'Peserta Online', 0, 'IDR', 'Registrasi gratis untuk mengikuti sesi secara online', '["Sertifikat peserta online", "Akses live streaming", "Recording akses 7 hari"]', 0, 1, 0, 1, 4, NOW(), NOW());

-- ============================================
-- IMPORTANT DATES
-- ============================================
INSERT INTO `important_dates` (`id`, `conference_id`, `title`, `date`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pembukaan Submission', '2026-01-01', 'Sistem submission paper dibuka', 1, 1, NOW(), NOW()),
(2, 1, 'Deadline Abstrak', '2026-03-15', 'Batas akhir pengiriman abstrak', 1, 2, NOW(), NOW()),
(3, 1, 'Notifikasi Abstrak', '2026-03-30', 'Pengumuman penerimaan abstrak', 1, 3, NOW(), NOW()),
(4, 1, 'Deadline Full Paper', '2026-04-30', 'Batas akhir pengiriman paper lengkap', 1, 4, NOW(), NOW()),
(5, 1, 'Notifikasi Review', '2026-05-15', 'Pengumuman hasil review paper', 1, 5, NOW(), NOW()),
(6, 1, 'Deadline Camera Ready', '2026-05-25', 'Batas akhir revisi final paper', 1, 6, NOW(), NOW()),
(7, 1, 'Early Bird Registration', '2026-05-20', 'Batas registrasi dengan harga khusus', 1, 7, NOW(), NOW()),
(8, 1, 'Pelaksanaan Seminar', '2026-06-01', 'Hari pelaksanaan seminar', 1, 8, NOW(), NOW());

-- ============================================
-- JOURNAL PUBLICATIONS
-- ============================================
INSERT INTO `journal_publications` (`id`, `conference_id`, `name`, `issn`, `publisher`, `indexing`, `url`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jurnal Teknologi Informasi dan Ilmu Komputer (JTIIK)', '2355-7699', 'Universitas Brawijaya', 'SINTA 2, DOAJ, Google Scholar', 'https://jtiik.ub.ac.id', 'Paper terbaik bidang AI dan Software Engineering', 1, 1, NOW(), NOW()),
(2, 1, 'Jurnal Ilmu Komputer dan Informasi (JIKI)', '1979-0732', 'Universitas Indonesia', 'SINTA 2, Scopus Indexed', 'https://jiki.cs.ui.ac.id', 'Paper terbaik bidang Data Science dan Big Data', 1, 2, NOW(), NOW()),
(3, 1, 'Telkomnika', '1693-6930', 'Universitas Ahmad Dahlan', 'SINTA 1, Scopus Q3', 'https://telkomnika.uad.ac.id', 'Paper terbaik bidang IoT dan Telecommunications', 1, 3, NOW(), NOW()),
(4, 1, 'Jurnal Sistem Informasi (JSI)', '1858-4667', 'Institut Teknologi Sepuluh Nopember', 'SINTA 3, Google Scholar', 'https://jsi.its.ac.id', 'Paper bidang Information Systems', 1, 4, NOW(), NOW());

-- ============================================
-- SUPPORTERS / SPONSORS
-- ============================================
INSERT INTO `supporters` (`id`, `conference_id`, `name`, `type`, `url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kementerian Riset dan Teknologi', 'organizer', 'https://ristekdikti.go.id', 1, 1, NOW(), NOW()),
(2, 1, 'Telkom Indonesia', 'sponsor_gold', 'https://telkom.co.id', 1, 1, NOW(), NOW()),
(3, 1, 'Tokopedia', 'sponsor_gold', 'https://tokopedia.com', 1, 2, NOW(), NOW()),
(4, 1, 'Gojek', 'sponsor_silver', 'https://gojek.com', 1, 1, NOW(), NOW()),
(5, 1, 'Bukalapak', 'sponsor_silver', 'https://bukalapak.com', 1, 2, NOW(), NOW()),
(6, 1, 'Microsoft Indonesia', 'sponsor_bronze', 'https://microsoft.com/id-id', 1, 1, NOW(), NOW()),
(7, 1, 'Google Indonesia', 'sponsor_bronze', 'https://google.co.id', 1, 2, NOW(), NOW()),
(8, 1, 'IEEE Indonesia Section', 'media_partner', 'https://ieee.org', 1, 1, NOW(), NOW()),
(9, 1, 'APTIKOM', 'media_partner', 'https://aptikom.org', 1, 2, NOW(), NOW());

-- ============================================
-- USERS (Authors, Reviewers, Editor)
-- Password: password (hashed dengan bcrypt)
-- ============================================
INSERT INTO `users` (`id`, `name`, `email`, `password`, `institution`, `phone`, `email_verified_at`, `created_at`, `updated_at`) VALUES
-- Authors (ID 100-109)
(100, 'Dr. Aditya Pratama', 'aditya.pratama@ui.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Universitas Indonesia', '081234567001', NOW(), NOW(), NOW()),
(101, 'Sinta Dewi, M.Kom.', 'sinta.dewi@itb.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Institut Teknologi Bandung', '081234567002', NOW(), NOW(), NOW()),
(102, 'Ir. Budi Setiawan, M.T.', 'budi.setiawan@ugm.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Universitas Gadjah Mada', '081234567003', NOW(), NOW(), NOW()),
(103, 'Rina Kartika, S.Kom., M.Cs.', 'rina.kartika@its.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Institut Teknologi Sepuluh Nopember', '081234567004', NOW(), NOW(), NOW()),
(104, 'Ahmad Rizki Mahasiswa', 'ahmad.rizki@student.ub.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Universitas Brawijaya', '081234567005', NOW(), NOW(), NOW()),
(105, 'Dewi Safitri, M.Kom.', 'dewi.safitri@unpad.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Universitas Padjadjaran', '081234567006', NOW(), NOW(), NOW()),
(106, 'Dr. Fahmi Abdullah', 'fahmi.abdullah@undip.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Universitas Diponegoro', '081234567007', NOW(), NOW(), NOW()),
(107, 'Gilang Ramadhan, S.T.', 'gilang.ramadhan@telkomuniversity.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Telkom University', '081234567008', NOW(), NOW(), NOW()),
(108, 'Hana Permata, M.Ti.', 'hana.permata@binus.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Binus University', '081234567009', NOW(), NOW(), NOW()),
(109, 'Irfan Maulana, S.Kom.', 'irfan.maulana@upi.edu', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Universitas Pendidikan Indonesia', '081234567010', NOW(), NOW(), NOW()),
-- Reviewers (ID 110-114)
(110, 'Prof. Dr. Joko Susilo', 'joko.susilo@reviewer.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Universitas Indonesia', '081234567020', NOW(), NOW(), NOW()),
(111, 'Dr. Kartini Wulandari', 'kartini.wulandari@reviewer.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Institut Teknologi Bandung', '081234567021', NOW(), NOW(), NOW()),
(112, 'Dr. Lukman Hakim', 'lukman.hakim@reviewer.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Universitas Gadjah Mada', '081234567022', NOW(), NOW(), NOW()),
(113, 'Dr. Mega Puspita', 'mega.puspita@reviewer.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Institut Teknologi Sepuluh Nopember', '081234567023', NOW(), NOW(), NOW()),
(114, 'Dr. Nugroho Santoso', 'nugroho.santoso@reviewer.ac.id', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Universitas Brawijaya', '081234567024', NOW(), NOW(), NOW()),
-- Editor (ID 115)
(115, 'Dr. Olivia Editor', 'olivia.editor@prosiding.test', '$2y$12$LQh9GJf7K8hJCqXvYDAhVe1YvhRz6l8WjBnkJ7rKgVL5jM9Ru5KYu', 'Panitia SNTII 2026', '081234567099', NOW(), NOW(), NOW());

-- ============================================
-- ROLE ASSIGNMENTS
-- (Assumes roles: 1=admin, 2=editor, 3=reviewer, 4=author)
-- ============================================
INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
-- Authors get author role (4)
(100, 4), (101, 4), (102, 4), (103, 4), (104, 4),
(105, 4), (106, 4), (107, 4), (108, 4), (109, 4),
-- Reviewers get reviewer role (3)
(110, 3), (111, 3), (112, 3), (113, 3), (114, 3),
-- Editor gets editor role (2)
(115, 2);

-- ============================================
-- PAPERS (Various statuses for testing)
-- ============================================
INSERT INTO `papers` (`id`, `user_id`, `conference_id`, `assigned_editor_id`, `title`, `abstract`, `keywords`, `topic`, `authors_meta`, `status`, `submitted_at`, `accepted_at`, `created_at`, `updated_at`) VALUES
(1, 100, 1, 115, 'Implementasi Deep Learning untuk Deteksi Penyakit Tanaman Padi Menggunakan Citra Drone', 'Penelitian ini membahas tentang implementasi deep learning untuk deteksi penyakit tanaman padi menggunakan citra drone. Metode yang digunakan meliputi studi literatur, pengumpulan data, analisis, dan implementasi sistem. Hasil penelitian menunjukkan peningkatan signifikan dalam hal efisiensi dan akurasi dibandingkan metode konvensional.', 'deep learning, deteksi penyakit, padi, drone, computer vision', 'Artificial Intelligence & Machine Learning', '[{"name": "Dr. Aditya Pratama", "email": "aditya.pratama@ui.ac.id", "institution": "Universitas Indonesia", "is_corresponding": true}]', 'submitted', NOW(), NULL, NOW(), NOW()),
(2, 101, 1, 115, 'Analisis Sentimen Media Sosial terhadap Kebijakan Pemerintah Menggunakan LSTM-CNN', 'Penelitian ini menggunakan kombinasi LSTM dan CNN untuk menganalisis sentimen masyarakat di media sosial terhadap kebijakan pemerintah. Dataset dikumpulkan dari Twitter dengan lebih dari 50.000 tweet.', 'sentiment analysis, LSTM, CNN, media sosial, NLP', 'Artificial Intelligence & Machine Learning', '[{"name": "Sinta Dewi, M.Kom.", "email": "sinta.dewi@itb.ac.id", "institution": "Institut Teknologi Bandung", "is_corresponding": true}]', 'screening', NOW(), NULL, NOW(), NOW()),
(3, 102, 1, 115, 'Pengembangan Sistem Smart Home Berbasis IoT dengan Protokol MQTT', 'Sistem smart home yang dikembangkan menggunakan protokol MQTT untuk komunikasi antar perangkat. Implementasi dilakukan pada rumah prototipe dengan berbagai sensor dan aktuator.', 'smart home, IoT, MQTT, sensor, automation', 'Internet of Things (IoT)', '[{"name": "Ir. Budi Setiawan, M.T.", "email": "budi.setiawan@ugm.ac.id", "institution": "Universitas Gadjah Mada", "is_corresponding": true}]', 'in_review', NOW(), NULL, NOW(), NOW()),
(4, 103, 1, 115, 'Keamanan Data pada Aplikasi E-Government: Studi Kasus Portal Layanan Publik', 'Evaluasi keamanan pada sistem e-government dengan fokus pada aspek autentikasi, enkripsi, dan proteksi data pribadi warga. Ditemukan beberapa kerentanan yang perlu diperbaiki.', 'cyber security, e-government, data privacy, vulnerability assessment', 'Cyber Security & Privacy', '[{"name": "Rina Kartika, S.Kom., M.Cs.", "email": "rina.kartika@its.ac.id", "institution": "Institut Teknologi Sepuluh Nopember", "is_corresponding": true}]', 'in_review', NOW(), NULL, NOW(), NOW()),
(5, 104, 1, 115, 'Prediksi Harga Saham dengan Ensemble Machine Learning', 'Penelitian ini membandingkan berbagai algoritma ensemble (Random Forest, XGBoost, LightGBM) untuk memprediksi harga saham di Bursa Efek Indonesia dengan akurasi hingga 85%.', 'prediksi saham, ensemble learning, machine learning, big data', 'Big Data & Data Science', '[{"name": "Ahmad Rizki Mahasiswa", "email": "ahmad.rizki@student.ub.ac.id", "institution": "Universitas Brawijaya", "is_corresponding": true}]', 'in_review', NOW(), NULL, NOW(), NOW()),
(6, 105, 1, 115, 'Perancangan Microservices Architecture untuk Sistem Informasi Akademik', 'Paper ini membahas migrasi sistem informasi akademik monolitik ke arsitektur microservices menggunakan Docker dan Kubernetes untuk meningkatkan skalabilitas.', 'microservices, docker, kubernetes, sistem akademik', 'Software Engineering', '[{"name": "Dewi Safitri, M.Kom.", "email": "dewi.safitri@unpad.ac.id", "institution": "Universitas Padjadjaran", "is_corresponding": true}]', 'revision_required', NOW(), NULL, NOW(), NOW()),
(7, 106, 1, 115, 'Evaluasi User Experience Aplikasi M-Banking di Indonesia', 'Studi UX terhadap 5 aplikasi m-banking terpopuler di Indonesia menggunakan metode SUS dan usability testing dengan 50 responden.', 'user experience, m-banking, usability, mobile apps', 'Human-Computer Interaction', '[{"name": "Dr. Fahmi Abdullah", "email": "fahmi.abdullah@undip.ac.id", "institution": "Universitas Diponegoro", "is_corresponding": true}]', 'revised', NOW(), NULL, NOW(), NOW()),
(8, 107, 1, 115, 'Sistem Pendukung Keputusan Pemilihan Beasiswa dengan Metode AHP-TOPSIS', 'Pengembangan SPK untuk membantu seleksi penerima beasiswa menggunakan kombinasi metode AHP dan TOPSIS dengan hasil validasi yang baik.', 'SPK, AHP, TOPSIS, beasiswa, decision support', 'Information Systems', '[{"name": "Gilang Ramadhan, S.T.", "email": "gilang.ramadhan@telkomuniversity.ac.id", "institution": "Telkom University", "is_corresponding": true}]', 'accepted', '2026-02-15', '2026-02-28', NOW(), NOW()),
(9, 108, 1, 115, 'Pengembangan Platform E-Learning Adaptif Berbasis AI', 'Platform e-learning yang dapat menyesuaikan materi pembelajaran berdasarkan kemampuan dan gaya belajar siswa menggunakan algoritma adaptive learning.', 'e-learning, adaptive learning, AI, pendidikan', 'Educational Technology', '[{"name": "Hana Permata, M.Ti.", "email": "hana.permata@binus.ac.id", "institution": "Binus University", "is_corresponding": true}]', 'accepted', '2026-02-15', '2026-02-28', NOW(), NOW()),
(10, 109, 1, 115, 'Analisis Green Computing pada Data Center Perguruan Tinggi', 'Audit efisiensi energi pada data center 10 perguruan tinggi di Indonesia dengan rekomendasi penghematan hingga 30% konsumsi daya.', 'green computing, data center, efisiensi energi, sustainability', 'Green Computing & Sustainability', '[{"name": "Irfan Maulana, S.Kom.", "email": "irfan.maulana@upi.edu", "institution": "Universitas Pendidikan Indonesia", "is_corresponding": true}]', 'accepted', '2026-02-15', '2026-02-28', NOW(), NOW()),
(11, 100, 1, 115, 'Natural Language Processing untuk Chatbot Layanan Kesehatan', 'Pengembangan chatbot berbasis NLP untuk memberikan informasi kesehatan awal kepada masyarakat dengan domain penyakit umum.', 'NLP, chatbot, kesehatan, conversational AI', 'Artificial Intelligence & Machine Learning', '[{"name": "Dr. Aditya Pratama", "email": "aditya.pratama@ui.ac.id", "institution": "Universitas Indonesia", "is_corresponding": true}]', 'payment_pending', '2026-01-20', '2026-02-20', NOW(), NOW()),
(12, 101, 1, 115, 'Blockchain untuk Transparansi Supply Chain Produk Halal', 'Implementasi blockchain untuk memastikan traceability dan transparansi pada supply chain produk halal dari produsen hingga konsumen.', 'blockchain, supply chain, halal, traceability', 'Information Systems', '[{"name": "Sinta Dewi, M.Kom.", "email": "sinta.dewi@itb.ac.id", "institution": "Institut Teknologi Bandung", "is_corresponding": true}]', 'payment_uploaded', '2026-01-15', '2026-02-15', NOW(), NOW()),
(13, 102, 1, 115, 'Computer Vision untuk Sistem Parkir Cerdas', 'Sistem pengenalan plat nomor kendaraan menggunakan YOLO dan OCR untuk manajemen parkir otomatis dengan akurasi 98%.', 'computer vision, YOLO, OCR, smart parking', 'Artificial Intelligence & Machine Learning', '[{"name": "Ir. Budi Setiawan, M.T.", "email": "budi.setiawan@ugm.ac.id", "institution": "Universitas Gadjah Mada", "is_corresponding": true}]', 'payment_verified', '2026-01-10', '2026-02-10', NOW(), NOW()),
(14, 103, 1, 115, 'Pengembangan API Gateway dengan Rate Limiting untuk Fintech', 'Desain dan implementasi API Gateway yang aman dan scalable untuk aplikasi fintech dengan fitur rate limiting dan traffic management.', 'API gateway, rate limiting, fintech, microservices', 'Software Engineering', '[{"name": "Rina Kartika, S.Kom., M.Cs.", "email": "rina.kartika@its.ac.id", "institution": "Institut Teknologi Sepuluh Nopember", "is_corresponding": true}]', 'completed', '2026-01-05', '2026-02-05', NOW(), NOW()),
(15, 104, 1, 115, 'Gamifikasi dalam Pembelajaran Pemrograman untuk Siswa SMA', 'Pengembangan platform pembelajaran pemrograman dengan elemen gamifikasi yang terbukti meningkatkan motivasi belajar siswa SMA.', 'gamifikasi, pembelajaran, pemrograman, pendidikan', 'Educational Technology', '[{"name": "Ahmad Rizki Mahasiswa", "email": "ahmad.rizki@student.ub.ac.id", "institution": "Universitas Brawijaya", "is_corresponding": true}]', 'completed', '2026-01-01', '2026-02-01', NOW(), NOW());

-- ============================================
-- PAPER FILES
-- ============================================
INSERT INTO `paper_files` (`id`, `paper_id`, `type`, `file_path`, `file_name`, `file_size`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'original', 'papers/dummy-paper-1.pdf', 'deep-learning-padi.pdf', 1500000, 100, NOW(), NOW()),
(2, 2, 'original', 'papers/dummy-paper-2.pdf', 'sentiment-analysis-lstm.pdf', 1200000, 101, NOW(), NOW()),
(3, 3, 'original', 'papers/dummy-paper-3.pdf', 'smart-home-iot.pdf', 1800000, 102, NOW(), NOW()),
(4, 4, 'original', 'papers/dummy-paper-4.pdf', 'keamanan-egovernment.pdf', 1100000, 103, NOW(), NOW()),
(5, 5, 'original', 'papers/dummy-paper-5.pdf', 'prediksi-saham.pdf', 1400000, 104, NOW(), NOW()),
(6, 6, 'original', 'papers/dummy-paper-6.pdf', 'microservices-akademik.pdf', 1600000, 105, NOW(), NOW()),
(7, 7, 'original', 'papers/dummy-paper-7.pdf', 'ux-mbanking.pdf', 1300000, 106, NOW(), NOW()),
(8, 8, 'original', 'papers/dummy-paper-8.pdf', 'spk-beasiswa.pdf', 1700000, 107, NOW(), NOW()),
(9, 9, 'original', 'papers/dummy-paper-9.pdf', 'elearning-adaptif.pdf', 1500000, 108, NOW(), NOW()),
(10, 10, 'original', 'papers/dummy-paper-10.pdf', 'green-computing.pdf', 1200000, 109, NOW(), NOW()),
(11, 11, 'original', 'papers/dummy-paper-11.pdf', 'nlp-chatbot.pdf', 1400000, 100, NOW(), NOW()),
(12, 12, 'original', 'papers/dummy-paper-12.pdf', 'blockchain-halal.pdf', 1600000, 101, NOW(), NOW()),
(13, 13, 'original', 'papers/dummy-paper-13.pdf', 'computer-vision-parkir.pdf', 1800000, 102, NOW(), NOW()),
(14, 14, 'original', 'papers/dummy-paper-14.pdf', 'api-gateway-fintech.pdf', 1100000, 103, NOW(), NOW()),
(15, 15, 'original', 'papers/dummy-paper-15.pdf', 'gamifikasi-pemrograman.pdf', 1500000, 104, NOW(), NOW());

-- ============================================
-- REVIEWS
-- ============================================
INSERT INTO `reviews` (`id`, `paper_id`, `reviewer_id`, `assigned_by`, `status`, `comments`, `comments_for_editor`, `recommendation`, `score`, `reviewed_at`, `created_at`, `updated_at`) VALUES
-- Paper 3 (in_review)
(1, 3, 110, 1, 'assigned', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
(2, 3, 111, 1, 'assigned', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
-- Paper 4 (in_review)
(3, 4, 112, 1, 'assigned', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
(4, 4, 113, 1, 'assigned', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
-- Paper 5 (in_review)
(5, 5, 114, 1, 'assigned', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
(6, 5, 110, 1, 'assigned', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
-- Paper 6 (revision_required)
(7, 6, 111, 1, 'completed', 'Paper ini memiliki ide yang bagus namun perlu penjelasan lebih detail pada bagian metodologi. Grafik perbandingan performa perlu ditambahkan. Referensi terbaru juga perlu dilengkapi.', 'Paper layak dengan revisi minor.', 'minor_revision', 72, '2026-02-20', NOW(), NOW()),
(8, 6, 112, 1, 'completed', 'Kontribusi paper cukup signifikan. Namun ada beberapa hal yang perlu diperbaiki: validasi hasil, penulisan yang lebih terstruktur, dan diskusi yang lebih mendalam.', 'Revisi diperlukan sebelum diterima.', 'major_revision', 65, '2026-02-21', NOW(), NOW()),
-- Paper 7 (revised)
(9, 7, 113, 1, 'completed', 'Studi UX yang komprehensif dengan metodologi yang baik. Saran: tambahkan demografis responden dan analisis statistik yang lebih detail.', 'Paper bagus, perlu sedikit perbaikan.', 'minor_revision', 78, '2026-02-18', NOW(), NOW()),
(10, 7, 114, 1, 'completed', 'Paper ini memberikan insight yang bermanfaat tentang UX m-banking di Indonesia. Penulisan sudah baik.', 'Recommend minor revision.', 'minor_revision', 80, '2026-02-19', NOW(), NOW()),
-- Paper 8-15 (accepted onwards)
(11, 8, 110, 1, 'completed', 'Metodologi AHP-TOPSIS diterapkan dengan baik. Paper layak diterima untuk presentasi.', 'Accept.', 'accept', 85, '2026-02-15', NOW(), NOW()),
(12, 8, 111, 1, 'completed', 'Implementasi SPK yang solid dengan validasi yang baik. Recommend acceptance.', 'Accept for presentation.', 'accept', 88, '2026-02-16', NOW(), NOW()),
(13, 9, 112, 1, 'completed', 'Platform e-learning yang inovatif. Kontribusi signifikan untuk pendidikan di Indonesia.', 'Strong accept.', 'accept', 90, '2026-02-14', NOW(), NOW()),
(14, 9, 113, 1, 'completed', 'Eksperimen dengan siswa menunjukkan hasil yang menjanjikan. Paper ditulis dengan baik.', 'Accept.', 'accept', 87, '2026-02-15', NOW(), NOW()),
(15, 10, 114, 1, 'completed', 'Penelitian yang relevan dengan isu sustainability. Data dari 10 universitas memberikan gambaran komprehensif.', 'Accept.', 'accept', 82, '2026-02-12', NOW(), NOW()),
(16, 10, 110, 1, 'completed', 'Kontribusi praktis yang baik untuk pengelolaan data center. Rekomendasi yang actionable.', 'Accept for publication.', 'accept', 84, '2026-02-13', NOW(), NOW()),
(17, 11, 111, 1, 'completed', 'Chatbot kesehatan yang bermanfaat. Domain knowledge yang baik. Accept.', 'Accept.', 'accept', 86, '2026-02-10', NOW(), NOW()),
(18, 11, 112, 1, 'completed', 'NLP implementation yang solid. Layak untuk dipresentasikan.', 'Accept.', 'accept', 85, '2026-02-11', NOW(), NOW()),
(19, 12, 113, 1, 'completed', 'Implementasi blockchain untuk halal supply chain sangat relevan. Paper excellent.', 'Strong accept.', 'accept', 92, '2026-02-08', NOW(), NOW()),
(20, 12, 114, 1, 'completed', 'Inovasi yang menarik dengan potensi impact besar. Well written.', 'Accept.', 'accept', 89, '2026-02-09', NOW(), NOW()),
(21, 13, 110, 1, 'completed', 'Akurasi 98% sangat impressive. Metodologi yang rigorous. Excellent paper.', 'Strong accept.', 'accept', 94, '2026-02-05', NOW(), NOW()),
(22, 13, 111, 1, 'completed', 'Computer vision implementation yang state-of-the-art. Accept.', 'Accept.', 'accept', 91, '2026-02-06', NOW(), NOW()),
(23, 14, 112, 1, 'completed', 'API Gateway design yang sangat berguna untuk industri fintech. Paper praktis dan akademis.', 'Accept.', 'accept', 88, '2026-02-03', NOW(), NOW()),
(24, 14, 113, 1, 'completed', 'Security aspects well covered. Scalability considerations excellent. Accept.', 'Accept.', 'accept', 86, '2026-02-04', NOW(), NOW()),
(25, 15, 114, 1, 'completed', 'Gamifikasi yang efektif meningkatkan motivasi belajar. Hasil eksperimen compelling.', 'Accept.', 'accept', 87, '2026-02-01', NOW(), NOW()),
(26, 15, 110, 1, 'completed', 'Platform pembelajaran pemrograman yang inovatif. Cocok untuk siswa SMA. Accept.', 'Accept.', 'accept', 85, '2026-02-02', NOW(), NOW());

-- ============================================
-- PAYMENTS
-- ============================================
INSERT INTO `payments` (`id`, `type`, `paper_id`, `user_id`, `registration_package_id`, `invoice_number`, `amount`, `description`, `status`, `payment_method`, `payment_proof`, `paid_at`, `verified_by`, `verified_at`, `created_at`, `updated_at`) VALUES
(1, 'paper', 11, 100, 2, 'INV-2026-0001', 1000000, 'Biaya registrasi pemakalah untuk paper: Natural Language Processing untuk Chatbot Layanan...', 'pending', NULL, NULL, NULL, NULL, NULL, NOW(), NOW()),
(2, 'paper', 12, 101, 2, 'INV-2026-0002', 1000000, 'Biaya registrasi pemakalah untuk paper: Blockchain untuk Transparansi Supply Chain Produk...', 'uploaded', 'bank_transfer', 'payments/dummy-proof-12.jpg', '2026-02-20', NULL, NULL, NOW(), NOW()),
(3, 'paper', 13, 102, 2, 'INV-2026-0003', 1000000, 'Biaya registrasi pemakalah untuk paper: Computer Vision untuk Sistem Parkir Cerdas', 'verified', 'bank_transfer', 'payments/dummy-proof-13.jpg', '2026-02-18', 1, '2026-02-19', NOW(), NOW()),
(4, 'paper', 14, 103, 2, 'INV-2026-0004', 1000000, 'Biaya registrasi pemakalah untuk paper: Pengembangan API Gateway dengan Rate Limiting...', 'verified', 'bank_transfer', 'payments/dummy-proof-14.jpg', '2026-02-15', 1, '2026-02-16', NOW(), NOW()),
(5, 'paper', 15, 104, 1, 'INV-2026-0005', 500000, 'Biaya registrasi pemakalah mahasiswa untuk paper: Gamifikasi dalam Pembelajaran...', 'verified', 'bank_transfer', 'payments/dummy-proof-15.jpg', '2026-02-10', 1, '2026-02-11', NOW(), NOW());

-- ============================================
-- NEWS / ANNOUNCEMENTS
-- ============================================
INSERT INTO `news` (`id`, `conference_id`, `title`, `slug`, `content`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pembukaan Pendaftaran SNTII 2026', 'pembukaan-pendaftaran-sntii-2026', '<p>Dengan bangga kami mengumumkan pembukaan pendaftaran Seminar Nasional Teknologi dan Inovasi Indonesia (SNTII) 2026.</p><p>Segera daftarkan paper Anda dan jadilah bagian dari forum ilmiah nasional terbesar di bidang teknologi!</p>', 1, '2026-01-15', NOW(), NOW()),
(2, 1, 'Keynote Speaker Terungkap!', 'keynote-speaker-terungkap', '<p>Kami dengan bangga mengumumkan keynote speaker untuk SNTII 2026. Para pakar terkemuka di bidang teknologi akan berbagi wawasan mereka.</p><p>Jangan lewatkan kesempatan emas untuk belajar dari yang terbaik!</p>', 1, '2026-02-01', NOW(), NOW()),
(3, 1, 'Early Bird Registration Diperpanjang', 'early-bird-registration-diperpanjang', '<p>Menanggapi permintaan banyak peserta, kami memperpanjang periode early bird registration hingga akhir bulan ini.</p><p>Manfaatkan kesempatan ini untuk mendapatkan harga spesial!</p>', 1, '2026-02-20', NOW(), NOW()),
(4, 1, 'Template Paper Tersedia', 'template-paper-tersedia', '<p>Template paper dalam format Word dan LaTeX sudah tersedia untuk diunduh.</p><p>Pastikan paper Anda mengikuti format yang ditentukan untuk memperlancar proses review.</p>', 1, '2026-03-01', NOW(), NOW());

INSERT INTO `announcements` (`id`, `title`, `content`, `type`, `is_active`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'Deadline Submission Diperpanjang', 'Deadline submission paper diperpanjang hingga tanggal 30 April 2026. Jangan lewatkan kesempatan ini!', 'info', 1, '2026-03-01', '2026-04-30', NOW(), NOW()),
(2, 'Registrasi Early Bird Dibuka', 'Daftar sekarang dan nikmati potongan harga 20% untuk registrasi early bird!', 'success', 1, '2026-03-01', '2026-05-20', NOW(), NOW());

-- ============================================
-- SLIDERS
-- ============================================
INSERT INTO `sliders` (`id`, `conference_id`, `title`, `subtitle`, `description`, `button_text`, `button_url`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'SNTII 2026', 'Seminar Nasional Teknologi dan Inovasi Indonesia', 'Transformasi Digital untuk Indonesia Maju', 'Daftar Sekarang', '/register', 1, 1, NOW(), NOW()),
(2, 1, 'Call for Papers', 'Submit Your Research', 'Deadline: 30 April 2026', 'Submit Paper', '/login', 2, 1, NOW(), NOW()),
(3, 1, 'Publikasi Jurnal', 'Kesempatan Publikasi di Jurnal Terakreditasi', 'Paper terbaik akan dipublikasikan di jurnal SINTA 1-3', 'Lihat Detail', '/journals', 3, 1, NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- SUMMARY
-- ============================================
-- Data yang diimport:
-- - 1 Conference (SNTII 2026)
-- - 10 Topics
-- - 5 Keynote Speakers
-- - 13 Committee Members
-- - 4 Registration Packages
-- - 8 Important Dates
-- - 4 Journal Publications
-- - 9 Supporters/Sponsors
-- - 16 Users (10 Authors, 5 Reviewers, 1 Editor)
-- - 15 Papers (berbagai status)
-- - 26 Reviews
-- - 5 Payments
-- - 4 News + 2 Announcements
-- - 3 Sliders
--
-- Login credentials:
-- Author: aditya.pratama@ui.ac.id / password
-- Reviewer: joko.susilo@reviewer.ac.id / password
-- Editor: olivia.editor@prosiding.test / password
-- ============================================
