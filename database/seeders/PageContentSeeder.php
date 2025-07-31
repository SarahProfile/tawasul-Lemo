<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PageContent;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Home Page Content
        $homeContent = [
            // Hero Section
            'hero' => [
                'title' => 'Book. Ride. Arrive in Luxury.',
                'image' => 'assets/travel-experience.png'
            ],
            // Features Section
            'features' => [
                'title' => 'How It Works'
            ],
            // Benefits Section
            'benefits' => [
                'title_line1' => 'Better Benefits',
                'title_line2' => 'For Tawasul Limousine'
            ],
            // Section 4 (Business Application)
            'section4' => [
                'title' => 'Apply And Start Reaping The Benefits Of Using Tawasul Limousine For business',
                'button_text' => 'Apply Now',
                'footer_text' => 'Rating Tawasul Limousine on Google Play and App Store',
                'background_image' => 'assets/section4-desktop.jpg',
                'logo' => 'assets/logo.png'
            ],
            // FAQ Section
            'faq' => [
                'title' => 'Frequently Asked Questions',
                'background_desktop' => 'assets/faq-desktop.jpg',
                'background_mobile' => 'assets/faq-mobile.jpg'
            ]
        ];

        foreach ($homeContent as $section => $data) {
            foreach ($data as $key => $value) {
                PageContent::setContent('home', $section, $key, $value, 
                    (strpos($key, 'image') !== false || strpos($key, 'logo') !== false) ? 'image' : 'text');
            }
        }

        // About Page Content
        $aboutContent = [
            // Hero Section
            'hero' => [
                'title' => 'Elevated Travel Experience',
                'subtitle' => 'Your Journey, Our Privilege',
                'description' => 'At Tawasul Limousine, we redefine luxury transportation with our commitment to excellence, comfort, and personalized service. Every journey with us is crafted to exceed your expectations.',
                'background_image' => 'assets/about-banner.jpg'
            ],
            // Company Section
            'company' => [
                'title' => 'About Our Company',
                'description' => 'Founded with a vision to provide unparalleled luxury transportation services, Tawasul Limousine has established itself as a leader in premium mobility solutions. Our commitment to excellence drives everything we do.',
                'image' => 'assets/about-company.jpg'
            ],
            // Values Section
            'values' => [
                'title' => 'Our Values',
                'excellence_title' => 'Excellence',
                'excellence_description' => 'We strive for perfection in every aspect of our service.',
                'reliability_title' => 'Reliability',
                'reliability_description' => 'Dependable service you can count on, every time.',
                'luxury_title' => 'Luxury',
                'luxury_description' => 'Premium comfort and sophistication in every journey.'
            ],
            // FAQ Section
            'faq' => [
                'title' => 'Frequently Asked Questions',
                'background_desktop' => 'assets/faq-desktop.jpg',
                'background_mobile' => 'assets/faq-mobile.jpg'
            ]
        ];

        foreach ($aboutContent as $section => $data) {
            foreach ($data as $key => $value) {
                PageContent::setContent('about', $section, $key, $value, 
                    (strpos($key, 'image') !== false) ? 'image' : 'text');
            }
        }

        // Services Page Content
        $servicesContent = [
            // Banner Section
            'banner' => [
                'title' => 'Setting a new standard in premium experience.',
                'description' => 'Tawasul Limousine presents a renewed range of vehicles designed to suit every occasion, from executive travel to everyday convenience. Each vehicle combines luxury, comfort, and intelligent technology to deliver a seamless, elevated experience that meets the highest standards of modern mobility.',
                'background_image' => 'assets/services-banner.jpg',
                'background_desktop' => 'assets/services-banner.jpg',
                'background_mobile' => 'assets/services-banner-mobile.jpg',
                'mobile_title' => 'Premium Experience',
                'mobile_description' => 'Luxury vehicles designed for every occasion, combining comfort and intelligent technology for an elevated travel experience.'
            ],
            // Looping Text
            'looping' => [
                'text' => 'Your Journey, Our Privilege',
                'icon' => 'assets/car-icon.png'
            ],
            // Service Selection Section
            'selection' => [
                'title' => 'Tailored luxury for every journey',
                'description_1' => 'At Tawasul Limousine, every vehicle in our fleet is chosen with purpose. Our Luxury Selection is crafted for moments that demand more than just transportation. These are vehicles where sophistication meets indulgence, ideal for formal occasions, executive transfers, or any instance where presence matters.',
                'description_2' => 'For everyday travel, our Day-to-Day Selection offers a seamless blend of comfort and elevated style, ensuring that routine journeys still feel refined. For clients with unique needs or preferences, additional premium models are available upon request, allowing us to deliver a truly bespoke experience.',
                'image' => 'assets/services-section2-left.jpg'
            ],
            // Fleet Excellence Section
            'fleet' => [
                'title' => 'Fleet of Excellence',
                'description' => 'What sets Tawasul Limousine apart is not just the elegance of its vehicles, but the thoughtfulness behind every option. Our fleet is meticulously curated to cater to diverse needs, whether it\'s the refined luxury of our high-end models or the elevated ease of our day-to-day selection. Each vehicle is maintained to the highest standards and equipped with advanced infotainment, smart safety systems, and discreet chauffeurs. For clients seeking something truly exceptional, bespoke premium models are available upon request, ensuring that no journey feels ordinary. At Tawasul, every ride is a reflection of precision, comfort, and class.',
                'background_image' => 'assets/services-section3-bg.jpg',
                'background_desktop' => 'assets/services-section3-bg.jpg',
                'background_mobile' => 'assets/services-section3-bg-mobile.jpg'
            ],
            // Luxury Vehicles Section
            'luxury_vehicles' => [
                'title' => 'Range of Luxury Vehicles',
                'image' => 'assets/luxury-vehicles-range.jpg'
            ],
            // Our Services Section
            'our_services' => [
                'title' => 'Our Services',
                'image' => 'assets/section5-image.jpg'
            ],
            // Technology Section
            'technology' => [
                'title' => 'Our Technology',
                'image' => 'assets/section6-image.jpg'
            ],
            // FAQ Section
            'faq' => [
                'title' => 'Frequently Asked Questions',
                'background_desktop' => 'assets/faq-desktop.jpg',
                'background_mobile' => 'assets/faq-mobile.jpg'
            ]
        ];

        foreach ($servicesContent as $section => $data) {
            foreach ($data as $key => $value) {
                PageContent::setContent('services', $section, $key, $value, 
                    (strpos($key, 'image') !== false) ? 'image' : 'text');
            }
        }

        // Contact Page Content
        $contactContent = [
            // Banner Section
            'banner' => [
                'background_image' => 'assets/contact-banner.jpg'
            ],
            // Get in Touch Section
            'get_in_touch' => [
                'title' => 'Get in touch',
                'form_title' => 'Send a Message'
            ],
            // FAQ Section
            'faq' => [
                'title' => 'Frequently Asked Questions',
                'background_desktop' => 'assets/faq-desktop.jpg',
                'background_mobile' => 'assets/faq-mobile.jpg'
            ]
        ];

        foreach ($contactContent as $section => $data) {
            foreach ($data as $key => $value) {
                PageContent::setContent('contact', $section, $key, $value, 
                    (strpos($key, 'image') !== false) ? 'image' : 'text');
            }
        }

        // Career Page Content
        $careerContent = [
            // Banner Section
            'banner' => [
                'background_image' => 'assets/career-banner.jpg'
            ],
            // Join Team Section
            'join_team' => [
                'title' => 'Join Our Team'
            ],
            // FAQ Section
            'faq' => [
                'title' => 'Frequently Asked Questions',
                'background_desktop' => 'assets/faq-desktop.jpg',
                'background_mobile' => 'assets/faq-mobile.jpg'
            ]
        ];

        foreach ($careerContent as $section => $data) {
            foreach ($data as $key => $value) {
                PageContent::setContent('career', $section, $key, $value, 
                    (strpos($key, 'image') !== false) ? 'image' : 'text');
            }
        }
    }
}
