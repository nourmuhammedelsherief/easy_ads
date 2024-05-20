<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Azmak\AZMenuCategory;
use App\Models\Restaurant\Azmak\AZBranch;
use App\Models\Restaurant\Azmak\AZMenuCategoryDay;
use App\Models\Restaurant;
use App\Models\AZRestaurantPoster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MenuCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee'):
            if (check_restaurant_permission($restaurant->id , 4) == false):
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;

        $branches = AZBranch::whereRestaurantId($restaurant->id)->get();
        $categories = AZMenuCategory::whereRestaurantId($restaurant->id)->paginate(500);
        return view('restaurant.menu_categories.index', compact('categories' , 'branches'));
    }
    public function branch_categories($id)
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee'):
            if (check_restaurant_permission($restaurant->id , 4) == false):
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $categories = AZMenuCategory::whereRestaurantId($restaurant->id)
            ->where('branch_id' , $id)
            ->paginate(500);
        $branches = AZBranch::whereRestaurantId($restaurant->id)
            ->get();
        return view('restaurant.menu_categories.index', compact('categories' , 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee'):
            if (check_restaurant_permission($restaurant->id , 4) == false):
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $branches = AZBranch::whereRestaurantId($restaurant->id)
            ->get();
        $posters = AZRestaurantPoster::whereRestaurantId($restaurant->id)->get();
        return view('restaurant.menu_categories.create', compact('branches' , 'posters','restaurant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee'):
            if (check_restaurant_permission($restaurant->id , 4) == false):
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $this->validate($request, [
            'branch_id' => 'required',
            'branch_id*' => 'exists:branches,id',
            'name_ar' => 'nullable|string|max:191',
            'name_en' => 'nullable|string|max:191',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'photo' => 'nullable|mimes:jpg,jpeg,png,gif,tif,psd,webp|max:20000',
            'image_name' =>'nullable|min:1|max:190' ,
            'start_at' => 'sometimes',
            'end_at' => 'sometimes',
            'time' => 'sometimes|in:true,false',
            'poster_id'         => 'nullable|exists:a_z_restaurant_posters,id',
        ]);

        if ($request->name_ar == null && $request->name_en == null) {
            flash(trans('messages.name_required'))->error();
            return redirect()->back();
        }
        if ($request->branch_id != null)
        {
            foreach ($request->branch_id as $branch_id)
            {
                // create new menu category
                $cat = AZMenuCategory::create([
                    'restaurant_id' => $restaurant->id,
                    'branch_id' => $branch_id,
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'description_ar' => $request->description_ar,
                    'description_en' => $request->description_en,
                    'photo'             => $request->file('photo') == null ? 'default.png' : UploadImage($request->file('photo'),'photo' , '/uploads/menu_categories'),
                    'active' => 'true',
                    'start_at' => $request->start_at,
                    'end_at' => $request->end_at,
                    'time' => $request->time == null ? 'false' : $request->time,
                    'poster_id'         => $request->poster_id,
                ]);
                if ($request->time == 'true' && $request->day_id != null)
                {
                    AZMenuCategoryDay::where('menu_category_id' , $cat->id)->delete();
                    foreach ($request->day_id as $day)
                    {
                        AZMenuCategoryDay::create([
                            'menu_category_id' => $cat->id,
                            'day_id'           => $day,
                        ]);
                    }
                }
            }
        }
        flash(trans('messages.created'))->success();
        return redirect()->route('menu_categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee'):
            if (check_restaurant_permission($restaurant->id , 4) == false):
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $category = AZMenuCategory::findOrFail($id);
        $branches = AZBranch::whereRestaurantId($restaurant->id)->get();
        $posters = AZRestaurantPoster::whereRestaurantId($restaurant->id)->get();
        return view('restaurant.menu_categories.edit', compact('branches', 'posters','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $category = AZMenuCategory::findOrFail($id);
        $this->validate($request, [
            'branch_id' => 'required|exists:a_z_branches,id',
            'name_ar' => 'nullable|string|max:191',
            'name_en' => 'nullable|string|max:191',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'photo' => 'nullable|mimes:jpg,jpeg,png,gif,tif,psd,webp|max:20000',
            'start_at' => 'sometimes',
            'end_at' => 'sometimes',
            'time' => 'sometimes|in:true,false',
            'poster_id'         => 'nullable|exists:a_z_restaurant_posters,id',
        ]);
        if ($request->name_ar == null && $request->name_en == null) {
            flash(trans('messages.name_required'))->error();
            return redirect()->back();
        }
        // create new menu category
        $category->update([
            'branch_id' => $request->branch_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'photo' => $request->file('photo') == null ? $category->photo : UploadImageEdit($request->file('photo'), 'photo', '/uploads/menu_categories', $category->photo),
            'start_at' => $request->start_at == null ? $category->start_at : $request->start_at,
            'end_at' => $request->end_at == null ? $category->end_at : $request->end_at,
            'time' => $request->time == null ? $category->time : $request->time,
            'poster_id'         => $request->poster_id,
        ]);
        if ($request->time == 'true' && $request->day_id != null)
        {
            AZMenuCategoryDay::where('menu_category_id' , $category->id)->delete();
            foreach ($request->day_id as $day)
            {
                AZMenuCategoryDay::create([
                    'menu_category_id' => $category->id,
                    'day_id'           => $day,
                ]);
            }
        }
        flash(trans('messages.updated'))->success();
        return redirect()->route('menu_categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $category = AZMenuCategory::findOrFail($id);
        if ($category->photo != null) {
            @unlink(public_path('/uploads/menu_categories/' . $category->photo));
        }
        $category->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('menu_categories.index');
    }

    public function activate($id, $active)
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $category = AZMenuCategory::findOrFail($id);
        $category->update([
            'active' => $active,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('menu_categories.index');
    }



    public function uploadImage(Request $request){
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $request->validate([
            'photo' => 'required|mimes:png,jepg,jpg,svg' ,
            'action' => 'required|in:create,edit' ,
            'item_id' => 'required_if:action,edit|integer|exists:a_z_menu_categories,id' ,
        ]);
        if($request->action == 'edit')
            $item = AZMenuCategory::findOrFail($request->item_id);

        if ($request->photo != null)
        {
            $photo = UploadImageEdit($request->file('photo'),'photo' , '/uploads/menu_categories' , (isset($item->photo) ? $item->photo : null));
            if(isset($item->id))
                $item->update([
                    'photo' => $photo ,
                ]);
            return response([
                'photo' =>  $photo,
                'status' => true ,
            ]);
        }
        return response('error' , 500);
    }
    public function arrange($id)
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $category = AZMenuCategory::findOrFail($id);
        return view('restaurant.menu_categories.arrange' , compact('category'));
    }
    public function arrange_submit(Request $request , $id)
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $category = AZMenuCategory::findOrFail($id);
        $this->validate($request , [
            'arrange' => 'required'
        ]);
        $category->update([
            'arrange' => $request->arrange
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('menu_categories.index');

    }

    public function copy_category($id)
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee'):
            if (check_restaurant_permission($restaurant->id , 4) == false):
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $category = AZMenuCategory::findOrFail($id);
        $branches = AZBranch::whereRestaurantId($restaurant->id)
            ->get();
        return view('restaurant.menu_categories.copy', compact('branches', 'category'));
    }
    public function copy_category_post(Request $request)
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee'):
            if (check_restaurant_permission($restaurant->id , 4) == false):
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $this->validate($request, [
            'branch_id' => 'required',
            'branch_id*' => 'exists:branches,id',
            'name_ar' => 'nullable|string|max:191',
            'name_en' => 'nullable|string|max:191',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            // 'photo' => 'nullable|mimes:jpg,jpeg,png,gif,tif,psd,webp|max:20000',
            'image_name' =>'nullable|min:1|max:190' ,
            'start_at' => 'sometimes',
            'end_at' => 'sometimes',
            'time' => 'sometimes|in:true,false',
            'old_category_id' => 'required|integer'
        ]);
        $category = AZMenuCategory::findOrFail($request->old_category_id);
        if ($request->name_ar == null && $request->name_en == null) {
            flash(trans('messages.name_required'))->error();
            return redirect()->back();
        }
        if ($request->branch_id != null)
        {
            foreach ($request->branch_id as $branch_id)
            {
                if (empty($request->image_name) and !empty($category->photo) and  Storage::disk('public_storage')->exists($category->image_path)) :
                    $imageName = copyImage($category->image_path, 'te', 'uploads/menu_categories');

                else :
                    $imageName = $request->image_name;
                endif;
                // create new menu category
                $cat = AZMenuCategory::create([
                    'restaurant_id' => $restaurant->id,
                    'branch_id' => $branch_id,
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'description_ar' => $request->description_ar,
                    'description_en' => $request->description_en,
                    'photo' => $imageName ,
                    'active' => 'true',
                    'start_at' => $request->start_at,
                    'end_at' => $request->end_at,
                    'time' => $request->time == null ? 'false' : $request->time,
                ]);
                if ($request->time == 'true' && $request->day_id != null)
                {
                    AZMenuCategoryDay::where('menu_category_id' , $cat->id)->delete();
                    foreach ($request->day_id as $day)
                    {
                        AZMenuCategoryDay::create([
                            'menu_category_id' => $cat->id,
                            'day_id'           => $day,
                        ]);
                    }
                }
            }
        }
        flash(trans('messages.created'))->success();
        return redirect()->route('menu_categories.index');
    }

    public function deleteCategoryPhoto($id)
    {
        if(!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $category = AZMenuCategory::findOrFail($id);
        if ($category->photo != null) {
            @unlink(public_path('/uploads/menu_categories/' . $category->photo));
        }
        $category->update([
            'photo' => null
        ]);
        flash(trans('messages.deleted'))->success();
        return redirect()->back();
    }
}
