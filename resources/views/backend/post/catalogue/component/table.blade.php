<table class="table">
     <thead>
          <tr>
               <th><input
                         type="checkbox"
                         value=""
                         id="checkAll"
                         class="input-checkbox"
                    ></th>
               <th>Ten</th>
               <th>So User</th>
               <th>Mo ta</th>
               <th>Publish</th>
          </tr>
     </thead>
     @if(isset($postCatalogues) && is_object($postCatalogues))
     @foreach($postCatalogues as $postCatalogue)
     <tbody>
          <tr>
               <td>
                    <input
                         type="checkbox"
                         value="{{$postCatalogue->id}}"
                         class="input-checkbox checkItem"
                    >
               </td>
               <td>{{$postCatalogue->name}}</td>
               <td>{{$postCatalogue->users_count}} nguoi </td>
               <td>{{$postCatalogue->description}}</td>
               <td><input
                         type="checkbox"
                         value="{{$postCatalogue->publish}}"
                         class="js-switch status js-switch-{{$postCatalogue->id}}"
                         data-model='postCatalogue'
                         data-field="publish"
                         data-modelId="{{$postCatalogue     ->id}}"
                         {{($postCatalogue->publish == 1) ? 'checked' :''}}
                    ></td>

               <td><a
                         href=" {{route('user.catalogue.edit',$postCatalogue->id)}}"
                         class="btn btn-success"
                    ><i class="fa fa-edit"></i></a>
                    <a
                         href=" {{route('user.catalogue.delete',$postCatalogue->id)}}"
                         class="btn btn-danger"
                    ><i class="fa fa-trash"></i></a>
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     $postCatalogues->links('pagination::bootstrap-4')
}}