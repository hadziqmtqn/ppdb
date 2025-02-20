<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Repositories\Student\StudentRegistrationRepository;
use Closure;
use Illuminate\Http\Request;

class RegistrationIsCompletedMiddleware
{
    protected StudentRegistrationRepository $studentRegistrationRepository;

    /**
     * @param StudentRegistrationRepository $studentRegistrationRepository
     */
    public function __construct(StudentRegistrationRepository $studentRegistrationRepository)
    {
        $this->studentRegistrationRepository = $studentRegistrationRepository;
    }

    public function handle(Request $request, Closure $next)
    {
        $user = User::filterByUsername($request->route('user')->username)
            ->firstOrFail();

        $allCompetencies = $this->studentRegistrationRepository->allCompleted($user);

        if (!$allCompetencies) return redirect()->back()->with('warning', 'Harap lengkapi data registrasi');

        return $next($request);
    }
}
