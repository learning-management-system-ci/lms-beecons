<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VideoCategoryNew extends Seeder
{
    public function run()
    {
        $data = [
            [
                'course_id' => '1',
                'title' => ''
            ],

            [
                'course_id' => '2',
                'title' => 'Introduction to BIM & Autodesk Revit'
            ],
            [
                'course_id' => '2',
                'title' => 'Project Browser & Views'
            ],
            [
                'course_id' => '2',
                'title' => 'Properties & Modifications'
            ],
            [
                'course_id' => '2',
                'title' => 'Starting a New Project'
            ],
            [
                'course_id' => '2',
                'title' => 'Site Modeling'
            ],

            [
                'course_id' => '3',
                'title' => 'Project Visualization'
            ],
            [
                'course_id' => '3',
                'title' => 'Project Collaboration'
            ],

            [
                'course_id' => '4',
                'title' => 'Architectural Elements'
            ],
            [
                'course_id' => '4',
                'title' => 'Openings & Furnishings'
            ],
            [
                'course_id' => '4',
                'title' => 'Curtain Wall'
            ],
            [
                'course_id' => '4',
                'title' => 'Vertical Circulation'
            ],
            [
                'course_id' => '4',
                'title' => 'Architectural Spatial Elements'
            ],

            [
                'course_id' => '5',
                'title' => 'Structural Elements'
            ],
            [
                'course_id' => '5',
                'title' => 'Conrete Rebar'
            ],
            [
                'course_id' => '5',
                'title' => 'Steel Connection Detail'
            ],
            [
                'course_id' => '5',
                'title' => 'Precast Concrete'
            ],
            [
                'course_id' => '5',
                'title' => 'Analytical Model'
            ],

            [
                'course_id' => '6',
                'title' => ''
            ],

            [
                'course_id' => '7',
                'title' => ''
            ],

            [
                'course_id' => '8',
                'title' => ''
            ],

            [
                'course_id' => '9',
                'title' => ''
            ],

            [
                'course_id' => '10',
                'title' => ''
            ],

            [
                'course_id' => '11',
                'title' => ''
            ],

            [
                'course_id' => '12',
                'title' => ''
            ],

            [
                'course_id' => '13',
                'title' => 'Annotations, Symbols, and Details'
            ],
            [
                'course_id' => '13',
                'title' => 'Project Management'
            ],
            [
                'course_id' => '13',
                'title' => 'Project Documentation'
            ],

            [
                'course_id' => '14',
                'title' => ''
            ],

            [
                'course_id' => '15',
                'title' => ''
            ],
        ];

        $this->db->table('video_category')->insertBatch($data);
    }
}
