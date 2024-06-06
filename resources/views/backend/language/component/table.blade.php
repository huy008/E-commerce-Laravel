<table class="table">
     <thead>
          <tr>
               <th><input type="checkbox" value="" id="checkAll" class="input-checkbox"></th>
               <th>Anh</th>
               <th>Ten</th>
               <th>Canonical</th>
               <th>Mo ta</th>
               <th>Publish</th>
               <th></th>
          </tr>
     </thead>
     @if(isset($languages) && is_object($languages))
     @foreach($languages as $language)
     <tbody>
          <tr>
               <td>
                    <input type="checkbox" value="{{$language->id}}" class="input-checkbox checkItem">
               </td>
               <td><img style="width:60px;" src="http://localhost/ecommerce/ecommerce{{$language->image}}" alt=""></td>
               <td>{{$language->name}}</td>
               <td>{{$language->canonical}}</td>
               <td>{{$language->description}}</td>
               <td><input type="checkbox" value="{{$language->publish}}" class="js-switch status js-switch-{{$language->id}}" data-model='Language' data-field="publish" data-modelId="{{$language->id}}" {{ ($language->publish == 1) ? 'checked' :''}}></td>
               <td><a href=" {{route('language.edit',$language->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href="{{route('language.delete',$language->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     $languages->links('pagination::bootstrap-4')
}}