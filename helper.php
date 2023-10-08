<?php

use Hashids\Hashids;



function hashIdInstance()
{
    return  new Hashids(url('/'), 25);
}


function encodeId($id)
{
    // 	$hashIdObject = hashIdInstance();
    // 	return $hashIdObject->encode($id);
    return urlencode(base64_encode($id));
}



function decodeId($slug)
{
    //$hashIdObject = hashIdInstance();
    //return !empty($hashIdObject->decode($slug)[0])?$hashIdObject->decode($slug)[0]:0;;
    return base64_decode(urldecode($slug));
}
/*
	 * Get K , M , 1.4k user  , 43.4M user etc by using number
	 */
function thousandNumberformats($num = 0)
{
    if ($num > 1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }
    return $num;
}


if (!function_exists('renderStarRating')) {
    function renderStarRating($rating, $maxRating = 5)
    {
        $fullStar = "<i class = 'fa fa-star active'></i>";
        $halfStar = "<i class = 'fa fa-star half'></i>";
        $emptyStar = "<i class = 'fa fa-star'></i>";
        $rating = $rating <= $maxRating ? $rating : $maxRating;

        $fullStarCount = (int)$rating;
        $halfStarCount = ceil($rating) - $fullStarCount;
        $emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

        $html = str_repeat($fullStar, $fullStarCount);
        $html .= str_repeat($halfStar, $halfStarCount);
        $html .= str_repeat($emptyStar, $emptyStarCount);
        echo $html;
    }
}

/*
	 * Get Time Ago format time by using timestamp
	 */

function time_Ago($time)
{

    $time = strtotime($time);
    $diff = time() - $time;

    if ($diff < 1) {
        return 'now';
    }

    $time_rules = array(
        12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60       => 'month',
        24 * 60 * 60           => 'day',
        60 * 60                   => 'hour',
        60                       => 'min',
        1                       => 'sec'
    );

    foreach ($time_rules as $secs => $str) {

        $div = $diff / $secs;

        if ($div >= 1) {

            $t = round($div);

            return $t . ' ' . $str .
                ($t > 1 ? 's' : '') . ' ago';
        }
    }
}

function ratingCalculate($totalRating = 0, $numberOfUSers = 0)
{

    $totalRating = count($totalRating);
    $numberOfUSers = (int) $numberOfUSers;

    return round(($totalRating / $numberOfUSers) * 5, 1);
}

function fileExist($path, $public = true)
{
    if ($public) {
        if (is_file('public/' . $path)) {
            return asset($path);
        } else {
            return $path;
        }
    } else {
        return '';
    }
}



function uploadImageAssets($uploadPath, $keyName, $s3 = false)
{
    try {

        if ($s3 === false) {

            $fileName   = time() . $file->getClientOriginalName();
            Storage::disk('public')->put($path . $fileName, File::get($file));
            $file_name  = $file->getClientOriginalName();
            $file_type  = $file->getClientOriginalExtension();
            $filePath   = 'storage/' . $path . $fileName;




            $originalImage = $request->file($keyName);
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path() . '/uploads/' . $folder . '/thumbnail/';
            $originalPath  = public_path() . '/uploads/' . $folder . '/images/';
            $thumbnailImage->save($originalPath . time() . $originalImage->getClientOriginalName());
            $thumbnailImage->resize(400, 400);
            $thumbnailImage->save($thumbnailPath . time() . $originalImage->getClientOriginalName());
            return time() . $originalImage->getClientOriginalName();
        } else {
        }
    } catch (Exception $e) {
        return $this->failure($e->getMessage());
    }
}

function imagePath($path)
{

    $file = public_path($path);

    if (File::exists($file)) {
        return asset($path);
    } else {
        return asset('assets/images/noimage.png');
    }
}

