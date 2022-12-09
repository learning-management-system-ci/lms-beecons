<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VideoNew extends Seeder
{
  public function run()
  {
    $data = [];

    for ($i = 1; $i <= 5; $i++) {
      array_push(
        $data,
        [
          "video_category_id" => $i,
          "title" => "Introduction to BIM & Autodesk Revit",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Project Browser & Views",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Properties & Modifications",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Starting a New Project",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Site Modeling",
          "order" => 5
        ]
      );
    };

    for ($i = 6; $i <= 10; $i++) {
      array_push(
        $data,
        [
          "video_category_id" => $i,
          "title" => "Project Visualization",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Project Collaboration",
          "order" => 2
        ],
      );
    };

    for ($i = 11; $i <= 15; $i++) {
      array_push(
        $data,
        [
          "video_category_id" => $i,
          "title" => "Architectural Elements",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Openings & Furnishings",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Curtain Wall",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Vertical Circulation",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Architectural Spatial Elements",
          "order" => 5
        ]
      );
    };

    for ($i = 16; $i <= 20; $i++) {
      array_push(
        $data,
        [
          "video_category_id" => $i,
          "title" => "Structural Elements",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Concrete Rebar",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Steel Connection Detail",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Precast Concrete",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Analytical Model",
          "order" => 5
        ],
      );
    };

    for ($i = 21; $i <= 25; $i++) {
      array_push(
        $data,
        [
          "video_category_id" => $i,
          "title" => "MEP Systems & Elements",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "HVAC & Plumbing",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Electrical & Lighting",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "MEP Spatial Elements",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "MEP Fabrication",
          "order" => 5
        ],
      );
    };

    for ($i = 26; $i <= 30; $i++) {
      array_push(
        $data,
        [
          "video_category_id" => $i,
          "title" => "New Family",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "3D Geometry",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Parametric",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "2D Family",
          "order" => 4
        ],
      );
    };

    for ($i = 31; $i <= 35; $i++) {
      array_push(
        $data,
        [
          "video_category_id" => $i,
          "title" => "Material Setting",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Light Setting",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Rendering Result Analysis and How to solve",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Overall layout, Elevation and Plan",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "3D and Animation Rendering",
          "order" => 5
        ],
      );
    };

    for ($i = 36; $i <= 40; $i++) {
      array_push(
        $data,
        [
          "video_category_id" => $i,
          "title" => "Structural modelling",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Load Combination",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Design of Foundation and Footing",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Design of Reinforced Concrete Beam",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Design of Reinforced Concrete Column",
          "order" => 5
        ],
        [
          "video_category_id" => $i,
          "title" => "Seismic Analysis",
          "order" => 6
        ],
        [
          "video_category_id" => $i,
          "title" => "Running Analysis and Reporting",
          "order" => 7
        ],
      );
    };

    for ($i = 41; $i <= 45; $i++) {
      array_push(
        $data,
        [
          "video_category_id" => $i,
          "title" => "Add spaces and zones to the model",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Specify area and volume settings",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Specify building parameters for the analysis",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Specify building type settings",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Export the project information to create a gbXML (Green Building XML) file",
          "order" => 5
        ],
        [
          "video_category_id" => $i,
          "title" => "Specifying electrical load calculation settings",
          "order" => 6
        ],
        [
          "video_category_id" => $i,
          "title" => "Calculating building electrical loads",
          "order" => 7
        ],
        [
          "video_category_id" => $i,
          "title" => "Creating electrical panel schedules",
          "order" => 8
        ],
      );
    };

    for ($i = 46; $i <= 50; $i++) {
      array_push(
        $data,
        [
          "video_category_id" => $i,
          "title" => "Fundamental Cost Estimation",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Quantity Calculation",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Basic Pricing for Material and Labour",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Unit Price Analysis",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Reporting Terminology",
          "order" => 5
        ],
      );
    };

    for ($i = 51; $i <= 55; $i++) {
      array_push(
        $data,
        [
          "video_category_id" => $i,
          "title" => "Append multi discipline BIM files to Navisworks",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Create Sets",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Create new Clash detective test and setting the clash detection rules",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Review clashes (appearance, view angle, etc.)",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Give comment and assign clash to a user",
          "order" => 5
        ],
        [
          "video_category_id" => $i,
          "title" => "change clash status",
          "order" => 6
        ],
        [
          "video_category_id" => $i,
          "title" => "Navisworks Switchback (to Revit)",
          "order" => 7
        ],
        [
          "video_category_id" => $i,
          "title" => "Export clash report",
          "order" => 8
        ],
      );
    };

    for ($i = 56; $i <= 60; $i++) {
      array_push(
        $data,
        [
          "video_category_id" => $i,
          "title" => "Annotations, Symbols, and Details",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Project Management",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Project Documentation",
          "order" => 3
        ],
      );
    };

    for ($i = 0; $i < count($data); $i++) {
      $data[$i]['thumbnail'] = $i + 1 . '.jpg';
      $data[$i]['video'] = $i + 1 . '.mp4';
    }

    $this->db->table('video')->insertBatch($data);
  }
}
