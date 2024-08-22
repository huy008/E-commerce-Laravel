<table class="table">
     <thead>
          <tr>
               <th><input type="checkbox" value="" id="checkAll" class="input-checkbox"></th>
               <th>Ten Menu</th>
               <th>Tu khoa</th>
               <th>Tinh trang</th>
               <th>Thao Tac</th>
          </tr>
     </thead>
     @if(isset($menuCatalogues) && is_object($menuCatalogues))
     @foreach($menuCatalogues as $menuCatalogue)
     <tbody>
          <tr>
               <td>
                    <input type="checkbox" value="{{$menuCatalogue->id}}" class="input-checkbox checkItem">
               </td>
               <td>{{$menuCatalogue->name}}</td>
               <td>{{$menuCatalogue->keyword}}</td>
               <td><input type="checkbox" value="{{$menuCatalogue->publish}}" class="js-switch status js-switch-{{$menuCatalogue->id}}" data-model='MenuCatalogue' data-field="publish" data-modelId="{{$menuCatalogue->id}}" {{($menuCatalogue->publish == 1) ? 'checked' :''}}></td>
               <td><a href=" {{route('menu.edit',$menuCatalogue->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{route('menu.delete',$menuCatalogue->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>