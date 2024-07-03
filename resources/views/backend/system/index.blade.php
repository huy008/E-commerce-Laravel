<form action="" method="post">
     @csrf
     <div class="wrapper wrapper-content animated fadeInRight">
          @foreach ($system as $key => $value)
          <div class="row">
               <div class="col-lg-5">
                    <div class="panel-head">
                         <div class="panel-title">{{$value['label']}}</div>
                         <div class="panel-description">{{$value['description']}}</div> 
                    </div>
               </div>
               <div class="col-lg-12">
                    <div class="ibox">
                         <div class="ibox-title">
                              <h5>Thông tin chung</h5>
                         </div>
                         @if(count($value['value']))
                         <div class="ibox-content">
                              @foreach ($value['value'] as $keyVal => $item)
                              <div class="row">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <label for="" class="control-label text-right">{{$item['label']}}</label>
                                             @if($item['type']=='text')
                                             <input type="text" name="{{$key.'_'.$keyVal}}" value="{{old($key.'_'.$keyVal)}}" class="form-control" placeholder="" autocomplete="off">
                                             @endif
                                        </div>
                                   </div>

                              </div>
                              @endforeach
                         </div>
                         @endif
                    </div>
               </div>
          </div>
     </div>
     @endforeach

</form>