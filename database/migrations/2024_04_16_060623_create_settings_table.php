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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_name', 250)->nullable();
            $table->text('site_motto')->nullable();
            $table->string('site_favicon', 255)->nullable();
            $table->string('site_logo_white', 255)->nullable();
            $table->string('site_logo_black', 255)->nullable();

            $table->string('contact_email', 100)->nullable();
            $table->string('support_email', 100)->nullable();
            $table->string('info_email', 100)->nullable();
            $table->string('sales_email', 100)->nullable();
            $table->string('primary_phone', 20)->nullable();
            $table->string('alternative_phone', 20)->nullable();
            $table->string('whatsapp_number', 20)->nullable();
            $table->string('default_language', 50)->nullable();
            $table->text('address_line_one')->nullable();
            $table->text('address_line_two')->nullable();

            $table->text('copyright_title')->nullable();
            $table->text('copyright_url')->nullable();

            $table->string('site_title', 250)->nullable();
            $table->text('site_url')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('google_analytics')->nullable();
            $table->text('google_adsense')->nullable();

            $table->boolean('maintenance_mode')->default(false);
            $table->string('company_name')->nullable();
            $table->string('system_timezone')->nullable(); // assuming timezone is a html text like 'UTC', 'EST', etc valueeee, select option

            $table->text('website_url')->nullable();
            $table->text('facebook_url')->nullable();
            $table->text('instagram_url')->nullable();
            $table->text('linkedin_url')->nullable();
            $table->text('whatsapp_url')->nullable();
            $table->text('twitter_url')->nullable();
            $table->text('youtube_url')->nullable();
            $table->text('pinterest_url')->nullable();
            $table->text('reddit_url')->nullable();
            $table->text('tumblr_url')->nullable();
            $table->text('tiktok_url')->nullable();

            $table->string('start_time_monday',150)->nullable();
            $table->string('monday',150)->nullable();
            $table->string('end_time_monday',150)->nullable();
            $table->string('start_time_tuesday',150)->nullable();
            $table->string('tuesday',150)->nullable();
            $table->string('end_time_tuesday',150)->nullable();
            $table->string('start_time_wednesday',150)->nullable();
            $table->string('wednesday',150)->nullable();
            $table->string('end_time_wednesday',150)->nullable();
            $table->string('start_time_thursday',150)->nullable();
            $table->string('thursday',150)->nullable();
            $table->string('end_time_thursday',150)->nullable();
            $table->string('start_time_friday',150)->nullable();
            $table->string('friday',150)->nullable();
            $table->string('end_time_friday',150)->nullable();
            $table->string('start_time_saturday',150)->nullable();
            $table->string('saturday',150)->nullable();
            $table->string('end_time_saturday',150)->nullable();
            $table->string('start_time_sunday',150)->nullable();
            $table->string('sunday',150)->nullable();
            $table->string('end_time_sunday',150)->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};


//$table->string('currency', 10)->default('USD');
//$table->string('timezone', 50)->default('UTC');
//$table->integer('pagination_count')->default(15);
//$table->string('analytics_code', 255)->nullable();
//$table->string('google_maps_key', 255)->nullable();
//$table->string('recaptcha_site_key', 255)->nullable();
//$table->string('recaptcha_secret_key', 255)->nullable();
