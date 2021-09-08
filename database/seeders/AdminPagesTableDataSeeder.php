<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPagesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pageTitles = [
            1 => 'Terms & Conditions',
            2 => 'Privacy Policy'

        ];
                //insert pages data in page table
                for ($i = 1; $i <= count($pageTitles); $i++) {
                    $newSlug = Str::slug($pageTitles[$i], "-");
                    $exist = Page::where('business_id', '=', 0)->where('slug', '=', $newSlug)->first();
                    if (!$exist){
                        $page = new Page();
                        $page->slug = $newSlug;
                        $page->name = $pageTitles[$i];
                        $page->title = $pageTitles[$i];
                        $page->meta_discription = Str::random(50);
                        $page->heading = $pageTitles[$i];
                        $page->content = Str::random(50);
                        $page->business_id = 0;
                        $page->is_active = 1;
                        $page->save();
                    }
                }

        //Home page
        $newSlug = "home-page";
        $exist =  $exist = Page::where('business_id', '=', 0)->where('slug', '=', $newSlug)->first();
        if (!$exist){
                $page = new Page();
                $content['page']['name'] = 'Home page';
                $content['page']['title'] ='Home page';
                $content['banner']['title']='Take your Business Online in 2 minutes';
                $content['banner']['btn_title']='Sign up for FREE';
                $content['banner']['banner_btn_link']='https://oogo.ae';
                $content['ecommerce']['heading']='Create Ecommerce website in few simple clicks';
                $content['ecommerce']['content']="Starting an online ordering platform does not have to be difficult or expensive. With OOGO, you can set a beautiful ecommerce website for FREE in minutes. No experience required. It's a simple as opening a Facebook or Instagram account.";
                $content['ecommerce']['btn_title']="Demo";
                $content['ecommerce']['btn_link']="https://oogo.ae/home#request";
                $content['ecommerce']['video_link']="https://i.ytimg.com/vi_webp/JsuVKe7Cp1Q/sddefault.webp";
                $content['service']['heading']="Why OOGO";

            $content['service']['content']=htmlentities('<p>All in One Solution</p> <ul class="list-unstyled li-space-lg"> <li class="media"> <h4>Setup a beautiful ecommerce website for FREE in minutes.</h4> </li> <div class="media-body">Launch your online store easily on OOGO.Simply upload your products and start selling in matter of Minutes.</div>  <li class="media"> <h4>Easily accepts payment online</h4> </li> <div class="media-body">Start Accepting Credit card payments on your website and get paid right away.</div>  <li class="media"> <h4>Quickly Manage orders &amp; Inventory</h4> </li> <div class="media-body">Quickly process orders,upload new products, manage your inventory and more in our easy to use dashboard.</div>  <li class="media"> <h4>Stress Free Delivery Solution</h4> </li> <div class="media-body">Provide faster and seamless delivery experience at competitive rates with our local delivery partners.</div></ul>');
            $content['pricing']['content']=htmlentities("<h2>Multiple Pricing Options</h2> <p class='p-heading p-large'>We've prepared pricing plans for all budgets so you can get started right away. For enterprises Contact us for custom plan.</p>");
                $content['request']['content']=htmlentities("<h2>Fill The Following Form To Request A Meeting</h2> <p>OOGO is providing a powerfull online ordering platform with ZERO Commission &amp; No Hidden Charges in the market. Discover what it can do for your business organization right away.</p> <ul class='list-unstyled li-space-lg'> <li class='media'> <i class='fas fa-check'></i> <div class=''><strong class='blue'>Automate your ordering</strong> platform and get results today</div> </li> <li class='media'> <i class='fas fa-check'></i> <div class='media-body'><strong class='blue'>Interact with all your</strong> targeted customers at a personal level</div> </li> <li class='media'> <i class='fas fa-check'></i> <div class='media-body'><strong class='blue'>Convince them to buy</strong> your company's awesome products</div> </li> <li class='media'> <i class='fas fa-check'></i> <div class='media-body'><strong class='blue''>Save precious time</strong> and invest it where you need it the most</div> </li> </ul>");
                $page->slug = 'home-page';
                $page->name = 'Home page';
                $page->title = 'Home page';
                $page->content = json_encode($content);
                $page->heading = 'Home page';
                $page->meta_discription = 'Meta Description here';
                $page->business_id = 0;
                $page->is_active = 1;
                $page->save();
//                if ($request->has('images')) {
//                    $this->imageService->saveImage($request, $page->id, Page::class, "pages");
//                }
        }





    }
}
