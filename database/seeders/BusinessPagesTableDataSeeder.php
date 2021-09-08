<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BusinessPagesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $business_ids = Business::pluck('id');

        $pageTitles = [
            1 => 'About Us',
            2 => 'Terms & Condition',
            3 => 'Privacy Policy',
            4 => 'Refund Policy',
            5 => 'Main Page'
        ];
        if (count($business_ids) > 0) {
            foreach ($business_ids as $key => $business_id) {
                //insert pages data in page table
                for ($i = 1; $i <= count($pageTitles); $i++) {
                    $newSlug = Str::slug($pageTitles[$i], "-");

                    $exist = Page::where('business_id', '=', $business_id)->where('slug', '=', $newSlug)->first();
                    if (!$exist) {
                        $page = new Page();
                        $page->slug = $newSlug;
                        $page->name = $pageTitles[$i];
                        $page->title = $pageTitles[$i];
                        $page->meta_discription = Str::random(50);
                        $page->heading = $pageTitles[$i];
                        $page->sub_heading = $pageTitles[$i];
                        $page->content = Str::random(50);
                        $page->business_id = $business_id;
                        $page->is_active = 1;
                        $page->save();

                    }
                }
            }
        }
    }
}
