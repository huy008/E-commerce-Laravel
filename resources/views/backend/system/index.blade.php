<form action="{{route('system.store')}}" method="post">
     @csrf
     <div class="wrapper wrapper-content animated fadeInRight">
          @foreach($systemConfig as $key => $value)
          <div class="row">
               <div class="col-lg-5">
                    <div class="panel-head">
                         <div class="panel-title">{{ $value['label'] }}</div>
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
                              @php
                              $name = $key.'_'.$keyVal;
                              @endphp
                              <div class="row">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <label for="" class="control-label text-right">{{$item['label']}}
                                             </label>
                                             @switch ($item['type'])
                                             @case('text')
                                             {!! renderSystemInput($name,$systems) !!}
                                             @break
                                             @case('images')
                                             {!! renderSystemImages($name,$systems) !!}
                                             @break
                                             @case('textarea')
                                             {!! renderSystemTextarea($name,$systems) !!}
                                             @break
                                             @case('select')
                                             {!! renderSystemSelect($item,$name,$systems) !!}
                                             @break
                                             @case('editor')
                                             {!! renderSystemEditor($name,$systems) !!}
                                             @break
                                             @endswitch
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
     <div class="text-right mb15 fixed-bottom">
          <button class="btn btn-primary" type="submit" name="send" value="send">Them</button>
     </div>
</form>