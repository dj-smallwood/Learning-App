<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Flashcard;
use Faker\Factory as Faker;

class FlashcardSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Sample subjects with their related terms
        $subjects = [
            'Mathematics' => [
                'terms' => ['Algebra', 'Calculus', 'Geometry', 'Trigonometry', 'Statistics'],
                'icon' => '🔢',
                'content_prefix' => 'Mathematical concept involving ',
            ],
            'Science' => [
                'terms' => ['Biology', 'Chemistry', 'Physics', 'Astronomy', 'Geology'],
                'icon' => '🧪',
                'content_prefix' => 'Branch of science studying ',
            ],
            'History' => [
                'terms' => ['Ancient Civilizations', 'World Wars', 'Industrial Revolution', 'Renaissance', 'Cold War'],
                'icon' => '📚',
                'content_prefix' => 'Historical period characterized by ',
            ],
            'Geography' => [
                'terms' => ['Continents', 'Climate', 'Topography', 'Population', 'Natural Resources'],
                'icon' => '🌍',
                'content_prefix' => 'Geographical concept related to ',
            ],
            'Literature' => [
                'terms' => ['Poetry', 'Novel', 'Drama', 'Shakespeare', 'Modern Literature'],
                'icon' => '📝',
                'content_prefix' => 'Literary form focusing on ',
            ],
        ];

        foreach ($subjects as $subjectName => $data) {
            $subject = Subject::create([
                'name' => $subjectName,
                'icon' => $data['icon'],
            ]);

            // Create base flashcards from the defined terms
            foreach ($data['terms'] as $term) {
                Flashcard::create([
                    'subject_id' => $subject->id,
                    'term' => $term,
                    'content' => $data['content_prefix'] . $faker->sentence(8),
                ]);
            }

            // Add some random additional flashcards
            for ($i = 0; $i < rand(5, 15); $i++) {
                Flashcard::create([
                    'subject_id' => $subject->id,
                    'term' => $faker->unique()->words(rand(1, 3), true),
                    'content' => $data['content_prefix'] . $faker->sentence(10),
                ]);
            }
        }
    }
} 