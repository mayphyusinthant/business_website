<?php

namespace Modules\FrontendModule\App\Http\Controllers;

use App\Models\CompanySetting;
use App\Models\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CompanySettingController extends Controller
{
    public function dashboard()
    {
        $companySettings = CompanySetting::all();
        $categories = Category::distinct('name')->pluck('name');

        return Inertia::render('Dashboard', [
            "companySettings" => $companySettings,
            "categories" => $categories,
        ]);
    }

    public function aboutus()
    {
        $companySettings = CompanySetting::all();
        $categories = Category::distinct('name')->pluck('name');

        return Inertia::render('About', [
            "companySettings" => $companySettings,
            "categories" => $categories,

        ]);    
    }

    public function viewCompanySetting()
    {
        $companySettings = CompanySetting::all();

        return Inertia::render('Admin/Company_Setting/View', [
            "companySettings" => $companySettings,
        ]);    }


    public function editCompanySetting()
    {
        $companySettings = CompanySetting::all();

        return Inertia::render('Admin/Company_Setting/Edit', [
            "companySettings" => $companySettings,
        ]); 
    }


    public function storeCompanySetting(Request $request)
    {
        {
            $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'img' => ['required', 'string', 'max:255'],
            'info' => ['required', 'string'],
            'service' => ['required', 'string'],
            'info_mm' => ['required', 'string'],
            'service_mm' => ['required', 'string'],
            'phone' => ['required'],
            'email' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'location_point' => ['required', 'string'],
            'open_hour' => ['required', 'date_format:H:i:s'], 
            'close_hour' => ['required',  'date_format:H:i:s'],
            'close_day' => ['required', 'string', 'max:255']
        ]);
    }
    
        if ($validator->fails()) {
            // If validation fails, return with errors
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
    
        // Retrieve the current user
        $currentUser = Auth::user();
        
        $userId = Auth::id();
    
        if($validator->validated()){
            $companySettings = CompanySetting::find(1);
            $companySettings->company_name = $request->input('name');
            $companySettings->company_info = $request->input('info');
            $companySettings->service_info = $request->input('service');
            $companySettings->company_info_mm = $request->input('info_mm');
            $companySettings->service_info_mm = $request->input('service_mm');
            $companySettings->phone_number = $request->input('phone');
            $companySettings->email = $request->input('email');
            $companySettings->address = $request->input('address');
            $companySettings->facebook_page = $request->input('facebook_page');
            $companySettings->location_point = $request->input('location_point');
            $companySettings->open_hour = $request->input('open_hour');
            $companySettings->close_hour = $request->input('close_hour');
            $companySettings->close_day = $request->input('close_day');
            $companySettings->company_logo = 'images/' .basename($request->input('img'));
            $companySettings->updated_by = $userId;
            
            $companySettings->save();
        }
        return redirect()->route('company_setting.view')
            ->with('success', 'Company setting created successfully.');
    }


    public function uploadPhotos()
    {
        $companySettings = CompanySetting::all();

        return Inertia::render('Admin/Company_Setting/Photos/Edit', [
            "companySettings" => $companySettings,
        ]); 
    }

    public function storeuploadPhotos1(Request $request)
    {
        {
            $validator = Validator::make($request->all(), [
                'photo' => ['required'],
            ]);
        }
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
        
        if($validator->validated()){
            $currentUser = Auth::user();
            $userId = Auth::id();

            // dd($request->file('photo'));
            foreach ($request->file('photo') as $file) {
                $path = $file->store('images', 'public');
                $paths[] = "/storage/" . $path;
            }
            $companySettings = CompanySetting::find(1);
            $companySettings->gallery1_photos = implode(',', $paths);
            $companySettings->updated_by = $userId;
            $companySettings->save();
            // return redirect()->route('company_setting.view')
            // ->with('success', 'Company setting created successfully.');
            session()->flash('flash.banner', 'Photos for Home Page Top Section - Uploaded Successfully  ✔');
            session()->flash('flash.bannerStyle', 'success');
            return Redirect::back();
        }
    }

    public function storeuploadPhotos2(Request $request)
    {
        {
            $validator = Validator::make($request->all(), [
                'photo' => ['required'],
            ]);
        }
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
        
        if($validator->validated()){
            $currentUser = Auth::user();
            $userId = Auth::id();

            // dd($request->file('photo'));
            foreach ($request->file('photo') as $file) {
                $path = $file->store('images', 'public');
                $paths[] = "/storage/" . $path;
            }
            $companySettings = CompanySetting::find(1);
            $companySettings->gallery2_photos = implode(',', $paths);
            $companySettings->updated_by = $userId;
            $companySettings->save();
            // return redirect()->route('company_setting.view')
            // ->with('success', 'Company setting created successfully.');
            session()->flash('flash.banner', 'Photos for Home Page Bottom Section - Uploaded Successfully  ✔');
            session()->flash('flash.bannerStyle', 'success');
            return Redirect::back();
        }
    }
}

