<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use function Complex\theta;

class ProductExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::whereNull('deleted_at')->whereBusinessId(\Auth::user()->business_id)->get();
    }

    public function headings(): array
    {
        return [
            'title',
            'slug',
            'description',
            'categories',
            'brand',
            'cost_price',
            'retail_price',
            'barcode',
            'sku',
            'weight',
            'volume',
            'business_type'
        ];
    }

    /**
     * @param Product $product
     * @return array
     */
    public function map($product): array
    {
        return [
            $product->title,
            isset($product->slug) ? $product->slug : \Str::slug($product->title),
            $product->description,
            join(',', $product->product_category),
            optional($product->brand)->title,
            $product->cost_price,
            $product->retail_price,
            $product->barcode,
            $product->sku,
            $product->weight,
            $product->volume,
            $product->product_type == 1 ? 'food' : 'retail',
        ];
    }
}
