<table class="table">
     <thead>
          <tr>
               <th><input type="checkbox" value="" id="checkAll" class="input-checkbox"></th>
               <th>Ten</th>
               <th>Schema</th>
               <th></th>
          </tr>
     </thead>
     @if(isset($generates) && is_object($generates))
     @foreach($generates as $generate)
     <tbody>
          <tr>
               <td>
                    <input type="checkbox" value="{{$generate->id}}" class="input-checkbox checkItem">
               </td>
 
               <td>{{$generate->name}}</td>
               <td>{{$generate->schema}}</td>
           
               <td><a href=" {{route('generate.edit',$generate->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{route('generate.delete',$generate->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     $generates->links('pagination::bootstrap-4')
}}