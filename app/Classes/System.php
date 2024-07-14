<?php

namespace App\classes;

class System
{
     public function config()
     {
          $data['homepage'] = [
               'label' => 'Thông tin chung',
               'description' => 'Cài đặt đầy đủ thông tin chung của website. Tên thương hiệu
hiệu website, Logo, Favicon, vv...',
               'value' => [
                    'company' => ['type' => 'text', 'label' => 'Tên công ty'],
                    'brand' => ['type' => 'text', 'label' => 'Tên thương hiệu'],
                    'slogan' => ['type' => 'text', 'label' => 'Slogan'],
                    'logo' => ['type' => 'images', 'label' => 'Logo Website', 'title' => 'Click vào ô phía dưới để tải logo'],
                    'favicon' => ['type' => 'images', 'label' => 'favicon Website', 'title' => 'Click vào ô phía dưới để tải favicon'],
                    'copyright' => ['type' => 'text', 'label' => 'Copyright'],
                    'website' => [
                         'type' => 'select', 'label' => 'Tinh trang website',
                         'option' => ['open' => 'Mo cua website', 'close' => 'dong website']
                    ],
                    'short_intro'=>['type' => 'editor', 'label' => 'Gioi thieu ngan']
               ]
          ];
          $data['contact'] = [
               'label' => 'Thông tin Liên hệ',
               'description' => 'Cài đặt thông tin liên hệ của website ví dụ: Địa chỉ công ty,
Văn phòng giao dịch, Hotline, Bản đồ, vv...',
               'value' => [
                    'office' => ['type' => 'text', 'label' => 'Địa chỉ công ty'],
                    'address' => ['type' => 'text', 'label' => 'Văn phòng giao dịch'],
                    'hotline' => ['type' => 'text', 'label' => 'Hotline'],
                    'technical_phone' => ['type' => 'text', 'label' => 'Hotline kỹ thuật'],
                    'sell_phone' => ['type' => 'text', 'label' => 'Hotline kinh doanh'],
                    'phone' => ['type' => 'text', 'label' => 'Số cố định'],
                    'fax' => ['type' => 'text', 'label' => 'Fax'],
                    'email' => ['type' => 'text', 'label' => 'Email'],
                    'tax' => ['type' => 'text', 'label' => 'Mã số thuế'],
                    'website' => ['type' => 'text', 'label' => 'Website'],
                    'map' => ['type' => 'textarea', 'label' => 'Bản đồ', 'link' => [
                         'text' => 'Hướng dẫn thiết lập bản đồ',
                         'href' => '#'
                    ]],
               ]
          ];

          $data['seo'] = [
               'label' => 'Cấu hình SEO dành cho trang chủ',
               'description' => 'Cài đặt đầy đủ thông tin về SEO của trang chủ website. Bao gồm
tiêu đề SEO, Từ Khóa SEO, Mô Tả SEO, Meta images',
               'value' => [
                    'meta_title' => ['type' => 'text', 'label' => 'Tiêu đề SEO'],
                    'meta_keyword' => ['type' => 'text', 'label' => 'Từ khóa SEO'],
                    'meta_description' => ['type' => 'text', 'label' => 'Mô tả SEO'],
                    'meta_images' => ['type' => 'images', 'label' => 'Ảnh SEO'],
               ]
          ];
          return $data;
     }
}
