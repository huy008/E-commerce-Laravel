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
     @if(isset($userCatalogues) && is_object($userCatalogues))
     @foreach($userCatalogues as $userCatalogue)
     <tbody>
          <tr>
               <td>
                    <input
                         type="checkbox"
                         value="{{$userCatalogue->id}}"
                         class="input-checkbox checkItem"
                    >
               </td>
               <td>{{$userCatalogue->name}}</td>
               <td>{{$userCatalogue->users_count}} nguoi </td>
               <td>{{$userCatalogue->description}}</td>
               <td><input
                         type="checkbox"
                         value="{{$userCatalogue->publish}}"
                         class="js-switch status js-switch-{{$userCatalogue->id}}"
                         data-model='UserCatalogue'
                         data-field="publish"
                         data-modelId="{{$userCatalogue     ->id}}"
                         {{($userCatalogue->publish == 1) ? 'checked' :''}}
                    ></td>

               <td><a
                         href=" {{route('user.catalogue.edit',$userCatalogue->id)}}"
                         class="btn btn-success"
                    ><i class="fa fa-edit"></i></a>
                    <a
                         href=" {{route('user.catalogue.delete',$userCatalogue->id)}}"
                         class="btn btn-danger"
                    ><i class="fa fa-trash"></i></a>
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     $userCatalogues->links('pagination::bootstrap-4')
}}