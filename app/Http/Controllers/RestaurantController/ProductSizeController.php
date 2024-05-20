<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Azmak\AZProduct;
use App\Models\Restaurant\Azmak\AZProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    private $restaurant ;
    public function __construct()
    {
        $this->middleware(function($request , $next){
            if(!auth('restaurant')->check()){
                abort(401);
            }
            $this->restaurant = auth('restaurant')->user();
            if($this->restaurant->type == 'employee') $this->restaurant = $this->restaurant->restaurant;
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $product = AZProduct::findOrFail($id);
        $sizes = AZProductSize::whereProductId($id)->get();
        return view('restaurant.products.sizes.index' , compact('product' , 'sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $product = AZProduct::findOrFail($id);
        return view('restaurant.products.sizes.create' , compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $id)
    {
        $product = AZProduct::findOrFail($id);
        $this->validate($request , [
            'name_ar'   => 'nullable|string|max:191',
            'name_en'   => 'nullable|string|max:191',
            'price'     => 'required|numeric',
            'calories'  => 'nullable|numeric',
        ]);
        if ($request->name_ar == null && $request->name_en == null)
        {
            flash(trans('messages.name_required'))->error();
            return redirect()->back();
        }
        // create new product size
        AZProductSize::create([
            'name_ar'    => $request->name_ar,
            'name_en'    => $request->name_en,
            'price'      => $request->price,
            'calories'   => $request->calories,
            'product_id' => $product->id,
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('productSize' , $product->id);
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
        $size = AZProductSize::findOrFail($id);
        return view('restaurant.products.sizes.edit' , compact('size'));
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
        $size = AZProductSize::findOrFail($id);
        $this->validate($request , [
            'name_ar'   => 'nullable|string|max:191',
            'name_en'   => 'nullable|string|max:191',
            'price'     => 'required|numeric',
            'calories'  => 'nullable|numeric',
        ]);
        if ($request->name_ar == null && $request->name_en == null)
        {
            flash(trans('messages.name_required'))->error();
            return redirect()->back();
        }
        $size->update([
            'name_ar'    => $request->name_ar,
            'name_en'    => $request->name_en,
            'price'      => $request->price,
            'calories'   => $request->calories,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('productSize' , $size->product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size = AZProductSize::findOrFail($id);
        $size->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('productSize' , $size->product->id);
    }

    public function changeStatus(Request $requet , $id  , $status){
        $restaurant = $this->restaurant;
        $size = AZProductSize::whereHas('product' , function($query)use($restaurant){
            $query->where('restaurant_id' ,$restaurant->id);
        })->findOrFail($id);
        if(!in_array($status , ['true' , 'false'])):
            abort(404);
        endif;

        $size->update([
            'status' => $status ,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect(route('productSize' , $size->product_id));
    }
}
