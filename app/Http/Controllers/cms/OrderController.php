<?php

namespace App\Http\Controllers\cms;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\OrderItemStatusMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
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
                    if ($data->payment_status == 'paid') {
                        return '<label class="badge badge-outline-success">' . ucfirst($data->payment_status) . '</label>';
                    } else {
                        return '<label class="badge badge-outline-warning">' . ucfirst($data->payment_status) . '</label>';
                    }
                })
                ->editColumn('info',function($data){
                    $aboutUrl   =   route('order.show', ['order' => $data->id]);
                    return '<a href="' . $aboutUrl . '"><i class="fa fa-info-circle"></i></a>';
                })
                ->editColumn('action', function ($data) {
                    $editUrl    =   route('order.edit', ['order' => $data->id]);
                    return '<a href="' . $editUrl . '"><i class="fa fa-edit"></i></a>';
                })
                ->rawColumns(['status','info' ,'action', 'payment_status'])
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

        $data['order']      =       Order::with(['customer.customer', 'orderItems.product', 'payment', 'address','coupon','country','city','shippingOption'])->find($id);

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
        $data['object']     =   Order::with([
                'customer',
                'orderItems.product',
                'payment','country','city','shippingOption'
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

            $order->status = 'completed';
            $order->save();
        }

        $orderData = [
            'order_number'      => $order->order_number,
            'status'            => $orderItem->status,
            'product_name'      => $orderItem->product->name,
            'quantity'          => $orderItem->quantity,
            'customer_name'     => $order->customer->name,
            'customer_email'    => $order->customer->email,
        ];

        Mail::to($order->customer->email)->send(new OrderItemStatusMail($orderData));

        Session::flash('success', 'Status Updated');

        $data['message']        =   auth()->user()->name . " has updated the delivery status to ".$request->status."";
        $data['action']         =   "updated";
        $data['module']         =   "orderItems";
        $data['object']         =   $orderItem;
        saveLogs($data);

        return back();
    }

    public function generateReceipt($orderId)
    {
        $order      =   Order::with('orderItems.product', 'customer','coupon','address')->findOrFail($orderId);

        if ($order->payment_status !== 'paid') {
            return redirect()->back()->with('error', 'Payment not completed for this order.');
        }

        $pdf = Pdf::loadView('cms.order.receipt', compact('order'));

        return $pdf->download("Order_Receipt_{$order->order_number}.pdf");
    }
}
