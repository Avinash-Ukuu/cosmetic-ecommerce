<?php

namespace App\Http\Controllers\cms;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\EmployeePayment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data         =       Order::with(['customer', 'orderItems.product', 'payment']);

            if ($request->order == null) {
                $data         =   $data->orderBy('order_created_at', 'asc');
            }

            return DataTables::of($data)
                ->editColumn('status', function ($data) {
                    if ($data->status == 'completed') {
                        return '<label class="badge badge-outline-success">' . ucfirst($data->status) . '</label>';
                    } else {
                        return '<label class="badge badge-outline-warning">' . ucfirst($data->status) . '</label>';
                    }
                })
                ->editColumn('payment_status', function ($data) {
                    if ($data->payment_status == 'completed') {
                        return '<label class="badge badge-outline-success">' . ucfirst($data->payment_status) . '</label>';
                    } else {
                        return '<label class="badge badge-outline-warning">' . ucfirst($data->payment_status) . '</label>';
                    }
                })
                ->editColumn('action', function ($data) {
                    if (auth()->user()->hasRole('admin') || auth()->user()->super_admin == 1) {
                        $aboutUrl   =   route('order.show', ['order' => $data->id]);
                        return '<a href="' . $aboutUrl . '"><i class="fa fa-info-circle"></i></a>';
                    } else {
                        $editUrl    =   route('order.edit', ['order' => $data->id]);
                        return '<a href="' . $editUrl . '"><i class="fa fa-edit"></i></a>';
                    }
                })
                ->rawColumns(['status', 'action', 'payment_status'])
                ->make(true);
        }

        return view('cms.order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(!auth()->user()->hasRole('admin'), 403);

        $data['order']      =       Order::with(['customer.customer', 'orderItems.product.vendor', 'payment', 'address'])->find($id);

        if (empty($data['order'])) {
            Session::flash('error', 'Data Not Found');

            return back();
        }

        return view('cms.order.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['object']     =   Order::whereHas('orderItems.product', function ($query) {
            $query->where('vendor_id', auth()->user()->id);
        })
            ->with([
                'customer',
                'orderItems' => function ($query) {
                    $query->whereHas('product', function ($q) {
                        $q->where('vendor_id', auth()->user()->id);
                    });
                },
                'orderItems.product',
                'payment'
            ])->where('id', $id)->first();


        if (empty($data['object'])) {
            Session::flash('error', 'Data Not Found');

            return back();
        }
        $data['status']     =       ['pending' => 'Pending', 'confirmed' => 'Confirmed', 'dispatch' => 'Dispatch', 'delivered' => 'Delivered'];

        return view('cms.order.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateOrderItemStatus(Request $request, $id)
    {
        $orderItem      =       OrderItem::find($id);
        if (empty($orderItem)) {
            Session::flash('error', 'Data not found');
            return redirect(route('order.index'));
        }

        $orderItem->status  =   $request->status;
        $orderItem->save();

        if ($request->status == 'delivered') {
            $product                =       Product::find($request->product_id);
            if (empty($product)) {
                Session::flash('error', 'Product not found');
                return back();
            }
            $product->quantity      =       $product->quantity - $request->quantity;
            $product->update();
        }

        // When all the order item status is delivered the order status is completed
        $order              =   $orderItem->order;
        $allDelivered       =   $order->orderItems()->where('status', '<>', 'delivered')->doesntExist();

        if ($allDelivered) {

            $vendorPayments =   [];

            foreach ($order->orderItems as $item) {
                $vendorId   = $item->product->vendor->id;
                $itemTotal  = $item->price * $item->quantity;

                if (!isset($vendorPayments[$vendorId])) {
                    $vendorPayments[$vendorId] = 0;
                }

                $vendorPayments[$vendorId] += $itemTotal;
            }

            // Insert payment records for each vendor
            foreach ($vendorPayments as  $vendorId => $amount) {
                EmployeePayment::create([
                    'user_id'               => $vendorId ,
                    'amount'                => $amount,
                    'user_type'             => 'vendor',
                    'payment_status'        => 'pending',
                    'payment_created_at'    => now(),
                ]);
            }

            $order->status = 'completed';
            $order->save();
        }
        Session::flash('success', 'Status Updated');

        $data['message']        =   auth()->user()->name . " has updated the delivery status to ".$request->status."";
        $data['action']         =   "updated";
        $data['module']         =   "orderItems";
        $data['object']         =   $orderItem;
        saveLogs($data);

        return back();
    }
}
