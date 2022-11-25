<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseNew extends Seeder
{
    public function run()
    {
        $data = [
                [
                        'title' => 'BIM Introduction & Fundamental Knowlegde',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                                - Components’ Material
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '720000',
                        'new_price' => '450000',
                        'thumbnail' => '1.jpg',
                        'author_id' => '5',
                ],
                [
                        'title' => 'Visualization & Collaboration',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Project Visualization        
                                - Camera Snapshot
                                - Walkthrough
                                - Basic Rendering
                                - Cloud Rendering
                        2. Project Collaboration        
                                - Building Modeling Collaboration
                                - Worksharing
                                - Shared Coordinates
                                - Link Models
                                - Link Repetition
                                - Link & Group
                                - Copy & Monitor
                                - Model Coordination',
                        'key_takeaways' => '- Peserta mampu menerapkan prinsip kolaborasi baik kalaborasi lokal maupun cloud serta memvisualkan dengan baik serta mengimplemensasikannya
                        - Peserta mampu berkolaborasi lintas disiplin untuk implementasi pekerjaan sesuai dengan sprint dan tatakala yang sudah ditentukan
                        - Peserta mampu membuat visualisasi yang menarik kaitan proyek BIM yang sedang dikerjakan',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '720000',
                        'new_price' => '450000',
                        'thumbnail' => '2.jpg',
                        'author_id' => '5',
                ],
                [
                        'title' => 'Architecture Design using Building Information Modeling',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Architectural Elements        
                                - Architectural & Structural Elements
                                - Architectural Column
                                - Element Accessories
                                - Material Layer
                                - Vertical & Horizontal Elements Connections
                                - Wall
                                - Wall Profile
                                - Floor, Ceiling, & Roof
                                - Roof by Extrusion
                        2. Openings & Furnishings        
                                - Door, Window, Furnishing
                                - Void Openings
                        3. Curtain Wall        
                                - Drawing a Curtain Wall
                                - Sloped Glazing Roof
                        4. Architectural Spatial Elements        
                                - Room
                                - Area
                        5. Vertical Circulation        
                                - Stair
                                - Ramp
                                - Railing',
                        'key_takeaways' => '- Peserta mampu dan memahami semua hal kaitan disiplin BIM Architecture
                        - Peserta mampu dan memahami semua element, tool dan family dalam disipin Architecture dan menerapkan pada proyek yang sedang dikerjakan
                        - Peserta mampu membuat pemodelan architecture dengan Level of Details yang baik',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1120000',
                        'new_price' => '700000',
                        'thumbnail' => '3.jpg',
                        'author_id' => '5',
                ],
                [
                        'title' => 'Structural Design using Building Information Modeling',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1200000',
                        'new_price' => '700000',
                        'thumbnail' => '4.jpg',
                        'author_id' => '5',
                ],
                [
                        'title' => 'Mechanical, Electrical and Plumbing (MEP) Design using Building Information Modeling',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. MEP Systems & Elements        
                        - MEP System Classifications
                        - MEP Settings
                        - MEP Components
                        - Assign MEP Systems
                        2. HVAC & Plumbing        
                        - Fitting & Routing Preferences
                        - Duct & Pipe
                        - Flexible, Insulation, Accessories
                        - Verification, Inspection, Report, Sizing
                        3. Electrical & Lighting        
                        - Wiring & Circuit Path
                        - Panel Schedule
                        - Cable Tray & Conduit
                        4. MEP Spatial Elements        
                        - Space
                        - Zone
                        - Heating/ Cooling Load Report
                        5. MEP Fabrication        
                        - Load Fabrication Service
                        - Fabrication Parts
                        - Design to Fabrication
                        - Hanger',
                        'key_takeaways' => '- Peserta mampu melakukan perancangan sistem dan elemen MEP dalam proyek BIM yang dikerjakan
                        - Peserta mampu merancang dan memodelkan HVAC dan Plumbing untuk diterapkan pada proyek yang dikerjakan
                        - Peserta mampu merancang dan memodelkan Electrical dan Lighting untuk diterapkan pada proyek yang dikerjakan
                        - Peserta mampu memodelkan untuk MEP spacial element dan mengenerate heeting/cooling load reportnya
                        - Peserta mampu membuat pemodelan MEP untuk jenis fabrication material',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1120000',
                        'new_price' => '700000',
                        'thumbnail' => '5.jpg',
                        'author_id' => '5',
                ],
                [
                        'title' => 'Working with BIM Family',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '640000',
                        'new_price' => '400000',
                        'thumbnail' => '6.jpg',
                        'author_id' => '5',
                ],
                [
                        'title' => 'BIM Fundamental Knowlegde',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                                - Components’ Material
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '630000',
                        'new_price' => '450000',
                        'thumbnail' => '7.jpg',
                        'author_id' => '2',
                ],
                [
                        'title' => 'Project Visualization & Collaboration',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Project Visualization        
                                - Camera Snapshot
                                - Walkthrough
                                - Basic Rendering
                                - Cloud Rendering
                        2. Project Collaboration        
                                - Building Modeling Collaboration
                                - Worksharing
                                - Shared Coordinates
                                - Link Models
                                - Link Repetition
                                - Link & Group
                                - Copy & Monitor
                                - Model Coordination',
                        'key_takeaways' => '- Peserta mampu menerapkan prinsip kolaborasi baik kalaborasi lokal maupun cloud serta memvisualkan dengan baik serta mengimplemensasikannya
                        - Peserta mampu berkolaborasi lintas disiplin untuk implementasi pekerjaan sesuai dengan sprint dan tatakala yang sudah ditentukan
                        - Peserta mampu membuat visualisasi yang menarik kaitan proyek BIM yang sedang dikerjakan',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '630000',
                        'new_price' => '450000',
                        'thumbnail' => '8.jpg',
                        'author_id' => '2',
                ],
                [
                        'title' => 'BIM Engineer for Architecture Discipline',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Architectural Elements        
                                - Architectural & Structural Elements
                                - Architectural Column
                                - Element Accessories
                                - Material Layer
                                - Vertical & Horizontal Elements Connections
                                - Wall
                                - Wall Profile
                                - Floor, Ceiling, & Roof
                                - Roof by Extrusion
                        2. Openings & Furnishings        
                                - Door, Window, Furnishing
                                - Void Openings
                        3. Curtain Wall        
                                - Drawing a Curtain Wall
                                - Sloped Glazing Roof
                        4. Architectural Spatial Elements        
                                - Room
                                - Area
                        5. Vertical Circulation        
                                - Stair
                                - Ramp
                                - Railing',
                        'key_takeaways' => '- Peserta mampu dan memahami semua hal kaitan disiplin BIM Architecture
                        - Peserta mampu dan memahami semua element, tool dan family dalam disipin Architecture dan menerapkan pada proyek yang sedang dikerjakan
                        - Peserta mampu membuat pemodelan architecture dengan Level of Details yang baik',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1040000',
                        'new_price' => '800000',
                        'thumbnail' => '9.jpg',
                        'author_id' => '2',
                ],
                [
                        'title' => 'BIM Engineer for Structure Discipline',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1040000',
                        'new_price' => '800000',
                        'thumbnail' => '10.jpg',
                        'author_id' => '2',
                ],
                [
                        'title' => 'BIM Engineer for MEP Discipline',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. MEP Systems & Elements        
                        - MEP System Classifications
                        - MEP Settings
                        - MEP Components
                        - Assign MEP Systems
                        2. HVAC & Plumbing        
                        - Fitting & Routing Preferences
                        - Duct & Pipe
                        - Flexible, Insulation, Accessories
                        - Verification, Inspection, Report, Sizing
                        3. Electrical & Lighting        
                        - Wiring & Circuit Path
                        - Panel Schedule
                        - Cable Tray & Conduit
                        4. MEP Spatial Elements        
                        - Space
                        - Zone
                        - Heating/ Cooling Load Report
                        5. MEP Fabrication        
                        - Load Fabrication Service
                        - Fabrication Parts
                        - Design to Fabrication
                        - Hanger',
                        'key_takeaways' => '- Peserta mampu melakukan perancangan sistem dan elemen MEP dalam proyek BIM yang dikerjakan
                        - Peserta mampu merancang dan memodelkan HVAC dan Plumbing untuk diterapkan pada proyek yang dikerjakan
                        - Peserta mampu merancang dan memodelkan Electrical dan Lighting untuk diterapkan pada proyek yang dikerjakan
                        - Peserta mampu memodelkan untuk MEP spacial element dan mengenerate heeting/cooling load reportnya
                        - Peserta mampu membuat pemodelan MEP untuk jenis fabrication material',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1040000',
                        'new_price' => '800000',
                        'thumbnail' => '11.jpg',
                        'author_id' => '2',
                ],
                [
                        'title' => 'Working with BIM Family',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '840000',
                        'new_price' => '600000',
                        'thumbnail' => '12.jpg',
                        'author_id' => '2',
                ],
                [
                        'title' => 'Knowledge and Overview Bulding Information Modeling',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                                - Components’ Material
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '700000',
                        'new_price' => '500000',
                        'thumbnail' => '13.jpg',
                        'author_id' => '4',
                ],
                [
                        'title' => 'Collaboration and Basic Visualization for BIM Project',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Project Visualization        
                                - Camera Snapshot
                                - Walkthrough
                                - Basic Rendering
                                - Cloud Rendering
                        2. Project Collaboration        
                                - Building Modeling Collaboration
                                - Worksharing
                                - Shared Coordinates
                                - Link Models
                                - Link Repetition
                                - Link & Group
                                - Copy & Monitor
                                - Model Coordination',
                        'key_takeaways' => '- Peserta mampu menerapkan prinsip kolaborasi baik kalaborasi lokal maupun cloud serta memvisualkan dengan baik serta mengimplemensasikannya
                        - Peserta mampu berkolaborasi lintas disiplin untuk implementasi pekerjaan sesuai dengan sprint dan tatakala yang sudah ditentukan
                        - Peserta mampu membuat visualisasi yang menarik kaitan proyek BIM yang sedang dikerjakan',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '700000',
                        'new_price' => '500000',
                        'thumbnail' => '14.jpg',
                        'author_id' => '4',
                ],
                [
                        'title' => 'Architecture Design using Building Information Modeling',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Architectural Elements        
                                - Architectural & Structural Elements
                                - Architectural Column
                                - Element Accessories
                                - Material Layer
                                - Vertical & Horizontal Elements Connections
                                - Wall
                                - Wall Profile
                                - Floor, Ceiling, & Roof
                                - Roof by Extrusion
                        2. Openings & Furnishings        
                                - Door, Window, Furnishing
                                - Void Openings
                        3. Curtain Wall        
                                - Drawing a Curtain Wall
                                - Sloped Glazing Roof
                        4. Architectural Spatial Elements        
                                - Room
                                - Area
                        5. Vertical Circulation        
                                - Stair
                                - Ramp
                                - Railing',
                        'key_takeaways' => '- Peserta mampu dan memahami semua hal kaitan disiplin BIM Architecture
                        - Peserta mampu dan memahami semua element, tool dan family dalam disipin Architecture dan menerapkan pada proyek yang sedang dikerjakan
                        - Peserta mampu membuat pemodelan architecture dengan Level of Details yang baik',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '975000',
                        'new_price' => '750000',
                        'thumbnail' => '15.jpg',
                        'author_id' => '4',
                ],
                [
                        'title' => 'Structural Design using Building Information Modeling',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '975000',
                        'new_price' => '750000',
                        'thumbnail' => '16.jpg',
                        'author_id' => '4',
                ],
                [
                        'title' => 'Mechanical, Electrical and Plumbing (MEP) Design using Building Information Modeling',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. MEP Systems & Elements        
                        - MEP System Classifications
                        - MEP Settings
                        - MEP Components
                        - Assign MEP Systems
                        2. HVAC & Plumbing        
                        - Fitting & Routing Preferences
                        - Duct & Pipe
                        - Flexible, Insulation, Accessories
                        - Verification, Inspection, Report, Sizing
                        3. Electrical & Lighting        
                        - Wiring & Circuit Path
                        - Panel Schedule
                        - Cable Tray & Conduit
                        4. MEP Spatial Elements        
                        - Space
                        - Zone
                        - Heating/ Cooling Load Report
                        5. MEP Fabrication        
                        - Load Fabrication Service
                        - Fabrication Parts
                        - Design to Fabrication
                        - Hanger',
                        'key_takeaways' => '- Peserta mampu melakukan perancangan sistem dan elemen MEP dalam proyek BIM yang dikerjakan
                        - Peserta mampu merancang dan memodelkan HVAC dan Plumbing untuk diterapkan pada proyek yang dikerjakan
                        - Peserta mampu merancang dan memodelkan Electrical dan Lighting untuk diterapkan pada proyek yang dikerjakan
                        - Peserta mampu memodelkan untuk MEP spacial element dan mengenerate heeting/cooling load reportnya
                        - Peserta mampu membuat pemodelan MEP untuk jenis fabrication material',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '975000',
                        'new_price' => '750000',
                        'thumbnail' => '17.jpg',
                        'author_id' => '4',
                ],
                [
                        'title' => 'Working with BIM Family',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '770000',
                        'new_price' => '550000',
                        'thumbnail' => '18.jpg',
                        'author_id' => '4',
                ],
                [
                        'title' => 'BIM Introduction & Fundamental Knowlegde',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                                - Components’ Material
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '640000',
                        'new_price' => '400000',
                        'thumbnail' => '19.jpg',
                        'author_id' => '3',
                ],
                [
                        'title' => 'Visualization & Collaboration',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Project Visualization        
                                - Camera Snapshot
                                - Walkthrough
                                - Basic Rendering
                                - Cloud Rendering
                        2. Project Collaboration        
                                - Building Modeling Collaboration
                                - Worksharing
                                - Shared Coordinates
                                - Link Models
                                - Link Repetition
                                - Link & Group
                                - Copy & Monitor
                                - Model Coordination',
                        'key_takeaways' => '- Peserta mampu menerapkan prinsip kolaborasi baik kalaborasi lokal maupun cloud serta memvisualkan dengan baik serta mengimplemensasikannya
                        - Peserta mampu berkolaborasi lintas disiplin untuk implementasi pekerjaan sesuai dengan sprint dan tatakala yang sudah ditentukan
                        - Peserta mampu membuat visualisasi yang menarik kaitan proyek BIM yang sedang dikerjakan',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '640000',
                        'new_price' => '400000',
                        'thumbnail' => '20.jpg',
                        'author_id' => '3',
                ],
                [
                        'title' => 'Architecture BIM Engineer',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Architectural Elements        
                                - Architectural & Structural Elements
                                - Architectural Column
                                - Element Accessories
                                - Material Layer
                                - Vertical & Horizontal Elements Connections
                                - Wall
                                - Wall Profile
                                - Floor, Ceiling, & Roof
                                - Roof by Extrusion
                        2. Openings & Furnishings        
                                - Door, Window, Furnishing
                                - Void Openings
                        3. Curtain Wall        
                                - Drawing a Curtain Wall
                                - Sloped Glazing Roof
                        4. Architectural Spatial Elements        
                                - Room
                                - Area
                        5. Vertical Circulation        
                                - Stair
                                - Ramp
                                - Railing',
                        'key_takeaways' => '- Peserta mampu dan memahami semua hal kaitan disiplin BIM Architecture
                        - Peserta mampu dan memahami semua element, tool dan family dalam disipin Architecture dan menerapkan pada proyek yang sedang dikerjakan
                        - Peserta mampu membuat pemodelan architecture dengan Level of Details yang baik',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1200000',
                        'new_price' => '750000',
                        'thumbnail' => '21.jpg',
                        'author_id' => '3',
                ],
                [
                        'title' => 'Structure BIM Engineer',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1200000',
                        'new_price' => '750000',
                        'thumbnail' => '22.jpg',
                        'author_id' => '3',
                ],
                [
                        'title' => 'MEP System BIM Engineer',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. MEP Systems & Elements        
                        - MEP System Classifications
                        - MEP Settings
                        - MEP Components
                        - Assign MEP Systems
                        2. HVAC & Plumbing        
                        - Fitting & Routing Preferences
                        - Duct & Pipe
                        - Flexible, Insulation, Accessories
                        - Verification, Inspection, Report, Sizing
                        3. Electrical & Lighting        
                        - Wiring & Circuit Path
                        - Panel Schedule
                        - Cable Tray & Conduit
                        4. MEP Spatial Elements        
                        - Space
                        - Zone
                        - Heating/ Cooling Load Report
                        5. MEP Fabrication        
                        - Load Fabrication Service
                        - Fabrication Parts
                        - Design to Fabrication
                        - Hanger',
                        'key_takeaways' => '- Peserta mampu melakukan perancangan sistem dan elemen MEP dalam proyek BIM yang dikerjakan
                        - Peserta mampu merancang dan memodelkan HVAC dan Plumbing untuk diterapkan pada proyek yang dikerjakan
                        - Peserta mampu merancang dan memodelkan Electrical dan Lighting untuk diterapkan pada proyek yang dikerjakan
                        - Peserta mampu memodelkan untuk MEP spacial element dan mengenerate heeting/cooling load reportnya
                        - Peserta mampu membuat pemodelan MEP untuk jenis fabrication material',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1200000',
                        'new_price' => '750000',
                        'thumbnail' => '23.jpg',
                        'author_id' => '3',
                ],
                [
                        'title' => 'Working with BIM Family',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '800000',
                        'new_price' => '500000',
                        'thumbnail' => '24.jpg',
                        'author_id' => '3',
                ],
                [
                        'title' => 'Fundamental Bulding Information Modeling',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                                - Components’ Material
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '720000',
                        'new_price' => '450000',
                        'thumbnail' => '25.jpg',
                        'author_id' => '1',
                ],
                [
                        'title' => 'Realtime Collaboration for BIM Project',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Project Visualization        
                                - Camera Snapshot
                                - Walkthrough
                                - Basic Rendering
                                - Cloud Rendering
                        2. Project Collaboration        
                                - Building Modeling Collaboration
                                - Worksharing
                                - Shared Coordinates
                                - Link Models
                                - Link Repetition
                                - Link & Group
                                - Copy & Monitor
                                - Model Coordination',
                        'key_takeaways' => '- Peserta mampu menerapkan prinsip kolaborasi baik kalaborasi lokal maupun cloud serta memvisualkan dengan baik serta mengimplemensasikannya
                        - Peserta mampu berkolaborasi lintas disiplin untuk implementasi pekerjaan sesuai dengan sprint dan tatakala yang sudah ditentukan
                        - Peserta mampu membuat visualisasi yang menarik kaitan proyek BIM yang sedang dikerjakan',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '720000',
                        'new_price' => '450000',
                        'thumbnail' => '26.jpg',
                        'author_id' => '1',
                ],
                [
                        'title' => 'Building Information Modeling for Architect',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Architectural Elements        
                                - Architectural & Structural Elements
                                - Architectural Column
                                - Element Accessories
                                - Material Layer
                                - Vertical & Horizontal Elements Connections
                                - Wall
                                - Wall Profile
                                - Floor, Ceiling, & Roof
                                - Roof by Extrusion
                        2. Openings & Furnishings        
                                - Door, Window, Furnishing
                                - Void Openings
                        3. Curtain Wall        
                                - Drawing a Curtain Wall
                                - Sloped Glazing Roof
                        4. Architectural Spatial Elements        
                                - Room
                                - Area
                        5. Vertical Circulation        
                                - Stair
                                - Ramp
                                - Railing',
                        'key_takeaways' => '- Peserta mampu dan memahami semua hal kaitan disiplin BIM Architecture
                        - Peserta mampu dan memahami semua element, tool dan family dalam disipin Architecture dan menerapkan pada proyek yang sedang dikerjakan
                        - Peserta mampu membuat pemodelan architecture dengan Level of Details yang baik',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1280000',
                        'new_price' => '800000',
                        'thumbnail' => '27.jpg',
                        'author_id' => '1',
                ],
                [
                        'title' => 'Building Information Modeling for Civil Engineering',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1200000',
                        'new_price' => '750000',
                        'thumbnail' => '28.jpg',
                        'author_id' => '1',
                ],
                [
                        'title' => 'Building Information Modeling for Mechanical, Electrical and Plumbing (MEP)',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. MEP Systems & Elements        
                        - MEP System Classifications
                        - MEP Settings
                        - MEP Components
                        - Assign MEP Systems
                        2. HVAC & Plumbing        
                        - Fitting & Routing Preferences
                        - Duct & Pipe
                        - Flexible, Insulation, Accessories
                        - Verification, Inspection, Report, Sizing
                        3. Electrical & Lighting        
                        - Wiring & Circuit Path
                        - Panel Schedule
                        - Cable Tray & Conduit
                        4. MEP Spatial Elements        
                        - Space
                        - Zone
                        - Heating/ Cooling Load Report
                        5. MEP Fabrication        
                        - Load Fabrication Service
                        - Fabrication Parts
                        - Design to Fabrication
                        - Hanger',
                        'key_takeaways' => '- Peserta mampu melakukan perancangan sistem dan elemen MEP dalam proyek BIM yang dikerjakan
                        - Peserta mampu merancang dan memodelkan HVAC dan Plumbing untuk diterapkan pada proyek yang dikerjakan
                        - Peserta mampu merancang dan memodelkan Electrical dan Lighting untuk diterapkan pada proyek yang dikerjakan
                        - Peserta mampu memodelkan untuk MEP spacial element dan mengenerate heeting/cooling load reportnya
                        - Peserta mampu membuat pemodelan MEP untuk jenis fabrication material',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1280000',
                        'new_price' => '800000',
                        'thumbnail' => '29.jpg',
                        'author_id' => '1',
                ],
                [
                        'title' => 'Optimizing BIM family',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '960000',
                        'new_price' => '600000',
                        'thumbnail' => '30.jpg',
                        'author_id' => '1',
                ],




                [
                        'title' => 'Rendering & Visualisation Architecture',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
                            1. Material Setting
                            2. Light Setting
                            3. Rendering Result Analysis and How to solve
                            4. Overall layout, Elevation and Plan
                            5. finalization of 3D and Animation Rendering',
                        'key_takeaways' => '- Peserta mampu menyajikan visualisasi arsitektur yang baik, mulai dari 3D sampai dengan animasi eksterior maupun interiornya
                        - Peserta mampu menentukan seting untuk lighting object render
                        - Peserta mampu membuat ilustrasi visual yang baik sebagai sarana delivery desain kepada klien pada pekerjaan',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '720000',
                        'new_price' => '450000',
                        'thumbnail' => '31.jpg',
                        'author_id' => '5',
                ],
                [
                    'title' => '3D and Animation Architecture Visualisation',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Material Setting
                        2. Light Setting
                        3. Rendering Result Analysis and How to solve
                        4. Overall layout, Elevation and Plan
                        5. finalization of 3D and Animation Rendering',
                    'key_takeaways' => '- Peserta mampu menyajikan visualisasi arsitektur yang baik, mulai dari 3D sampai dengan animasi eksterior maupun interiornya
                    - Peserta mampu menentukan seting untuk lighting object render
                    - Peserta mampu membuat ilustrasi visual yang baik sebagai sarana delivery desain kepada klien pada pekerjaan',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '700000',
                    'new_price' => '500000',
                    'thumbnail' => '32.jpg',
                    'author_id' => '2',
                ],
                [
                    'title' => '3D Visualization and Animation for Architecture Project',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Material Setting
                        2. Light Setting
                        3. Rendering Result Analysis and How to solve
                        4. Overall layout, Elevation and Plan
                        5. finalization of 3D and Animation Rendering',
                    'key_takeaways' => '- Peserta mampu menyajikan visualisasi arsitektur yang baik, mulai dari 3D sampai dengan animasi eksterior maupun interiornya
                    - Peserta mampu menentukan seting untuk lighting object render
                    - Peserta mampu membuat ilustrasi visual yang baik sebagai sarana delivery desain kepada klien pada pekerjaan',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '560000',
                    'new_price' => '400000',
                    'thumbnail' => '33.jpg',
                    'author_id' => '4',
                ],
                [
                    'title' => 'Rendering & Visualisation Architecture',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Material Setting
                        2. Light Setting
                        3. Rendering Result Analysis and How to solve
                        4. Overall layout, Elevation and Plan
                        5. finalization of 3D and Animation Rendering',
                    'key_takeaways' => '- Peserta mampu menyajikan visualisasi arsitektur yang baik, mulai dari 3D sampai dengan animasi eksterior maupun interiornya
                    - Peserta mampu menentukan seting untuk lighting object render
                    - Peserta mampu membuat ilustrasi visual yang baik sebagai sarana delivery desain kepada klien pada pekerjaan',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '640000',
                    'new_price' => '400000',
                    'thumbnail' => '34.jpg',
                    'author_id' => '3',
                ],
                [
                    'title' => '3D and Animation Architecture Visualization',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Material Setting
                        2. Light Setting
                        3. Rendering Result Analysis and How to solve
                        4. Overall layout, Elevation and Plan
                        5. finalization of 3D and Animation Rendering',
                    'key_takeaways' => '- Peserta mampu menyajikan visualisasi arsitektur yang baik, mulai dari 3D sampai dengan animasi eksterior maupun interiornya
                    - Peserta mampu menentukan seting untuk lighting object render
                    - Peserta mampu membuat ilustrasi visual yang baik sebagai sarana delivery desain kepada klien pada pekerjaan',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '800000',
                    'new_price' => '500000',
                    'thumbnail' => '35.jpg',
                    'author_id' => '1',
                ],

                [
                        'title' => 'Structural Analysis using Robot Structural Analysis',
                        'service' => 'course',
                        'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '720000',
                        'new_price' => '450000',
                        'thumbnail' => '36.jpg',
                        'author_id' => '5'
                ],
                [
                    'title' => 'Building Structural Analysis',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '700000',
                    'new_price' => '500000',
                    'thumbnail' => '37.jpg',
                    'author_id' => '2'
                ],
                [
                    'title' => 'Building Structural Analysis using Robot Structural Analysis',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '560000',
                    'new_price' => '400000',
                    'thumbnail' => '38.jpg',
                    'author_id' => '4'
                ],
                [
                    'title' => 'Structural Analysis using Robot Structural Analysis',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '640000',
                    'new_price' => '400000',
                    'thumbnail' => '39.jpg',
                    'author_id' => '3'
                ],
                [
                    'title' => 'Building Structural Analysis',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '800000',
                    'new_price' => '500000',
                    'thumbnail' => '40.jpg',
                    'author_id' => '1'
                ],

                [
                    'title' => 'HVAC & Electrical Load Analysis',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '720000',
                    'new_price' => '450000',
                    'thumbnail' => '41.jpg',
                    'author_id' => '5'
                ],
                [
                    'title' => 'Electrical Load & HVAC Analysis',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '700000',
                    'new_price' => '500000',
                    'thumbnail' => '42.jpg',
                    'author_id' => '2'
                ],
                [
                    'title' => 'Electrical Load & HVAC Analysis',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '560000',
                    'new_price' => '400000',
                    'thumbnail' => '43.jpg',
                    'author_id' => '4'
                ],
                [
                    'title' => 'HVAC & Electrical Load Analysis',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '640000',
                    'new_price' => '400000',
                    'thumbnail' => '44.jpg',
                    'author_id' => '3'
                ],
                [
                    'title' => 'HVAC & Electrical Load Analysis',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '800000',
                    'new_price' => '500000',
                    'thumbnail' => '45.jpg',
                    'author_id' => '1'
                ],

                [
                    'title' => 'Detailed Cost Estimate',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Fundamental Cost Estimation
                        2. Quantity Calculation
                        3. Basic Pricing for Material and Labour
                        4. Unit Price Analysis
                        5. Reporting Terminology',
                    'key_takeaways' => '- Peserta mampu dan memahami kadidah dasar pembuatan rencana anggaran biaya pekerjaan sesuai dengan ketentuan
                        - Peserta mampu melakukan perhitungan quantity (volume pekerjaan) sesuai model yanga ada di BIM dengan fasilitas Take Off Schedule
                        - Peserta mampu membuat analisa harga satuan pekerjaan, menentukan koefisien dan mendefinisikan material dan upah yang dipakai pada suatu pekerjaan
                        - Peserta mampu mendefinisikan harga dasar material dan upah pekerja sesuai dengan lokasi pekerjaan yang spesifik dengan sumber yang terpercaya
                        Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '1040000',
                    'new_price' => '650000',
                    'thumbnail' => '46.jpg',
                    'author_id' => '5'
                ],
                [
                    'title' => 'Cost Estimate for Construction',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Fundamental Cost Estimation
                        2. Quantity Calculation
                        3. Basic Pricing for Material and Labour
                        4. Unit Price Analysis
                        5. Reporting Terminology',
                    'key_takeaways' => '- Peserta mampu dan memahami kadidah dasar pembuatan rencana anggaran biaya pekerjaan sesuai dengan ketentuan
                        - Peserta mampu melakukan perhitungan quantity (volume pekerjaan) sesuai model yanga ada di BIM dengan fasilitas Take Off Schedule
                        - Peserta mampu membuat analisa harga satuan pekerjaan, menentukan koefisien dan mendefinisikan material dan upah yang dipakai pada suatu pekerjaan
                        - Peserta mampu mendefinisikan harga dasar material dan upah pekerja sesuai dengan lokasi pekerjaan yang spesifik dengan sumber yang terpercaya
                        Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '980000',
                    'new_price' => '700000',
                    'thumbnail' => '47.jpg',
                    'author_id' => '2'
                ],
                [
                    'title' => 'Rencana Anggaran Biaya (RAB) untuk proyek Konstruksi',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Fundamental Cost Estimation
                        2. Quantity Calculation
                        3. Basic Pricing for Material and Labour
                        4. Unit Price Analysis
                        5. Reporting Terminology',
                    'key_takeaways' => '- Peserta mampu dan memahami kadidah dasar pembuatan rencana anggaran biaya pekerjaan sesuai dengan ketentuan
                        - Peserta mampu melakukan perhitungan quantity (volume pekerjaan) sesuai model yanga ada di BIM dengan fasilitas Take Off Schedule
                        - Peserta mampu membuat analisa harga satuan pekerjaan, menentukan koefisien dan mendefinisikan material dan upah yang dipakai pada suatu pekerjaan
                        - Peserta mampu mendefinisikan harga dasar material dan upah pekerja sesuai dengan lokasi pekerjaan yang spesifik dengan sumber yang terpercaya
                        Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '840000',
                    'new_price' => '600000',
                    'thumbnail' => '48.jpg',
                    'author_id' => '4'
                ],
                [
                    'title' => 'Detailed Cost Estimate',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Fundamental Cost Estimation
                        2. Quantity Calculation
                        3. Basic Pricing for Material and Labour
                        4. Unit Price Analysis
                        5. Reporting Terminology',
                    'key_takeaways' => '- Peserta mampu dan memahami kadidah dasar pembuatan rencana anggaran biaya pekerjaan sesuai dengan ketentuan
                        - Peserta mampu melakukan perhitungan quantity (volume pekerjaan) sesuai model yanga ada di BIM dengan fasilitas Take Off Schedule
                        - Peserta mampu membuat analisa harga satuan pekerjaan, menentukan koefisien dan mendefinisikan material dan upah yang dipakai pada suatu pekerjaan
                        - Peserta mampu mendefinisikan harga dasar material dan upah pekerja sesuai dengan lokasi pekerjaan yang spesifik dengan sumber yang terpercaya
                        Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '960000',
                    'new_price' => '600000',
                    'thumbnail' => '49.jpg',
                    'author_id' => '3'
                ],
                [
                    'title' => 'Detiled Cost Estimate for Construction',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
                        1. Fundamental Cost Estimation
                        2. Quantity Calculation
                        3. Basic Pricing for Material and Labour
                        4. Unit Price Analysis
                        5. Reporting Terminology',
                    'key_takeaways' => '- Peserta mampu dan memahami kadidah dasar pembuatan rencana anggaran biaya pekerjaan sesuai dengan ketentuan
                        - Peserta mampu melakukan perhitungan quantity (volume pekerjaan) sesuai model yanga ada di BIM dengan fasilitas Take Off Schedule
                        - Peserta mampu membuat analisa harga satuan pekerjaan, menentukan koefisien dan mendefinisikan material dan upah yang dipakai pada suatu pekerjaan
                        - Peserta mampu mendefinisikan harga dasar material dan upah pekerja sesuai dengan lokasi pekerjaan yang spesifik dengan sumber yang terpercaya
                        Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '640000',
                    'new_price' => '400000',
                    'thumbnail' => '50.jpg',
                    'author_id' => '1'
                ],

                [
                    'title' => 'Simulation And Clash Detection',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '800000',
                    'new_price' => '500000',
                    'thumbnail' => '51.jpg',
                    'author_id' => '5'
                ],
                [
                    'title' => 'Multi Discipline Clash Detection',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '840000',
                    'new_price' => '600000',
                    'thumbnail' => '52.jpg',
                    'author_id' => '2'
                ],
                [
                    'title' => 'Clash Detection and Simulation',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '700000',
                    'new_price' => '500000',
                    'thumbnail' => '53.jpg',
                    'author_id' => '4'
                ],
                [
                    'title' => 'Simulation And Clash Detection',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '800000',
                    'new_price' => '500000',
                    'thumbnail' => '54.jpg',
                    'author_id' => '3'
                ],
                [
                    'title' => 'Clash Detection for Multi Discipline',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '960000',
                    'new_price' => '600000',
                    'thumbnail' => '55.jpg',
                    'author_id' => '1'
                ],

                [
                    'title' => 'Documentations Report',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '720000',
                    'new_price' => '450000',
                    'thumbnail' => '56.jpg',
                    'author_id' => '5'
                ],
                [
                    'title' => 'Working with Documentations Report',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '840000',
                    'new_price' => '600000',
                    'thumbnail' => '57.jpg',
                    'author_id' => '2'
                ],
                [
                    'title' => 'Arrange Documentations Report',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '630000',
                    'new_price' => '450000',
                    'thumbnail' => '58.jpg',
                    'author_id' => '4'
                ],
                [
                    'title' => 'Documentations Report',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '800000',
                    'new_price' => '500000',
                    'thumbnail' => '59.jpg',
                    'author_id' => '3'
                ],
                [
                    'title' => 'Arrange Documentations Report',
                    'service' => 'course',
                    'description' => 'Detail materi pada pembelajaran ini meliputi :
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
                        Untuk mengaktifkan dukungan pembaca layar, tekan Ctrl+Alt+Z. Untuk mempelajari pintasan keyboard, tekan Ctrl+garis miring.',
                    'suitable_for' => 'Mahasiswa atau umum',
                    'old_price' => '800000',
                    'new_price' => '500000',
                    'thumbnail' => '60.jpg',
                    'author_id' => '1'
                ],


                [
                        'title' => 'Agile Execution',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1500000',
                        'new_price' => '1500000',
                        'thumbnail' => '61.jpg',
                        'author_id' => '5'
                ],
                [
                        'title' => 'Agile Execution',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1250000',
                        'new_price' => '1250000',
                        'thumbnail' => '62.jpg',
                        'author_id' => '2'
                ],
                [
                        'title' => 'Agile Execution',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1000000',
                        'new_price' => '1000000',
                        'thumbnail' => '63.jpg',
                        'author_id' => '4'
                ],
                [
                        'title' => 'Agile Execution',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1100000',
                        'new_price' => '1100000',
                        'thumbnail' => '64.jpg',
                        'author_id' => '3'
                ],
                [
                        'title' => 'Agile Execution',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1200000',
                        'new_price' => '1200000',
                        'thumbnail' => '65.jpg',
                        'author_id' => '1'
                ],


                




                [
                        'title' => 'Powerful Delivery',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1500000',
                        'new_price' => '1500000',
                        'thumbnail' => '66.jpg',
                        'author_id' => '5'
                ],
                [
                        'title' => 'Powerful Delivery',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1250000',
                        'new_price' => '1250000',
                        'thumbnail' => '67.jpg',
                        'author_id' => '2'
                ],
                [
                        'title' => 'Powerful Delivery',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1000000',
                        'new_price' => '1000000',
                        'thumbnail' => '68.jpg',
                        'author_id' => '4'
                ],
                [
                        'title' => 'Powerful Delivery',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1100000',
                        'new_price' => '1100000',
                        'thumbnail' => '69.jpg',
                        'author_id' => '3'
                ],
                [
                        'title' => 'Powerful Delivery',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1200000',
                        'new_price' => '1200000',
                        'thumbnail' => '70.jpg',
                        'author_id' => '1'
                ],




                [
                        'title' => 'Effective Communication',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1500000',
                        'new_price' => '1500000',
                        'thumbnail' => '71.jpg',
                        'author_id' => '5'
                ],
                [
                        'title' => 'Effective Communication',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1250000',
                        'new_price' => '1250000',
                        'thumbnail' => '72.jpg',
                        'author_id' => '2'
                ],
                [
                        'title' => 'Effective Communication',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1000000',
                        'new_price' => '1000000',
                        'thumbnail' => '73.jpg',
                        'author_id' => '4'
                ],
                [
                        'title' => 'Effective Communication',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1100000',
                        'new_price' => '1100000',
                        'thumbnail' => '74.jpg',
                        'author_id' => '3'
                ],
                [
                        'title' => 'Effective Communication',
                        'service' => 'training',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'key_takeaways' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
                        'suitable_for' => 'Mahasiswa atau umum',
                        'old_price' => '1200000',
                        'new_price' => '1200000',
                        'thumbnail' => '75.jpg',
                        'author_id' => '1'
                ],
        ];

        $this->db->table('course')->insertBatch($data);
    }
}
