<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Azmak\AZProduct;
use App\Models\Restaurant\Azmak\AZProductOption;
use App\Models\Restaurant\Azmak\AZOption;
use App\Models\Restaurant\Azmak\AZProductModifier;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $options = AZProductOption::whereProductId($id)->get();
        $product = AZProduct::findOrFail($id);
        return view('restaurant.products.options.index' , compact('options' , 'product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee'):
            if (check_restaurant_permission($restaurant->id , 4) == false):
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $options = AZOption::whereRestaurantId($restaurant->id)->get();
        $product = AZProduct::findOrFail($id);
        return view('restaurant.products.options.create' , compact('options' , 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $id)
    {
//        dd($request->all());
        $product = AZProduct::findOrFail($id);
        $this->validate($request , [
            'option_id' => 'required|exists:a_z_options,id',
            'min'       => 'required|numeric',
            'max'       => 'required|numeric',
        ]);

        if ($request->option_id != null) {
            foreach ($request->option_id as $option) {
                // create new product Option
                AZProductOption::updateOrCreate([
                    'option_id'   => $option,
                    'product_id'  => $product->id,
                ],[
                    'min'         => $request->min,
                    'modifier_id' => AZOption::find($option)->modifier_id,
                    'max'         => $request->max,
                ]);

                // create product modifier
                AZProductModifier::updateOrCreate([
                    'product_id'   => $product->id,
                    'modifier_id'  => AZOption::find($option)->modifier->id,
                ]);
            }
        }

        flash(trans('messages.created'))->success();
        return redirect()->route('productOption' , $product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee'):
            if (check_restaurant_permission($restaurant->id , 4) == false):
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $product_option = AZProductOption::findOrFail($id);
        $options = AZOption::whereRestaurantId($restaurant->id)->get();
        return view('restaurant.products.options.edit' , compact('product_option' , 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $option = AZProductOption::findOrFail($id);
        $this->validate($request , [
            'option_id' => 'required|exists:a_z_options,id',
            'min'       => 'required|numeric',
            'max'       => 'required|numeric',
        ]);

        $option->update([
            'option_id'   => $request->option_id,
            'min'         => $request->min,
            'max'         => $request->max,
        ]);

        $productModifier = AZProductModifier::whereProductId($option->product_id)
            ->where('modifier_id' , $option->modifier_id)
            ->first();
        $productModifier->update([
            'modifier_id'  => AZOption::find($request->option_id)->modifier->id,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('productOption' , $option->product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $option = AZProductOption::findOrFail($id);
        $option->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('productOption' , $option->product->id);
    }

    public function deleteAll(Request $request , Product $product)
    {
        $request->validate([
            'ids' => 'required|array|min:1'  ,
            'ids.*' => 'required|integer'  ,
        ]);
        $option = AZProductOption::whereIn('id' , $request->ids)->delete();

        flash(trans('messages.deleted'))->success();
        return redirect()->route('productOption' , $product->id);
    }

}
