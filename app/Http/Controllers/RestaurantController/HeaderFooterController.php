<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantCode;
use App\Models\RestaurantSlider;
use App\Models\TemporaryFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HeaderFooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant = auth('restaurant')->user();

        $items = RestaurantCode::where('restaurant_id', $restaurant->id)->orderBy('id', 'desc')->get();
        return view('restaurant.related_code.index', compact('items'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.related_code.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee') :
            if (check_restaurant_permission($restaurant->id, 5) == false) :
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $data = $request->validate([
            'name' => 'required|min:1',
            'header' => 'nullable|min:1',
            'footer' => 'nullable|min:1',
        ]);
        $data['restaurant_id'] = $restaurant->id;

        // create new slider
        RestaurantCode::create($data);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant.related_code.index');
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

        $item = RestaurantCode::where('restaurant_id', $restaurant->id)->findOrFail($id);
        return view('restaurant.related_code.edit', compact('item'));
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
        $restaurant = auth('restaurant')->user();
        $item = RestaurantCode::where('restaurant_id', $restaurant->id)->findOrFail($id);
        $data = $request->validate([
            'name' => 'required|min:1',
            'header' => 'nullable|min:1',
            'footer' => 'nullable|min:1',
        ]);

        $item->update($data);
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant.related_code.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = RestaurantCode::findOrFail($id);

        $item->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.related_code.index');
    }
}
