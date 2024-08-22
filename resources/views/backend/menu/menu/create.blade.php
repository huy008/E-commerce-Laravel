@php
$url = ($config['method'] == 'create') ? route ('menu.store') : route('menu.update',$menu->id ?? $id );

$module = [
'PostCatalogue' => 'Nhom bai viet',
'Post' => 'Bai viet',
'ProductCatalogue' => 'Nhom san pham',
'Product' => 'San pham',
]
@endphp

<form action="{{$url}}" method="post">
     @csrf
     <div class="wrapper wrapper-content animated fadeInRight">
          <div class="row">
               <div class="col-lg-5">
                    <div class="panel-head">
                         <div class="panel-title">Thông tin chung</div>
                         <div class="panel-description">Nhập thông tin chung của người sử dụng</ div>
                         </div>
                    </div>
               </div>
               <div class="col-lg-7">
                    <div class="ibox">
                         <div class="ibox-content">
                              <div class="row">
                                   <div class="col-lg-5">
                                        <select name="menu_catalogue_id" class="form-control setupSelect2">
                                             <option>
                                                  [Chon vi tri hien thi]
                                             </option>
                                             @if(count($menuCatalogues))
                                             @foreach($menuCatalogues as $key => $value)
                                             <option {{(isset($menuCatalogue) && $menuCatalogue->id == $value->id) ? ' selected="selected"' : ''}} value="{{$value->id}}">
                                                  {{$value->name}}
                                             </option>
                                             @endforeach
                                             @endif
                                        </select>
                                   </div>
                                   <div class="col-lg-5">
                                        <select name="type" class="form-control setupSelect2">
                                             <option>
                                                  [Chon vi tri hien thi]
                                             </option>
                                             <option value="1">
                                                  Kieu 1
                                             </option>
                                             <option value="2">
                                                  Kieu 2
                                             </option>
                                        </select>
                                   </div>
                                   <div class="col-lg-2">
                                        <button type="button" data-toggle="modal" data-target="#createMenuCatalogue" class="createMenuCatalogue btn btn-danger">Tao vi tri hien thi</button>
                                   </div>
                              </div>

                         </div>

                    </div>
               </div>
          </div>


          <div class="row">
               <div class="col-lg-5">
                    <div class="ibox">
                         <div class="ibox-content">
                              <div class="panel-body">
                                   <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                             <div class="panel-heading">
                                                  <h5 class="panel-title">
                                                       <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Tao Menu</a>
                                                  </h5>
                                             </div>
                                             <div id="collapseOne" class="panel-collapse collapse in">
                                                  <div class="panel-body">


                                                       <a href="#" class="btn btn-default add-menu">Them duong dan</a>
                                                  </div>
                                             </div>
                                        </div>
                                        @foreach($module as $key => $value)
                                        <div class="panel panel-default">
                                             <div class="panel-heading">
                                                  <h4 class="panel-title">
                                                       <a data-toggle="collapse" data-parent="#accordion" href="#{{$key}}" class="collapsed menu-module" data-model="{{$key}}">{{$value}}</a>
                                                  </h4>
                                             </div>
                                             <div id="{{$key}}" class="panel-collapse collapse">
                                                  <div class="panel-body">
                                                       <form action="" method="get" data-model="{{$key}}" class="search-model">
                                                            <div class="form-row">
                                                                 <input type="text" value="" class="form-control" name="keyword">
                                                            </div>
                                                       </form>
                                                       <div class="menu-list mb20">

                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                        @endforeach
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="col-lg-7">
                    <div class="ibox">
                         <div class="ibox-content menu-wrapper">
                              <div class="row">
                                   <div class="col-lg-4">
                                        <label for="">Ten menu</label>
                                   </div>
                                   <div class="col-lg-4">
                                        <label for="">Duong dan</label>
                                   </div>
                                   <div class="col-lg-2">
                                        <label for="">Vi tri</label>
                                   </div>
                                   <div class="col-lg-2">
                                        <label for="">Vi tri</label>
                                   </div>
                              </div>
                              <div class="row">
                                   @php
                                   $menu = old('menu',$menuList ?? null)
                                   @endphp
                                   @if(count($menu))
                                   @foreach($menu['name'] as $key=>$val)
                                   <div class="row mb10 menu-item" bis_skin_checked="1">
                                        <div class="col-lg-4" bis_skin_checked="1">
                                             <input type="text" class="form-control" name="menu[name][]" value="{{$val}}">
                                        </div>
                                        <div class="col-lg-4" bis_skin_checked="1">
                                             <input type="text" value="{{$menu['canonical'][$key]}}" class="form-control" name="menu[canonical][]">
                                        </div>
                                        <div class="col-lg-2" bis_skin_checked="1">
                                             <input type="text" value="{{$menu['order'][$key]}}" class="form-control" name="menu[order][]">
                                        </div>
                                        <div class="col-lg-2" bis_skin_checked="1">
                                             <div class="form-row text-center" bis_skin_checked="1"><a class="delete-menu"><i class="fa fa-trash"></i></a></div><input class="hidden" name="menu[id][]" value="{{$menu['id'][$key]}}">
                                        </div>
                                   </div>
                                   @endforeach
                                   @endif
                              </div>
                         </div>
                    </div>
               </div>
          </div>
          <button type="submit" class="btn btn-primary">Luu lai</button>
</form>

<div class="modal fade" id="createMenuCatalogue">
     <form action="" class="create_menu_catalogue" method="">

          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                         </button>
                    </div>
                    <div class="modal-body">
                         <div class="row">
                              <div class="col-lg-12 mb10">
                                   I <label for="">Tên vị trí hiển thị</Label>
                                   <input type="text" class="form-control" value="" name="name">
                              </div>
                              <div class="col-lg-12 mb10">
                                   <label for="">Từ khóa</Label>
                                   <input type="text" class="form-control" value="" name="keyword">
                              </div>
                         </div>
                    </div>
                    <div class="modal-footer">
                         <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button type="submit" name="create" value="create" class="btn btn-primary create">Save changes</button>
                    </div>
               </div>
          </div>
     </form>

</div>