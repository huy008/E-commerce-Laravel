<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Repositories\Interfaces\AttributeRepositoryInterface;

/**
 * Class PostService
 * @package App\Services
 */
class AttributeRepository extends BaseRepository implements AttributeRepositoryInterface
{
     protected $model;
     public function __construct(Attribute $model)
     {
          $this->model = $model;
     }

     public function getAttributeById(int $id = 0, $language_id = 0)
     {
          return $this->model->select([
               'attributes.id',
                'attributes.image',
               'attributes.icon',
               'attributes.album',
               'attributes.publish',
               'attributes.follow',
               'tb2.name',
               'tb2.description', 'tb2.content',
               'tb2.meta_title',
               'tb2.meta_description',
               'tb2.meta_keyword'
          ])
               ->join('attribute_language as tb2', 'tb2.attribute_id', '=', 'attributes.id')
               ->where('tb2.language_id', '=', $language_id)
               ->findOrFail($id);
     }

     public function searchAttributes(string $keyword, array $option = [], int $languageId = 0)
     {
          return $this->model->whereHas('attribute_catalogues', function ($query) use ($option) {
               $query->where('attribute_catalogue_id', $option['attributeCatalogueId']);
          })->whereHas('attribute_language', function ($query) use ($keyword) {
               $query->where('name', 'like', '%' . $keyword . '%');
          })->get();
     }
}
