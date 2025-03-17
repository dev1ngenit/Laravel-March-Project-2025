<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.setting.index', ['setting' => Setting::first()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function updateOrcreateSetting(Request $request)
    {

        try {
            $webSetting = Setting::firstOrNew([]);

            $files = [
                'site_favicon'    => $request->file('site_favicon'),
                'site_logo_white' => $request->file('site_logo_white'),
                'site_logo_black' => $request->file('site_logo_black'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (! empty($file)) {
                    $filePath = 'webSetting/' . $key;
                    $oldFile  = $webSetting->$key ?? null;

                    if ($oldFile) {
                        Storage::delete("public/" . $oldFile);
                    }
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // dd();
            $setting = Setting::updateOrCreate([], [
                'website_name'         => $request->website_name,
                'site_motto'           => $request->site_motto,
                'site_favicon'         => $uploadedFiles['site_favicon']['status'] == 1 ? $uploadedFiles['site_favicon']['file_path'] : $webSetting->site_favicon,
                'site_logo_white'      => $uploadedFiles['site_logo_white']['status'] == 1 ? $uploadedFiles['site_logo_white']['file_path'] : $webSetting->site_logo_white,
                'site_logo_black'      => $uploadedFiles['site_logo_black']['status'] == 1 ? $uploadedFiles['site_logo_black']['file_path'] : $webSetting->site_logo_black,
                'contact_email'        => $request->contact_email,
                'support_email'        => $request->support_email,
                'info_email'           => $request->info_email,
                'sales_email'          => $request->sales_email,
                'primary_phone'        => $request->primary_phone,
                'alternative_phone'    => $request->alternative_phone,
                'whatsapp_number'      => $request->whatsapp_number,
                'default_language'     => $request->default_language,
                'address_line_one'     => $request->address_line_one,
                'address_line_two'     => $request->address_line_two,
                'copyright_title'      => $request->copyright_title,
                'copyright_url'        => $request->copyright_url,
                'site_title'           => $request->site_title,
                'site_url'             => $request->site_url,
                'meta_keyword'         => $request->meta_keyword,
                'meta_description'     => $request->meta_description,
                'google_analytics'     => $request->google_analytics,
                'google_adsense'       => $request->google_adsense,
                'maintenance_mode'     => $request->maintenance_mode ?? '0',
                'company_name'         => $request->company_name,
                'system_timezone'      => $request->system_timezone,
                'website_url'          => $request->website_url,
                'facebook_url'         => $request->facebook_url,
                'instagram_url'        => $request->instagram_url,
                'linkedin_url'         => $request->linkedin_url,
                'whatsapp_url'         => $request->whatsapp_url,
                'twitter_url'          => $request->twitter_url,
                'youtube_url'          => $request->youtube_url,
                'pinterest_url'        => $request->pinterest_url,
                'reddit_url'           => $request->reddit_url,
                'tumblr_url'           => $request->tumblr_url,
                'tiktok_url'           => $request->tiktok_url,

                'start_time_monday'    => $request->start_time_monday,
                'monday'               => $request->monday,
                'end_time_monday'      => $request->end_time_monday,
                'start_time_tuesday'   => $request->start_time_tuesday,
                'tuesday'              => $request->tuesday,
                'end_time_tuesday'     => $request->end_time_tuesday,
                'start_time_wednesday' => $request->start_time_wednesday,
                'wednesday'            => $request->wednesday,
                'end_time_wednesday'   => $request->end_time_wednesday,
                'start_time_thursday'  => $request->start_time_thursday,
                'thursday'             => $request->thursday,
                'end_time_thursday'    => $request->end_time_thursday,
                'start_time_friday'    => $request->start_time_friday,
                'friday'               => $request->friday,
                'end_time_friday'      => $request->end_time_friday,
                'start_time_saturday'  => $request->start_time_saturday,
                'saturday'             => $request->saturday,
                'end_time_saturday'    => $request->end_time_saturday,
                'start_time_sunday'    => $request->start_time_sunday,
                'sunday'               => $request->sunday,
                'end_time_sunday'      => $request->end_time_sunday,

            ]);

            // $setting = Setting::updateOrCreate([], $dataToUpdateOrCreate);

            $toastrMessage = $setting->wasRecentlyCreated ? 'Setting created successfully' : 'Setting updated successfully';

            return redirect()->back()->with('success', $toastrMessage);
        } catch (\Exception $e) {
            Session::flash('error', [$messages = $e->getMessage()]);
            return redirect()->back()->with('error', [$messages = $e->getMessage()]);
        }
    }
}
