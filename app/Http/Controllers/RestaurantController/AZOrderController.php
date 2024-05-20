<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant\Azmak\AZOrder;

class AZOrderController extends Controller
{
    public function index($status = 'new')
    {
        $orders = AZorder::whereStatus($status)
            ->whereRestaurantId(auth('restaurant')->user()->id)
            ->paginate(100);
        return view('restaurant.orders.index' , compact('orders' , 'status'));
    }
    public function show($id)
    {
        $order = AZOrder::findOrFail($id);
        return view('restaurant.orders.show'  , compact('order'));
    }
    public function cancel(Request $request , $id)
    {
        $order = AZOrder::findOrFail($id);
        $this->validate($request , [
            'cancel_reason' => 'required',
        ]);
        $order->update([
            'status' => 'canceled',
            'cancel_reason' => $request->cancel_reason,
        ]);
        flash(trans('messages.orderCanceledSuccessfully'))->success();
        return redirect()->back();
    }
    public function complete_order(Request $request , $id)
    {
        $order = AZOrder::findOrFail($id);
        $this->validate($request , [
            'order_code' => 'required',
        ]);
        if ($order->order_code == $request->order_code)
        {
            $order->update([
                'status' => 'completed',
            ]);
            flash(trans('messages.orderCompletedSuccessfully'))->success();
            return redirect()->back();
        }else{
            flash(trans('messages.wrongOrderCode'))->error();
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        $order = AZOrder::findOrFail($id);
        $order->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->back();
    }
}
