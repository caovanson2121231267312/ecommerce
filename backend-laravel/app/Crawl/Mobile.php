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
        $crawler->filter('nav .root #dien-thoai-di-dong')->each(
            function (Crawler $node) {
                $name = $node->filter('a')->text();
                try {
                    $category = Category::create([
                        "name" => $name,
                        "parent_id" => 0,
                        "description" => $name
                    ]);

                    echo "Tạo thành công " . $name . "\n";
                    try {
                        $node->filter('.sub-container .format_3 li')->each(
                            function (Crawler $node) use ($category) {
                                try {
                                    $name = $node->filter('a')->text();
                                    $slug = $node->filter('a')->attr('href');

                                    $c = Category::create([
                                        "name" => $name,
                                        "parent_id" => $category->id,
                                        "description" => $name
                                    ]);

                                    echo "Tạo thành công " . $name . "\n";
                                } catch (\Throwable $th) {
                                    echo "category đã có" . "\n";
                                    echo $th;
                                }
                            }
                        );
                    } catch (\Throwable $th) {
                        // echo $th;
                    }
                } catch (\Throwable $th) {
                    echo "category đã có" . "\n";
                    // echo $th;
                }
            }
        );
        dd(123);

        echo "start" . "\n";
        $url = "https://hoanghamobile.com/laptop?p=25#page_25";
        $client = new Client();

        $crawler = $client->request('GET', $url);

        $crawler->filter('.list-product .item')->each(
            function (Crawler $node) {
                $slug = $node->filter('.img a')->attr("href");

                $crawlerBlogs = (new Client())->request('GET', 'https://hoanghamobile.com' . $slug);

                echo $slug . "\n";

                // $crawlerBlogs->filter('html')->each(
                //     function (Crawler $node) {

                //         $name = $node->filter('.content h1')->text();
                //         $description = $node->filterXPath('//meta[@name="description"]')->attr('content');
                //         $content = $node->filter('.content')->html();
                //         echo $name . "\n";
                //         try {
                //             Article::create([
                //                 "name" => $name,
                //                 "description" => $description,
                //                 "content" => $content,
                //                 "user_id" => 1,
                //                 "category_id" => 1,
                //                 "image" => "bootstrap.png"
                //             ]);

                //             echo "Tạo thành công " . $name . "\n";
                //         } catch (\Throwable $th) {
                //             echo "Article đã có" . "\n";
                //         }
                //         echo "\n";
                //     }
                // );
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
