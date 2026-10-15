<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $q = Enquiry::with('product')->latest();
        if ($s = trim((string) $request->get('q'))) {
            $q->where(fn ($w) => $w->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%")->orWhere('phone', 'like', "%$s%"));
        }

        return view('admin.enquiries.index', ['items' => $q->paginate(20)->withQueryString()]);
    }

    public function show(Enquiry $enquiry)
    {
        $enquiry->update(['is_read' => true]);

        return view('admin.enquiries.show', ['item' => $enquiry]);
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted.');
    }
}
