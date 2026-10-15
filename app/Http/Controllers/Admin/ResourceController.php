<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Generic CRUD driven by fields() / columns() definitions.
 * Field types: text, number, textarea, editor, image, select, checkbox.
 */
abstract class ResourceController extends Controller
{
    /** @var class-string<Model> */
    protected string $model;

    protected string $route;      // e.g. "sliders" => admin.sliders.*
    protected string $title;      // e.g. "Home Sliders"
    protected string $singular;   // e.g. "Slider"
    protected array $searchable = ['name'];
    protected string $orderBy = 'id';
    protected string $orderDir = 'desc';

    abstract protected function fields(): array;

    abstract protected function columns(): array;

    protected function query(): Builder
    {
        return $this->model::query();
    }

    protected function afterSave(Model $item, Request $request): void
    {
    }

    protected function formData(?Model $item): array
    {
        return [];
    }

    public function index(Request $request): View
    {
        $q = $this->query();

        if ($s = trim((string) $request->get('q'))) {
            $q->where(function ($w) use ($s) {
                foreach ($this->searchable as $col) {
                    $w->orWhere($col, 'like', "%{$s}%");
                }
            });
        }

        return view('admin.resource.index', [
            'items' => $q->orderBy($this->orderBy, $this->orderDir)->paginate(20)->withQueryString(),
            'columns' => $this->columns(),
            'meta' => $this->meta(),
        ]);
    }

    public function create(): View
    {
        return view('admin.resource.form', [
            'item' => new $this->model,
            'fields' => $this->fields(),
            'meta' => $this->meta(),
        ] + $this->formData(null));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->save(new $this->model, $request);

        return redirect()->route("admin.{$this->route}.index")->with('success', "{$this->singular} created.");
    }

    public function edit(int $id): View
    {
        $item = $this->model::findOrFail($id);

        return view('admin.resource.form', [
            'item' => $item,
            'fields' => $this->fields(),
            'meta' => $this->meta(),
        ] + $this->formData($item));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->save($this->model::findOrFail($id), $request);

        return redirect()->route("admin.{$this->route}.index")->with('success', "{$this->singular} updated.");
    }

    public function destroy(int $id): RedirectResponse
    {
        $item = $this->model::findOrFail($id);

        foreach ($this->fields() as $f) {
            if ($f['type'] === 'image' && $item->{$f['name']}) {
                Storage::disk('public')->delete($item->{$f['name']});
            }
        }
        $item->delete();

        return back()->with('success', "{$this->singular} deleted.");
    }

    protected function meta(): array
    {
        return ['route' => $this->route, 'title' => $this->title, 'singular' => $this->singular];
    }

    protected function save(Model $item, Request $request): void
    {
        $fields = $this->fields();
        $rules = [];
        foreach ($fields as $f) {
            $rules[$f['name']] = $f['rules'] ?? ($f['type'] === 'image' ? 'nullable|image|max:4096' : 'nullable');
        }
        $data = $request->validate($rules);

        foreach ($fields as $f) {
            $name = $f['name'];

            if ($f['type'] === 'checkbox') {
                $data[$name] = $request->boolean($name);
            } elseif ($f['type'] === 'image') {
                unset($data[$name]);
                if ($request->hasFile($name)) {
                    if ($item->{$name}) {
                        Storage::disk('public')->delete($item->{$name});
                    }
                    $data[$name] = $request->file($name)->store($this->route, 'public');
                } elseif ($request->boolean("remove_{$name}") && $item->{$name}) {
                    Storage::disk('public')->delete($item->{$name});
                    $data[$name] = null;
                }
            } elseif (($data[$name] ?? null) === null && array_key_exists('default', $f)) {
                $data[$name] = $f['default'];
            }
        }

        $this->fillSlug($item, $data);

        $item->fill($data)->save();
        $this->afterSave($item, $request);
    }

    private function fillSlug(Model $item, array &$data): void
    {
        if (! Schema::hasColumn($item->getTable(), 'slug')) {
            return;
        }

        $slug = Str::slug(($data['slug'] ?? null) ?: ($data['title'] ?? $data['name'] ?? ''));
        if ($slug === '') {
            return;
        }

        $base = $slug;
        $i = 2;
        while ($item->newQuery()->where('slug', $slug)->where('id', '!=', $item->id ?? 0)->exists()) {
            $slug = $base.'-'.$i++;
        }
        $data['slug'] = $slug;
    }
}
