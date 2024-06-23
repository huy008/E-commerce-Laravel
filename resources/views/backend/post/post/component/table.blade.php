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
     @if(isset($posts) && is_object($posts))
     @foreach($posts as $post)
     <tbody>
          <tr>
               <td>
                    <input type="checkbox" value="{{$post->id}}" class="input-checkbox checkItem">
               </td>
               <td>
                    <div class="uk-flex uk-flex-middle" style="display:flex">
                         <div class="image" style="margin-right:20px">
                              <div class="image-cover">
                                   <img style="width:80px" src="http://localhost/ecommerce/ecommerce{{$post->image}}" alt="">
                              </div>
                         </div>
                         <div class="main-info">
                              <div class="name">{{$post->name}}</div>
                              <div class="catalogue">
                                   <span class="text-danger">Nhom hien thi</span>
                                   @foreach($post->post_catalogues as $val)
                                   @foreach($val->postCatalogueLanguage as $cat)
                                   <a href="">{{$cat->name}}</a>
                                   @endforeach
                                   @endforeach
                              </div>
                         </div>
                    </div>
                    </div>
               </td>
               <td><input style="width:100px" type="text" name="order" value="{{$post->order}}" class="form-control" data-id="{{$post->id}}" data-model="Post"></td>
               <td><input type="checkbox" value="{{$post->publish}}" class="js-switch status js-switch-{{$post->id}}" data-model='Post' data-field="publish" data-modelId="{{$post->id}}" {{($post->publish == 1) ? 'checked' :''}}></td>
               <td><a href=" {{route('post.edit',$post->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href=" {{route('post.delete',$post->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     $posts->links('pagination::bootstrap-4')
}}