<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Question;
use App\Models\Answer;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('data/questions.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("File not found at: $jsonPath");
            return;
        }

        $json = File::get($jsonPath);
        $questionsData = json_decode($json, true);

        if (is_null($questionsData)) {
            $this->command->error("Invalid JSON format.");
            return;
        }

        foreach ($questionsData as $item) {
            // 1. Create the Question
            $question = Question::create([
                'category_id' => $item['category_id'],
                'title'    => $item['title'],
                'description' => $item['description'] ?? null,
                'image'       => $item['image'] ?? null,
            ]);

            // 2. Extract options
            $options = $item['answer'];
            $correctIndex = $item['answers'];

            // 3. Create Answers
            foreach ($options as $index => $optionText) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer'      => $optionText,
                    // FIX: Wrap the values in quotes ('1' and '0') to force them as Strings
                    'correct'     => ($index == $correctIndex) ? '1' : '0'
                ]);
            }
        }

        $this->command->info("Seeded " . count($questionsData) . " questions successfully.");
    }
}
