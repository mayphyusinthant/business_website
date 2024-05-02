<?php

namespace Modules\AdminModule\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;


class AdminItemController extends Controller
{   

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        // $cachedData = Cache::get('items'. $page);
        // if ($cachedData && isset($cachedData['items']) && isset($cachedData['categories'])) {
        //     //echo "Cache is working, retrieve items and categories from cache";
        //     return Inertia::render('Admin/Index', [
        //         "items" => $cachedData['items'],
        //         'categories' => $cachedData['categories'],
        //     ]);
        // } else {
        //echo "First attempt - no cache";

            $categories = Category::distinct('name')->pluck('name');
            $items = Item::with(['createdBy', 'updatedBy', 'category'])->paginate(10);
            $items->withQueryString();

            // // Cache the items for 60 minutes
            // Cache::put('items'. $page, [
            //     "items" => $items,
            //     'categories' => $categories,
            // ], 60);

            return Inertia::render('Admin/Index', [
                "items" => $items,
                'categories' => $categories,
            ]);
        // }
    }



    // Explore () function shows items / products owned by other users. 
    // public function explore()
    // {
    //     $categories = Item::distinct('category')->pluck('category');
         
    //     // Retrieve the current user
    //     $currentUser = Auth::user();
    //     // Retrieve items not owned by the current user
    //     $items = Item::whereNotIn('created_by', [$currentUser->id])->get()->load('user');
    //     return Inertia::render('Item/Explore', [
    //         "items" => $items,
    //         'categories' => $categories,

    //     ]);
    // }

    public function view(Request $request, $id){

        $item = Item::with('category')->find($id);
        if(!$item){
            return redirect("/items")->with('error', 'Item not found.');
        }

        $referrer = $request->headers->get('referer');
       
        return Inertia::render('Item/View', [
            'item' => $item,
            'referrer' => $referrer,
        ]);
    }


    public function filter(Request $request)
    {
        $categories = Category::distinct('name')->pluck('name');
        $category = $request->input('category');
        $cat = Category::where('name', $category)->first();


        $referrer = $request->headers->get('referer');

        if (strpos($referrer, '/admin') !== false) { 
            $items = Item::with(['user', 'category', 'createdBy', 'updatedBy'])->where('category', $cat->id)->paginate(10);
            $items->withQueryString();

            return Inertia::render('Admin/Index', [
                'items' => $items,
                'categories' => $categories,
                'filteredCategory' => $category,
            ]);
        }
        // else if (strpos($referrer, 'items/explore') !== false) { 
        //      // Retrieve the current user
        //     $currentUser = Auth::user();
        //     // Retrieve items not owned by the current user - and filter
        //     $items = Item::whereNotIn('created_by', [$currentUser->id])
        //             ->where('category', $category)
        //             ->get()
        //             ->load('user');
        //     return Inertia::render('Item/Explore', [
        //         'items' => $items,
        //         'categories' => $categories,
        //         'filteredCategory' => $category,
        //     ]);
        // }
        else{
            $currentUser = Auth::user();
            // Retrieve items  owned by the current user
            $items = Item::where('created_by', $currentUser->id)->get()->load('user');
            return Inertia::render('Item/Index', [
                'items' => $items,
                'categories' => $categories,
                'filteredCategory' => $category,
            ]);
        }
    }


    public function create(){
        $categories = Category::distinct('name')->pluck('id', 'name');

        {
            return Inertia::render('Item/Create', [
                'edit' => false,
                'categories' => $categories,
            ]);
        }
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string', 'max:255'],
        'category' => ['required', 'integer'],
        // 'medium' => ['required', 'string', 'max:255'],
        'size' => ['required'],
        'price' => ['required', 'integer'],
        'status' => ['required', 'string', 'max:255'],
        // 'photo' => ['required'],
        ]);

        if ($validator->fails()) {
            
            // If validation fails, return with errors
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $userId = Auth::id();
        // Validation passed, create the item
        $validatedData = $validator->validated();
        $validatedData['photo'] = '/storage/images/' .basename($request->input('photo'));
        $validatedData['size'] = $request->input('size');
        $validatedData['created_by'] = $userId;
        $validatedData['updated_by'] = $userId;

        Item::create($validatedData);
        return back(303)->with('status', 'recentlySuccessful');

        // $referrer = $request->headers->get('referer');
        // if (strpos($referrer, '/admin') !== false) {
        //     return  Redirect::route('admin.index')->with('success', 'New Item has been created successfully.');       
        // }else{
        //     return  Redirect::route('items.index')->with('success', 'New Item has been created successfully.');       
        // }
    }

    public function edit(Request $request, $id){
        $item = Item::find($id);
        $categories = Category::distinct('name')->pluck('id', 'name');

        if(!$item){
            return redirect("/items")->with('error', 'Item not found.');
        }

        // Retrieve the current user
        $currentUser = Auth::user();
        // Authorization Check
        // if ($item->owner !== $currentUser->id) {
        //     return "You are not allowed to edit. Only owner can edit.";
        // }

        return Inertia::render('Item/Create', [
            'edit' => true,
            'item' => $item,
            'categories' => $categories
        ]);
    }



    public function update(Request $request, $id)
    {

        // dd($request->input('img'));
        $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string', 'max:255'],
        'category' => ['required', 'integer'],
        'size' => ['required', 'string', 'max:255'],
        // 'medium' => ['required', 'string', 'max:255'],
        'price' => ['required', 'integer'],
        'status' => ['required', 'string', 'max:255'],
    ]);

    if ($validator->fails()) {
        // If validation fails, return with errors
        throw ValidationException::withMessages($validator->errors()->toArray());
    }

    // Retrieve the current user
    $currentUser = Auth::user();
    

    if($validator->validated()){
        
        $item = Item::find($id);
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->category = $request->input('category');
        $item->size = $request->input('size');
        // $item->medium = $request->input('medium');
        $item->price = $request->input('price');
        $item->status = $request->input('status');
        // $item->img = '/storage/images/' .basename($request->input('img'));

        $item->save();
        return back(303)->with('status', 'recentlySuccessful');

        // Redirect or render as needed
        // $referrer = $request->headers->get('referer');
        // if (strpos($referrer, '/admin') !== false) {
        //     return  Redirect::route('admin.index')->with('success', 'Item has been updated successfully.');
        // }
        // else{
        //     return  Redirect::route('items.index')->with('success', 'Item has been updated successfully.');
        // }
        
    }
    }

    public function photoUpdate(Request $request, $id)
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
            $item = Item::find($id);
            $item->img = implode(',', $paths);
            $item->updated_by = $userId;
            $item->save();
            return back(303)->with('status', 'recentlySuccessful');

        }
    }
    
    public function delete(Request $request, $id){
        $item = Item::find($id);
        if(!$item){
            return back(303)->with('status', 'notFound');
        }
        else{
            $item->delete();
            session()->flash('flash.banner', 'Deleted Item Successfully .  ✔');
            session()->flash('flash.bannerStyle', 'success');
            return Redirect::back();
            }
        }
    }

