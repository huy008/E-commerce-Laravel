<form action="{{ route('user.catalogue.updatePermission') }}" method="post">
     @csrf
     <div class="row">
          <div class="col-lg-12">
               <div class="ibox">
                    <div class="ibox-title">Cap quyen</div>
                    <div class="ibox-content">
                         <table class="table">
                              <tr>
                                   <th></th>
                                   @foreach($userCatalogues as $userCatalogue)
                                   <th class="text-center"> {{ $userCatalogue->name}}</th>
                                   @endforeach
                              </tr>
   
                              @foreach($permission as $per)

                              <tr>
                                   <td>{{ $per->name}}</td>
                                   @foreach($userCatalogues as $userCatalogue)
                                   <td><input {{(collect($userCatalogue->permissions)->contains('id',$per->id)) ? 'checked' : ''}} type="checkbox" name="permission[{{$userCatalogue->id}}][]" value="{{$per->id}}" class="form-control" value=""></td>
                                   @endforeach
                              </tr>
                              @endforeach

                         </table>
                    </div>
               </div>
          </div>
     </div>
     <button type="submit" class="btn btn-primary">Luu lai</button>
</form>