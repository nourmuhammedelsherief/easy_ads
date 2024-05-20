<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\City;
use App\Models\CountryPackage;
use App\Models\History;
use App\Models\MarketerOperation;
use App\Models\Order;
use App\Models\Package;
use App\Models\Report;
use App\Models\Restaurant;
use App\Models\Restaurant\Azmak\AZRestaurantColor;
use App\Models\RestaurantPermission;
use App\Models\RestaurantUser;
use App\Models\SellerCode;
use App\Models\ServiceSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:restaurant');
    }

    public function my_profile()
    {
        if (!auth('restaurant')->check()) {
            return redirect(url('restaurant/login'));
        }
        $user = Auth::guard('restaurant')->user();
        if ($user->type == 'employee'):
            if (check_restaurant_permission($user->id, 2) == false):
                abort(404);
            endif;
            $user = Restaurant::find($user->restaurant_id);
        endif;
        $cities = City::whereCountryId($user->country_id)->get();
        return view('restaurant.user.my_subscription', compact('user', 'cities'));
    }

    public function update_logo(Request $request)
    {
        $user = Auth::guard('restaurant')->user();
        $this->validate($request, [
            'logo' => 'nullable|mimes:jpg,jpeg,png,gif,tif,psd,pmp,webp|max:5000'
        ]);
        $user->update([
            'az_logo' => $request->file('logo') == null ? $user->az_logo : UploadImageEdit($request->file('logo'), 'logo', '/uploads/restaurants/logo', $user->az_logo),
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }

    public function my_restaurant_users()
    {
        if (!auth('restaurant')->check()) {
            return redirect(url('restaurant/login'));
        }
        $restaurant = Auth::guard('restaurant')->user();
        // $users = RestaurantUser::whereRestaurantId($restaurant->id)
        //     ->paginate(500);
        $usersId = Order::where('restaurant_id', $restaurant->id)->get()->pluck('user_id');
        $users = User::whereIn('id', $usersId)->paginate(500);
        return view('restaurant.user.my_users', compact('users'));
    }

    public function updateMyInformation(Request $request, $id = null)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) {
            abort(401);
        }
        if ($id != null) {
            $user = Restaurant::findOrFail($id);
        } else {
            $user = Auth::guard('restaurant')->user();
            if ($user->type == 'employee'):
                if (check_restaurant_permission($user->id, 6) == false):
                    abort(404);
                endif;
                $user = Restaurant::find($user->restaurant_id);
            endif;
        }
        if ($request->method() == 'POST'):

            $this->validate($request, [
                'is_call_phone' => 'required|in:true,false',
                'is_whatsapp' => 'required|in:true,false',
                'call_phone' => 'required_if:is_call_phone,true|nullable|numeric',
                'whatsapp_number' => 'required_if:is_whatsapp,true|nullable|numeric',
            ]);

            $user->update([
                'is_call_phone' => $request->is_call_phone,
                'is_whatsapp' => $request->is_whatsapp,
                'call_phone' => $request->call_phone,
                'whatsapp_number' => $request->whatsapp_number,

            ]);
            flash(trans('messages.updated'))->success();
        endif;


        return view('restaurant.user.contact_information', compact('user'));
    }

    public function updateBarcode(Request $request, $id = null)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) {
            abort(401);
        }
        if ($id != null) {
            $user = Restaurant::findOrFail($id);
        } else {
            $user = Auth::guard('restaurant')->user();
            if ($user->type == 'employee'):
                if (check_restaurant_permission($user->id, 2) == false):
                    abort(404);
                endif;
                $user = Restaurant::find($user->restaurant_id);
            endif;
        }
        if ($request->ar == 'false' && $request->en == 'false') {
            flash(trans('messages.languageError'))->error();
            return redirect()->back();
        }
        $this->validate($request, [
            'name_ar' => 'required|string|max:191',
            'name_en' => 'required|string|max:191',
//            'name_barcode' => 'required|string|max:191|unique:restaurants,name_barcode,' . $user->id,
        ]);
        foreach ([' ', ',', '.'] as $value):
            if (count(explode($value, $request->name_barcode)) > 1):
                throw ValidationException::withMessages([
                    'name_barcode' => trans('messages.error_barcode_name')
                ]);
            endif;
        endforeach;
//        $barcode = str_replace(' ' , '-' , $request->name_barcode);
        $user->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
//            'name_barcode' => $barcode,
        ]);
        // here the main branch should be edited with his restaurant
