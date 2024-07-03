<?php

namespace App\Http\Controllers\Ajax;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;

class AttributeController extends Controller
{
     protected $attributeRepository;
     protected $language;

     public function __construct(AttributeRepository $attributeRepository)
     {
          $this->attributeRepository = $attributeRepository;
          $this->language = $this->currentLanguage();
     }

    public function getAttribute(Request $request){
          

     $payload = $request->input();
     
     $attributes = $this->attributeRepository->searchAttributes($payload['search'],$payload['option'],$this->language);
   
     $attributeMapped = $attributes->map(function($attribute){
          return [
               'id' => $attribute->id,
               'text' => $attribute->attribute_language->first()->name
          ];
     })->all();
     
     return response()->json(array('items' => $attributeMapped));
  
    }
}
