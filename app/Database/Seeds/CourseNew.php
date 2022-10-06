<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseNew extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Rendering & Visualisation Architecture',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
            1. Material Setting
            2. Light Setting
            3. Rendering Result Analysis and How to solve
            4. Overall layout, Elevation and Plan
            5. 3D and Animation Rendering',
                'key_takeaways' => '- Peserta mampu menyajikan visualisasi arsitektur yang baik, mulai dari 3D sampai dengan animasi eksterior maupun interiornya
                - Peserta mampu menentukan seting untuk lighting object render
                - Peserta mampu membuat ilustrasi visual yang baik sebagai sarana delivery desain kepada klien pada pekerjaan',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
            [
                'title' => 'Structural Analysis using Robot Structural Analysis',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
            1. Structural modelling
            2. Load Combination
            3. Design of Foundation and Footing
            4. Design of Reinforced Concrete Beam
            5. Design of Reinforced Concrete Column
            6. Seismic Analysis
            7. Running Analysis and Reporting',
                'key_takeaways' => '- Peserta mampu membuat pemodelan struktur untuk diteruskan pada tahap analisa struktur
                - Peserta mampu mendefinisikan pembebanan dan kombinasi pembebanan struktur pada model yang akan di analisa
                - Peserta mampu memodelkan dan mendefinisikan komponen struktur dan assign parameternya yang meliputi struktur pondasi, balok, kolom dan lainnya
                - Peserta mampu membuat dan menerapkan seismic analysis pada pemodelan struktur yang akan di analisa lebih lanjut
                - Peserta mampu melakukan analisa struktur secara menyeluruh dan parsial serta menyajikan report hasil analisa dengan baik
            Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.
                ',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
            [
                'title' => 'HVAC & Electrical Load Analysis',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
            1. Add spaces and zones to the model
            2. Specify area and volume settings
            3. Specify building parameters for the analysis
            4. Specify building type settings
            5. Export the project information to create a gbXML (Green Building XML) file
            6. Specifying electrical load calculation settings
            7. Calculating building electrical loads
            8. Creating electrical panel schedules',
                'key_takeaways' => '- Peserta mampu membuat energy analysis atas model BIM yang dibuat
                - Peserta mampu melakukan export project information untuk membuat extention XML
                - Peserta mampu membuat building electrical load calculation dan membuat laporannya
                - Peserta mampu membuat electrical panel schedule pada model BIM yang dirancang',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
            [
                'title' => 'Detailed Cost Estimate',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
            1. Fundamental Cost Estimation
            2. Quantity Calculation
            3. Basic Pricing for Material and Labour
            4. Unit Price Analysis
            5. Reporting Terminology',
                'key_takeaways' => '- Peserta mampu dan memahami kadidah dasar pembuatan rencana anggaran biaya pekerjaan sesuai dengan ketentuan
                - Peserta mampu melakukan perhitungan quantity (volume pekerjaan) sesuai model yanga ada di BIM dengan fasilitas Take Off Schedule
                - Peserta mampu membuat analisa harga satuan pekerjaan, menentukan koefisien dan mendefinisikan material dan upah yang dipakai pada suatu pekerjaan
                - Peserta mampu mendefinisikan harga dasar material dan upah pekerja sesuai dengan lokasi pekerjaan yang spesifik dengan sumber yang terpercaya
            Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.
                ',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
            [
                'title' => 'Simulation And Clash Detection',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
            1. Append multi discipline BIM files to Navisworks
            2. Create Sets
            3. Create new Clash detective test and setting the clash detection rules
            4. Review clashes (appearance, view angle, etc.)
            5. Give comment and assign clash to a user
            6. Change clash status
            7. Navisworks Switchback (to Revit)
            8. Export clash report',
                'key_takeaways' => '- Peserta mampu melakukan tahapan clash detection multi disiplin untuk model BIM yang dibuat
                - Peserta mampu menggunakan software pendukung untuk clash detection dengan baik (navisworks)
                - Peserta mampu membuat dan mengorganisir clash report',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
            [
                'title' => 'Documentations Report',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
            1. Annotations, Symbols, and Details        
                    - Detail Drawing
                    - Detail Annotation
                    - Element Tag
                    - 3D Annotation
                    - Component Legend
                    - Drafting View
                    - Color Scheme
            2. Project Management        
                    - Schedule/ Quantities
                    - Project Phase
                    - Design Options
            3. Project Documentation        
                    - Sheet
                    - Printing
                    - Exporting to CAD & IFC',
                'key_takeaways' => '- Peserta mampu membuat documentation report yang baik atas model BIM yang sudah dibuat
                - Peserta mampu mendefinisikan Annotations, Symbols, and Details dengan baik sesuai standar
                - Peserta mampu menerapkan project management dalam pemodelan BIM, mulai Schedule sampai dengan Design Options
                - Peserta mampu membuat dan setting sheet untuk disiapkan dalam bentuk print out, termasuk ekport model dalam extension lain yang diperlukan
            Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.
                ',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
        ];

        $this->db->table('course')->insertBatch($data);
    }
}