//        $branch = Branch::whereRestaurantId($user->id)
//            ->where('main', 'true')
//            ->first();
//        if ($branch) {
////            $barcode = str_replace(' ' , '-' , $request->name_barcode);
//            $branch->update([
//                'name_ar' => $request->name_ar,
//                'name_en' => $request->name_en,
////                'name_barcode' => $barcode,
//            ]);
//        }
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }

    public function my_profile_edit(Request $request, $id = null)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) {
            abort(401);
        }
        if ($id != null) {
            $user = Restaurant::findOrFail($id);
        } else {
            $user = Auth::guard('restaurant')->user();
            if ($user->type == 'employee'):
                if (check_restaurant_permission($user->id, 2) == false):
                    abort(404);
                endif;
                $user = Restaurant::find($user->restaurant_id);
            endif;
        }

        $this->validate($request, [
//            'phone_number' => ['required', 'unique:restaurants,phone_number,' . $user->id, 'regex:/^((05)|(01))[0-9]{8}/'],
//            'city_id' => 'required|exists:cities,id',
            'logo' => 'sometimes|mimes:jpg,jpeg,png,gif,tif,psd,pmp,webp|max:5000',
            'lang' => 'required|in:ar,en,both',
            'menu_show_type' => 'required|in:style1,style2,style3',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'commission_payment' => 'nullable|in:user,restaurant'
        ]);

        if ($request->logo != null):
            $user->update([
                'az_logo' => $request->file('logo') == null ? $user->az_logo : UploadImageEdit($request->file('logo'), 'logo', '/uploads/restaurants/logo', $user->az_logo),
            ]);
        endif;
        $user->az_info->update([
            'lang'  => $request->lang,
            'menu_show_type' => $request->menu_show_type,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'commission_payment' => $request->commission_payment,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }

    public function barcode()
    {
        $model = Auth::guard('restaurant')->user();
        if ($model->type == 'employee'):
            if (check_restaurant_permission($model->id, 2) == false):
                abort(404);
            endif;
            $model = Restaurant::find($model->restaurant_id);
        endif;
        return view('restaurant.user.barcode', compact('model'));
    }

    public function barcodePDF()
    {
        $model = Auth::guard('restaurant')->user();
        if ($model->type == 'employee'):
            if (check_restaurant_permission($model->id, 2) == false):
                abort(404);
            endif;
            $model = Restaurant::find($model->restaurant_id);
        endif;
        return view('restaurant.user.barcode_pdf', compact('model'));
    }

    public function urgentBarcode()
    {
        $model = Auth::guard('restaurant')->user();
        if ($model->type == 'employee'):
            if (check_restaurant_permission($model->id, 2) == false):
                abort(404);
            endif;
            $model = Restaurant::find($model->restaurant_id);
        endif;
        return view('restaurant.user.barcode_urgent', compact('model'));
    }

    public function change_pass_update(Request $request, $id = null)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) {
            abort(401);
        }
        if ($id != null) {
            $user = Restaurant::findOrFail($id);
        } else {
            $user = Auth::guard('restaurant')->user();
            if ($user->type == 'employee'):
                if (check_restaurant_permission($user->id, 2) == false):
                    abort(404);
                endif;
                $user = Restaurant::find($user->restaurant_id);
            endif;
        }
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user->password = Hash::make($request->password);
        $user->save();
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }

    public function renew_subscription($id, $admin = null)
    {
        $user = Restaurant::findOrFail($id);
        $admin = $admin == null ? 'restaurant' : 'admin';
        return view('restaurant.user.subscription', compact('user', 'admin'));
    }

    public function information()
    {
        if (!auth('restaurant')->check()) {
            return redirect(url('restaurant/login'));
        }
        $restaurant = Auth::guard('restaurant')->user();
        if ($restaurant->type == 'employee'):
            if (check_restaurant_permission($restaurant->id, 6) == false):
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        return view('restaurant.user.information', compact('restaurant'));
    }

    public function store_information(Request $request)
    {
        if (!auth('restaurant')->check()) {
            return redirect(url('restaurant/login'));
        }
        $this->validate($request, [
            'information_ar' => 'sometimes|string|max:1020',
            'information_en' => 'sometimes|string|max:1020'
        ]);
        $restaurant = Auth::guard('restaurant')->user();
        if ($restaurant->type == 'employee'):
            if (check_restaurant_permission($restaurant->id, 6) == false):
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $restaurant->update([
            'information_ar' => $request->information_ar,
            'information_en' => $request->information_en,
        ]);
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }

    public function RestaurantChangeExternal(Request $request, $id = null)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) {
            abort(401);
        }
        $this->validate($request, [
//            'state' => 'required|in:open,closed,busy,un_available',
            'cart' => 'nullable|in:true,false',
            'menu' => 'nullable|in:vertical,horizontal',
            'show_branches_list' => 'nullable|in:true,false',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'latitude' => 'sometimes',
            'product_menu_view' => 'nullable|string'
        ]);
