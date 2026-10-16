<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Certification;
use App\Models\Enquiry;
use App\Models\JobOpening;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Variant;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home()
    {
        $categories = Category::active()->withCount('products')->get();

        return view('pages.index', [
            'sliders' => Slider::active()->get(),
            'categories' => $categories,
            // "Popular products" tabs: up to four products from each category that has any
            'popular' => $categories->where('products_count', '>', 0)->take(4)->mapWithKeys(fn ($c) => [
                $c->id => Product::active()->where('category_id', $c->id)->with(['category', 'variants'])->limit(4)->get(),
            ]),
            'codeCount' => Variant::count(),
            'certifications' => Certification::active()->get(),
            'about' => Page::where('slug', 'about-us')->where('is_active', true)->first(),
        ]);
    }

    public function products(Request $request, ?Category $category = null)
    {
        $q = Product::active()->with(['category', 'variants']);

        if ($category) {
            abort_unless($category->is_active, 404);
            $q->where('category_id', $category->id);
        }
        if ($s = trim((string) $request->get('q'))) {
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%$s%")
                    ->orWhereHas('variants', fn ($v) => $v->where('code', 'like', "%$s%")->orWhere('rating', 'like', "%$s%"));
            });
        }

        return view('pages.products', [
            'category' => $category,
            'products' => $q->paginate(12)->withQueryString(),
            'categories' => Category::active()->withCount('products')->get(),
        ]);
    }

    public function product(string $slug)
    {
        $product = Product::active()->where('slug', $slug)->with(['category', 'variants'])->firstOrFail();

        $versions = $product->versions();

        return view('pages.product', [
            'product' => $product,
            'versions' => $versions,
            'related' => Product::active()->with(['category', 'variants'])
                ->where('category_id', $product->category_id)
                ->whereNotIn('id', $versions->pluck('id')->push($product->id))
                ->limit(4)->get(),
        ]);
    }

    public function page(string $slug)
    {
        return view('pages.page', ['page' => Page::where('slug', $slug)->where('is_active', true)->firstOrFail()]);
    }

    public function contact(Request $request)
    {
        return view('pages.contact', [
            'product' => $request->filled('product') ? Product::find($request->get('product')) : null,
        ]);
    }

    public function sendEnquiry(Request $request)
    {
        // honeypot: bots fill the hidden field
        if ($request->filled('website_url')) {
            return back();
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|required_without:phone',
            'phone' => 'nullable|string|max:30|required_without:email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:3000',
            'product_id' => 'nullable|exists:products,id',
        ]);

        Enquiry::create($data);

        return back()->with('success', 'Thank you! Your enquiry has been received. We will contact you shortly.');
    }

    public function blog()
    {
        return view('pages.blog', ['posts' => Post::published()->paginate(9)]);
    }

    public function post(string $slug)
    {
        return view('pages.post', [
            'post' => Post::published()->where('slug', $slug)->firstOrFail(),
            'recent' => Post::published()->where('slug', '!=', $slug)->limit(5)->get(),
        ]);
    }

    public function careers()
    {
        return view('pages.careers', ['jobs' => JobOpening::active()->get()]);
    }

    public function career(string $slug)
    {
        return view('pages.career', ['job' => JobOpening::active()->where('slug', $slug)->firstOrFail()]);
    }

    public function applyJob(Request $request, string $slug)
    {
        $job = JobOpening::active()->where('slug', $slug)->firstOrFail();

        if ($request->filled('website_url')) {
            return back();
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'experience' => 'nullable|string|max:100',
            'cover_letter' => 'nullable|string|max:3000',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:4096',
        ]);

        $data['resume'] = $request->file('resume')->store('resumes', 'local');
        $job->applications()->create($data);

        return back()->with('success', 'Thank you! Your application has been submitted. We will contact you if you are shortlisted.');
    }
}
