<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\Backup;
use App\Models\Bank;
use App\Models\Country;
use App\Models\MenuCategory;
use App\Models\Modifier;
use App\Models\Poster;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\RestaurantPoster;
use App\Models\RestaurantSensitivity;
use App\Models\Sensitivity;
use App\Models\ServiceSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\Count;

class BackupController extends Controller
{
    private $restaurant;
    public function __construct()
    {



        $this->middleware('auth:restaurant');
        $this->middleware(function ($request, $next) {

            if (auth('restaurant')->check()) {
                $this->restaurant = auth('restaurant')->user();
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // check service subscription 
        if (!$this->restaurant->serviceSubscriptions()->where('service_id', 12)->where('status', 'active')->first()) {
            return $this->publicError('Error');
        }


        $backups = Backup::where('restaurant_id', $this->restaurant->id)->orderBy('id', 'desc')->get();
        return view('restaurant.backups.index', compact('backups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('restaurant.banks.create', compact('countries'));
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
            'name_ar' => 'required|string|max:191',
            'name_en' => 'required|string|max:191',
            'useful' => 'required|string|max:191',
            'account_number' => 'required|max:191',
            'IBAN_number' => 'required|max:191',
        ]);
        $restaurant = auth('restaurant')->user();
        // create new bank
        Bank::create([
            'country_id' => $request->country_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'useful' => $request->useful,
            'restaurant_id' => $restaurant->id,
            'account_number' => $request->account_number,
            'IBAN_number' => $request->IBAN_number,
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant.banks.index');
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
        $countries = Country::all();
        $bank = Bank::findOrFail($id);
        return view('restaurant.banks.edit', compact('bank', 'countries'));
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
        $restaurant = auth('restaurant')->user();
        $bank = Bank::where('restaurant_id', $restaurant->id)->findOrFail($id);
        $this->validate($request, [
            'country_id' => 'required|exists:countries,id',
            'name_ar' => 'required|string|max:191',
            'name_en' => 'required|string|max:191',
            'useful' => 'required|string|max:191',
            'account_number' => 'required|max:191',
            'IBAN_number' => 'required|max:191',
        ]);
        $bank->update([
            'country_id' => $request->country_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'useful' => $request->useful,
            'account_number' => $request->account_number,
            'IBAN_number' => $request->IBAN_number,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant.banks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();
        flash(trans('messages.deleted'))->success();
        return redirect()->route('restaurant.banks.index');
    }


    public function settings(Request $request)
    {
        $restaurant = auth('restaurant')->user();

        if ($request->method() == 'POST') :
            // return $restaurant;
            $data = $request->validate([
                'enable_reservation_bank' => 'required|in:true,false',
            ]);
            $restaurant->update($data);
            flash(trans('messages.updated'))->success();
            return redirect(route('restaurant.banks.index'));
        endif;
        return view('restaurant.banks.setting', compact('restaurant'));
    }

    public function createBackup()
    {
        $restaurant = auth('restaurant')->user();
        // first make new folder and check if exists before
        $count = 0;
        $folderName = 'backups/backup_' . $restaurant->id;
        $temp = $folderName;
        while (File::exists(storage_path($temp))) {
            $count++;
            $temp = $folderName . '_'  . $count;
        }
        $folderName = $temp;
        $filesPath = $folderName . '/files';
        
        // return $folderName;
        // store branches
        $branches = $restaurant->branches;

        $this->backupStore($folderName , $branches  , 'branches' );

        // store categories and sub categories
        $categories = MenuCategory::where('restaurant_id', $restaurant->id)->with('sub_categories')->get();
        $this->backupStore($folderName , $categories  , 'menu_categories' );

        // posters
        $posters = RestaurantPoster::where('restaurant_id'  , $restaurant->id )->get();
        $this->backupStore($folderName , $posters  , 'posters' );
        
        // sens
        $sen = RestaurantSensitivity::where('restaurant_id'  , $restaurant->id )->get();
        $this->backupStore($folderName , $sen  , 'sensitivities' );

        // options 
        $options = Modifier::where('restaurant_id' , $restaurant->id)->with('options')->get();
        $this->backupStore($folderName , $options  , 'modifiers' , false );

        // products 
        $products = Product::where('restaurant_id' , $restaurant->id)->with('options' , 'sizes' , 'days')->get();
        $this->backupStore($folderName , $products  , 'products'  );
        
        return 'true';
    }
    
    private function backupStore($folderName, $data, $type, $hasFile = true)
    {
        // store database
        Storage::disk('storage')->put($folderName . '/database/' . $type . '.json', json_encode($data));
        // store files if exists
        $filesPath = $folderName . '/files';
        // if ($hasFile) :
        //     if (in_array($type, ['menu_categories' , 'sensitivities' , 'products'])) :
        //         Storage::disk('storage')->makeDirectory($filesPath . '/'  . $type);
        //         foreach ($data as $item) :
        //             if (Storage::disk('public_storage')->exists($item->image_path)) {

        //                 File::copy(public_path($item->image_path), storage_path($filesPath . '/'.$type.'/' . $item->photo));
        //             }
        //         endforeach;
        //         elseif (in_array($type, ['posters'])) :
        //             Storage::disk('storage')->makeDirectory($filesPath . '/'  . $type);
        //             foreach ($data as $item) :
        //                 if (Storage::disk('public_storage')->exists($item->image_path)) {
    
        //                     File::copy(public_path($item->image_path), storage_path($filesPath . '/'.$type.'/' . $item->poster));
        //                 }
        //             endforeach;
        //     endif; // check if there stander photos
        // endif; // check if has file
    }
}
