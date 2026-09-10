<?php

namespace Database\Seeders;

use App\Models\KpiQuestion;
use Illuminate\Database\Seeder;

class KpiQuestionSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            // Leader ke Tim
            ['category' => 'Keterbukaan Laporan', 'question_text' => 'Apakah anggota tim selalu jujur melaporkan kendala atau progres kerja, tanpa menyembunyikan masalah?', 'type' => 'leader_to_team'],
            ['category' => 'Responsibility', 'question_text' => 'Saat hasil kerjanya kurang maksimal, apakah dia mau mengevaluasi diri ketimbang mencari alasan atau menyalahkan orang lain?', 'type' => 'leader_to_team'],
            ['category' => 'Kepatuhan Aturan', 'question_text' => 'Apakah dia konsisten menjalankan instruksi dan SOP yang sudah Anda tetapkan?', 'type' => 'leader_to_team'],
            ['category' => 'Komitmen Target', 'question_text' => 'Apakah dia menunjukkan usaha terbaik untuk menyelesaikan target yang Anda berikan?', 'type' => 'leader_to_team'],
            ['category' => 'Ketepatan Waktu', 'question_text' => 'Apakah dia selalu hadir tepat waktu dan menyerahkan hasil kerja sesuai deadline yang Anda tentukan?', 'type' => 'leader_to_team'],
            ['category' => 'Inisiatif', 'question_text' => 'Apakah dia sering mengambil tindakan cepat untuk menyelesaikan masalah kecil tanpa perlu menunggu perintah Anda?', 'type' => 'leader_to_team'],
            ['category' => 'Ketahanan Tekanan', 'question_text' => 'Apakah dia tetap bisa bekerja dengan baik dan emosinya stabil saat beban kerja sedang tinggi?', 'type' => 'leader_to_team'],
            ['category' => 'Respon Instruksi', 'question_text' => 'Apakah dia menanggap tugas atau arahan baru dari Anda dengan sikap positif dan sigap?', 'type' => 'leader_to_team'],
            ['category' => 'Fleksibilitas', 'question_text' => 'Seberapa cepat dia menyesuaikan cara kerjanya saat Anda mengubah prioritas atau keputusan kerja?', 'type' => 'leader_to_team'],
            ['category' => 'Kekompakan Tim', 'question_text' => 'Apakah dia mau berbaur dan aktif membantu rekan sesama tim yang sedang kesulitan?', 'type' => 'leader_to_team'],
            ['category' => 'Komunikasi', 'question_text' => 'Apakah dia menyampaikan laporan atau ide kepada Anda dan rekan kerjanya secara sopan dan jelas?', 'type' => 'leader_to_team'],
            ['category' => 'Sikap Masukan', 'question_text' => 'Saat Anda memberikan teguran atau evaluasi, apakah dia mendengarkannya dengan terbuka dan langsung memperbaikinya?', 'type' => 'leader_to_team'],
            ['category' => 'Etika', 'question_text' => 'Apakah dia menghormati Anda sebagai atasan serta menghargai pendapat rekan kerjanya?', 'type' => 'leader_to_team'],
            ['category' => 'Suasana Kerja', 'question_text' => 'Apakah hadirnya dia di dalam tim memberikan energi positif (bukan memicu gosip atau konflik)?', 'type' => 'leader_to_team'],
            ['category' => 'Semangat Kerja', 'question_text' => 'Apakah dia menunjukkan keinginan untuk mempelajari skill baru demi meningkatkan kualitas kerjanya?', 'type' => 'leader_to_team'],
            ['category' => 'Fokus Solusi', 'question_text' => 'Saat melaporkan masalah kepada Anda, apakah dia juga membawa usulan jalan keluar?', 'type' => 'leader_to_team'],
            ['category' => 'Empati', 'question_text' => 'Apakah dia peduli dengan kelancaran kerja tim secara keseluruhan, bukan hanya memikirkan tugasnya sendiri?', 'type' => 'leader_to_team'],
            ['category' => 'Kualitas Layanan', 'question_text' => 'Apakah hasil pekerjaannya selalu memuaskan dan memudahkan divisi lain yang membutuhkan datanya?', 'type' => 'leader_to_team'],
            
            // Antar Leader
            ['category' => 'Kecepatan Respon', 'question_text' => 'Apakah dia merespon pesan, koordinasi, atau permintaan data dari divisi Anda dengan cepat dan kooperatif?', 'type' => 'leader_to_leader'],
            ['category' => 'Kolaborasi', 'question_text' => 'Seberapa mudah divisi Anda berkolaborasi dengan divisinya saat ada proyek atau tugas bersama?', 'type' => 'leader_to_leader'],
            ['category' => 'Sikap', 'question_text' => 'Apakah dia mau mendengarkan dan menghargai masukan atau kritik dari leader divisi lain?', 'type' => 'leader_to_leader'],
            ['category' => 'Orientasi Solusi', 'question_text' => 'Saat terjadi masalah antar-divisi, apakah dia fokus mencari jalan keluar bersama daripada saling menyalahkan?', 'type' => 'leader_to_leader'],
            ['category' => 'Transparansi', 'question_text' => 'Apakah dia jujur menyampaikan kondisi dan keterbatasan divisinya tanpa menutupi masalah yang bisa berdampak ke divisi lain?', 'type' => 'leader_to_leader'],
            ['category' => 'Pengendalian Tim', 'question_text' => 'Apakah dia mampu mengarahkan anggota timnya untuk bersikap sopan dan kooperatif saat berhubungan dengan divisi Anda?', 'type' => 'leader_to_leader'],
            ['category' => 'Integritas', 'question_text' => 'Apakah dia menunjukkan konsistensi antara ucapan dan tindakannya dalam keputusan-keputusan kerja?', 'type' => 'leader_to_leader'],
            ['category' => 'Respect', 'question_text' => 'Apakah dia selalu menghormati batasan, peran, dan wewenang kerja divisi Anda?', 'type' => 'leader_to_leader'],
            ['category' => 'Hubungan Baik', 'question_text' => 'Apakah dia aktif membangun hubungan kerja yang harmonis dan saling mendukung sesama leader?', 'type' => 'leader_to_leader'],
            ['category' => 'Kepedulian', 'question_text' => 'Apakah dia peka dan mempertimbangkan kapasitas kerja divisi lain sebelum memberikan permintaan atau tugas baru?', 'type' => 'leader_to_leader'],

            // Tim ke Leader
            ['category' => 'Kepemimpinan', 'question_text' => 'Apakah atasan selalu ada dan mudah dihubungi saat tim membutuhkan arahan atau bantuan kerja?', 'type' => 'team_to_leader'],
            ['category' => 'Pengendalian Emosi', 'question_text' => 'Apakah atasan tetap tenang, bersikap kepala dingin, dan tidak mudah marah saat situasi kerja sedang krisis?', 'type' => 'team_to_leader'],
            ['category' => 'Respect', 'question_text' => 'Apakah atasan selalu berbicara dengan bahasa yang sopan dan menghargai anggota tim tanpa merendahkan?', 'type' => 'team_to_leader'],
            ['category' => 'Keadilan', 'question_text' => 'Apakah atasan memperlakukan seluruh anggota tim secara adil dalam pembagian tugas maupun apresiasi?', 'type' => 'team_to_leader'],
            ['category' => 'Keterbukaan', 'question_text' => 'Apakah atasan mau mendengarkan masukan, ide, atau kritik dari bawahan dengan tangan terbuka?', 'type' => 'team_to_leader'],
            ['category' => 'Kejelasan Instruksi', 'question_text' => 'Apakah atasan memberikan instruksi kerja, target, dan deadline dengan jelas serta mudah dipahami?', 'type' => 'team_to_leader'],
            ['category' => 'Transparansi', 'question_text' => 'Apakah atasan selalu menyampaikan perubahan aturan, prioritas, atau keputusan manajemen yang berdampak pada tim?', 'type' => 'team_to_leader'],
            ['category' => 'Diskusi', 'question_text' => 'Apakah atasan menciptakan suasana yang nyaman sehingga tim tidak takut untuk bertanya atau menyampaikan kendala?', 'type' => 'team_to_leader'],
            ['category' => 'Apresiasi', 'question_text' => 'Apakah atasan rutin memberikan pujian atau ucapan terima kasih atas kerja keras dan pencapaian tim?', 'type' => 'team_to_leader'],
            ['category' => 'Perlindungan Tim', 'question_text' => 'Apakah atasan pasang badan dan membela timnya saat menghadapi tekanan atau masalah dari luar divisi?', 'type' => 'team_to_leader'],
            ['category' => 'Empati', 'question_text' => 'Apakah atasan peduli dan peka terhadap kondisi beban kerja serta kesejahteraan anggota timnya?', 'type' => 'team_to_leader'],
            ['category' => 'Solusi', 'question_text' => 'Saat tim mengalami kebingungan atau kebuntuan kerja, apakah atasan mampu memberikan jalan keluar yang jelas?', 'type' => 'team_to_leader'],
            ['category' => 'Konsistensi', 'question_text' => 'Apakah atasan menjalankan sendiri aturan dan komitmen yang sudah dibuatnya untuk tim?', 'type' => 'team_to_leader'],
            ['category' => 'Kedisiplinan', 'question_text' => 'Apakah atasan menjadi contoh yang baik dalam hal ketepatan waktu dan kedisiplinan kerja?', 'type' => 'team_to_leader'],
            ['category' => 'Tanggung Jawab', 'question_text' => 'Ketika terjadi kesalahan pada tim, apakah atasan mau bertanggung jawab dan tidak melemparkan kesalahan sepenuhnya kepada bawahan?', 'type' => 'team_to_leader'],
            ['category' => 'Integritas', 'question_text' => 'Apakah atasan bersikap jujur dan dapat dipercaya dalam setiap keputusan yang diambilnya?', 'type' => 'team_to_leader'],
            ['category' => 'Suasana Positif', 'question_text' => 'Apakah gaya kepemimpinan atasan membuat anggota tim merasa aman, nyaman, dan bersemangat untuk bekerja?', 'type' => 'team_to_leader'],
        ];

        foreach ($questions as $q) {
            KpiQuestion::create($q);
        }
    }
}
