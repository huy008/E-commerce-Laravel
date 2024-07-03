<form action="">
     <div class="filter" style="display:flex;">
          <div class="perpage">

               @php
               $perpage =request('perpage')?:old('keyword')
               @endphp
               <select name="perpage" class="form-control">
                    @for($i = 20 ;$i<= 140; $i+=20) <option {{ ($perpage == $i) ? 'selected' : ''}} value="{{ $i }}">{{ $i }}</option>
                         @endfor
               </select>
          </div>
          <div class="action" style="display:flex;">
               <div>

                    <select name="product_catalogue_id" class="form-control setupSelect2">
                         @foreach($dropdown as $key => $value)
                         <option value="{{$key}}" checked>{{$value}}</option>
                              @endforeach
                    </select>

                    <div>
                         <div class="from-group">
                              <input type="text" name="keyword" value="{{request('keyword')?:old('keyword')}}" class=" form-control"><button type="submit" name="search" value="Search" class="btn btn-primary">Tim kiem</button>
                         </div>
                    </div>
                    <a href="{{route('product.create')}}" class="btn btn-danger">Them moi</a>
               </div>
          </div>
     </div>
</form>