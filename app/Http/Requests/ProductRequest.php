<?php

namespace App\Http\Requests;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductVariations;
use App\Models\Store;
use App\Rules\AlphaNumericHyphen;
use App\Rules\ProductTitleRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => [
                'required',
                new ProductTitleRule(),
                Rule::unique((new Product())->getTable())
                    ->ignore(request('product_id'))
                    ->where('business_id', \Auth::user()->business_id)
            ],
            'slug' => ['required', Rule::unique((new Product())->getTable(), 'slug')->ignore(request('product_id'))->where('business_id',Auth::user()->business_id), new AlphaNumericHyphen()],
            'brand_id' => ['required', Rule::exists((new Brand())->getTable(), 'id')],
            'categories.*' => ['required', Rule::exists((new Category())->getTable(), 'id')],
            'retail_price' => ['required', 'numeric', 'min:0', 'max:5000000'],
            'cost_price' => ['nullable', 'numeric', 'min:0', 'max:5000000'],
            'discounted_price' => ['numeric', 'nullable', 'min:0', 'max:5000000'],
            'stores.0' => ['required', Rule::exists((new Store())->getTable(), 'id')],

            'sku' => [
//                'required',
                'nullable',
//                Rule::unique((new Product())->getTable(), 'sku')->ignore(request('product_id')),
                new AlphaNumericHyphen(),
                'max:40'
            ],
            'images.*' => [Rule::dimensions()->minWidth(352)->minHeight(398), 'image', 'mimes:jpg,png,gif,jpeg'],
            'variant.*.cost_price' => ['nullable', 'numeric', 'min:0', 'max:5000000'],
            'variant.*.retail_price' => ['required', 'numeric', 'min:0', 'max:5000000'],
            'variant.*.discounted_price' => ['nullable', 'numeric', 'min:0', 'max:5000000'],
        ];

        $rules = array_merge($rules,
            [
                'barcode' => [
                    'nullable',
//                    Rule::unique((new Product())->getTable(), 'barcode')->ignore(request('product_id')),
                    new AlphaNumericHyphen(),
                    'max:40'
                ]
            ]);
        if (!empty(request('product_id'))) {
            $i = 0;
            $customRule = [];
            if (!empty(request('variant'))) {
                foreach (request('variant') as $variant) {
                    if (!empty(request('variant.' . $i . '.variant_id'))) {
                        $existingBarcode = ProductVariations::whereBarcode(request('variant.' . $i . '.barcode'))
                            ->where('id', '!=', request('variant.' . $i . '.variant_id'))->first();
                        if ($existingBarcode) {
                            $customRule['variant.' . $i . '.barcode'] = [
//                                Rule::unique((new ProductVariations())->getTable(), 'barcode')
                            ];
                        }
                    }
                    $rules = array_merge($rules, $customRule);
                    $i++;
                }
            }
            $rules = array_merge($rules, [
                'variant.*.barcode' => [
//                    'required',
                    'nullable',
                    new AlphaNumericHyphen(),
                    'max:40',
                    'distinct:ignore_case'
                ],
                'variant.*.sku' => [
//                    'required',
                    'nullable',
                    new AlphaNumericHyphen(),
                    'max:40',
                ],
            ]);
        }
        if (empty(request('product_id'))) {
            $rules = array_merge($rules, [
                'variant.*.barcode' => [
//                    'required',
                    'nullable',
//                    Rule::unique((new ProductVariations())->getTable(), 'barcode')->ignore(request('product_id')),
                    new AlphaNumericHyphen(),
                    'max:40',
                    'distinct:ignore_case'
                ],
                'variant.*.sku' => [
//                    'required',
                    'nullable',
//                    Rule::unique((new ProductVariations())->getTable(), 'sku')->ignore(request('product_id')),
                    new AlphaNumericHyphen(),
                    'max:40',
                ],
            ]);
        }

        if (!empty(request('product_id'))) {
            $image = Image::whereImageableId(request('product_id'))->whereImageableType(Product::class)->where(['key' => 'main'])->first();
            if (empty($image)) {
                $rules = array_merge($rules, [
                    'images.main' => [
                        Rule::dimensions()->minWidth(352)->minHeight(398),
//                        'required',
                        'image',
                        'mimes:jpg,png,gif,jpeg'
                    ]
                ]);
            }
        } else {
            $rules = array_merge($rules, [
                'images.main' => [
                    Rule::dimensions()->minWidth(352)->minHeight(398),
                    'required',
                    'image',
                    'mimes:jpg,png,gif,jpeg'
                ]
            ]);
        }
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'brand_id.exists' => 'The brand field is required',
            'stores.*.required' => 'The store field is required',
            'stores.*.exists' => 'The store field is required',
            'images.main.dimensions' => 'The main image has invalid dimensions. Minimum required dimension are 360 X 400 px',
            'images.main.required' => 'The main image field is required',
            'images.main.image' => 'The main image must be an image',
            'images.main.mimes' => 'The main image has invalid format. Allowed file types are: JPG, PNG, GIF',
            'images.*.dimensions' => 'The image has invalid dimensions. Minimum required dimension are 360 X 400 px',
            'images.*.image' => 'The main image must be an image',
            'images.*.mimes' => 'The main image has invalid format. Allowed file types are: JPG, PNG, GIF',
            'variant.*.cost_price.required' => 'Cost is required',
            'variant.*.retail_price.required' => 'Retail is required',
            'variant.*.barcode.required' => 'Barcode is required',
            'variant.*.sku.required' => 'Sku is required',
            'variant.*.cost_price.numeric' => 'Must be numbers',
            'variant.*.retail_price.numeric' => 'Must be numbers',
            'variant.*.discounted_price.numeric' => 'Must be numbers',
            'variant.*.barcode.unique' => 'Already taken',
            'variant.*.sku.unique' => 'Already taken',
            'variant.*.barcode.max' => 'Max length is 40',
            'variant.*.sku.max' => 'Max length is 40',
            'variant.*.sku.distinct' => 'Already assigned',
            'variant.*.barcode.distinct' => 'Already assigned',
        ];

        return array_merge($messages, parent::messages());
    }
}
