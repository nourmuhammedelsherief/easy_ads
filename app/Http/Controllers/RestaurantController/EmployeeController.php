<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\AZRestaurantEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Restaurant\Azmak\AZBranch;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant = Auth::guard('restaurant')->user();
//        if ($restaurant->type == 'employee'):
//            if (check_restaurant_permission($restaurant->id , 3) == false):
//                abort(404);
//            endif;
//            $restaurant = Restaurant::find($restaurant->restaurant_id);
//        endif;
//        if ($checkOrderService == null)
//        {
//            abort(404);
//        }
        $employees = AZRestaurantEmployee::whereRestaurantId($restaurant->id)
            ->get();
        return view('restaurant.employees.index' , compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant = Auth::guard('restaurant')->user();
        $branches = AZBranch::whereRestaurantId($restaurant->id)
            ->get();


        return view('restaurant.employees.create' , compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $restaurant = Auth::guard('restaurant')->user();
        $this->validate($request , [
            'branch_id' => 'required|exists:a_z_branches,id',
            'name'   => 'required|string|max:191',
            'email' => 'required|string|email|max:255|unique:a_z_restaurant_employees',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => ['required', 'unique:a_z_restaurant_employees', 'regex:/^((05)|(01))[0-9]{8}/'],
        ]);
        // create new employee
        $employee = AZRestaurantEmployee::create([
            'restaurant_id' => $restaurant->id,
            'branch_id'  => $request->branch_id,
            'name'  => $request->name,
            'email'  => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('employees.index');
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
        $restaurant = Auth::guard('restaurant')->user();
        $employee = AZRestaurantEmployee::findOrFail($id);
        $branches = AZBranch::whereRestaurantId($restaurant->id)->get();
        return view('restaurant.employees.edit' , compact('branches' , 'employee'));
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
        $employee = AZRestaurantEmployee::findOrFail($id);
        $this->validate($request , [
            'branch_id' => 'required|exists:a_z_branches,id',
            'name'   => 'required|string|max:191',
            'email' => 'required|string|email|max:255|unique:a_z_restaurant_employees,email,'.$employee->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => ['required', 'unique:a_z_restaurant_employees,phone_number,' .$employee->id, 'regex:/^((05)|(01))[0-9]{8}/'],
        ]);
        // create new employee
        $employee->update([
            'branch_id'  => $request->branch_id,
            'name'  => $request->name,
            'email'  => $request->email,
            'phone_number' => $request->phone_number,
            'password' => $request->password == null ? $employee->password : Hash::make($request->password),
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = AZRestaurantEmployee::findOrFail($id);
        $employee->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('employees.index');
    }
}