function number_shorten($number, $precision = 0, $divisors = null, $s = false)
{

    // Setup default $divisors if not provided
    if (!isset($divisors)) {
        $divisors = array(
            pow(1000, 0) => '', // 1000^0 == 1
            pow(1000, 1) => 'K', // Thousand
            pow(1000, 2) => 'M', // Million
            pow(1000, 3) => 'B', // Billion
            pow(1000, 4) => 'T', // Trillion
            pow(1000, 5) => 'Qa', // Quadrillion
            pow(1000, 6) => 'Qi', // Quintillion
        );
    }

    // Loop through each $divisor and find the
    // lowest amount that matches
    foreach ($divisors as $divisor => $shorthand) {
        if (abs($number) < ($divisor * 1000)) {
            // We found a match!
            break;
        }
    }

    if ($s) {
        return $shorthand;
    }

    // We found our match, or there were no matches.
    // Either way, use the last defined value for $divisor.
    return number_format($number / $divisor, $precision) . $shorthand;
}

if (!function_exists('_dropzoneCreateUpdate')) {
    function _dropzoneCreateUpdate($key, $value = NULL, $optiondata  = NULL, $vieMode = false)
    {
        $str = '';

        if ($optiondata['maxFiles'] > 1) {
            $filename = $key . '[]';
        } else {
            $filename = $key;
        }
        $textarea = '';
        if (!empty($optiondata['data-textarea1'])) {
            $textarea = 'data-textarea1="image_caption[]"';
        }
        if (empty($vieMode)) {
            $str .= '<div class="dropzone upload-widget"
            data-inputname="' . $filename . '"
            data-max-width="' . $optiondata['width'] . '"
            data-max-height="' . $optiondata['height'] . '"
            data-upload-maxfiles="' . (!empty($optiondata['maxFiles']) ? $optiondata['maxFiles'] : 1) . '"
            data-upload-url="' . route('upload-image') . '"
            data-delete-url="' . route('delete-image') . '"
            data-upload-type="' . $optiondata['filetype'] . '"
            data-upload-folder="' . $optiondata['filepath'] . '"
            ' . $textarea . '
            data-upload-filekey="userfile">
                <div class="dz-message needsclick">
                    Drop files here or click to upload.<br>
                </div>';
        }
        if (!empty($value)) {

            if ($optiondata['maxFiles'] > 1) {
                $exp = explode('{+}', $value);

                foreach ($exp as $userkey => $imgame) {
                    # code...


                    $img = 'public/' . $imgame;


                    if (is_file($img)) {

                        if (empty($vieMode)) {
                            $img = $img;
                            $str .= '<div class="dz-preview dz-processing dz-image-preview dz-complete">
                            <div class="dz-image">
                               ';


                            $str .= '<img data-dz-thumbnail="" alt="' . $value . '" src="' . asset($img) . '">';

                            $str .= '
                            </div>';

                            $str .= '
                            <div class="dz-details">
                                <div class="dz-filename"><span data-dz-name="">' . $imgame . '</span></div>
                            </div>

                            <div class="dropzone-ajaxdata"><div class="dz-remove dz-deletefile" style="" title="Delete"> X </div><input type="hidden" value="' . $imgame . '" class="dz-serveruploadfile" name="' . $filename . '"></div>
                            ';

                            $str .= '</div>';
                        } else {
                            $str .= '<img data-dz-thumbnail=""  src="' . asset($img) . '" width="200">';
                        }
                    }
                }
            } else {

                $img = 'public/' . $value;

                if (is_file($img)) {

                    $img = $img;
                    if (empty($vieMode)) {
                        $str .= '<div class="dz-preview dz-processing dz-image-preview dz-complete">
                        <div class="dz-image">';


                        $str .= '<img data-dz-thumbnail="" alt="' . $value . '" src="' . asset($img) . '">';
                        $str .= '</div>';



                        $str .= '<div class="dz-details">
                            <div class="dz-filename"><span data-dz-name="">' . $value . '</span></div>
                        </div>

                        <div class="dropzone-ajaxdata"><div class="dz-remove dz-deletefile" style="" title="Delete"> X </div><input type="hidden" value="' . $value . '" class="dz-serveruploadfile" name="' . $filename . '"></div>';


                        $str .= '</div>';
                    } else {
                        $str .= '<img data-dz-thumbnail="" alt="' . $value . '" src="' . asset($img) . '" width="200">';
                    }
                }
            }
        }
        if (empty($vieMode)) {
            $str .= '<div class="fallback"><input type="file" name="userfile"></div>

            </div>';
        }

        return $str;
    }
}



