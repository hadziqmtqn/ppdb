<?php

namespace Database\Seeders\Setting;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $datas = json_decode(File::get(database_path('import/faq.json')), true);

        foreach ($datas as $data) {
            $faqCategory = new FaqCategory();
            $faqCategory->name = $data['name'];
            $faqCategory->qualification = json_encode(array_map('intval', $data['qualification']));
            $faqCategory->save();

            if (isset($data['faqs'])) {
                foreach ($data['faqs'] as $item) {
                    $faq = new Faq();
                    $faq->educational_institution_id = $item['educational_institution_id'];
                    $faq->faq_category_id = $faqCategory->id;
                    $faq->title = $item['title'];
                    $faq->description = $item['description'];
                    $faq->save();
                }
            }
        }
    }
}
