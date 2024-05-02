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


class AdminCategoryController extends Controller
{   

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $catTypes = Category::distinct('name')->pluck('name');

        // $cachedData = Cache::get('categories'. $page);
        // if ($cachedData && isset($cachedData['categories']) && isset($cachedData['categories'])) {
        //     //echo "Cache is working, retrieve items and categories from cache";
        //     return Inertia::render('Admin/Category/Index', [
        //         'categories' => $cachedData['categories'],
        //     ]);
        // } else {
        //echo "First attempt - no cache";

            $categories = Category::with(['createdBy', 'updatedBy'])->paginate(10);
            $categories->withQueryString();

            // Cache the items for 60 minutes
            Cache::put('categories'. $page, [
                'categories' => $categories,
            ], 60);

            return Inertia::render('Admin/Category/Index', [
                'categories' => $categories,
                'catTypes' => $catTypes,
            ]);
        //}
    }


    public function view($id){

        $category = Category::with(['createdBy', 'updatedBy'])->find($id);
        if(!$category){
            return redirect("/Admin/Category")->with('error', 'Item not found.');
        }

       
        return Inertia::render('Admin/Category/View', [
            'category' => $category,
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
        {
            return Inertia::render('Admin/Category/Create', [
                'edit' => false,

            ]);
        }
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string', 'max:255'],
        'status' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            
            // If validation fails, return with errors
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $userId = Auth::id();
        // Validation passed, create the item
        $validatedData = $validator->validated();
        $validatedData['created_by'] = $userId;
        $validatedData['updated_by'] = $userId;

        Category::create($validatedData);
        return back(303)->with('status', 'recentlySuccessful');

        //return  Redirect::route('admin.category.index')->with('success', 'New Category has been created successfully.');       

    }

    public function edit(Request $request, $id){
        $category = Category::find($id);
        //$categories = Category::distinct('name')->pluck('id', 'name');

        if(!$category){
            return redirect("admin/category")->with('error', 'Category not found.');
        }

        // Retrieve the current user
        $currentUser = Auth::user();
        // Authorization Check
        // if ($item->owner !== $currentUser->id) {
        //     return "You are not allowed to edit. Only owner can edit.";
        // }

        return Inertia::render('Admin/Category/Create', [
            'edit' => true,
            'category' => $category,
        ]);
    }



    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string', 'max:255'],
        'status' => ['required', 'string', 'max:255'],
    ]);

    if ($validator->fails()) {
        // If validation fails, return with errors
        throw ValidationException::withMessages($validator->errors()->toArray());
    }

    // Retrieve the current user
    $currentUser = Auth::user();
    

    if($validator->validated()){
        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->status = $request->input('status');

        $category->save();
        // Redirect or render as needed
        // $referrer = $request->headers->get('referer');
        // return  Redirect::route('admin.category.index')->with('success', 'Item has been updated successfully.');
        return back(303)->with('status', 'recentlySuccessful');

    }
    
    }

    public function delete(Request $request, $id){
        $category = Category::find($id);
        $item = Item::where('category', $id)->get();
        $itemExists = $item->count() !== 0;
        if(!$category){
            return Redirect::route('admin.category.index')->with('error', 'Category not found.');
        }
        else if($itemExists){
            // return Redirect::back()->with('error', 'You cannot delete this category. You will need to delete all products related to this category first.');
            session()->flash('flash.banner', 'You cannot delete this category. You will need to delete all products related to this category first.');
            session()->flash('flash.bannerStyle', 'danger');
            return Redirect::back();
        }
        else{
            $category->delete();
            session()->flash('flash.banner', 'Deleted Category Successfully .  ✔');
            session()->flash('flash.bannerStyle', 'success');
            return Redirect::back();
        }
    }
}
