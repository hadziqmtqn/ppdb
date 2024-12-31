<?php

namespace Database\Seeders\Setting;

use App\Models\MessageTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MessageTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $rows = json_decode(File::get(database_path('import/message-template.json')), true);

        foreach ($rows as $row) {
            $messageTemplate = new MessageTemplate();
            $messageTemplate->title = $row['title'];
            $messageTemplate->educational_institution_id = $row['educational_institution_id'];
            $messageTemplate->category = $row['category'];
            $messageTemplate->recipient = $row['recipient'];
            $messageTemplate->message = $row['message'];
            $messageTemplate->save();
        }
    }
}
