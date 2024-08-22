  <div class="ibox">
     <div class="ibox-title">
          <div class="uk-flex uk-flex-middle uk-flex-space-between">
               <h5>Menu chinh</h5>
               <a href="{{route('menu.editMenu',['id' => $id])}}" class="cursor-button">Cap nhat menu</a>
          </div>
     </div>
       <div class="ibox-content" data-catalogueId="{{$id}}" id="dataCatalogue">
            @php
            $menus = recursive($menus);
            $menuString = recursive_menu($menus);
            @endphp
            <div class="dd" id="nestable2">
                 <ol class="dd-list">
                      {!!$menuString!!}
                 </ol>
            </div>
       </div>
  </div>

  