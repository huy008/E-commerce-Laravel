<form action="{{route('language.destroy',$language->id)}}" method="post">
     @csrf
     <div class="wrapper wrapper-content animated fadeInRight">
          <div class="row">
               <div class="col-lg-5">
                    <div class="panel-head">
                         <div class="panel-title">Thông tin chung</div>
                         <div class="panel-description">Nhập thông tin chung của người sử dụng</ div>
                         </div>
                    </div>
                    <div class="col-lg-12">
                         <div class="ibox">
                              <div class="ibox-title">
                                   <h5>Thông tin chung</h5>
                              </div>
                              <div class="ibox-content">
                                   <div class="row">
                                        <div class="col-lg-6">
                                             <div class="form-row">
                                                  <label for="" class="control-label text-right">Email</label>
                                                  <input type="text" name="name" value="{{ old('name' ,($language->name) ?? '' )}}" class="form-control" placeholder="" autocomplete="off">
                                             </div>
                                        </div>
                                        <div class="col-lg-6">
                                             <div class="form-row">
                                                  <label for="" class="control-label text-right">Mo ta</label>
                                                  <input type="text" name="name" value="{{ old('description',($language->description) ?? '') }}" class="form-control" placeholder="" autocomplete="off">
                                             </div>
                                        </div>
                                   </div>

                              </div>




                         </div>
                    </div>
               </div>
          </div>


          <button type="submit" class="btn btn-danger">Xoa</button>
</form>