<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AzOccasion;

class OccasionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $occasions = AzOccasion::orderBy('id' , 'desc')->paginate(100);
        return view('admin.occasions.index' , compact('occasions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.occasions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'name_ar'    => 'required|string|max:191',
            'name_en'    => 'required|string|max:191',
            'icon'       => 'required|mimes:jpg,jpeg,png,gif,tif,psd,pmb,webp|max:5000',
        ]);
        // create new occasion
        AzOccasion::create([
            'name_ar'   => $request->name_ar,
            'name_en'   => $request->name_en,
            'icon'      => UploadImage($request->file('icon'),'icon' , '/uploads/occasions')
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('occasions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $occasion = AzOccasion::findOrFail($id);
        return view('admin.occasions.edit' , compact('occasion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $occasion = AzOccasion::findOrFail($id);
        $this->validate($request , [
            'name_ar'    => 'required|string|max:191',
            'name_en'    => 'required|string|max:191',
            'icon'       => 'nullable|mimes:jpg,jpeg,png,gif,tif,psd,pmb,webp|max:5000',
        ]);
        $occasion->update([
            'name_ar'   => $request->name_ar,
            'name_en'   => $request->name_en,
            'icon'      => $request->file('icon') == null ? $occasion->icon : UploadImageEdit($request->file('icon'),'icon' , '/uploads/occasions' , $occasion->icon)
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('occasions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $occasion = AzOccasion::findOrFail($id);
        if ($occasion->icon)
        {
            @unlink(public_path('/uploads/occasions/' . $occasion->icon));
        }
        $occasion->delete();
        return redirect()->route('occasions.index');
    }
}
