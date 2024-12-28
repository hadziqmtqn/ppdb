<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\ApplicationRequest;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function index()
    {
        return Application::all();
    }

    public function store(ApplicationRequest $request)
    {
        return Application::create($request->validated());
    }

    public function show(Application $application)
    {
        return $application;
    }

    public function update(ApplicationRequest $request, Application $application)
    {
        $application->update($request->validated());

        return $application;
    }

    public function destroy(Application $application)
    {
        $application->delete();

        return response()->json();
    }
}
