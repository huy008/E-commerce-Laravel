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
     @if(isset($attributes) && is_object($attributes))
     @foreach($attributes as $attribute)
     <tbody>
          <tr>
               <td>
                    <input type="checkbox" value="{{$attribute->id}}" class="input-checkbox checkItem">
               </td>
               <td>
                    <div class="uk-flex uk-flex-middle" style="display:flex">
                         <div class="image" style="margin-right:20px">
                              <div class="image-cover">
                                   <img style="width:80px" src="http://localhost/ecommerce/ecommerce{{$attribute->image}}" alt="">
                              </div>
                         </div>
                         <div class="main-info">
                              <div class="name">{{$attribute->name}}</div>
                              <div class="catalogue">
                                   <span class="text-danger">Nhom hien thi</span>
                                   @foreach($attribute->attribute_catalogues as $val)
                                   @foreach($val->attributeCatalogueLanguage as $cat)
                                   <a href="">{{$cat->name}}</a>
                                   @endforeach
                                   @endforeach
                              </div>
                         </div>
                    </div>
                    </div>
               </td>
               <td><input style="width:100px" type="text" name="order" value="{{$attribute->order}}" class="form-control" data-id="{{$attribute->id}}" data-model="attribute"></td>
               <td><input type="checkbox" value="{{$attribute->publish}}" class="js-switch status js-switch-{{$attribute->id}}" data-model='attribute' data-field="publish" data-modelId="{{$attribute->id}}" {{($attribute->publish == 1) ? 'checked' :''}}></td>
               <td><a href=" {{route('attribute.edit',$attribute->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href=" {{route('attribute.delete',$attribute->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     $attributes->links('pagination::bootstrap-4')
}}