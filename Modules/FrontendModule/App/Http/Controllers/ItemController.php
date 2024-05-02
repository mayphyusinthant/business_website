<?php

namespace Modules\FrontendModule\App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
class ItemController extends Controller
{
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

    public function index()
    {
        $categories = Category::distinct('name')->pluck('name');
         
        // Retrieve the current user
        $currentUser = Auth::user();
        // Retrieve items  owned by the current user
        //$items = Item::where('created_by', $currentUser->id)->get()->load('user');
        $items = Item::with(['createdBy', 'updatedBy', 'category'])->paginate(12);
        $items->withQueryString();

        return Inertia::render('Item/Index', [
            "items" => $items,
            'categories' => $categories,

        ]);
    }

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
            $items = Item::with('user')->where('category', $cat->id)->paginate(12);
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


    public function create()
    {
        return Inertia::render('Item/Create', [
            'edit' => false,
        ]);
    }

    public function store(Request $request) {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string', 'max:255'],
        'category' => ['required', 'integer'],
        'medium' => ['required', 'string', 'max:255'],
        'size' => ['required'],
        'price' => ['required', 'integer'],
        'status' => ['required', 'string', 'max:255'],
        'img' => ['required'],
        ]);

        if ($validator->fails()) {
            
            // If validation fails, return with errors
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $userId = Auth::id();
        // Validation passed, create the item
        $validatedData = $validator->validated();
        $validatedData['img'] = 'images/' .basename($request->input('img'));
        $validatedData['size'] = $request->input('size');
        $validatedData['created_by'] = $userId;
        $validatedData['updated_by'] = $userId;

        Item::create($validatedData);

        $referrer = $request->headers->get('referer');
        if (strpos($referrer, '/admin') !== false) {
            return  Redirect::route('admin.index')->with('success', 'New Item has been created successfully.');       
        }else{
            return  Redirect::route('items.index')->with('success', 'New Item has been created successfully.');       
        }
    }

    public function edit(Request $request, $id){
        $categories = Category::distinct('name')->pluck('id', 'name');

        $item = Item::find($id);
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
        ]);
    }



    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string', 'max:255'],
        'category' => ['required', 'integer'],
        'size' => ['required', 'string', 'max:255'],
        'medium' => ['required', 'string', 'max:255'],
        'price' => ['required', 'integer'],
        'status' => ['required', 'string', 'max:255'],
        'img' => ['required']
    ]);

    if ($validator->fails()) {
        // If validation fails, return with errors
        throw ValidationException::withMessages($validator->errors()->toArray());
    }

    // Retrieve the current user
    $currentUser = Auth::user();
    
    $userId = Auth::id();

    if($validator->validated()){
        $item = Item::find($id);
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->category = $request->input('category');
        $item->size = $request->input('size');
        $item->medium = $request->input('medium');
        $item->price = $request->input('price');
        $item->status = $request->input('status');
        $item->img = 'images/' .basename($request->input('img'));
        $item->updated_by = $userId;
        // Authorization Check
        // if ($item->created_by !== $currentUser->id) {
        //     return "You are not allowed to update. Only owner can update.";;
        // }else{
        //     $item->save();
        //     // Redirect or render as needed
        //     $referrer = $request->headers->get('referer');
        //     if (strpos($referrer, '/admin') !== false) {
        //         return  Redirect::route('admin.index')->with('success', 'Item has been updated successfully.');
        //     }
        //     else{
        //         return  Redirect::route('items.index')->with('success', 'Item has been updated successfully.');
        //     }
        // }
        $item->save();
        // Redirect or render as needed
        $referrer = $request->headers->get('referer');
        if (strpos($referrer, '/admin') !== false) {
            return  Redirect::route('admin.index')->with('success', 'Item has been updated successfully.');
        }
        else{
            return  Redirect::route('items.index')->with('success', 'Item has been updated successfully.');
        }
    }
    
    }

    public function delete(Request $request, $id){
        $item = Item::find($id);
        if(!$item){
            return redirect("/items")->with('error', 'Item not found.');
        }
        else{
            // Retrieve the current user
            $currentUser = Auth::user();
            // Authorization Check
            if ($item->created_by !== $currentUser->id) {
                return "You are not allowed to delete. Only owner can delete.";
            }
            else{
                $item->delete();
                $referrer = $request->headers->get('referer');
                if (strpos($referrer, '/admin') !== false) {
                    return  redirect("/admin/items")->with('success', 'Item has been deleted successfully.');
                }else{
                    return  redirect("/items")->with('success', 'Item has been deleted successfully.');
                }
            }
        }
    }
}
