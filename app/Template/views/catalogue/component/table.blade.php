<table class="table">
     <thead>
          <tr>
               <th><input type="checkbox" value="" id="checkAll" class="input-checkbox"></th>
               <th>Ten nhom</th>
               <th>Publish</th>
               <th>Thao tac </th>

          </tr>
     </thead>
     @if(isset(${module}s) && is_object(${module}s))
     @foreach(${module}s as ${module})
     <tbody>
          <tr>
               <td>
                    <input type="checkbox" value="{{${module}->id}}" class="input-checkbox checkItem">
               </td>
               <td>{{str_repeat('|----',((${module}->level > 0)?(${module}->level-1):0)).${module}->name}}</td>
               <td><input type="checkbox" value="{{${module}->publish}}" class="js-switch status js-switch-{{${module}->id}}" data-model='{module}' data-field="publish" data-modelId="{{${module}     ->id}}" {{(${module}->publish == 1) ? 'checked' :''}}></td>

               <td><a href=" {{route('{view}.edit',${module}->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href=" {{route('{view}.delete',${module}->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a> 
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     ${module}s->links('pagination::bootstrap-4')
}}