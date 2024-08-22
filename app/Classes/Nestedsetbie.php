<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Nestedsetbie
{

     function __construct($params = NULL)
     {
          $this->params = $params;
          $this->checked = NULL;
          $this->data = NULL;
          $this->count = 0;
          $this->count_level = 0;
          $this->left = NULL;
          $this->right = NULL;
          $this->level = NULL;
     }

     public function Get()
     {
          $catalogue = (isset($this->params['isMenu'])&&$this->params['isMenu']==true) ? '' : '_catalogue';
          $moduleExtract = explode('_', $this->params['table']);
          $join = (isset($this->params['isMenu']) && $this->params['isMenu'] == true) ? substr($moduleExtract[0],0,-1) : $moduleExtract[0];
          $foreignkey = (isset($this->params['foreignkey'])) ? $this->params['foreignkey'] : $join.'_catalogue_id';
          $result = DB::table($this->params['table'] . ' as tb1')
               ->select('tb1.id', 'tb2.name', 'tb1.parentid', 'tb1.left', 'tb1.right', 'tb1.level', 'tb1.order')
               ->join($join. $catalogue. '_language as tb2', 'tb1.id', '=', 'tb2.' . $foreignkey . '')
               ->where('tb2.language_id', '=', $this->params['language_id'])->whereNull('tb1.deleted_at')
               ->orderBy('tb1.left', 'asc')->get()->toArray();
          $this->data = $result;
     }

     public function Set()
     {
          if (isset($this->data) && is_array($this->data)) {
               $arr = NULL;
               foreach ($this->data as $key => $val) {
                    $arr[$val->id][$val->parentid] = 1;
                    $arr[$val->parentid][$val->id] = 1;
               }
               return $arr;
          }
     }

     public function Recursive($start = 0, $arr = NULL)
     {
          $this->left[$start] = ++$this->count;
          $this->level[$start] = $this->count_level;
          if (isset($arr) && is_array($arr)) {
               foreach ($arr as $key => $val) {
                    if ((isset($arr[$start][$key]) || isset($arr[$key][$start])) && (!isset($this->checked[$key][$start]) && !isset($this->checked[$start][$key]))) {
                         $this->count_level++;
                         $this->checked[$start][$key] = 1;
                         $this->checked[$key][$start] = 1;
                         $this->recursive($key, $arr);
                         $this->count_level--;
                    }
               }
          }
          $this->right[$start] = ++$this->count;
     }

     public function Action()
     {
          if (isset($this->level) && is_array($this->level) && isset($this->left) && is_array($this->left) && isset($this->right) && is_array($this->right)) {

               $data = NULL;
               foreach ($this->level as $key => $val) {
                    if ($key == 0) continue;
                    $data[] = array(
                         'id' => $key,
                         'level' => $val,
                         'left' => $this->left[$key],
                         'right' => $this->right[$key],
                         'user_id' => Auth::id(),
                    );
               }
               if (isset($data) && is_array($data) && count($data)) {
                    DB::table($this->params['table'])->upsert($data, 'id', ['level', 'left', 'right']);
               }
          }
     }

     public function Dropdown($param = NULL)
     {
          $this->get();
          if (isset($this->data) && is_array($this->data)) {
               $temp = NULL;
               $temp[0] = (isset($param['text']) && !empty($param['text'])) ? $param['text'] : '[Root]';
               foreach ($this->data as $key => $val) {
                    $temp[$val->id] = str_repeat('|-----', (($val->level > 0) ? ($val->level - 1) : 0)) . $val->name;
               }
               return $temp;
          }
     }
}
