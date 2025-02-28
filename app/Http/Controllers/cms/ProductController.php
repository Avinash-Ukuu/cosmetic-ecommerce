<?php

namespace App\Http\Controllers\cms;

use DB;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view',new Product());
        if ($request->ajax()) {

            $data               =    Product::with(['productImages','category','brand'])->select('*');

            if ($request->order == null) {
                $data           =   $data->orderBy('product_created_at', 'desc');
            }

            return DataTables::of($data)
                ->filterColumn('product', function($query, $keyword) {
                    $sql = "products.name LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('product', function ($data) {
                    if(!empty($data->productImages) && $data->productImages->isNotEmpty())
                    {
                        if(file_exists("uploads/products/" . $data->id."/".$data->productImages->first()->url))
                        {
                            $image   =   asset('uploads/products/'.$data->id.'/'.$data->productImages->first()->url);
                        }else{
                            $image   =   asset('images/product-default.jpg');
                        }
                        return '<img class="mr-2" src="' . $image . '" width="50"/> ' . $data->name;
                    }
                    else{
                        $image   =   asset('images/product-default.jpg');
                        return '<img class="mr-2" src="' . $image . '" width="50"/> ' . $data->name;
                    }
                })
                ->editColumn('publish_type',function($data){
                    return '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input"
                                    ' . ($data->publish_type == 'publish' ? 'checked' : '') . '
                                    onchange="isPublishAction(' . $data->id . ', this)"
                                    id="customActiveSwitch' . $data->id . '">
                                <label class="custom-control-label" for="customActiveSwitch' . $data->id . '"></label>
                            </div>';
                })
                ->addColumn('category', function ($data) {
                    return $data->category->name;
                })
                ->editColumn('sale_price', function ($data) {
                    return 'AED ' . $data->sale_price;
                })
                ->editColumn('mrp_price', function ($data) {
                    return !empty($data->mrp_price) ? 'AED ' . $data->mrp_price : 'N/A';
                })
                ->editColumn('brand', function ($data) {
                    return  $data->brand->name ?? 'N/A';
                })
                ->editColumn('info', function ($data) {
                    $aboutUrl = route('product.show', ['product' => $data->id]);
                    return '<a href="' . $aboutUrl . '"><i class="fa fa-info-circle"></i></a>';
                })
                ->addColumn('action', function ($data) {

                        $editUrl = route('product.edit', ['product' => $data->id]);
                        $deleteUrl = route('product.destroy', ['product' => $data->id]);
                        $btn = '<div class="row">';
                        $btn .= '<a href="' . $editUrl . '"><i class="fa fa-edit"></i></a>';
                        if (isset(auth()->user()->super_admin)) {
                            $btn .= '<a style="cursor: pointer;" onclick="deleteItem(\'' . $deleteUrl . '\')">
                                        <i class="fa fa-trash text-danger ml-2"></i>
                                    </a>';
                        }
                        $btn .= '</div>';
                        return $btn;

                })
                ->rawColumns(['product','mrp_price','sale_price','publish_type' ,'category' ,'info','action'])
                ->make(true);
        }

        return view('cms.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product                    =       new Product();
        $this->authorize('create',$product);

        $data['object']             =       $product;
        $data['method']             =       'POST';
        $data['url']                =       route('product.store');
        $data['categories']         =       Category::where('is_active',1)->pluck('name','id')->toArray();
        $data['brands']             =       Brand::where('is_active',1)->pluck('name','id')->toArray();

        return view('cms.product.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product                =       new Product();
        $this->authorize('create',$product);

        $product                    =       $product;
        $product->category_id       =       $request->category_id;
        $product->name              =       $request->name;
        $product->slug              =       Str::slug($request->name);
        $product->description       =       $request->description;
        $product->mrp_price         =       $request->mrp_price;
        $product->price_without_tax =       $request->price_without_tax;
        $product->tax               =       $request->tax;
        $product->sale_price        =       $request->sale_price;
        $product->weight            =       $request->weight;
        $product->quantity          =       $request->quantity;
        // $product->unit              =       $request->unit;
        $product->brand_id          =       $request->brand_id;
        $product->publish_type      =       'publish';
        $product->product_created_at=       now();
        $product->save();

        if($request->has('images'))
        {
            foreach($request->file('images') as $index => $image)
            {
                $productImage                   =       new ProductImage();
                $productImage->product_id       =       $product->id;

                $imageName                      =       "product_" . $product->id . '_' . $product->brand_id . '_' . ($index+1) . '_'. Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products/'.$product->id.'/'), $imageName);
                $productImage->url              =       $imageName;
                $productImage->save();
            }
        }

        $data['message']        =   auth()->user()->name . " has created $product->name";
        $data['action']         =   "created";
        $data['module']         =   "product";
        $data['object']         =   $product;
        saveLogs($data);
        Session::flash("success", "Product Created");
        return redirect(route("product.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(!auth()->user()->hasRole('admin'),403);

        $data['product']        =   Product::find($id);

        if(empty($data['product']))
        {
            Session::flash('error','Data not found');

            return back();
        }

        return view('cms.product.detail',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update',new Product());

        $data['object']         =       Product::with(['productImages','category','brand' ])->where('id',$id)->first();

        if(empty($data['object']))
        {
            Session::flash('error','Data not found');

            return redirect(route('product.index'));
        }
        $data['method']             =       'PUT';
        $data['url']                =       route('product.update',['product'=>$id]);
        $data['categories']         =       Category::where('is_active',1)->pluck('name','id')->toArray();
        $data['brands']             =       Brand::where('is_active',1)->pluck('name','id')->toArray();

        return view('cms.product.form',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $this->authorize('update',new Product());

        $product                    =       Product::find($id);
        if(empty($product))
        {
            Session::flash('error','Data not found');

            return  redirect(route('product.index'));
        }
        $product->category_id       =       $request->category_id;
        $product->name              =       $request->name;
        $product->slug              =       Str::slug($request->name);
        $product->description       =       $request->description;
        $product->mrp_price         =       $request->mrp_price;
        $product->price_without_tax =       $request->price_without_tax;
        $product->tax               =       $request->tax;
        $product->sale_price        =       $request->sale_price;
        $product->quantity          =       $request->quantity;
        // $product->unit              =       $request->unit;
        $product->weight            =       $request->weight;
        $product->brand_id          =       $request->brand_id;
        $product->update();

        if($request->has('images'))
        {
            foreach($request->file('images') as $index => $image)
            {
                $imageName          =       "product_" . $product->id . '_' . $product->brand_id . '_' . ($index+1) . '_'. Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();
                $existingImage      =       ProductImage::where('product_id', $product->id)->where('url', $imageName)->first();

                if ($existingImage) {
                    continue;
                }

                $productImage                   =       new ProductImage();
                $productImage->product_id       =       $product->id;

                $image->move(public_path('uploads/products/'.$product->id.'/'), $imageName);
                $productImage->url              =       $imageName;
                $productImage->save();
            }
        }

        $data['message']        =   auth()->user()->name . " has updated $product->name";
        $data['action']         =   "updated";
        $data['module']         =   "product";
        $data['object']         =   $product;
        saveLogs($data);

        Session::flash("success", "Product Updated");
        return redirect(route("product.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(!auth()->user()->super_admin,  403);

        $product                =       Product::find($id);
        if(empty($product))
        {
            Session::flash('error','Data not found');

            return  redirect(route('product.index'));
        }

        $data['message']        =   auth()->user()->name . " has deleted $product->name";
        $data['action']         =   "deleted";
        $data['module']         =   "product";
        $data['object']         =   $product;
        saveLogs($data);

        if($product->productImages->isNotEmpty())
        {
            foreach($product->productImages as $image)
            {
                if (file_exists("uploads/products/" . $product->id ."/".$image->url)) {
                    File::delete("uploads/products/" . $product->id ."/".$image->url);
                }
                $image->delete();
            }
        }


        $product->delete();

        Session::flash("success", "Product Deleted");
        return response()->json(['success' => '200', 'message' => 'Data Deleted']);
    }

    public function lowProduct(Request $request)
    {
        if ($request->ajax()) {
            $data               =    Product::with(['productImages','category','brand'])->where('quantity','<',10)->select('*');

            if ($request->order == null) {
                $data           =   $data->orderBy('product_created_at', 'desc');
            }

            return DataTables::of($data)
                ->addColumn('product', function ($data) {
                    if(!empty($data->productImages) && $data->productImages->isNotEmpty())
                    {
                        if(file_exists("uploads/products/" . $data->id."/".$data->productImages->first()->url))
                        {
                            $image   =   asset('uploads/products/'.$data->id.'/'.$data->productImages->first()->url);
                        }else{
                            $image   =   asset('images/product-default.jpg');
                        }
                        return '<img class="mr-2" src="' . $image . '" width="50"/> ' . $data->name;
                    }
                    else{
                        $image   =   asset('images/product-default.jpg');
                        return '<img class="mr-2" src="' . $image . '" width="50"/> ' . $data->name;
                    }
                })
                ->addColumn('action', function ($data) {
                    $editUrl = route('product.edit', ['product' => $data->id]);
                    $btn = '<div class="row">';
                    $btn .= '<a href="' . $editUrl . '"><i class="fa fa-edit"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['product','action'])
                ->make(true);
        }

        return view('cms.product.lowProduct');
    }

    public function topSellingProducts()
    {
        $data['topProducts']    =       \DB::table('order_items')
                                            ->select(
                                                'products.id',
                                                'products.name',
                                                'products.sale_price',
                                                \DB::raw('SUM(order_items.quantity) as total_sold'),
                                                \DB::raw('(SELECT url FROM product_images WHERE product_images.product_id = products.id LIMIT 1) as product_image')
                                            )
                                            ->join('products', 'order_items.product_id', '=', 'products.id')
                                            ->groupBy('products.id', 'products.name', 'products.sale_price')
                                            ->orderByDesc('total_sold')
                                            ->limit(10)
                                            ->get();


        return view('cms.product.topProducts',$data);
    }

    public function topAreaBuyProducts()
    {
        $data['topAreas']       =       \DB::table('order_items')
                                            ->join('orders', 'order_items.order_id', '=', 'orders.id')
                                            ->join('addresses', 'orders.address_id', '=', 'addresses.id')
                                            ->select(
                                                'addresses.area',
                                                \DB::raw('COUNT(order_items.id) as total_orders'),
                                                \DB::raw('SUM(order_items.quantity) as total_sold')
                                            )
                                            ->groupBy('addresses.area')
                                            ->orderByDesc('total_sold')
                                            ->limit(10)
                                            ->get();



        return view('cms.product.topArea',$data);
    }
}
