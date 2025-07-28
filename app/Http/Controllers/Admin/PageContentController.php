<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageContent;
use Illuminate\Support\Facades\Storage;

class PageContentController extends Controller
{
    public function index()
    {
        $pages = ['home', 'about', 'services', 'career', 'contact'];
        $contents = PageContent::all()->groupBy('page');
        
        return view('admin.content.index', compact('pages', 'contents'));
    }

    public function edit($page)
    {
        $contents = PageContent::where('page', $page)
                              ->orderBy('section')
                              ->orderBy('key')
                              ->get()
                              ->groupBy('section');
        
        return view('admin.content.edit', compact('page', 'contents'));
    }

    public function update(Request $request, $page)
    {
        $contents = $request->input('content', []);
        
        // Handle text content updates
        foreach ($contents as $section => $sectionData) {
            foreach ($sectionData as $key => $value) {
                PageContent::setContent($page, $section, $key, $value, 'text');
            }
        }
        
        // Handle image uploads separately
        $images = $request->file('images', []);
        foreach ($images as $section => $sectionImages) {
            foreach ($sectionImages as $key => $file) {
                if ($file && $file->isValid()) {
                    // Generate unique filename
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    // Move file to public/assets directory
                    $file->move(public_path('assets'), $filename);
                    
                    // Update database with new image path
                    PageContent::setContent($page, $section, $key, 'assets/' . $filename, 'image');
                }
            }
        }

        return redirect()->route('admin.content.edit', $page)
                        ->with('success', 'Content updated successfully!');
    }
}
