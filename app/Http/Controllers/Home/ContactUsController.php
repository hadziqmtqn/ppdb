<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\ContactUsRequest;
use App\Models\Application;
use Exception;
use Illuminate\Support\Facades\Log;

class ContactUsController extends Controller
{
    public function store(ContactUsRequest $request)
    {
        $application = Application::firstOrFail();

        try {
            $phone = $application->whatsapp_number;
            $name = urlencode($request->input('name'));
            $message = urlencode($request->input('message'));

            $formattedMessage = "*Nama:* $name%0A%0A*Isi Pesan:*%0A$message";

            return redirect()->away("https://api.whatsapp.com/send?phone=$phone&text=$formattedMessage");
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Pesan gagal dikirim');
        }
    }
}
