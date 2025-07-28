<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page')->index(); // home, about, services, career, contact
            $table->string('section')->index(); // section1, section2, etc.
            $table->string('key')->index(); // title, content, image, etc.
            $table->text('value'); // the actual content
            $table->string('type')->default('text'); // text, image, textarea
            $table->timestamps();
            
            $table->unique(['page', 'section', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
