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
$url = ($config['method'] == 'create') ? route('attribute.store') : route('attribute.update', $attribute->id);
@endphp
<form action="{{ $url }}" method="post" class="box">
     @csrf
     <div class="wrapper wrapper-content animated fadeInRight">
          <div class="row">
               <div class="col-lg-9">
                    <div class="ibox">
                         <div class="ibox-title">
                              <h5>Thong tin chung</h5>
                         </div>
                         <div class="ibox-content">
                              <div class="row mb15">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <label for="" class="control-label text-left">Tieu de bai viet<span class="text-danger">(*)</span></label>
                                             <input type="text" name="name" value="{{ old('name', ($attribute->name) ?? '' ) }}" class="form-control" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>
                                        </div>
                                   </div>
                              </div>
                              <div class="row mb15">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <label for="" class="control-label text-left">description</label>
                                             <textarea name="description" class="ck-editor" id="ckDescription" data-height="100">{{ old('description', ($attribute->description) ?? '') }}</textarea>
                                        </div>
                                   </div>
                              </div>
                              <div class="row mb15">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                  <label for="" class="control-label text-left">Noi dung </label>
                                                  <a href="" class="multipleUploadImageCkeditor" data-target="ckContent">Upload nhieu anh</a>
                                             </div>
                                             <textarea name="content" class="form-control ck-editor" placeholder="" autocomplete="off" id="ckContent" data-height="500">{{ old('content', ($attribute->content) ?? '' ) }}</textarea>
                                        </div>
                                   </div>

                              </div>
                         </div>


                         <div class="ibox">
                              <div class="ibox-title">
                                   <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                        <h5>{{ __('messages.album.heading') }}</h5>
                                        <div class="upload-album"><a href="" class="upload-picture">{{ __('messages.album.image') }}</a></div>
                                   </div>
                              </div>
                              <div class="ibox-content">
                                   @php
                                   $album = (!empty($attribute->album)) ? json_decode($attribute->album) : [];
                                   $gallery = (isset($album) && count($album) ) ? $album : old('album');
                                   @endphp
                                   <div class="row">
                                        <div class="col-lg-12">
                                             @if(!isset($gallery) || count($gallery) == 0)
                                             <div class="click-to-upload">
                                                  <div class="icon">
                                                       <a href="" class="upload-picture">
                                                            <svg style="width:80px;height:80px;fill: #d3dbe2;margin-bottom: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                                                                 <path d="M80 57.6l-4-18.7v-23.9c0-1.1-.9-2-2-2h-3.5l-1.1-5.4c-.3-1.1-1.4-1.8-2.4-1.6l-32.6 7h-27.4c-1.1 0-2 .9-2 2v4.3l-3.4.7c-1.1.2-1.8 1.3-1.5 2.4l5 23.4v20.2c0 1.1.9 2 2 2h2.7l.9 4.4c.2.9 1 1.6 2 1.6h.4l27.9-6h33c1.1 0 2-.9 2-2v-5.5l2.4-.5c1.1-.2 1.8-1.3 1.6-2.4zm-75-21.5l-3-14.1 3-.6v14.7zm62.4-28.1l1.1 5h-24.5l23.4-5zm-54.8 64l-.8-4h19.6l-18.8 4zm37.7-6h-43.3v-51h67v51h-23.7zm25.7-7.5v-9.9l2 9.4-2 .5zm-52-21.5c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5zm0-8c-1.7 0-3 1.3-3 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3zm-13-10v43h59v-43h-59zm57 2v24.1l-12.8-12.8c-3-3-7.9-3-11 0l-13.3 13.2-.1-.1c-1.1-1.1-2.5-1.7-4.1-1.7-1.5 0-3 .6-4.1 1.7l-9.6 9.8v-34.2h55zm-55 39v-2l11.1-11.2c1.4-1.4 3.9-1.4 5.3 0l9.7 9.7c-5.2 1.3-9 2.4-9.4 2.5l-3.7 1h-13zm55 0h-34.2c7.1-2 23.2-5.9 33-5.9l1.2-.1v6zm-1.3-7.9c-7.2 0-17.4 2-25.3 3.9l-9.1-9.1 13.3-13.3c2.2-2.2 5.9-2.2 8.1 0l14.3 14.3v4.1l-1.3.1z"></path>
                                                            </svg>
                                                       </a>
                                                  </div>
                                                  <div class="small-text">{{ __('messages.album.notice') }}</div>
                                             </div>
                                             @endif

                                             <div class="upload-list {{ (isset($gallery) && count($gallery)) ? '' : 'hidden' }}">
                                                  <ul id="sortable" class="clearfix data-album sortui ui-sortable">
                                                       @if(isset($gallery) && count($gallery))
                                                       @foreach($gallery as $key => $val)
                                                       <li class="ui-state-default">
                                                            <div class="thumb">
                                                                 <span class="span image img-scaledown">
                                                                      <img style="width:80px" src="{{$val}}" alt="{{ $val }}">
                                                                      <input type="hidden" name="album[]" value="{{ $val }}">
                                                                 </span>
                                                                 <button class="delete-image"><i class="fa fa-trash"></i></button>
                                                            </div>
                                                       </li>
                                                       @endforeach
                                                       @endif
                                                  </ul>
                                             </div>

                                        </div>
                                   </div>
                              </div>
                         </div>


                         <div class="ibox">
                              <div class="ibox-title">
                                   <h5>Cau hinh Seo</h5>
                              </div>
                              <div class="ibox-content">
                                   <div class="seo-container">
                                        <div class="meta-title">
                                             Học Laravel Framework - Học PHP - Toidicode.com
                                        </div>
                                        <div class="canonical">httpdasdasd</div>
                                        <div class="meta-description">
                                             hiện nay đang là php framework được nhiều lập trình viên sử dụng nhất. Chúng ta cùng tìm hiểu về framework này xem nó có gì hay mà được nhiều lập trình viên dùng đến thế nhéaravel
                                        </div>
                                   </div>
                                   <div class="seo-wrapper">
                                        <div class="row mb15">
                                             <div class="col-lg-12">
                                                  <div class="form-row">
                                                       <label for="" class="control-label text-left">
                                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                                 <span>Mo ta SEO</span>
                                                                 <span class="count_meta-title">0</span>
                                                            </div>
                                                       </label>
                                                       <input type="text" name="meta_title" value="{{ old('meta_title', ($attribute->meta_title) ?? '' ) }}" class="form-control" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row mb15">
                                             <div class="col-lg-12">
                                                  <div class="form-row">
                                                       <label for="" class="control-label text-left">
                                                            <span>Tu khoa Seo</span>
                                                       </label>
                                                       <input type="text" name="meta_keyword" value="{{ old('meta_keyword', ($attribute->meta_keyword) ?? '' ) }}" class="form-control" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row mb15">
                                             <div class="col-lg-12">
                                                  <div class="form-row">
                                                       <label for="" class="control-label text-left">
                                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                                 <span>Mo ta Seo</span>
                                                                 <span class="count_meta-description">0 {{ __('messages.character') }}</span>
                                                            </div>
                                                       </label>
                                                       <textarea name="meta_description" class="form-control" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>{{ old('meta_description', ($attribute->meta_description) ?? '') }}</textarea>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row mb15">
                                             <div class="col-lg-12">
                                                  <div class="form-row">
                                                       <label for="" class="control-label text-left">
                                                            <span>canonical<span class="text-danger">*</span></span>
                                                       </label>
                                                       <div class="input-wrapper">
                                                            <input type="text" name="canonical" value="{{ old('canonical', ($attribute->canonical) ?? '' ) }}" class="form-control seo-canonical" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>

                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>

               </div>
               <div class="col-lg-3">
                    <div class="ibox">
                         <div class="ibox-content">
                              <div class="row mb15">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <label for="" class="control-label text-left">
                                                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                       <span>Chon danh muc cha</span>
                                                       <span class="count_meta-title">0</span>
                                                  </div>
                                             </label>
                                             <select name="attribute_catalogue_id" class="form-control setupSelect2 ">
                                                  @foreach($dropdown as $key => $value)
                                                  <option {{$key==old('attribute_catalogue_id',((isset($attribute->attribute_catalogue_id)) ? $attribute->attribute_catalogue_id : '') ? 'selected' : '' )}} value="{{$key}}">{{$value}}</option>
                                                  @endforeach
                                             </select>
                                        </div>
                                   </div>
                              </div>

                              <div class="row mb15">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <label for="" class="control-label text-left">
                                                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                       <span>Chon danh muc phu</span>
                                                       <span class="count_meta-title">0</span>
                                                  </div>
                                             </label>
                                             <select multiple name="catalogue[]" class="form-control  setupSelect2">
                                                  @foreach($dropdown as $key => $value)
                                                  <option value="{{$key}}">{{$value}}</option>
                                                  @endforeach
                                             </select>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="ibox">
                         <div class="ibox-title">
                              <label for="" class="control-label text-left">
                                   <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                        <span>Chon anh dai dien</span>
                                        <span class="count_meta-title">0</span>
                                   </div>
                              </label>
                         </div>
                         <div class="ibox-content">
                              <div class="row mb15">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <span class="image img-cover image-target"> <img src="http://127.0.0.1:8000/backend/img/image.jpg" alt=""></span>
                                             <input type="hidden" name='image'>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="ibox">
                         <div class="ibox-content">
                              <div class="row mb15">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <label for="" class="control-label text-left">
                                                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                       <span>Cau hinh nang cao</span>
                                                       <span class="count_meta-title">0</span>
                                                  </div>
                                             </label>
                                             <div class="mb15">
                                                  <select name="publish" class="form-control ">
                                                       <option value="1">publish</option>
                                                       <option value="2">No publish</option>
                                                  </select>
                                             </div>
                                             <select name="follow" class="form-control ">
                                                  <option value="1">follow</option>
                                                  <option value="2">No follow</option>
                                             </select>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>



               </div>

          </div>
          <div class="text-right mb15 fixed-bottom">
               <button class="btn btn-primary" type="submit" name="send" value="send">Them</button>
          </div>
</form>