<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantIcon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee') :
            // if (check_restaurant_permission($restaurant->id , 4) == false):
            //     abort(404);
            // endif;
            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;

        if (RestaurantIcon::where('restaurant_id', $restaurant->id)->whereNotNull('code')->count() != 15) :
            $this->baseIcons($restaurant);
        endif;
        $icons = RestaurantIcon::whereRestaurantId($restaurant->id)
            ->orderBy('id', 'desc')
            ->paginate(500);
        return view('restaurant.home_icons.index', compact('icons'));
    }

    private function baseIcons(Restaurant $restaurant)
    {
        $list = [
            [
                'title_ar' => 'التقييم',
                'title_en' => 'Rate Us',
                'sort' => 1,
                'code' => 'feedback',
            ],
            [
                'title_ar' => 'اتصال',
                'title_en' => 'Call us',
                'sort' => 2,
                'code' => 'call_phone',
            ],
            [
                'title_ar' => 'الوتساب',
                'title_en' => 'Whatsapp',
                'sort' => 3,
                'code' => 'whatsapp',
            ],
            [
                'title_ar' => 'نظام الحجوزات',
                'title_en' => 'Reservation',
                'sort' => 4,
                'code' => 'reservation',
            ],
            [
                'title_ar' => 'الحفلات',
                'title_en' => 'Parties',
                'sort' => 4,
                'code' => 'party',
            ],

            [
                'title_ar' => 'تواصل معنا',
                'title_en' => 'Follow Us',
                'sort' => 5,
                'code' => 'follow_us',
            ],
            [
                'title_ar' => 'التوصيل',
                'title_en' => 'Deliveries',
                'sort' => 6,
                'code' => 'deliveries',
            ],
            [
                'title_ar' => 'الحساسية',
                'title_en' => 'Sensitivities',
                'sort' => 7,
                'code' => 'sensitivities',
            ],
            [
                'title_ar' => 'العروض',
                'title_en' => 'Offer',
                'sort' => 8,
                'code' => 'offer',
            ],
            [
                'title_ar' => 'معلومات',
                'title_en' => 'Information',
                'sort' => 9,
                'code' => 'information',
            ],
            [
                'title_ar' => 'الموقع',
                'title_en' => 'Branch',
                'sort' => 10,
                'code' => 'branch',
            ],
            [
                'title_ar' => 'نداء',
                'title_en' => 'Call Waiter',
                'sort' => 11,
                'code' => 'waiter',
            ],

            [
                'title_ar' => 'الانتظار',
                'title_en' => 'Waiting',
                'sort' => 12,
                'code' => 'waiting',
            ],
            [
                'title_ar' => 'ضربة حظ',
                'title_en' => 'Lucky Wheel',
                'sort' => 13,
                'code' => 'lucky',
            ],

        ];
        foreach ($list as $item) :
            if (!RestaurantIcon::where('restaurant_id', $restaurant->id)->where('code', $item['code'])->first()) :
                RestaurantIcon::create([
                    'restaurant_id' => $restaurant->id,
                    'title_ar' => $item['title_ar'],
                    'title_en' => $item['title_en'],
                    'code' => $item['code'],
                    'sort' => $item['sort'],
                ]);
            endif;
        endforeach;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.home_icons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $restaurant = auth('restaurant')->user();
        if ($restaurant->type == 'employee') :

            $restaurant = Restaurant::find($restaurant->restaurant_id);
        endif;
        $this->validate($request, [
            'image'   => 'required|mimes:jpg,jpeg,png,gif,tif,psd,pmp,webp|max:5000',
            'title_ar'  => 'nullable|string|max:191',
            'title_en'  => 'nullable|string|max:191',
            'link' => 'nullable|url',
            'sort' => 'nullable|integer',
        ]);
        RestaurantIcon::create([
            'restaurant_id' => $restaurant->id,
            'image'        => $request->file('image') == null ? null : UploadImage($request->file('image'), 'home_icon', '/uploads/home_icons'),
            'title_ar'       => $request->title_ar,
            'title_en'       => $request->title_en,
            'link'       => $request->link,
            'sort' => $request->sort,
        ]);
        flash(trans('messages.created'))->success();
        return redirect()->route('restaurant.home_icons.index');
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
        $icon = RestaurantIcon::findOrFail($id);
        return view('restaurant.home_icons.edit', compact('icon'));
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
        $poster = RestaurantIcon::findOrFail($id);
        $data = $this->validate($request, [
            'image'   => 'nullable|mimes:jpg,jpeg,png,gif,tif,psd,pmp,webp|max:5000',
            'title_ar'  => 'required|string|max:191',
            'title_en'  => 'required|string|max:191',
            'link' => 'nullable|url',
            'sort' => 'nullable|integer',
        ]);
        $data['image'] = $request->file('image') == null ? $poster->image : UploadImage($request->file('image'), 'home_icon', '/uploads/home_icons');
        $poster->update($data);
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant.home_icons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $icon = RestaurantIcon::findOrFail($id);
        if ($icon->image != null) {
            @unlink(public_path($icon->image_path));
        }
        $icon->delete();
        flash(trans('messages.updated'))->success();
        return redirect()->route('restaurant.home_icons.index');
    }

    public function changeStatus(Request $request, RestaurantIcon $icon, $status)
    {
        if (auth('restaurant')->check() and $restaurant = auth('restaurant')->user() and in_array($status, ['true', 'false']) and $restaurant->id == $icon->restaurant_id) :
            $icon->update([
                'is_active' => $status,
            ]);
            flash(trans('messages.updated'))->success();
            return redirect()->back();
        endif;
        return abort(404);
    }
    public function changeContactStatus(Request $request, RestaurantIcon $icon, $status)
    {
        if (auth('restaurant')->check() and $restaurant = auth('restaurant')->user() and in_array($status, ['true', 'false']) and $restaurant->id == $icon->restaurant_id) :
            $icon->update([
                'contact_us_is_active' => $status,
            ]);
            flash(trans('messages.updated'))->success();
            return redirect()->back();
        endif;
        return abort(404);
    }
}