function bannerUrlSetting($object)

{



    /// return site_url();
    //    [1=>'Category',2=>'Multiple Products ',3=>'Single Product']
    if ($object->type == 1) {
        $findCat = \App\Models\Categories::find($object->categories_id);
        //return categoryUrl($findCat->cat_id);

    } else if ($object->type == 2) {

        $products = explode(',', $object->multiple_product);
    } else if ($object->type == 3) {
        $findItem = \App\Models\Product::find($object->product_id);
        ///   return productURL($findItem->name,$findItem->p_id);
    } else {

        return 'javascript:;';
    }
}


/************  PRICE Calculation Code */
//converts currency to home default currency
if (!function_exists('convert_price')) {
    function convert_price($price)
    {
        if (Session::has('currency_code') && (Session::get('currency_code') != get_system_default_currency()->code)) {
            $price = floatval($price) / floatval(get_system_default_currency()->exchange_rate);
            $price = floatval($price) * floatval(Session::get('currency_exchange_rate'));
        }
        return $price;
    }
}

//gets currency symbol
if (!function_exists('currency_symbol')) {
    function currency_symbol()
    {
        if (Session::has('currency_symbol')) {
            return Session::get('currency_symbol');
        }
        return '$ ';
    }
}

//return file uploaded via uploader
if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {


        return '';
    }
}

//formats currency
if (!function_exists('format_price')) {
    function format_price($price)
    {
        if (get_setting('decimal_separator') == 1) {
            $fomated_price = number_format($price, get_setting('no_of_decimals'));
        } else {
            $fomated_price = number_format($price, get_setting('no_of_decimals'), ',', ' ');
        }

        if (get_setting('symbol_format') == 1) {
            return currency_symbol() . $fomated_price;
        } else if (get_setting('symbol_format') == 3) {
            return currency_symbol() . ' ' . $fomated_price;
        } else if (get_setting('symbol_format') == 4) {
            return $fomated_price . ' ' . currency_symbol();
        }
        $fomated_price = $price;
        return $fomated_price . currency_symbol();
    }
}

//formats price to home default price with convertion
if (!function_exists('single_price')) {
    function single_price($price)
    {
        return format_price(convert_price($price));
    }
}

if (!function_exists('discount_in_percentage')) {
    function discount_in_percentage($product)
    {
        try {
            $base = home_base_price($product, false);
            $reduced = home_discounted_base_price($product, false);
            $discount = $base - $reduced;
            $dp = ($discount * 100) / $base;
            return round($dp);
        } catch (Exception $e) {
        }
        return 0;
    }
}

