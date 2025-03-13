<?php

namespace App\Http\Controllers\cms;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductBundle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProductBundleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['bundles']    =   ProductBundle::with('products')->get();

        return view('cms.bundles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['object']         =   new ProductBundle();
        $data['method']         =   'POST';
        $data['url']            =   route('bundle.store');
        $data['products']       =   Product::where('publish_type','publish')->pluck('name','id')->toArray();

        return view('cms.bundles.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string',
            'description'       => 'required|string',
            'sale_price'        => 'required|numeric',
            'products'          => 'required|array|min:2|max:4',
        ]);

        $bundle                 =       new ProductBundle();
        $bundle->name           =       $request->name;
        $bundle->description    =       $request->description;
        $bundle->sale_price     =       $request->sale_price;
        $bundle->mrp_price      =       $request->mrp_price;
        $bundle->publish_type   =       'publish';
        $bundle->save();


        $bundle->products()->attach($request->products);

        $data['message']        =   auth()->user()->name . " has created $bundle->name";
        $data['action']         =   "created";
        $data['module']         =   "product bundle";
        $data['object']         =   $bundle;
        saveLogs($data);
        Session::flash("success", "Bundle created successfully");
        return redirect(route("bundle.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['object']         =   ProductBundle::find($id);
        if(empty($data['object']))
        {
            Session::flash('error','Data not found');
            return back();
        }
        $data['method']         =   'PUT';
        $data['url']            =   route('bundle.update',['bundle'=>$id]);
        $data['products']       =   Product::where('publish_type','publish')->pluck('name','id')->toArray();

        return view('cms.bundles.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'              => 'required|string',
            'description'       => 'required|string',
            'sale_price'        => 'required|numeric'
        ]);

        $bundle                 =       ProductBundle::find($id);
        if(empty($bundle))
        {
            Session::flash('error','Data not found');
            return back();
        }
        $bundle->name           =       $request->name;
        $bundle->description    =       $request->description;
        $bundle->sale_price     =       $request->sale_price;
        $bundle->mrp_price      =       $request->mrp_price;
        $bundle->publish_type   =       $request->publish_type;
        $bundle->update();

        $data['message']        =   auth()->user()->name . " has updated $bundle->name";
        $data['action']         =   "updated";
        $data['module']         =   "product bundle";
        $data['object']         =   $bundle;
        saveLogs($data);
        Session::flash("success", "Bundle updated successfully");
        return redirect(route("bundle.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
