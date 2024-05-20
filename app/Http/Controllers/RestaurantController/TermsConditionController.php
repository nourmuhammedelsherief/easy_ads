<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RestaurantTermsCondition;
use App\Models\RestaurantAboutAzmak;
use App\Models\Restaurant\Azmak\AZContactUs;

class TermsConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terms = RestaurantTermsCondition::whereRestaurantId(auth()->guard('restaurant')->user()->id)->first();
        return view('restaurant.terms.index' , compact('terms'));
    }
    public function azmak_about()
    {
        $about = RestaurantAboutAzmak::whereRestaurantId(auth()->guard('restaurant')->user()->id)->first();
        return view('restaurant.terms.about' , compact('about'));
    }

    public function az_contacts()
    {
        $contacts = AZContactUs::whereRestaurantId(auth()->guard('restaurant')->user()->id)->get();
        return view('restaurant.terms.contacts' , compact('contacts'));
    }
    public function delete_az_contact($id)
    {
        $contact = AZContactUs::findOrFail($id);
        $contact->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->back();
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $terms = RestaurantTermsCondition::findOrFail($id);
        $terms->update([
            'terms_ar'  => $request->terms_ar,
            'terms_en'  => $request->terms_en,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }
    public function azmak_about_update(Request $request, string $id)
    {
        $about = RestaurantAboutAzmak::findOrFail($id);
        $about->update([
            'about_ar'  => $request->about_ar,
            'about_en'  => $request->about_en,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }
}
