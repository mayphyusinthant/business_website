<?php

namespace Modules\AdminModule\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Item;
use App\Models\Category;
use App\Models\User;
use Inertia\Inertia;

class AdminModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function panel(){
        $ItemCount = Item::count();
        $CategoryCount = Category::count();
        $UserCount = User::count();

        return Inertia::render('Admin/Panel', [
            "ItemCount" => $ItemCount,
            'CategoryCount' => $CategoryCount,
            'UserCount' => $UserCount,
        ]);
    }


    public function index()
    {
        return view('adminmodule::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adminmodule::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('adminmodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('adminmodule::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
