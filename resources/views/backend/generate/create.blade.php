@if ($errors->any())
<div class="alert alert-danger">
     <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
     </ul>
</div>
@endif

@php
$url = ($config['method'] == 'create') ? route ('generate.store') : route('generate.update',$generate->id );
@endphp

<form action="{{$url}}" method="post">
     @csrf
     <div class="wrapper wrapper-content animated fadeInRight">
          <div class="row">
               <div class="col-lg-8">
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
                                                  <label for="" class="control-label text-right">Name</label>
                                                  <input type="text" name="name" value="{{ old('name' ,($generate->name) ?? '' )}}" class="form-control" placeholder="" autocomplete="off">
                                             </div>
                                        </div>
                                        <div class="col-lg-6">
                                             <div class="form-row">
                                                  <label for="" class="control-label text-right">module</label>
                                                  <input type="text" name="module" value="{{ old('module' ,($generate->module) ?? '' )}}" class="form-control" placeholder="" autocomplete="off">
                                             </div>
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-lg-6">
                                             <div class="form-row">
                                                  <label for="" class="control-label text-right">Loai module</label>
                                                  <select name="module_type" class="setupSelrct2 form-control">
                                                       <option value="0">Chon loai module</option>
                                                       <option value="1">Module danh muc</option>
                                                       <option value="2">Module chi tiet</option>
                                                       <option value="3">Module khac</option>
                                                  </select>
                                             </div>
                                        </div>

                                        <div class="col-lg-6">
                                             <div class="form-row">
                                                  <label for="" class="control-label text-right">Path</label>
                                                  <input type="text" name="path" value="{{ old('path' ,($generate->path) ?? '' )}}" class="form-control" placeholder="" autocomplete="off">
                                             </div>
                                        </div>
                                   </div>



                              </div>

                         </div>
                    </div>
               </div>
          </div>
          <div class="row">
               <div class="col-lg-8">
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
                                        <div class="col-lg-12">
                                             <div class="form-row">
                                                  <label for="" class="control-label text-right">Schema</label>
                                                  <textarea name="schema" class="form-control">{{ old('schema' ,($generate->schema) ?? '' )}}</textarea>
                                             </div>
                                        </div>

                                   </div>




                              </div>

                         </div>
                    </div>
               </div>
          </div>

          <button type="submit" class="btn btn-primary">Luu lai</button>
</form>