//Shows Price on page based on low to high
if (!function_exists('home_price')) {
    function home_price($product, $formatted = true)
    {
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {

            foreach ($product->stocks as $key => $stock) {

                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }


        if (!empty($product->taxes)) {
            // foreach ($product->taxes as $product_tax) {
            //     if ($product_tax->tax_type == 'percent') {
            //         $lowest_price += ($lowest_price * $product_tax->tax) / 100;
            //         $highest_price += ($highest_price * $product_tax->tax) / 100;
            //     } elseif ($product_tax->tax_type == 'amount') {
            //         $lowest_price += $product_tax->tax;
            //         $highest_price += $product_tax->tax;
            //     }
            // }
        }



        if ($formatted) {
            if ($lowest_price == $highest_price) {
                return format_price(convert_price($lowest_price));
            } else {
                return format_price(convert_price($lowest_price)) . ' - ' . format_price(convert_price($highest_price));
            }
        } else {
            return $lowest_price . ' - ' . $highest_price;
        }
    }
}

//Shows Price on page based on low to high with discount
if (!function_exists('home_discounted_price')) {
    function home_discounted_price($product, $formatted = true)
    {
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        $discount_applicable = false;


        if ($product->discount_start_date == null) {
            $discount_applicable = false;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }


        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $lowest_price -= ($lowest_price * $product->discount) / 100;
                $highest_price -= ($highest_price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }


        // foreach ($product->taxes as $product_tax) {
        //     if ($product_tax->tax_type == 'percent') {
        //         $lowest_price += ($lowest_price * $product_tax->tax) / 100;
        //         $highest_price += ($highest_price * $product_tax->tax) / 100;
        //     } elseif ($product_tax->tax_type == 'amount') {
        //         $lowest_price += $product_tax->tax;
        //         $highest_price += $product_tax->tax;
        //     }
        // }

        if ($formatted) {
            if ($lowest_price == $highest_price) {
                return format_price(convert_price($lowest_price));
            } else {
                return format_price(convert_price($lowest_price)) . ' - ' . format_price(convert_price($highest_price));
            }
        } else {
            return $lowest_price . ' - ' . $highest_price;
        }
    }
}

//Shows Base Price
if (!function_exists('home_base_price_by_stock_id')) {
    function home_base_price_by_stock_id($id)
    {
        $product_stock = \App\Models\ProductStocks::findOrFail($id);
        $price = $product_stock->price;
        $tax = 0;

        foreach ($product_stock->product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;
        return format_price(convert_price($price));
    }
}
if (!function_exists('home_base_price')) {
    function home_base_price($product, $formatted = true)
    {
        $price = $product->unit_price;
        $tax = 0;

        if (!empty($product->taxes)) {
            foreach ($product->taxes as $product_tax) {
                if ($product_tax->tax_type == 'percent') {
                    $tax += ($price * $product_tax->tax) / 100;
                } elseif ($product_tax->tax_type == 'amount') {
                    $tax += $product_tax->tax;
                }
            }
        }

        $price += $tax;
        return $formatted ? format_price(convert_price($price)) : $price;
    }
}

//Shows Base Price with discount
if (!function_exists('home_discounted_base_price_by_stock_id')) {
    function home_discounted_base_price_by_stock_id($id)
    {
        $product_stock = \App\Models\ProductStocks::findOrFail($id);
        $product = $product_stock->product;
        $price = $product_stock->price;
        $tax = 0;

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if (!empty($product->taxes)) {
            foreach ($product->taxes as $product_tax) {
                if ($product_tax->tax_type == 'percent') {
                    $tax += ($price * $product_tax->tax) / 100;
                } elseif ($product_tax->tax_type == 'amount') {
                    $tax += $product_tax->tax;
                }
            }
        }

        $price += $tax;

        return format_price(convert_price($price));
    }
}

//Shows Base Price with discount
if (!function_exists('home_discounted_base_price')) {
    function home_discounted_base_price($product, $formatted = true)
    {
        $price = $product->unit_price;
        $tax = 0;

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if (!empty($product->taxes)) {
            foreach ($product->taxes as $product_tax) {
                if ($product_tax->tax_type == 'percent') {
                    $tax += ($price * $product_tax->tax) / 100;
                } elseif ($product_tax->tax_type == 'amount') {
                    $tax += $product_tax->tax;
                }
            }
        }

        $price += $tax;

        return $formatted ? format_price(convert_price($price)) : $price;
    }
}


if (!function_exists('get_setting')) {
    function get_setting($key, $default = null, $lang = false)
    {
        $setting = \App\Models\WebsiteModel::where('type', $key)->first();

        return $setting == null ? $default : $setting->value;
    }
}

if (!function_exists('get_title')) {
    function get_title($key, $default = null, $lang = false)
    {
        $setting = \App\Models\WebsiteModel::where('type', $key)->first();

        return $setting == null ? $default : $setting->title;
    }
}


function translate($key)
{
    return $key;
}

if (!function_exists('OrderArray')) {
    function OrderArray()
    {
        $Ordering[250] = 'Default';
        foreach (range(1, 100) as $i) {
            $Ordering[$i] = $i;
        }
        return $Ordering;
    }
}