//        dd($request->all());
        if ($id != null) {
            $restaurant = Restaurant::findOrFail($id);
        } else {
            $restaurant = Auth::guard('restaurant')->user();
            if ($restaurant->type == 'employee'):
                if (check_restaurant_permission($restaurant->id, 2) == false):
                    abort(404);
                endif;
                $restaurant = Restaurant::find($restaurant->restaurant_id);
            endif;
        }

        $restaurant->update([
//            'state' => $request->state,
            'menu' => $request->menu,
            'cart' => $request->cart == null ? $restaurant->cart : $request->cart,
            'show_branches_list' => $request->show_branches_list,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description_ar' => $request->description_ar == null ? $restaurant->description_ar : $request->description_ar,
            'description_en' => $request->description_en == null ? $restaurant->description_en : $request->description_en,
            'product_menu_view' => $request->product_menu_view ?? 'theme-1'
        ]);
        $main_branch = Branch::whereRestaurantId($restaurant->id)
            ->where('main', 'true')
            ->first();
        if ($main_branch) {
            $main_branch->update([
                'latitude' => $restaurant->latitude,
                'longitude' => $restaurant->longitude,
            ]);
        }
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }

    public function RestaurantChangeColors(Request $request, $id)
    {
        if (!auth('admin')->check() and !auth('restaurant')->check()) {
            abort(401);
        }
        $this->validate($request, [
            'restaurant_id' => 'sometimes',
            'main_heads' => 'sometimes',
            'icons' => 'sometimes',
            'options_description' => 'sometimes',
            'background' => 'sometimes',
            'product_background' => 'sometimes',
            'category_background' => 'sometimes',
        ]);
        $restaurant = Restaurant::findOrFail($id);
        if ($restaurant->type == 'employee'):
            if (check_restaurant_permission($restaurant->id, 2) == false):
                abort(404);
            endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        AZRestaurantColor::updateOrCreate(
            ['restaurant_id' => $restaurant->id],
            [
                'main_heads' => $request->main_heads,
                'icons' => $request->icons,
                'options_description' => $request->options_description,
                'background' => $request->background,
                'product_background' => $request->product_background,
                'category_background' => $request->category_background,
            ]
        );
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }



    public function Reset_to_main($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        if ($restaurant) {
            if ($restaurant->az_color != null) {
                $restaurant->az_color->delete();
            }
            flash(trans('messages.updated'))->success();
            return redirect()->back();
        }
    }

    public function Reset_to_bio_main($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        if ($restaurant) {
            if ($restaurant->bio_color != null) {
                $restaurant->bio_color->delete();
            }
            flash(trans('messages.updated'))->success();
            return redirect()->back();
        }
    }

    public function uploadImage(Request $request)
    {

        $request->validate([
            'photo' => 'required|mimes:png,jepg,jpg,svg',
            'action' => 'required|in:edit',
            'item_id' => 'required_if:action,edit|integer|exists:restaurants,id',
        ]);
        if ($request->action == 'edit')
            $item = Restaurant::findOrFail($request->item_id);

        if ($request->photo != null) {
            $photo = UploadImageEdit($request->file('photo'), 'photo', '/uploads/restaurants/logo', (isset($item->photo) ? $item->photo : null));
            if (isset($item->id))
                $item->update([
                    'logo' => $photo,
                ]);
            return response([
                'photo' => $photo,
                'status' => true,
            ]);
        }
        return response('error', 500);
    }

    public function myfatoora_token()
    {
        if (!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;
        $restaurant = auth('restaurant')->user();
        return view('restaurant.user.myfatoora_token', compact('restaurant'));
    }

    public function update_myfatoora_token(Request $request)
    {
        if (!auth('restaurant')->check()):
            return redirect(url('restaurant/login'));
        endif;

        $data = $this->validate($request, [
            'payment_company' => 'nullable|in:myFatoourah,tap,express',
            'online_token' => 'nullable|string',
            'merchant_key' => 'nullable|string',
            'express_password' => 'nullable|string',
            'enable_reservation_online_pay' => 'nullable|in:true,false',
            'enable_party_payment_online' => 'nullable|in:true,false',
            'online_payment_fees' => 'nullable|numeric|min:0.01|max:100',
        ]);
        $restaurant = auth('restaurant')->user();
        $restaurant->update($data);
        flash(trans('messages.updated'))->success();
        return redirect()->back();
    }


}
