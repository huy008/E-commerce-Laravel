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
$url = ($config['method'] == 'create') ? route('post.store') : route('post.update', $post->id);
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
                                             <input type="text" name="name" value="{{ old('name', ($post->name) ?? '' ) }}" class="form-control" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>
                                        </div>
                                   </div>
                              </div>
                              <div class="row mb15">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <label for="" class="control-label text-left">description</label>
                                             <textarea name="description" class="ck-editor" id="ckDescription" data-height="100">{{ old('description', ($post->description) ?? '') }}</textarea>
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
                                             <textarea name="content" class="form-control ck-editor" placeholder="" autocomplete="off" id="ckContent" data-height="500">{{ old('content', ($post->content) ?? '' ) }}</textarea>
                                        </div>
                                   </div>

                              </div>
                         </div>


                         @include('backend.post.post.component.album')

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
                                                       <input type="text" name="meta_title" value="{{ old('meta_title', ($post->meta_title) ?? '' ) }}" class="form-control" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row mb15">
                                             <div class="col-lg-12">
                                                  <div class="form-row">
                                                       <label for="" class="control-label text-left">
                                                            <span>Tu khoa Seo</span>
                                                       </label>
                                                       <input type="text" name="meta_keyword" value="{{ old('meta_keyword', ($post->meta_keyword) ?? '' ) }}" class="form-control" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>
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
                                                       <textarea name="meta_description" class="form-control" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>{{ old('meta_description', ($post->meta_description) ?? '') }}</textarea>
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
                                                            <input type="text" name="canonical" value="{{ old('canonical', ($post->canonical) ?? '' ) }}" class="form-control seo-canonical" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>

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
                                             <select name="post_catalogue_id" class="form-control setupSelect2 ">
                                                  @foreach($dropdown as $key => $value)
                                                  <option {{$key==old('post_catalogue_id',((isset($post->post_catalogue_id)) ? $post->post_catalogue_id : '') ? 'selected' : '' )}} value="{{$key}}">{{$value}}</option>
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