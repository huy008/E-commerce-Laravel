<form action="{{route('generate.index')}}">
     <div class="filter">
          <div class="perpage">

               @php
               $perpage =request('perpage')?:old('keyword')
               @endphp
               <select name="perpage" class="form-control">
                    @for($i = 20 ;$i<= 140; $i+=20) <option {{ ($perpage == $i) ? 'selected' : ''}} value="{{ $i }}">{{ $i }}</option>
                         @endfor
               </select>
          </div>
          <div class="action">
               <div>
                    <div>
                         <div class="from-group">
                              <input type="text" name="keyword" value="{{request('keyword')?:old('keyword')}}" class=" form-control"><button type="submit" name="search" value="Search" class="btn btn-primary">Tim kiem</button>
                         </div>
                    </div>
                    <a href="{{route('generate.create')}}" class="btn btn-danger">Them moi</a>
               </div>
          </div>
     </div>
</form>