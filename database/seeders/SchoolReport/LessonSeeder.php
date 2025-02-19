<?php

namespace Database\Seeders\SchoolReport;

use App\Models\Lesson;
use App\Models\LessonMapping;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LessonSeeder extends Seeder
{
    /**
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $rows = json_decode(File::get(database_path('import/school-report/lesson.json')), true);

        foreach ($rows as $row) {
            $lesson = new Lesson();
            $lesson->name = $row['name'];
            $lesson->type = $row['type'];
            $lesson->save();

            foreach ($row['lesson_mapping'] as $item) {
                $lessonMapping = new LessonMapping();
                $lessonMapping->lesson_id = $lesson->id;
                $lessonMapping->educational_institution_id = $item['educational_institution_id'];
                $lessonMapping->previous_educational_group = json_encode(array_map('intval', $item['provious_educational_group']));
                $lessonMapping->save();
            }
        }
    }
}
