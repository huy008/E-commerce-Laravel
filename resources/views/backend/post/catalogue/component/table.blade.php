<table class="table">
     <thead>
          <tr>
               <th><input type="checkbox" value="" id="checkAll" class="input-checkbox"></th>
               <th>Ten nhom</th>
               <th>Publish</th>
               <th>Thao tac </th>

          </tr>
     </thead>
     @if(isset($postCatalogues) && is_object($postCatalogues))
     @foreach($postCatalogues as $postCatalogue)
     <tbody>
          <tr>
               <td>
                    <input type="checkbox" value="{{$postCatalogue->id}}" class="input-checkbox checkItem">
               </td>
               <td>{{str_repeat('|----',(($postCatalogue->level > 0)?($postCatalogue->level-1):0)).$postCatalogue->name}}</td>
               <td><input type="checkbox" value="{{$postCatalogue->publish}}" class="js-switch status js-switch-{{$postCatalogue->id}}" data-model='postCatalogue' data-field="publish" data-modelId="{{$postCatalogue     ->id}}" {{($postCatalogue->publish == 1) ? 'checked' :''}}></td>

               <td><a href=" {{route('post.catalogue.edit',$postCatalogue->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href=" {{route('post.catalogue.delete',$postCatalogue->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a> 
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     $postCatalogues->links('pagination::bootstrap-4')
}}