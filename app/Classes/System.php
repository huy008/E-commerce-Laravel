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
                    'copyright' => ['type' => 'text', 'label' => 'Copyright'],
               ]
          ];
          return $data;
     }
}
