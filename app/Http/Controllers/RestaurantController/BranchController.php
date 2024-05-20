<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Azmak\AZBranch;
use App\Models\Restaurant;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PDF;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $user = Auth::guard('restaurant')->user();
        if ($user->type == 'employee') :
            if (check_restaurant_permission($user->id, 2) == false) :
                abort(404);
            endif;
            $user = Restaurant::find($user->restaurant_id);
        endif;
        $branches = AZBranch::whereRestaurantId($user->id)
            ->orderBy('id', 'desc')
            ->paginate(500);
        return view('restaurant.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant = auth('restaurant')->user();
        if (!auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $cities = City::whereCountryId($restaurant->country_id)->get();
        return view('restaurant.branches.create' , compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $this->validate($request, [
            'city_id' => 'required|exists:cities,id',
            'name_ar' => 'required|string|max:191',
            'name_en' => 'required|string|max:191|unique:a_z_branches',
            'latitude' => 'required'
        ]);
        if ($request->name_ar == null && $request->name_en == null) {
            flash(trans('messages.name_required'))->error();
            return redirect()->back();
        }
        // create new branch
        $user = Auth::guard('restaurant')->user();
        if ($user->type == 'employee') :
            if (check_restaurant_permission($user->id, 2) == false) :
                abort(404);
            endif;
            $user = Restaurant::find($user->restaurant_id);
        endif;
        $barcode = str_replace(' ', '-', $request->name_en);
        $branch = AZBranch::create([
            'restaurant_id' => $user->id,
            'city_id' => $request->city_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('branches.index');
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
        $restaurant = auth('restaurant')->user();
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $branch = AZBranch::findOrFail($id);
        $cities = City::whereCountryId($restaurant->country_id)->get();
        return view('restaurant.branches.edit', compact('branch' , 'cities'));
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
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $branch = AZBranch::findOrFail($id);
        $this->validate($request, [
            'city_id' => 'required|exists:cities,id',
            'name_ar' => 'nullable|string|max:191',
            'name_en' => 'nullable|string|max:191|unique:a_z_branches,name_en,' . $id,
        ]);
        if ($request->name_ar == null && $request->name_en == null) {
            flash(trans('messages.name_required'))->error();
            return redirect()->back();
        }
        //        $barcode = str_replace(' ', '-', $request->name_en);
        $branch->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'city_id' => $request->city_id,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('branches.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $branch = AZBranch::findOrFail($id);
        $branch->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->to(url()->previous());
    }


    public function barcode($id)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $model = AZBranch::findOrFail($id);
        if ($model->main == 'true') {
            $model = Auth::guard('restaurant')->user();
            if ($model->type == 'employee') :
                if (check_restaurant_permission($model->id, 2) == false) :
                    abort(404);
                endif;
                $model = Restaurant::find($model->restaurant_id);
            endif;
            return view('restaurant.user.barcode', compact('model'));
        } else {
            return view('restaurant.branches.barcode', compact('model'));
        }
    }
    public function showBranchCart($id, $state)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $branch = Branch::findOrFail($id);
        $branch->update([
            'cart' => $state,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }

    public function stopBranchMenu($id, $state)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) :
            return redirect(url('restaurant/login'));
        endif;
        $branch = Branch::findOrFail($id);
        $branch->update([
            'stop_menu' => $state,
        ]);
        if ($branch->main == 'true') {
            $branch->restaurant->update([
                'stop_menu' => $state,
            ]);
        }
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }
}
