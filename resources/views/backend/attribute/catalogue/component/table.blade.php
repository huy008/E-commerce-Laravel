<table class="table">
     <thead>
          <tr>
               <th><input type="checkbox" value="" id="checkAll" class="input-checkbox"></th>
               <th>Ten nhom</th>
               <th>Publish</th>
               <th>Thao tac </th>

          </tr>
     </thead>
     @if(isset($attributeCatalogues) && is_object($attributeCatalogues))
     @foreach($attributeCatalogues as $attributeCatalogue)
     <tbody>
          <tr>
               <td>
                    <input type="checkbox" value="{{$attributeCatalogue->id}}" class="input-checkbox checkItem">
               </td>
               <td>{{str_repeat('|----',(($attributeCatalogue->level > 0)?($attributeCatalogue->level-1):0)).$attributeCatalogue->name}}</td>
               <td><input type="checkbox" value="{{$attributeCatalogue->publish}}" class="js-switch status js-switch-{{$attributeCatalogue->id}}" data-model='attributeCatalogue' data-field="publish" data-modelId="{{$attributeCatalogue     ->id}}" {{($attributeCatalogue->publish == 1) ? 'checked' :''}}></td>

               <td><a href=" {{route('attribute.catalogue.edit',$attributeCatalogue->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href=" {{route('attribute.catalogue.delete',$attributeCatalogue->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a> 
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     $attributeCatalogues->links('pagination::bootstrap-4')
}}