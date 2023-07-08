<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // DB::statement('LOAD DATA INFILE "' . resource_path('database/questions.csv') .
        //     '"  INTO TABLE questions
        //         FIELDS TERMINATED BY "\t"
        //         IGNORE 1 ROWS;'
        // );

        // $csvFile = fopen(resource_path('database/questions.csv'), "r");

        // $firstline = true;

        // $loop = 1;

        // DB::disableQueryLog();

        // while (($data = fgetcsv($csvFile, 2000, "\t")) !== FALSE) {
        //     if (!$firstline) {
        //         Question::create([
        //             'round' => $data[0],
        //             'value' => $data[1],
        //             'daily_double_value' => $data[2],
        //             'category' => $data[3],
        //             'comments' => $data[4],
        //             'answer' => $data[5],
        //             'question' => $data[6],
        //             'air_date' => $data[7],
        //             'notes' => $data[8],
        //         ]);
        //     }
        //     $firstline = false;
        // }

        // fclose($csvFile);
        // $path = resource_path('database/questions.csv');

        // DB::enableQueryLog();

        // $this->command->info('Created ' . $loop . ' records.');



        //
        // $this->migrateQuestions();
    }

    /**
     * Get data from https://github.com/jwolle1/jeopardy_clue_dataset
     */
    public function migrateQuestions($max = INF)
    {

        $path = resource_path('database/questions.csv');

        $csvData = fopen($path, 'r');

        $transRow = true;

        $loop = 1;
        while (($data = fgetcsv($csvData, null, "\t") !== false)) {
            if (!$transRow && $loop !== 1 && $max <= $loop) {
                Question::create([
                    'round' => $data[0],
                    'value' => $data[1],
                    'daily_double_value' => $data[2],
                    'category' => $data[3],
                    'comments' => $data[4],
                    'answer' => $data[5],
                    'question' => $data[6],
                    'air_date' => $data[7],
                    'notes' => $data[8],
                ]);
            }

            $transRow = false;

            $loop++;
        }

        fclose($csvData);

        $this->command->info('Created ' . $loop . ' records.');
    }
}
