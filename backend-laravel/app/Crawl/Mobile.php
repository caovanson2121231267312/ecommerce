<?php

namespace App\Crawl;

use Goutte\Client;
use App\Models\Category;
use Symfony\Component\DomCrawler\Crawler;

class Mobile
{
    public $domain = "https://hoanghamobile.com";

    public function html()
    {
        $crawler = (new Client())->request('GET', $this->domain);
        $crawler->filter('nav ul.root li span')->each(
            function (Crawler $node) {
                $name = $node->filter('span')->html();
                try {
                    $category = Category::create([
                        "name" => $name,
                        "parent_id" => 0,
                        "description" => $name
                    ]);

                    echo "Tạo thành công " . $name . "\n";
                } catch (\Throwable $th) {
                    echo "category đã có" . "\n";
                    // echo $th;
                }
            }
        );
    }

    public function brand()
    {
        $crawler = (new Client())->request('GET', $this->domain);
        $crawler->filter('nav .root #dien-thoai-di-dong .sub-container .format_3 li')->each(
            function (Crawler $node) {
                $name = $node->filter('a')->text();
                try {
                    \App\Models\Brand::create([
                        "name" => $name,
                    ]);
                    echo "Tạo thành công " . $name . "\n";
                } catch (\Throwable $th) {
                    echo "brand đã có" . "\n";
                }
            }
        );
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