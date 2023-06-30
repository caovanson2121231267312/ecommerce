<?php

namespace App\Crawl;

use Exception;
use Goutte\Client;
use App\Models\Tag;
use App\Models\Rate;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductInfor;
use Symfony\Component\DomCrawler\Crawler;

class Product
{
    public $domain = "https://hoanghamobile.com/dien-thoai-di-dong?&p=15#page_15";
    public $arr = [
        "dien-thoai-di-dong",
        "dong-ho",
        "laptop",
        "man-hinh",
        "smart-tv",
        "tablet",
        "loa-tai-nghe",
        "smart-home",
        "phu-kien",
        "do-choi-cong-nghe",
        "kho-san-pham-cu",
        "am-thanh",
    ];

    public $select = '';

    public function html()
    {
        foreach ($this->arr as $category) {
            $this->select = $category;
            $crawler = (new Client())->request('GET', "https://hoanghamobile.com/" . $category . "?&p=15#page_15");
            $i = 5;

            // dd($crawler);
            $crawler->filter('.list-product .item')->each(
                function (Crawler $node) {
                    $slug = $node->filter('.info a')->attr('href');
                    echo "\n";
                    echo $slug . "\n";
                    $i = 5;
                    begin:

                    try {
                        $crawler = (new Client())->request('GET', "https://hoanghamobile.com" . $slug);
                    } catch (Exception $e) {
                        dump($e);
                        dump("retry -- " . $i);
                        if ($i) {
                            $i--;
                            goto begin;
                        }
                    }

                    $crawler->filter('html')->each(
                        function (Crawler $node) {
                            $retry = 5;
                            start:
                            try {
                                $name = $node->filter('.product-details .top-product h1')->text();
                                echo $name . "\n";
                                $price = intval(str_replace([",", "₫"], "", $node->filter('.price.current-product-price strong')->text()));

                                try {
                                    $price_sale = intval(str_replace([",", "₫"], "", $node->filter('.price.current-product-price strike')->text()));
                                    $sale = round(100 - ($price / $price_sale) * 100, 2);
                                } catch (Exception $e) {
                                    $sale = 0;
                                }
                                echo $sale . "\n";
                                try {
                                    $productName = '';
                                    try {
                                        $productName = $node->filter('ol.breadcrumb li:nth-child(5) span')->text();
                                    } catch (Exception $e) {
                                        $productName = $node->filter('.product-details .top-product')->text();
                                    }

                                    $category_name = $node->filter('ol.breadcrumb li:nth-child(2) span')->text();
                                    $category = Category::firstOrCreate([
                                        'name' => $category_name,
                                        'parent_id' => 0,
                                        'description' => $category_name,
                                    ]);

                                    $brand_name = $node->filter('ol.breadcrumb li:nth-child(3) span')->text();
                                    $brand = \App\Models\Brand::firstOrCreate([
                                        'name' => $brand_name,
                                    ]);

                                    $category->brands()->syncWithoutDetaching([$brand->id]);

                                    $productTag = $node->filter('ol.breadcrumb li:nth-child(4) span')->text();
                                    $tag = \App\Models\Tag::firstOrCreate([
                                        'name' => $productTag,
                                    ]);

                                    $images = array();
                                    $i = 0;
                                    $node->filter('.product-image .viewer a')->each(
                                        function (Crawler $node) use (&$i, $productName, &$images) {
                                            // $url = $node->filter('img')->text();
                                            $image_url = $node->filter('a')->attr('href');
                                            // echo $image_url . "\n";
                                            $image_name = basename($image_url);
                                            $image_data = file_get_contents($image_url);
                                            if (!file_exists('public/images/products/' . $this->select)) {
                                                mkdir('public/images/products/' . $this->select, 0777, true);
                                            }
                                            file_put_contents('public/images/products/' . $this->select . "/" . $image_name, $image_data);
                                            array_push($images, [
                                                'id' => $i,
                                                'image' => 'images/products/' . $this->select . "/" . $image_name,
                                                'title' => $productName,
                                            ]);
                                            $i++;
                                        }
                                    );
                                    $i = 0;

                                    // dump($images);
                                    $arr['images'] = json_encode($images, true);

                                    $data = [
                                        "name" => $node->filter('.product-details .top-product')->text(),
                                        "description" => $node->filter('meta[name="description"]')->attr('content'),
                                        "price" => $price,
                                        "category_id" => $category->id,
                                        "sale" => $sale,
                                        'content' => $node->filter('#productContent')->html(),
                                        'sale' => $sale,
                                        'status' => 1,
                                        'quantity' => rand(10, 10000),
                                        'time_sale' => \Carbon\Carbon::createFromFormat('d-m-Y', '09-12-2023')->format('Y-m-d H:i:s'),
                                        'user_id' => 1,
                                        'brand_id' => $brand->id,
                                    ];
                                    $data = array_merge($data, $arr);

                                    $product = \App\Models\Product::create($data);
                                    $product->tags()->attach($tag->id);

                                    try {
                                        $node->filter('.product-right .product-specs ol li')->each(
                                            function (Crawler $node) use ($product) {
                                                ProductInfor::create([
                                                    'name' =>  $node->filter('strong')->text(),
                                                    'detail' => $node->filter('span')->text(),
                                                    'product_id' => $product->id,
                                                ]);
                                            }
                                        );
                                    } catch (Exception $e) {
                                        echo $e . "\n";
                                    }

                                    $gt = rand(1, 5);

                                    for ($i = 0; $i <= $gt; $i++) {
                                        Rate::create([
                                            'rate' => rand(1, 5),
                                            'content' => 'DEV CaoSon',
                                            'check' => 1,
                                            'user_id' => 1,
                                            'product_id' => $product->id,
                                        ]);
                                    }
                                } catch (Exception $e) {
                                    echo "Bỏ qua node này" . "\n\n";
                                    echo $e . "\n";
                                }
                                echo "\n";

                                // $retry = 5;
                            } catch (Exception $e) {
                                echo "Bỏ qua node này" . "\n\n";
                                echo $e . "\n";

                                if ($retry) {
                                    $retry--;
                                    goto start;
                                }
                            }
                        }
                    );
                }
            );
        }
    }

    function to_slug($str, $char = "-")
    {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', $char, $str);
        return $str;
    }

    function removeAllSpace($str)
    {
        return preg_replace('/\s+/', ' ', str_replace(array("\r", "\n"), " ", $str));
    }
}
