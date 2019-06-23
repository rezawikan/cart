<?php

namespace App\Scoping\Scopes\Products;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;
use App\Models\Category;

/**
 *
 */
class CategoryScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        $category = Category::where('slug', $value)->first();

        if (empty($category)) {
            abort(404);
        }

        if ($category->parents()) {
            $values = $category->children()->get()->map(function ($child) {
                return $child->slug;
            })->toArray();
        }

        $value = array_merge([$value], $values);

        return $builder->whereHas('categories', function ($builder) use ($value) {
            $builder->whereIn('slug', $value);
        });
    }
}
