<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Flashcard;
use App\Models\User;
use Faker\Factory as Faker;

class CompletedFlashcardsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $user = User::first(); // Get the first user (test user)

        $subjects = [
            'World History' => [
                'icon' => '🌍',
                'content_prefix' => 'Historical event: ',
                'terms' => [
                    'World War II' => 'Global conflict that lasted from 1939 to 1945',
                    'Renaissance' => 'Period of cultural rebirth in Europe from 14th to 17th century',
                    'Industrial Revolution' => 'Period of rapid industrialization in the 18th and 19th centuries',
                    'French Revolution' => 'Period of radical social and political upheaval in France',
                    'Cold War' => 'Period of geopolitical tension between the United States and Soviet Union'
                ]
            ],
            'Physics' => [
                'icon' => '⚛️',
                'content_prefix' => 'Physics concept: ',
                'terms' => [
                    'Quantum Mechanics' => 'Branch of physics dealing with atomic and subatomic particles',
                    'Relativity' => 'Einstein\'s theory describing gravity as a consequence of spacetime curvature',
                    'Thermodynamics' => 'Study of heat, temperature, and their relation to energy and work',
                    'Nuclear Physics' => 'Study of atomic nuclei and their interactions',
                    'Wave Theory' => 'Study of the behavior and properties of waves'
                ]
            ]
        ];

        foreach ($subjects as $subjectName => $data) {
            $subject = Subject::create([
                'name' => $subjectName,
                'icon' => $data['icon'],
            ]);

            // Create base flashcards from predefined terms
            foreach ($data['terms'] as $term => $content) {
                $flashcard = Flashcard::create([
                    'subject_id' => $subject->id,
                    'term' => $term,
                    'content' => $content,
                ]);

                // Mark as completed
                $user->completedFlashcards()->attach($flashcard->id);
                $user->points += 10;
                $user->save();
            }

            // Create remaining flashcards to reach 500
            for ($i = 0; $i < 495; $i++) {
                $term = $faker->unique()->sentence(rand(1, 3));
                
                // Generate content based on subject
                $content = match($subjectName) {
                    'World History' => $data['content_prefix'] . $faker->paragraph(3) . "\n\nDate: " . $faker->year() . "\nLocation: " . $faker->country(),
                    'Physics' => $data['content_prefix'] . $faker->paragraph(2) . "\n\nFormula: " . $faker->text(30) . "\nApplication: " . $faker->sentence(),
                };

                $flashcard = Flashcard::create([
                    'subject_id' => $subject->id,
                    'term' => $term,
                    'content' => $content,
                ]);

                // Mark as completed and award points
                $user->completedFlashcards()->attach($flashcard->id);
                $user->points += 10;
                $user->save();
            }
        }
    }
} 