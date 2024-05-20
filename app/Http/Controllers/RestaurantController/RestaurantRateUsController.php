<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\OurRate;
use App\Models\Restaurant\RestaurantOurRate;
use App\Models\Restaurant\RestaurantRateUsQuestion;
use Illuminate\Http\Request;

class RestaurantRateUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = auth()->guard('restaurant')->user();
        $rates = RestaurantRateUsQuestion::whereRestaurantId($res->id)
            ->orderBy('id' , 'asc')
            ->get();
        return view('restaurant.rates.index' , compact('rates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.rates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $res = auth()->guard('restaurant')->user();
        $this->validate($request , [
            'question_ar' => 'required|string',
            'question_en' => 'required|string',
            'more_option' => 'nullable'
        ]);
        $arrange = RestaurantRateUsQuestion::whereRestaurantId($res->id)
                ->orderBy('arrange' , 'desc')
                ->first();
        $arrange = $arrange == null ? 1 : $arrange->arrange + 1;
        // create new question
        RestaurantRateUsQuestion::create([
            'restaurant_id' => $res->id,
            'question_ar'  => $request->question_ar,
            'question_en'  => $request->question_en,
            'more_option'  => $request->more_option == null ? 'text' : $request->more_option,
            'arrange'      => $arrange,
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant_rate_us.index');
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
        $rate = RestaurantRateUsQuestion::findOrFail($id);
        return view('restaurant.rates.edit' , compact('rate'));
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
        $rate = RestaurantRateUsQuestion::findOrFail($id);
        $this->validate($request , [
            'question_ar' => 'required|string',
            'question_en' => 'required|string'
        ]);
        $rate->update([
            'question_ar'  => $request->question_ar,
            'question_en'  => $request->question_en,
            'more_option'  => $request->more_option == null ? $rate->more_option : $request->more_option,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant_rate_us.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rate = RestaurantRateUsQuestion::findOrFail($id);
        $rate->delete();
        $rates = RestaurantRateUsQuestion::whereRestaurantId(auth()->guard('restaurant')->user()->id)->get();
        $num = 1;
        foreach ($rates as $rate)
        {
            $rate->update(['arrange' => $num]);
            $num++;
        }
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant_rate_us.index');
    }
    public function our_rates()
    {
        $rates = RestaurantOurRate::whereRestaurantId(auth()->guard('restaurant')->user()->id)
            ->orderBy('id' , 'desc')
            ->paginate(100);
        return view('restaurant.rates.our_rates' , compact('rates'));
    }
    public function delete_our_rate($id)
    {
        $rate = RestaurantOurRate::findOrFail($id);
        $rate->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->back();
    }
    public function show_restaurant_rate($id)
    {
        $rate = RestaurantOurRate::findOrFail($id);
        return view('restaurant.rates.show' , compact('rate'));
    }
}
