<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhatsappConfig\WhatsappConfigRequest;
use App\Models\WhatsappConfig;

class WhatsappConfigController extends Controller
{
    public function index()
    {
        return WhatsappConfig::all();
    }

    public function store(WhatsappConfigRequest $request)
    {
        return WhatsappConfig::create($request->validated());
    }

    public function show(WhatsappConfig $whatsappConfig)
    {
        return $whatsappConfig;
    }

    public function update(WhatsappConfigRequest $request, WhatsappConfig $whatsappConfig)
    {
        $whatsappConfig->update($request->validated());

        return $whatsappConfig;
    }

    public function destroy(WhatsappConfig $whatsappConfig)
    {
        $whatsappConfig->delete();

        return response()->json();
    }
}
