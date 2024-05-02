<?php

namespace Modules\FrontendModule\App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cache;


class ItemApiController extends Controller
{
    public function index(Request $request)
{
    $page = $request->input('page', 1);
    $cachedItems = Cache::get('items_List' . $page);

    if ($cachedItems && !isset($cachedItems['filteredCategory'])) {
        // Cache is working, return cached items
        return Response::json($cachedItems);
    } else {
        // Cache is not available or filtered, fetch items from database
        $category = $request->query('category');
        $categories = Category::distinct('name')->pluck('name');
        //$items = Item::with('user')->paginate(3);
        $items = Item::with(['createdBy', 'updatedBy', 'category'])->paginate(12);

        $items->withQueryString();

        // Cache the items for 60 minutes, including the page number in the cache key
        Cache::put('items_List' . $page, [
            "items" => $items,
            'categories' => $categories,
        ], 60);

        return Response::json([
            "items" => $items,
            'categories' => $categories,
        ]);
    }
}

    

    public function filter(Request $request)
    {
                //echo $request->input('category');
                // Retrieve filter criteria from the request body
                $category = $request->input('category');
                $cat = Category::where('name', $category)->first();

                //dd($cat->id);
                // Query items based on the filter criteria
                $items = Item::with(['user', 'category'])->where('category', $cat->id)->paginate(12);

                $categories = Category::distinct('name')->pluck('name');

                 // Cache the items for 60 minutes
                Cache::put('items', [
                    "items" => $items,
                    'categories' => $categories,
                    'filteredCategory' => $category,
                ], 60);

                // Show the value of the parameter
                return Response::json([
                    "items" => $items,
                    'categories' => $categories,
                    'filteredCategory' => $category,
                ]); 
        
    }

    public function search(Request $request)
    {
        // Retrieve search data from the request body
        $itemName = $request->input('itemName');

        // Query items based on the filter criteria
        $items = Item::with(['user'])->where('name', 'LIKE', '%' . $itemName . '%')->paginate(12);
        $categories = Item::distinct('category')->pluck('category');

        // Show the value of the parameter
        return response()->json([
            "items" => $items,
            'categories' => $categories,
        ]);
    }

}
