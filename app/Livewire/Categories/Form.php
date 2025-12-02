<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Livewire\Component;

class Form extends Component
{
    public $category_id;
    public $name;
    public $description;
    public $is_active = true;

    public function mount($id = null): void
    {
        if ($id) {
            $category = Category::findOrFail($id);

            $this->category_id = $category->id;
            $this->name = $category->name;
            $this->description = $category->description;
            $this->is_active = $category->is_active;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:25',
                Rule::unique('categories')
                    ->ignore($this->category_id)
                    ->whereNull('deleted_at'),
            ],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'is_active' => (bool) $this->is_active,
        ];

        if ($this->category_id) {
            $category = Category::findOrFail($this->category_id);
            $category->update($data);
        } else {
            $category = Category::create($data);
            $this->category_id = $category->id;
        }

        return redirect()
            ->route('category.index')
            ->with('success', 'Category saved!');
    }

    public function render()
    {
        return view('livewire.categories.form');
    }
}


