<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Marketer;
use App\Models\Package;
use App\Models\EasyAdsSellerCode;
use Illuminate\Http\Request;

class SellerCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seller_codes = EasyAdsSellerCode::orderBy('id', 'desc')->paginate(500);
        return view('admin.seller_codes.index', compact('seller_codes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.seller_codes.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'country_id' => 'required|exists:countries,id',
            'seller_name' => 'required_if:used_type,code|string|max:191',
            'permanent' => 'required|in:true,false',
            'active' => 'required|in:true,false',
//            'percentage' => 'required|numeric',
            'code_percentage' => 'required|numeric',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
        ]);

        // create new seller code
        EasyAdsSellerCode::create([
            'country_id' => $request->country_id,
            'seller_name' => $request->seller_name,
            'active' => $request->active,
            'permanent' => $request->permanent,
            'percentage' => 0,
            'commission' => 0,
            'code_percentage' => $request->code_percentage,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('seller_codes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seller_code = EasyAdsSellerCode::findOrFail($id);

        return view('admin.seller_codes.show', compact('seller_code'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seller_code = EasyAdsSellerCode::findOrFail($id);
        $countries = Country::all();
        return view('admin.seller_codes.edit', compact('countries', 'seller_code'));
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
        $seller_code = EasyAdsSellerCode::findOrFail($id);
        $this->validate($request, [
            'country_id' => 'required|exists:countries,id',
            'permanent' => 'required|in:true,false',
            'active' => 'required|in:true,false',
//            'percentage' => 'required|numeric',
            'code_percentage' => 'required|numeric',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
            'seller_name' => 'required_if:used_type,code|string|max:191',

        ]);
        $seller_code->update([
            'seller_name' => $request->seller_name,
            'permanent' => $request->permanent,
            'active' => $request->active,
//            'percentage' => $request->percentage,
            'code_percentage' => $request->code_percentage,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'country_id' => $request->country_id,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('seller_codes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller_code = EasyAdsSellerCode::findOrFail($id);
        $seller_code->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('seller_codes.index');
    }

    public function activate($id, $status)
    {
        $seller_code = EasyAdsSellerCode::findOrFail($id);
        if ($status == 'true' and EasyAdsSellerCode::whereId($id)->where('end_at', '<', date('Y-m-d'))->count() > 0) {

            flash(trans('dashboard.errors.seller_end_date'))->error();
            return redirect()->route('seller_codes.index');
        }
        $seller_code->update([
            'active' => $status,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('seller_codes.index');
    }
}
