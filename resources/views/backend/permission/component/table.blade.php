<table class="table">
     <thead>
          <tr>
               <th><input type="checkbox" value="" id="checkAll" class="input-checkbox"></th>
               <th>Ten</th>
               <th>Canonical</th>
               <th></th>
          </tr>
     </thead>
     @if(isset($permissions) && is_object($permissions))
     @foreach($permissions as $permission)
     <tbody>
          <tr>
               <td>
                    <input type="checkbox" value="{{$permission->id}}" class="input-checkbox checkItem">
               </td>
               <td>{{$permission->name}}</td>
               <td>{{$permission->canonical}}</td>

               <td><a href=" {{route('permission.edit',$permission->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{route('permission.delete',$permission->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     $permissions->links('pagination::bootstrap-4')
}}