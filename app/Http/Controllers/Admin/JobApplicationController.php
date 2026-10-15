<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $q = JobApplication::with('job')->latest();
        if ($s = trim((string) $request->get('q'))) {
            $q->where(fn ($w) => $w->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%")->orWhere('phone', 'like', "%$s%"));
        }

        return view('admin.applications.index', ['items' => $q->paginate(20)->withQueryString()]);
    }

    public function show(JobApplication $application)
    {
        $application->update(['is_read' => true]);

        return view('admin.applications.show', ['item' => $application]);
    }

    public function resume(JobApplication $application)
    {
        abort_unless($application->resume && Storage::disk('local')->exists($application->resume), 404);

        return Storage::disk('local')->download($application->resume);
    }

    public function destroy(JobApplication $application)
    {
        if ($application->resume) {
            Storage::disk('local')->delete($application->resume);
        }
        $application->delete();

        return redirect()->route('admin.applications.index')->with('success', 'Application deleted.');
    }
}
