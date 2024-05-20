<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Azmak\AZMenuCategory;
use App\Models\RestaurantCategory;
use App\Models\Restaurant\Azmak\AZRestaurantSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $category = AZMenuCategory::findOrFail($id);
        $sub_categories = AZRestaurantSubCategory::where('menu_category_id' , $id)
            ->orderBy('id' , 'desc')
            ->paginate(100);
        return view('restaurant.sub_categories.index' , compact('sub_categories' , 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $category = AZMenuCategory::findOrFail($id);
        $restaurant = $category->restaurant;
        return view('restaurant.sub_categories.create' , compact('category' , 'restaurant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $id)
    {
        $category = AZMenuCategory::findOrFail($id);
        $this->validate($request , [
            'name_ar'  => 'nullable|string|max:191',
            'name_en'  => 'nullable|string|max:191' ,
        ]);
        AZRestaurantSubCategory::create([
            'menu_category_id' => $category->id,
            'name_ar'  => $request->name_ar,
            'name_en'  => $request->name_en ,
            'image' => $request->file('photo')  == null ? null : UploadImage($request->file('photo'),'photo' , '/uploads/sub_menu_categories'),
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('sub_categories.index' , $category->id);
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
        $sub_category = AZRestaurantSubCategory::findOrFail($id);
        $restaurant = $sub_category->restaurant_category->restaurant;
        return view('restaurant.sub_categories.edit' , compact('sub_category' , 'restaurant'));
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
        $sub_category = AZRestaurantSubCategory::findOrFail($id);
        $this->validate($request , [
            'name_ar'  => 'nullable|string|max:191',
            'name_en'  => 'nullable|string|max:191'
        ]);
        $sub_category->update([
            'name_ar'  => $request->name_ar,
            'name_en'  => $request->name_en,
            'image' => $request->file('photo')  == null ? $sub_category->image : UploadImageEdit($request->file('photo'),'photo' , '/uploads/sub_menu_categories' , (isset($sub_category->image) ? $sub_category->imgae : null))
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('sub_categories.index' , $sub_category->menu_category_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sub_category = AZRestaurantSubCategory::findOrFail($id);
        if ($sub_category->image)
        {
            @unlink(public_path('/uploads/sub_menu_categories/' . $sub_category->image));
        }
        $sub_category->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('sub_categories.index', $sub_category->menu_category_id);
    }
}
