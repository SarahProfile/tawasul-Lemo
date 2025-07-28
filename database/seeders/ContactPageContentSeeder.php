<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class ContactPageContentSeeder extends Seeder
{
    public function run()
    {
        // Contact Page Banner Section
        PageContent::setContent('contact', 'banner', 'background_image', 'assets/contact-banner.jpg', 'image');
        
        // Contact Page Get in Touch Section
        PageContent::setContent('contact', 'get_in_touch', 'title', "Get in\ntouch");
        PageContent::setContent('contact', 'get_in_touch', 'form_title', 'Send a Message');
    }
}