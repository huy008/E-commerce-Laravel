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
     @if(isset($products) && is_object($products))
     @foreach($products as $product)
     <tbody>
          <tr>
               <td>
                    <input type="checkbox" value="{{$product->id}}" class="input-checkbox checkItem">
               </td>
               <td>
                    <div class="uk-flex uk-flex-middle" style="display:flex">
                         <div class="image" style="margin-right:20px">
                              <div class="image-cover">
                                   <img style="width:80px" src="http://localhost/ecommerce/ecommerce{{$product->image}}" alt="">
                              </div>
                         </div>
                         <div class="main-info">
                              <div class="name">{{$product->name}}</div>
                              <div class="catalogue">
                                   <span class="text-danger">Nhom hien thi</span>
                                   @foreach($product->product_catalogues as $val)
                                   @foreach($val->productCatalogueLanguage as $cat)
                                   <a href="">{{$cat->name}}</a>
                                   @endforeach
                                   @endforeach
                              </div>
                         </div>
                    </div>
                    </div>
               </td>
               <td><input style="width:100px" type="text" name="order" value="{{$product->order}}" class="form-control" data-id="{{$product->id}}" data-model="product"></td>
               <td><input type="checkbox" value="{{$product->publish}}" class="js-switch status js-switch-{{$product->id}}" data-model='product' data-field="publish" data-modelId="{{$product->id}}" {{($product->publish == 1) ? 'checked' :''}}></td>
               <td><a href=" {{route('product.edit',$product->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                    <a href=" {{route('product.delete',$product->id)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
               </td>
          </tr>

     </tbody>
     @endforeach
     @endif
</table>

{{
     $products->links('pagination::bootstrap-4')
}}