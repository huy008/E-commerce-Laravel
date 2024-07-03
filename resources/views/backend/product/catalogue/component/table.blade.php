<table class="table">
     <thead>
          <tr>
               <th><input type="checkbox" value="" id="checkAll" class="input-checkbox"></th>
               <th>Ten nhom</th>
               <th>Publish</th>
               <th>Thao tac </th>

          </tr>
     </thead>
     @if(isset($productCatalogues) && is_object($productCatalogues))
     @foreach($productCatalogues as $productCatalogue)
     <tbody>
          <tr>
               <td>
                    <input type="checkbox" value="{{$productCatalogue->id}}" class="input-checkbox checkItem">
               </td>
               <td>{{str_repeat('|----',(($productCatalogue->level > 0)?($productCatalogue->level-1):0)).$productCatalogue->name}}</td>
               <td><input type="checkbox" value="{{$productCatalogue->publish}}" class="js-switch status js-switch-{{$productCatalogue->id}}" data-model='productCatalogue' data-field="publish" data-modelId="{{$productCatalogue     ->id}}" {{($productCatalogue->publish == 1) ? 'checked' :''}}></td>

               <td><a href=" {{route('product.catalogue.edit',$productCatalogue->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href=" {{route('product.catalogue.delete',$productCatalogue->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a> 
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     $productCatalogues->links('pagination::bootstrap-4')
}}