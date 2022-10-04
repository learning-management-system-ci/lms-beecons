<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseNew extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Agile Execution, Effective Communication & Powerfull Delivery',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait: 
                1. Agile Execution (soft skills)
                2. Powerfull Delivery (soft skills)
                3. Effective Communication (soft skills)',
                'key_takeaways' => '- Peserta memahami dan mampu dalam menerapkan metode Agile Execution untuk menyelesaiakan setiap tahapan sprint pembelajaran dan implementasi proyek lintas disiplin serta mampu mengoptimalkan Trello sebagai tool pendukung
                - Peserta memahami dan mampu bagaimana caranya berkomunikasi dengan lebih cakap, baik terhadap rekan satu tim, tim lain, atasan, mentor maupun pihak eksternal lain demi memperlancar berjalannya pekerjaan
                - Peserta memahami dan mampu membuat presentasi dan paparan yang menarik, baik dalam hal self branding maupun presentasi atas pekerjaan yang dilakukan kepada pihak eksternal',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
            [
                'title' => 'Bim Introduction & Fundamental Knowlegde',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
                1. Introduction to BIM & Autodesk Revit        
                        - BIM & IPD
                        -  Autodesk Revit
                        - Starting & Opening a Project
                        - User Interface
                        - View Navigation
                        - Revit Elements
                        - Element Properties
                        - Choosing Elements
                2. Project Browser & Views        
                        - Project Browser
                        - View Display Settings
                        - View Templates & View Types
                        - Elevation, Section, and Callout
                        - 3D View
                3. Properties & Modifications        
                        - Work Plane
                        - Sketching
                        - Modification/ Contextual Ribbon
                        - Element Repetition
                        - Components Material
                        - Material Assets
                        - Dimensions
                        - Elements Relationship
                4. Starting a New Project        
                        - Preparing CAD Files
                        - Linking & Importing CAD Files
                        - Locaiton, Coordinates, & Orientation
                        - Level & Gird
                5. Site Modeling        
                        - Topography
                        - Building Pad
                        - Site & Parking Component',
                'key_takeaways' => '- Peserta mampu dan memahami kaidah dasar BIM
                - Peserta memahami tools dan kaidah dasar proyek BIM dan mampu mengimplementasikan dalam proyek
                - Peserta memahami cara memulai project BIM dengan beberapa metode dan mampu mengimplementasikannya
                - Peserta mampu membuat pemodelan site dan mengimplemantasikan dalam proyek',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
            [
                'title' => 'Visualization & Collaboration',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
                1. Project Visualization        
                        - Camera Snapshot
                        - Basic Rendering
                        - Cloud Rendering
                        - Walkthrough
                2. Project Collaboration        
                        - Building Modeling Collaboration
                        - Link Models
                        - Shared Coordinates
                        - Link Repetition
                        - Link & Group
                        - Copy & Monitor
                        - Model Coordination
                        - Worksharing',
                'key_takeaways' => '- Peserta mampu menerapkan prinsip kolaborasi baik kalaborasi lokal maupun cloud serta memvisualkan dengan baik serta mengimplemensasikannya
                - Peserta mampu berkolaborasi lintas disiplin untuk implementasi pekerjaan sesuai dengan sprint dan tatakala yang sudah ditentukan
                - Peserta mampu membuat visualisasi yang menarik kaitan proyek BIM yang sedang dikerjakan',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
            [
                'title' => 'Architecture BIM Engineer',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
                1. Architectural Elements        
                        - Architectural & Structural Elements
                        - Architectural Column
                        - Wall
                        - Floor, Ceiling, & Roof
                        - Material Layer
                        - Vertical & Horizontal Elements Connections
                        - Wall Profile
                        - Roof by Extrusion
                        - Element Accessories
                2. Openings & Furnishings        
                        - Door, Window, Furnishing
                        - Void Openings
                3. Curtain Wall        
                        - Drawing a Curtain Wall
                        - Sloped Glazing Roof
                4. Vertical Circulation        
                        - Stair
                        - Ramp
                        - Railing
                5. Architectural Spatial Elements        
                        - Room
                        - Area',
                'key_takeaways' => '- Peserta mampu dan memahami semua hal kaitan disiplin BIM Architecture
                - Peserta mampu dan memahami semua element, tool dan family dalam disipin Architecture dan menerapkan pada proyek yang sedang dikerjakan
                - Peserta mampu membuat pemodelan architecture dengan Level of Details yang baik',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
            [
                'title' => 'Structure BIM Engineer',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
            1. Structural Elements        
                    -  Model Reference, Component, View
                    -  Structural Column
                    -  Beam
                    -  Bracing
                    -  Structural Wall & Floor
                    -  Truss
                    -  Beam System
                    -  Foundation
            2. Concrete Rebar        
                    -  Rebar Setting & Cover
                    -  Rebar for Concrete Components
                    -  Area & Path Reinforcement
                    -  Fabric Reinforcement
            3. Steel Connection Detail        
                    -  Steel Connection
                    -  Custom Steel Connection
            4. Precast Concrete        
                    -  Precast Configuration
                    -  Segmentation
                    -  Reinforcement & Shop Drawing
            5. Analytical Model        
                    -  Analytical Model & Link
                    -  Loads & Boundary Conditions',
                'key_takeaways' => ' - Peserta mampu memodelkan elemen struktur dalam BIM termasuk parameter detailnya
                - Peserta mampu membuat pemodelan rebar pada struktur beton
                - Peserta mampu memahami dan menerapkan seputar Analytical Model untuk dilanjutkan pada tahapan analisa selanjutnya
                - Peserta mampu memodelkan struktur Precast Concrete dalam BIM
                - Peserta mampu membuat pemodelan Struktur Baja dan pembuatan sambungan baja termasuk detail lainnya',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
            [
                'title' => 'MEP System BIM Engineer',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
            1. MEP Systems & Elements        
                    MEP System Classifications
                    MEP Settings
                    MEP Components
                    Assign MEP Systems
            2. HVAC & Plumbing        
                    Fitting & Routing Preferences
                    Duct & Pipe
                    Flexible, Insulation, Accessories
                    Verification, Inspection, Report, Sizing
            3. Electrical & Lighting        
                    Wiring & Circuit Path
                    Panel Schedule
                    Cable Tray & Conduit
            4. MEP Spatial Elements        
                    Space
                    Zone
                    Heating/ Cooling Load Report
            5. MEP Fabrication        
                    Load Fabrication Service
                    Fabrication Parts
                    Design to Fabrication
                    Hanger',
                'key_takeaways' => '- Peserta mampu melakukan perancangan sistem dan elemen MEP dalam proyek BIM yang dikerjakan
                - Peserta mampu merancang dan memodelkan HVAC dan Plumbing untuk diterapkan pada proyek yang dikerjakan
                - Peserta mampu merancang dan memodelkan Electrical dan Lighting untuk diterapkan pada proyek yang dikerjakan
                - Peserta mampu memodelkan untuk MEP spacial element dan mengenerate heeting/cooling load reportnya
                - Peserta mampu membuat pemodelan MEP untuk jenis fabrication material',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
            [
                'title' => 'Working with BIM Family',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
            1. New Family        
                    - In-Place Component
                    - Loadable Component
                    - Family Template
                    - Family Editor
            2. 3D Geometry        
                    - 3D Geometry and Work Plane
                    - Solid Extrusion
                    - Solid Blend
                    - Solid Revolve
                    - Solid Sweep
                    - Solid Swept Blend
                    - Void Geometry
                    - Nested Family
                    - Connector
            3. Parametric        
                    - Family Category
                    - Family Types Parameter
                    - Geometry Properties
                    - Associate Family Parameter
                    - Dimension Parameter
                    - Shared Parameter
            4. 2D Family        
                    - Text Label
                    - Other 2D Elements',
                'key_takeaways' => '- Peserta mampu dan memahami seluk beluk kaitan BIM Family dan menerapkannya pada proyek
                - Peserta mampu mengelola BIM Family dengan baik sehingga proyek yang dikerjakan bisa lebih efisien
                - Peserta mampu membuat dan memodifikasi berbagai jenis BIM Family yang dibutuhkan untuk mendukung penerapakan pekerjaan',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
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
                'title' => 'Documentation Report',
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
            [
                'title' => 'BIM Project Implementation',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
                1. Conseptual Design
            2. Rendering & Visualisation Architecture
            3. Schematic Design
            4. Detailed Engineering Drawing
            5. Detailed Cost Estimate',
                'key_takeaways' => '- Peserta mampu menerapkan dalam proyek nyata untuk menghasilkan produk BIM pada tahapan pembuatan Conseptual Design
                - Peserta mampu menerapkan dalam proyek nyata untuk menghasilkan produk BIM pada tahapan pembuatan Rendering & Visualisation Architecture
                - Peserta mampu menerapkan dalam proyek nyata untuk menghasilkan produk BIM pada tahapan pembuatan Schematic Design
                - Peserta mampu menerapkan dalam proyek nyata untuk menghasilkan produk BIM pada tahapan pembuatan Detailed Engineering Drawing
                - Peserta mampu menerapkan dalam proyek nyata untuk menghasilkan produk BIM pada tahapan pembuatan Detailed Cost Estimate
            Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.
                
                ',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
            [
                'title' => 'Final Project Report',
                'service' => 'course',
                'description' => 'Pada pembelajaran individu, peserta akan mengikuti pembelajaran synchronous dan asynchronous, serta praktek implementasi partial sesuai materi. Pembelajaran yang dilakukan adalah pembelajaran terkait:
                1. Conseptual Design
            2. Rendering & Visualisation Architecture
            3. Schematic Design
            4. Detailed Engineering Drawing
            5. Detailed Cost Estimate',
                'key_takeaways' => '- Peserta mampu membuat laporan akhir Rendering & Visualisation Architecture sesuai dengan format yang sudah ditentukan
                - Peserta mampu membuat laporan akhir Schematic Design sesuai dengan format yang sudah ditentukan
                - Peserta mampu membuat laporan akhir Detailed Engineering Drawing sesuai dengan format yang sudah ditentukan
                - Peserta mampu membuat laporan akhir Detailed Cost Estimate sesuai dengan format yang sudah ditentukan',
                'suitable_for' => '',
                'old_price' => '0',
                'new_price' => '',
                'thumbnail' => 'course.jpg',
            ],
        ];

        $this->db->table('course')->insertBatch($data);
    }
}
