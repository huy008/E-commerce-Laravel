<table class="table">
     <thead>
          <tr>
               <th><input type="checkbox" value="" id="checkAll" class="input-checkbox"></th>
               <th>Anh</th>
               <th>Thon tin thanh vien</th>
               <th>Dia chi</th>
               <th>Tinh trang</th>
               <th>Thao Tac</th>
          </tr>
     </thead>
     @if(isset($users) && is_object($users))
     @foreach($users as $user)
     <tbody>
          <tr>
               <td>
                    <input type="checkbox" value="{{$user->id}}" class="input-checkbox checkItem">
               </td>
               <td><img style="width:60px;" src="http://localhost/ecommerce/ecommerce{{$user->image}}" alt=""></td>
               <td>{{$user->name}}</td>
               <td>{{$user->address}}</td>
               <td><input type="checkbox" value="{{$user->publish}}" class="js-switch status js-switch-{{$user->id}}" data-model='User' data-field="publish" data-modelId="{{$user->id}}" {{($user->publish == 1) ? 'checked' :''}}></td>
               <td><a href=" {{route('user.edit',$user->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{route('user.delete',$user->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     $users->links('pagination::bootstrap-4')
}}