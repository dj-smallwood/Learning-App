<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Flashcard;
use Faker\Factory as Faker;

class BulkTestDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $subjects = [
            'Computer Science' => [
                'icon' => '💻',
                'terms' => [
                    'Algorithm' => 'A step-by-step procedure for solving a problem or accomplishing a task',
                    'Database' => 'An organized collection of structured information or data',
                    'API' => 'Application Programming Interface - a set of rules for building software',
                    'Framework' => 'A platform for developing software applications',
                    'Variable' => 'A storage location paired with an associated symbolic name'
                ]
            ],
            'Psychology' => [
                'icon' => '🧠',
                'terms' => [
                    'Cognition' => 'The mental process of acquiring knowledge and understanding',
                    'Behavior' => 'The way in which one acts or conducts oneself',
                    'Memory' => 'The faculty by which the mind stores and remembers information',
                    'Emotion' => 'A natural instinctive state of mind',
                    'Perception' => 'The ability to see, hear, or become aware of something through the senses'
                ]
            ],
            'Business' => [
                'icon' => '💼',
                'terms' => [
                    'Marketing' => 'The process of promoting and selling products or services',
                    'Finance' => 'The management of money and investments',
                    'Management' => 'The process of dealing with or controlling things or people',
                    'Economics' => 'The study of production, consumption, and transfer of wealth',
                    'Strategy' => 'A plan of action designed to achieve a long-term or overall aim'
                ]
            ],
            'Philosophy' => [
                'icon' => '🤔',
                'terms' => [
                    'Ethics' => 'Moral principles that govern behavior or conducting of an activity',
                    'Logic' => 'Reasoning conducted or assessed according to strict principles',
                    'Metaphysics' => 'The branch of philosophy dealing with existence and reality',
                    'Epistemology' => 'The theory of knowledge, especially regarding methods and validity',
                    'Aesthetics' => 'The study of beauty and taste in art and culture'
                ]
            ],
            'Languages' => [
                'icon' => '🗣️',
                'terms' => [
                    'Grammar' => 'The whole system and structure of a language',
                    'Syntax' => 'The arrangement of words and phrases to create sentences',
                    'Phonetics' => 'The study of speech sounds in language',
                    'Vocabulary' => 'The body of words used in a particular language',
                    'Semantics' => 'The study of meaning in language'
                ]
            ],
        ];

        foreach ($subjects as $subjectName => $data) {
            $subject = Subject::create([
                'name' => $subjectName,
                'icon' => $data['icon'],
            ]);

            // Add the predefined terms first
            foreach ($data['terms'] as $term => $content) {
                Flashcard::create([
                    'subject_id' => $subject->id,
                    'term' => $term,
                    'content' => $content,
                ]);
            }

            // Add 95 more random flashcards to reach 100 total
            for ($i = 0; $i < 95; $i++) {
                $term = $faker->unique()->sentence(rand(1, 3));
                
                // Generate content related to the subject
                $content = match($subjectName) {
                    'Computer Science' => $faker->paragraph(2) . "\n\nExample in code:\n```\n" . $faker->text(100) . "\n```",
                    'Psychology' => "Research finding: " . $faker->paragraph(3),
                    'Business' => "Business concept: " . $faker->paragraph(2) . "\n\nKey application: " . $faker->paragraph(1),
                    'Philosophy' => "Philosophical argument: " . $faker->paragraph(3) . "\n\nKey thinkers: " . $faker->name . ", " . $faker->name,
                    'Languages' => "Definition: " . $faker->paragraph(1) . "\n\nUsage examples:\n- " . $faker->sentence() . "\n- " . $faker->sentence(),
                    default => $faker->paragraph(2),
                };

                Flashcard::create([
                    'subject_id' => $subject->id,
                    'term' => $term,
                    'content' => $content,
                ]);
            }
        }
    }
} 