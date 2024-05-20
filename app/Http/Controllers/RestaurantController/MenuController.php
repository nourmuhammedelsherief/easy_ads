<?php

namespace App\Http\Controllers\RestaurantController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\AzRestaurantSlider;
use App\Models\AZRestaurantPoster;
use App\Models\AZRestaurantSensitivity;
use \Illuminate\Support\Facades\DB;
use App\Models\Restaurant\Azmak\AZBranch;
use App\Models\Restaurant\Azmak\AZMenuCategory;
use App\Models\Restaurant\Azmak\AZMenuCategoryDay;
use App\Models\Restaurant\Azmak\AZRestaurantSubCategory;
use App\Models\Restaurant\Azmak\AZProduct;
use App\Models\Restaurant\Azmak\AZModifier;
use App\Models\Restaurant\Azmak\AZOption;
use App\Models\Restaurant\Azmak\AZProductDay;
use App\Models\Restaurant\Azmak\AZProductSensitivity;
use App\Models\Restaurant\Azmak\AZProductModifier;
use App\Models\Restaurant\Azmak\AZProductSize;
use App\Models\Restaurant\Azmak\AZProductOption;
use Image;

class MenuController extends Controller
{
    public function integrations()
    {
        $restaurant = auth('restaurant')->user();
        return view('restaurant.integrations.index' , compact('restaurant'));
    }
    public function copy_menu($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        // copy restaurant sliders
        $sliders = DB::table('restaurant_sliders')->whereRestaurantId($restaurant->id)->get();
        if ($sliders->count() > 0) {
            foreach ($sliders as $slider) {
                $image = null;
                if (isset($slider->photo) and ($slider->type == 'image' or $slider->type == 'gif')) {
                    $info = pathinfo('https://easymenu.site/uploads/sliders/' . $slider->photo);
                    $contents = file_get_contents('https://easymenu.site/uploads/sliders/' . $slider->photo);
                    $file = '/tmp/' . $info['basename'];
                    file_put_contents($file, $contents);
                    $image = $info['basename'];
                    $destinationPath = public_path('/' . 'uploads/sliders');
                    $img = Image::make($file);
                    $img->resize(500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath . '/' . $image);
                }
                AzRestaurantSlider::create([
                    'restaurant_id' => $restaurant->id,
                    'photo' => $image,
                    'type' => $slider->type,
                    'youtube' => $slider->youtube,
                    'description_en' => $slider->description_en,
                    'description_ar' => $slider->description_ar,
                    'stop' => $slider->stop,
                ]);
            }
        }

        // copy restaurant posters
        $posters = DB::table('restaurant_posters')->whereRestaurantId($restaurant->id)->get();
        if ($posters->count() > 0) {
            foreach ($posters as $poster) {
                $image = null;
                $check_poster = AZRestaurantPoster::whereRestaurantId($restaurant->id)->whereNameAr($poster->name_ar)->first();
                if (isset($poster->poster)) {
                    $info = pathinfo('https://easymenu.site/uploads/posters/' . $poster->poster);
                    $contents = file_get_contents('https://easymenu.site/uploads/posters/' . $poster->poster);
                    $file = '/tmp/' . $info['basename'];
                    file_put_contents($file, $contents);

                    $image = $info['basename'];
                    $destinationPath = public_path('/' . 'uploads/posters');
                    $img = Image::make($file);
                    $img->resize(500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath . '/' . $image);
                }
                if (!isset($check_poster)) {
                    AZRestaurantPoster::create([
                        'restaurant_id' => $restaurant->id,
                        'name_ar' => $poster->name_ar,
                        'name_en' => $poster->name_en,
                        'poster' => $image,
                        'easy_id' => $poster->id,
                    ]);
                }
            }
        }

        // copy restaurant sensitivities
        $sensitivities = DB::table('restaurant_sensitivities')->whereRestaurantId($restaurant->id)->get();
        if ($sensitivities->count() > 0) {
            foreach ($sensitivities as $sensitivity) {
                $check_sensitivity = AZRestaurantSensitivity::whereRestaurantId($restaurant->id)->whereNameAr($sensitivity->name_ar)->first();
                $image = null;
                if (isset($sensitivity->photo)) {
                    $info = pathinfo('https://easymenu.site/uploads/sensitivities/' . $sensitivity->photo);
                    $contents = file_get_contents('https://easymenu.site/uploads/sensitivities/' . $sensitivity->photo);
                    $file = '/tmp/' . $info['basename'];
                    file_put_contents($file, $contents);

                    $image = $info['basename'];
                    $destinationPath = public_path('/' . 'uploads/sensitivities');
                    $img = Image::make($file);
                    $img->resize(500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath . '/' . $image);
                }
                if (!isset($check_sensitivity)) {
                    AZRestaurantSensitivity::create([
                        'restaurant_id' => $restaurant->id,
                        'name_ar' => $sensitivity->name_ar,
                        'name_en' => $sensitivity->name_en,
                        'photo' => $image,
                        'details_ar' => $sensitivity->details_ar,
                        'details_en' => $sensitivity->details_en,
                        'easy_id' => $sensitivity->id,
                    ]);
                }
            }
        }

        // copy restaurant modifiers
        $modifiers = DB::table('modifiers')->whereRestaurantId($restaurant->id)->get();
        if ($modifiers->count() > 0) {
            foreach ($modifiers as $modifier) {
                AZModifier::create([
                    'restaurant_id' => $restaurant->id,
                    'name_ar' => $modifier->name_ar,
                    'name_en' => $modifier->name_en,
                    'is_ready' => $modifier->is_ready,
                    'choose' => $modifier->choose,
                    'sort' => $modifier->sort,
                    'custom' => $modifier->custom,
                    'easy_id' => $modifier->id,
                ]);
            }
        }

        // copy restaurant options
        $options = DB::table('options')->whereRestaurantId($restaurant->id)->get();
        if ($options->count() > 0) {
            foreach ($options as $option) {
                $modifier = AZModifier::whereEasyId($option->modifier_id)->first();
                if (isset($modifier)) {
                    AZOption::create([
                        'restaurant_id' => $restaurant->id,
                        'modifier_id' => $modifier?->id,
                        'name_ar' => $option->name_ar,
                        'name_en' => $option->name_en,
                        'is_active' => $option->is_active,
                        'price' => $option->price,
                        'calories' => $option->calories,
                        'easy_id' => $option->id,
                    ]);
                }
            }
        }

        // copy branches
        $branches = DB::table('branches')->whereRestaurantId($restaurant->id)->get();
        if ($branches->count() > 0) {
            foreach ($branches as $branch) {
                $az_branch = AZBranch::create([
                    'restaurant_id' => $restaurant->id,
                    'city_id' => $branch->city_id,
                    'name_ar' => $branch->name_ar,
                    'name_en' => $branch->name_en,
                    'latitude' => $branch->latitude,
                    'longitude' => $branch->longitude,
                ]);
                // get menu categories for this branch
                $menu_categories = DB::table('menu_categories')
                    ->whereRestaurantId($restaurant->id)
                    ->whereBranchId($branch->id)
                    ->get();
                foreach ($menu_categories as $menu_category) {
                    $image = 'default.jpg';
                    if (isset($menu_category->photo)) {
                        $info = pathinfo('https://easymenu.site/uploads/menu_categories/' . $menu_category->photo);
                        $contents = file_get_contents('https://easymenu.site/uploads/menu_categories/' . $menu_category->photo);
                        $file = '/tmp/' . $info['basename'];
                        file_put_contents($file, $contents);

                        $image = $info['basename'];
                        $destinationPath = public_path('/' . 'uploads/menu_categories');
                        $img = Image::make($file);
                        $img->resize(500, 500, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath . '/' . $image);
                    }
                    $az_menu_category = AZMenuCategory::create([
                        'restaurant_id' => $restaurant->id,
                        'branch_id' => $az_branch->id,
                        'name_ar' => $menu_category->name_ar,
                        'name_en' => $menu_category->name_en,
                        'photo' => $image,
                        'active' => $menu_category->active,
                        'arrange' => $menu_category->arrange,
                        'description_ar' => $menu_category->description_ar,
                        'description_en' => $menu_category->description_en,
                        'time' => $menu_category->time,
                        'start_at' => $menu_category->start_at,
                        'end_at' => $menu_category->end_at,
                    ]);
                    // create menu category days
                    $menu_category_days = DB::table('menu_category_days')
                        ->whereMenuCategoryId($menu_category->id)
                        ->get();
                    if ($menu_category_days->count() > 0) {
                        foreach ($menu_category_days as $menu_category_day) {
                            AZMenuCategoryDay::create([
                                'menu_category_id' => $az_menu_category->id,
                                'day_id' => $menu_category_day->day_id,
                            ]);
                        }
                    }

                    // create sub categories
                    $sub_categories = DB::table('restaurant_sub_categories')
                        ->whereMenuCategoryId($menu_category->id)
                        ->get();
                    if ($sub_categories->count() > 0) {
                        foreach ($sub_categories as $sub_category) {
                            AZRestaurantSubCategory::create([
                                'menu_category_id' => $az_menu_category->id,
                                'name_ar' => $sub_category->name_ar,
                                'name_en' => $sub_category->name_en,
                                'image' => $sub_category->image,
                                'easy_id' => $sub_category->id,
                            ]);
                        }
                    }

                    // create products
                    $products = DB::table('products')
                        ->whereRestaurantId($restaurant->id)
                        ->whereBranchId($branch->id)
                        ->whereMenuCategoryId($menu_category->id)
                        ->get();
                    if ($products->count() > 0) {
                        foreach ($products as $product) {
                            $sub_category_id = AZRestaurantSubCategory::where('easy_id', $product->sub_category_id)->first();
                            $poster_id = AZRestaurantPoster::whereRestaurantId($restaurant->id)
                                ->where('easy_id', $product->poster_id)
                                ->first();
                            $PImage = 'default.jpg';;
                            if (isset($product->photo) and $product->photo != 'default.png') {
                                // product photo
                                $info = pathinfo('https://easymenu.site/uploads/products/' . $product->photo);
                                $contents = file_get_contents('https://easymenu.site/uploads/products/' . $product->photo);
                                $file = '/tmp/' . $info['basename'];
                                file_put_contents($file, $contents);

                                $PImage = $info['basename'];
                                $destinationPath = public_path('/' . 'uploads/products');
                                $img = Image::make($file);
                                $img->resize(500, 500, function ($constraint) {
                                    $constraint->aspectRatio();
                                })->save($destinationPath . '/' . $PImage);
                            }

                            $az_product = AZProduct::create([
                                'restaurant_id' => $restaurant->id,
                                'branch_id' => $az_branch->id,
                                'menu_category_id' => $az_menu_category->id,
                                'sub_category_id' => $sub_category_id?->id,
                                'poster_id' => $poster_id?->id,
                                'name_ar' => $product->name_ar,
                                'name_en' => $product->name_en,
                                'active' => $product->active,
                                'description_ar' => $product->description_ar,
                                'description_en' => $product->description_en,
                                'time' => $product->time,
                                'start_at' => $product->start_at,
                                'end_at' => $product->end_at,
                                'photo' => $PImage,
                                'available' => $product->available,
                                'price' => $product->price,
                                'price_before_discount' => $product->price_before_discount,
                                'calories' => $product->calories,
                                'arrange' => $product->arrange,
//                                'video_type' => $product->video_type,
//                                'video_id' => $product->video_id,
                            ]);

                            // create product days
                            $product_days = DB::table('product_days')->whereProductId($product->id)->get();
                            if ($product_days->count() > 0) {
                                foreach ($product_days as $product_day) {
                                    AZProductDay::create([
                                        'product_id' => $az_product->id,
                                        'day_id' => $product_day->day_id,
                                    ]);
                                }
                            }

                            // create product sensitivities
                            $product_sensitivities = DB::table('product_sensitivities')->whereProductId($product->id)->get();
                            if ($product_sensitivities->count() > 0) {
                                foreach ($product_sensitivities as $product_sensitivity) {
                                    $pSensitivity = AZRestaurantSensitivity::whereEasyId($product_sensitivity->sensitivity_id)->first();
                                    if ($pSensitivity) {
                                        AZProductSensitivity::create([
                                            'product_id' => $az_product->id,
                                            'sensitivity_id' => $pSensitivity->id,
                                        ]);
                                    }
                                }
                            }

                            // create product modifiers
                            $product_modifiers = DB::table('product_modifiers')->whereProductId($product->id)->get();
                            if ($product_modifiers->count() > 0) {
                                foreach ($product_modifiers as $product_modifier) {
                                    $Pmodifier = AZModifier::whereEasyId($product_modifier->modifier_id)->first();
                                    if (isset($Pmodifier)):
                                        AZProductModifier::create([
                                            'product_id' => $az_product->id,
                                            'modifier_id' => $Pmodifier->id,
                                        ]);
                                    endif;
                                }
                            }

                            // create product options
                            $product_options = DB::table('product_options')->whereProductId($product->id)->get();
                            if ($product_options->count() > 0) {
                                foreach ($product_options as $product_option) {
                                    $pModifier = AZModifier::whereEasyId($product_option->modifier_id)->first();
                                    $pOption = AZOption::whereEasyId($product_option->option_id)->first();
                                    if ($pModifier and $pOption) {
                                        AZProductOption::create([
                                            'product_id' => $az_product->id,
                                            'modifier_id' => $pModifier->id,
                                            'option_id' => $pOption->id,
                                            'max' => $product_option->max,
                                            'min' => $product_option->min,
                                        ]);
                                    }
                                }
                            }

                            // create product sizes
                            $product_sizes = DB::table('product_sizes')->whereProductId($product->id)->get();
                            if ($product_sizes->count() > 0) {
                                foreach ($product_sizes as $product_size) {
                                    AZProductSize::create([
                                        'product_id' => $az_product->id,
                                        'name_ar' => $product_size->name_ar,
                                        'name_en' => $product_size->name_en,
                                        'price' => $product_size->price,
                                        'calories' => $product_size->calories,
                                        'status' => $product_size->status,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
        flash(trans('messages.menuCopiedSuccessfully'))->success();
        return redirect()->back();
    }
}
