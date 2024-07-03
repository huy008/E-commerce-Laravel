<table class="table">
     <thead>
          <tr>
               <th><input type="checkbox" value="" id="checkAll" class="input-checkbox"></th>
               <th style="width:700px">Tieu de</th>
               <th>Vi tri</th>
               <th>Trang thai</th>
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
               <td>
                    <div class="uk-flex uk-flex-middle" style="display:flex">
                         <div class="image" style="margin-right:20px">
                              <div class="image-cover">
                                   <img style="width:80px" src="http://localhost/ecommerce/ecommerce{{${module}->image}}" alt="">
                              </div>
                         </div>
                         <div class="main-info">
                              <div class="name">{{${module}->name}}</div>
                              <div class="catalogue">
                                   <span class="text-danger">Nhom hien thi</span>
                                   @foreach(${module}->{module}_catalogues as $val)
                                   @foreach($val->{module}CatalogueLanguage as $cat)
                                   <a href="">{{$cat->name}}</a>
                                   @endforeach
                                   @endforeach
                              </div>
                         </div>
                    </div>
                    </div>
               </td>
               <td><input style="width:100px" type="text" name="order" value="{{${module}->order}}" class="form-control" data-id="{{${module}->id}}" data-model="{module}"></td>
               <td><input type="checkbox" value="{{${module}->publish}}" class="js-switch status js-switch-{{${module}->id}}" data-model='{module}' data-field="publish" data-modelId="{{${module}->id}}" {{(${module}->publish == 1) ? 'checked' :''}}></td>
               <td><a href=" {{route('{module}.edit',${module}->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href=" {{route('{module}.delete',${module}->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     ${module}s->links('pagination::bootstrap-4')
}}