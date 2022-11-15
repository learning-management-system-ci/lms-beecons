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
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Project Browser & Views",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Properties & Modifications",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Starting a New Project",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Site Modeling",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
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
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Project Collaboration",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
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
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Openings & Furnishings",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Curtain Wall",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Vertical Circulation",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Architectural Spatial Elements",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
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
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Concrete Rebar",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Steel Connection Detail",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Precast Concrete",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Analytical Model",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
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
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "HVAC & Plumbing",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Electrical & Lighting",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "MEP Spatial Elements",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "MEP Fabrication",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
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
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "3D Geometry",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Parametric",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "2D Family",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
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
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Light Setting",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Rendering Result Analysis and How to solve",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Overall layout, Elevation and Plan",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "3D and Animation Rendering",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
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
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Load Combination",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Design of Foundation and Footing",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Design of Reinforced Concrete Beam",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Design of Reinforced Concrete Column",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 5
        ],
        [
          "video_category_id" => $i,
          "title" => "Seismic Analysis",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 6
        ],
        [
          "video_category_id" => $i,
          "title" => "Running Analysis and Reporting",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
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
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Specify area and volume settings",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Specify building parameters for the analysis",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Specify building type settings",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Export the project information to create a gbXML (Green Building XML) file",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 5
        ],
        [
          "video_category_id" => $i,
          "title" => "Specifying electrical load calculation settings",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 6
        ],
        [
          "video_category_id" => $i,
          "title" => "Calculating building electrical loads",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 7
        ],
        [
          "video_category_id" => $i,
          "title" => "Creating electrical panel schedules",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
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
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Quantity Calculation",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Basic Pricing for Material and Labour",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Unit Price Analysis",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Reporting Terminology",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
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
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Create Sets",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Create new Clash detective test and setting the clash detection rules",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 3
        ],
        [
          "video_category_id" => $i,
          "title" => "Review clashes (appearance, view angle, etc.)",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 4
        ],
        [
          "video_category_id" => $i,
          "title" => "Give comment and assign clash to a user",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 5
        ],
        [
          "video_category_id" => $i,
          "title" => "change clash status",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 6
        ],
        [
          "video_category_id" => $i,
          "title" => "Navisworks Switchback (to Revit)",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 7
        ],
        [
          "video_category_id" => $i,
          "title" => "Export clash report",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
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
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 1
        ],
        [
          "video_category_id" => $i,
          "title" => "Project Management",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 2
        ],
        [
          "video_category_id" => $i,
          "title" => "Project Documentation",
          "video" => "https://www.youtube.com/watch?app=desktop&v=p0epmLVsKro&feature=youtu.be",
          "order" => 3
        ],
      );
    };

    $this->db->table('video')->insertBatch($data);
  }
}
