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
$attributeCatalogue1=$attributeCatalogue -> map(function($item) {
$name = $item -> attributeCatalogueLanguage -> first() -> name;
return [
'id' => $item -> id,
'name' => $name,
];
}) -> values();
$jsonArray = json_encode($attributeCatalogue1);

@endphp

@php
$url = ($config['method'] == 'create') ? route('product.store') : route('product.update', $product->id);
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
                                             <input type="text" name="name" value="{{ old('name', ($product->name) ?? '' ) }}" class="form-control" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>
                                        </div>
                                   </div>
                              </div>
                              <div class="row mb15">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <label for="" class="control-label text-left">description</label>
                                             <textarea name="description" class="ck-editor" id="ckDescription" data-height="100">{{ old('description', ($product->description) ?? '') }}</textarea>
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
                                             <textarea name="content" class="form-control ck-editor" placeholder="" autocomplete="off" id="ckContent" data-height="500">{{ old('content', ($product->content) ?? '' ) }}</textarea>
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
                                   $album = (!empty($product->album)) ? json_decode($product->album) : [];
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



                         @include('backend.product.product.component.variant')


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
                                                       <input type="text" name="meta_title" value="{{ old('meta_title', ($product->meta_title) ?? '' ) }}" class="form-control" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row mb15">
                                             <div class="col-lg-12">
                                                  <div class="form-row">
                                                       <label for="" class="control-label text-left">
                                                            <span>Tu khoa Seo</span>
                                                       </label>
                                                       <input type="text" name="meta_keyword" value="{{ old('meta_keyword', ($product->meta_keyword) ?? '' ) }}" class="form-control" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>
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
                                                       <textarea name="meta_description" class="form-control" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>{{ old('meta_description', ($product->meta_description) ?? '') }}</textarea>
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
                                                            <input type="text" name="canonical" value="{{ old('canonical', ($product->canonical) ?? '' ) }}" class="form-control seo-canonical" placeholder="" autocomplete="off" {{ (isset($disabled)) ? 'disabled' : '' }}>

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
                                             <select name="product_catalogue_id" class="form-control setupSelect2 ">
                                                  @foreach($dropdown as $key => $value)
                                                  <option {{$key==old('product_catalogue_id',((isset($product->product_catalogue_id)) ? $product->product_catalogue_id : '') ? 'selected' : '' )}} value="{{$key}}">{{$value}}</option>
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
                         <div class="ibox-content">
                              <div class="row mb15">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <label for="" class="control-label text-left">
                                                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                       <span>Ma san pham</span>
                                                       <span class="count_meta-title">0</span>
                                                  </div>
                                             </label>
                                             <input type="text" name="code" class="form-control">
                                        </div>
                                   </div>
                              </div>
                              <div class="row mb15">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <label for="" class="control-label text-left">
                                                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                       <span>Xuat xu</span>
                                                       <span class="count_meta-title">0</span>
                                                  </div>
                                             </label>
                                             <input type="text" name="code" class="form-control">
                                        </div>
                                   </div>
                              </div>
                              <div class="row mb15">
                                   <div class="col-lg-12">
                                        <div class="form-row">
                                             <label for="" class="control-label text-left">
                                                  <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                       <span>Gia ban/span>
                                                            <span class="count_meta-title">0</span>
                                                  </div>
                                             </label>
                                             <input type="text" name="price" class="form-control">
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

<script>
     (function($) {
          "use strict";
          var HT = {};


          HT.setupProductVariant = () => {
               if ($(".turnOnVariant").length) {
                    $(document).on("click", ".turnOnVariant", function() {
                         let _this = $(this);
                         let price = $('input[name="price"]').val();
                         let code = $('input[name="code"]').val();
                         if (_this.siblings("input:checked").length == 0) {
                              $(".variant-wrapper").removeClass("hidden");
                         } else {
                              $(".variant-wrapper").addClass("hidden");
                         }
                    });
               }
          };

          HT.addVariant = () => {
               var attributeCatalogue = <?php echo $jsonArray; ?>;
               if ($(".add-variant").length) {
                    $(document).on("click", ".add-variant", function() {
                         let html = HT.renderVariantItem();

                         $(".variant-body").append(html);
                         $('.variantTable thead').html('')
                         $('.variantTable tbody').html('')
                         HT.checkMaxAttribute(attributeCatalogue)

                         HT.disabledAttribute();
                    });
               }
          };

          HT.renderVariantItem = () => {
               var attributeCatalogue = <?php echo $jsonArray; ?>;
               let html = "";
               html += '<div class="row  variant-item">';
               html += ' <div class="col-lg-3">';
               html += ' <div class="attribute-catalogue">';
               html += ' <select name="" id="" class="choose-attribute niceSelect">';
               html += ' <option value="0"  > Chon nhom thuoc tin  </option>';
               for (let i = 0; i < attributeCatalogue.length; i++) {
                    html += '     <option value="' + attributeCatalogue[i].id + '">' + attributeCatalogue[i].name + "</option>";
               }
               html += "  </select>";
               html += " </div>";
               html += "  </div>";
               html += ' <div class="col-lg-8">';
               html += '    <input type="text"  class="  fake-variant form-control">';
               html += "  </div>";
               html += ' <div class="col-lg-1">';
               html += '   <button type="button" class="btn btn-danger remove-attribute "><i class="fa fa-trash"></i></button>';
               html += "   </div>";
               html += " </div>";
               return html;
          };
          HT.disabledAttribute = () => {
               let id = [];
               $('.choose-attribute').each(function() {
                    let _this = $(this);
                    let selected = _this.find('option:selected').val();
                    if (selected != 0) {
                         id.push(selected);
                    }
               })
               $('.choose-attribute').find('option').removeAttr('disabled');
               for (let i = 0; i < id.length; i++) {
                    $('.choose-attribute').find('option[value=' + id[i] + ']').prop('disabled', true);
               }
               HT.niceSelectDestroy();
               HT.niceSelect();
          }
          HT.niceSelect = () => {
               $(".niceSelect").niceSelect();
          };
          HT.niceSelectDestroy = () => {
               if ($(".niceSelect").length) {
                    $(".niceSelect").niceSelect("destroy");
               }
          };
          HT.getSelect2 = (object) => {
               let option = {
                    'attributeCatalogueId': object.attr('data-catid')
               }
               $(object).select2({
                    minimumInputLength: 2,
                    //placeholder: "Nhap toi thieu 2 ky tu",
                    ajax: {
                         url: 'http://127.0.0.1:8000/ajax/attribute/getAttribute',
                         type: 'GET',
                         dataType: 'json',
                         delay: 250,
                         data: function(params) {

                              return {
                                   search: params.term,
                                   option: option
                              }
                         },
                         processResults: function(data) {

                              return {
                                   results: $.map(data, function(obj, i) {
                                        return obj;
                                   })
                              }
                         },
                         cache: true
                    }
               })
          }
          HT.chooseVariantGroup = () => {
               $(document).on('change', '.choose-attribute', function() {
                    let _this = $(this)
                    let attributeCatalogueId = _this.val()
                    if (attributeCatalogueId != 0) {
                         _this.parents('.col-lg-3').siblings('.col-lg-8').html(HT.select2Variant(attributeCatalogueId))
                         $('.selectVariant').each(function(key, index) {

                              HT.getSelect2($(this))
                         })
                    } else {
                         _this.parents('.col-lg-3').siblings('.col-lg-8').html(' <input type="text"  disabled="" class="  fake-variant form-control">')
                    }

                    HT.disabledAttribute();
               })
          }

          HT.checkMaxAttribute = (attributeCatalogue) => {
               let variantItem = $('.variant-item').length;
               if (variantItem >= attributeCatalogue.length) {
                    $('.add-variant').remove();
               } else {
                    $('.variant-footer').html(' <button type="button" class="add-variant">Them san pham moi</button>')
               }
          }
          HT.removeAttribute = () => {
               var attributeCatalogue = <?php echo $jsonArray; ?>;
               $(document).on('click', '.remove-attribute', function() {
                    let _this = $(this)
                    _this.parents('.variant-item').remove()
                    HT.checkMaxAttribute(attributeCatalogue)
                    HT.createVariant()
               })


          }
          HT.select2Variant = (id) => {
               let html = '<select class="selectVariant variant-' + id + ' form-control" name="attribute[' + id + '][]" multiple data-catid="' + id + '"></select>';
               return html;
          }

          HT.createProductVariant = () => {
               $(document).on('change', '.selectVariant', function() {
                    let _this = $(this)
                    HT.createVariant()
               })
          }
          HT.createVariant = () => {
               let attributes = []
               let variant = []
               let attributeTitle = []
               $('.variant-item').each(function() {
                    let _this = $(this)
                    let attr = []
                    let attrVariant = []
                    let attributeCatalogueId = _this.find('.choose-attribute option:selected').val();
                    let optionText = _this.find('.choose-attribute option:selected').text();
                    let attribute = $('.variant-' + attributeCatalogueId).select2('data')
                    for (let i = 0; i < attribute.length; i++) {
                         let item = {}
                         let itemVariant = {}
                         item[optionText] = attribute[i].text
                         itemVariant[attributeCatalogueId] = attribute[i].id
                         attr.push(item)
                         attrVariant.push(itemVariant)
                    }
                    attributes.push(attr)
                    attributeTitle.push(optionText)
                    variant.push(attrVariant)
               })
               attributes = attributes.reduce(
                    (a, b) => a.flatMap(d => b.map(e => ({
                         ...d,
                         ...e
                    })))
               )
               variant = variant.reduce(
                    (a, b) => a.flatMap(d => b.map(e => ({
                         ...d,
                         ...e
                    })))
               )
               let trClass = []
               HT.renderTableHeader(attributeTitle)
               attributes.forEach((item, index) => {
                    let $row = HT.createVariantRow(item, variant[index])
                    let classModified = 'tr-variant-' + Object.values(variant[index]).join(', ').replace(/, /g, '-')
                    trClass.push(classModified)
                    if (!$('table.variantTable tbody tr').hasClass(classModified))
                         $('.variantTable tbody').append($row)
               })
               // let html = HT.renderTableHtml(attributes, attributeTitle, variant)
               // $('table.variantTable').html(html)
               $('table.variantTable tbody tr').each(function() {
                    const $row = $(this)
                    const rowClass = $row.attr('class')
                    if (rowClass) {
                         const rowClassArray = rowClass.split(' ')
                         let check = false
                         rowClassArray.forEach(rowClass => {
                              if (rowClass == 'variant-row') {
                                   return;
                              } else if (!trClass.includes(rowClass)) {
                                   check = true
                              }
                         })
                         if (check) {
                              $row.remove()
                         }
                    }
               })
          }
          HT.createVariantRow = (attributeItem, variantItem) => {
               let attributeString = Object.values(attributeItem).join(', ')
               let attributeId = Object.values(variantItem).join(', ')
               let classModified = attributeId.replace(/, /g, '-')
               let $row = $('<tr>').addClass('variant-row tr-variant-' + classModified)
               let $td
               $td = $('<td>').append($('<span>').addClass('image img-cover').append($('<img>').attr('src', 'dasda')))

               $row.append($td)

               Object.values(attributeItem).forEach(value => {
                    $td = $('<td>').text(value)
                    $row.append($td)
               })
               let mainPrice = $('input[name="price"]').val()
               let mainCode = $('input[name="code"]').val()
               let inputHiddenField = [{
                         name: 'variant[sku][]',
                         class: 'variant_sku',
                         value: mainCode + '-' + classModified
                    },
                    {
                         name: 'variant[quantity][]',
                         class: 'variant_quantity'
                    },
                    {
                         name: 'variant[price][]',
                         class: 'variant_price',
                         value: mainPrice
                    },
                    {
                         name: 'variant[barcode][]',
                         class: 'variant_barcode'
                    },
                    {
                         name: 'variant[filename][]',
                         class: 'variant_filename'
                    },
                    {
                         name: 'variant[url][]',
                         class: 'variant_url'
                    },
                    {
                         name: 'variant[album][]',
                         class: 'variant_album'
                    },
                    {
                         name: 'variant[name][]',
                         value: attributeString
                    },
                    {
                         name: 'variant[id][]',
                         value: attributeId
                    },
               ]
               $td = $('<td>').addClass(' hidden td-variant')
               $.each(inputHiddenField, function(_, field) {
                    let $input = $('<input>').attr('type', 'text').attr('name', field.name).addClass(field.class)
                    if (field.value) {
                         $input.val(field.value)
                    }
                    $td.append($input)
               })
               $row.append($('<td>').addClass('td-quantity').text('-'))
                    .append($('<td>').addClass('td-price').text(mainPrice))
                    .append($('<td>').addClass('td-sku').text(mainCode + '-' + classModified))
                    .append($td)
               return $row
          }


          HT.renderTableHeader = (attributeTitle) => {
               let $thead = $('table.variantTable thead');
               let $row = $('<tr>')
               $row.append($('<td>').text('Hinh anh'))
               for (let i = 0; i < attributeTitle.length; i++) {
                    $row.append($('<td>').text(attributeTitle[i]))
               }
               $row.append($('<td>').text('So luong'))
               $row.append($('<td>').text('Gia'))
               $row.append($('<td>').text('SKU'))
               $thead.html($row)
               return $thead
          }
          HT.renderTableHtml = (attributes, attributeTitle, variant) => {
               let html = ''

               html += ' <thead>'
               html += '<tr >'
               html += '<td>Anh</td>'
               for (let i = 0; i < attributeTitle.length; i++) {
                    html += ' <td>' + attributeTitle[i] + '</td>'
               }
               html += '<td>So luong</td>'
               html += ' <td>Gia tien</td>'
               html += ' <td>SKU</td>'
               html += ' </tr>'
               html += ' </thead>'
               html += '<tbody>'
               for (let i = 0; i < attributes.length; i++) {
                    html += '<tr class="variant-row">'
                    html += ' <td><span class="image img-cover "><img src="asd" style="width:60px" class="imgSrc" alt="dasd"><</span></td>'
                    let attributeArray = [];
                    let attributeIDArray = [];
                    $.each(attributes[i], function(index, value) {
                         html += ' <td>' + value + '</td>'
                         attributeArray.push(value)
                    })
                    $.each(variant[i], function(index, value) {
                         attributeIDArray.push(value)
                    })
                    let attributeString = attributeArray.join(', ')
                    let attributeIdString = attributeIDArray.join(', ')
                    html += ' <td class="td-quantity"></td>'
                    html += ' <td class="td-price"></td>'
                    html += ' <td class="td-sku">SKU</td>'
                    html += ' <td class="hidden td-variant">'
                    html += ' <input type="text" name="variant[sku][]" class="variant_sku">'
                    html += ' <input type="text" name="variant[quantity][]" class="variant_quantity">'
                    html += '<input type="text" name="variant[price][]" class="variant_price">'
                    html += ' <input type="text" name="variant[barcode][]" class="variant_barcode">'
                    html += ' <input type="text" name="variant[filename][]" class="variant_filename">'
                    html += ' <input type="text" name="variant[fileurl][]" class="variant_url">'
                    html += ' <input type="text" name="variant[album][]" class="variant_album">'
                    html += ' <input type="text" name="attribute[name][]" value="' + attributeString + '">'
                    html += ' <input type="text" name="attribute[id][]" value="' + attributeIdString + '">'
                    html += ' </td>'
                    html += ' </tr>'
               }
               html += ' </tbody>'
               return html;
          }
          HT.variantAlbum = () => {
               $(document).on('click', '.click-to-upload-variant', function(e) {
                    HT.browseVariantServerAlbum()
                    e.preventDefault();
               })
          }
          HT.browseVariantServerAlbum = () => {
               var type = "Images";
               var finder = new CKFinder();

               finder.resourceType = type;
               finder.selectActionFunction = function(fileUrl, data, allFiles) {
                    let html = "";
                    for (var i = 0; i < allFiles.length; i++) {
                         var image = allFiles[i].url;
                         html += '<li class="ui-state-default">';
                         html += ' <div class="thumb">';
                         html += ' <span class="span image img-scaledown">';
                         html +=
                              '<img src="' +
                              image +
                              '" alt="' +
                              image +
                              '">';
                         html +=
                              '<input type="hidden" name="variantAlbum[]" value="' +
                              image +
                              '">';
                         html += "</span>";
                         html +=
                              '<button class="variant-delete-image"><i class="fa fa-trash"></i></button>';
                         html += "</div>";
                         html += "</li>";
                    }

                    $(".click-to-upload-variant").addClass("hidden");
                    $("#sortable2").append(html);
                    $(".upload-variant-list").removeClass("hidden");
               };
               finder.popup();
          };
          HT.deleteVariantPicture = () => {
               $(document).on("click", ".variant-delete-image", function() {
                    let _this = $(this);
                    _this.parents(".ui-state-default").remove();
                    if ($(".ui-state-default").length == 0) {
                         $(".click-to-upload-variant").removeClass("hidden");
                         $(".upload-variant-list").addClass("hidden");
                    }
               });
          };
          HT.switchChange = () => {
               $(document).on("change", '.js-switch', function() {
                    let _this = $(this);
                    let isChecked = _this.prop("checked");
                    if (isChecked) {
                         _this.parents('.col-lg-2').siblings('.col-lg-10').find('.disabled').removeAttr('disabled')
                    } else {
                         _this.parents('.col-lg-2').siblings('.col-lg-10').find('.disabled').attr('disabled', true)
                    }
               })
          }
          HT.variantAlbumList = (album) => {
               let html = ''
               if (album.length && album[0] != '') {
                    for (let i = 0; i < album.length; i++) {
                         html += ' <li class="ui-state-default"> '
                         html += '<div class="thumb"> '
                         html += '<span class="span image img-scaledown">'
                         html += ' <img src="' + album[i] + '" alt="' + album[i] + '">'
                         html += ' <input type="hidden" name="variantAlbum[]" value="' + album[i] + '">'
                         html += ' </span>'
                         html += '<button class="variant-delete-image" fdprocessedid="pjui73">'
                         html += '<i class="fa fa-trash"></i>'
                         html += ' </button>'
                         html += ' </div>'
                         html += ' </li>'
                    }
               }

               return html
          }
          HT.updateVariantHtml = (variantData) => {
               console.log(variantData)
               let variantAlbum = variantData.variant_album.split(', ');
               let variantAlbumItem = HT.variantAlbumList(variantAlbum)
               let html = ''
               html += ' <tr class="updateVariantTr">'
               html += '<td colspan="6">'
               html += '  <div class="updateVariant ibox">'
               html += '  <div class="ibox-title">'
               html += '  <div class="uk-flex uk-flex-middle uk-flex-space-between">'
               html += '   <h5>Cap nhat phien ban</h5>'
               html += ' <div class="button-group">'
               html += '     <div class="uk-flex uk-flex-middle">'
               html += ' <button type="button" class="cancelUpdate btn btn-danger">Huy bo</button>'
               html += '  <button type="button" class="saveUpdate btn btn-success">Luu lai</button>'
               html += ' </div>'
               html += ' </div>'
               html += '   </div>'
               html += '</div>'
               html += ' <div class="iox-content">'
               html += ' <div class="click-to-upload-variant" ' + ((variantAlbum.length > 0 && variantAlbum[0] !== '') ? 'disabled' : '') + '>'
               html += ' <div class="icon">'
               html += ' <a href="" class="upload-variant-picture">'
               html += '  <svg style="width:80px;height:80px;fill: #d3dbe2;margin-bottom: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">'
               html += ' <path d="M80 57.6l-4-18.7v-23.9c0-1.1-.9-2-2-2h-3.5l-1.1-5.4c-.3-1.1-1.4-1.8-2.4-1.6l-32.6 7h-27.4c-1.1 0-2 .9-2 2v4.3l-3.4.7c-1.1.2-1.8 1.3-1.5 2.4l5 23.4v20.2c0 1.1.9 2 2 2h2.7l.9 4.4c.2.9 1 1.6 2 1.6h.4l27.9-6h33c1.1 0 2-.9 2-2v-5.5l2.4-.5c1.1-.2 1.8-1.3 1.6-2.4zm-75-21.5l-3-14.1 3-.6v14.7zm62.4-28.1l1.1 5h-24.5l23.4-5zm-54.8 64l-.8-4h19.6l-18.8 4zm37.7-6h-43.3v-51h67v51h-23.7zm25.7-7.5v-9.9l2 9.4-2 .5zm-52-21.5c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5zm0-8c-1.7 0-3 1.3-3 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3zm-13-10v43h59v-43h-59zm57 2v24.1l-12.8-12.8c-3-3-7.9-3-11 0l-13.3 13.2-.1-.1c-1.1-1.1-2.5-1.7-4.1-1.7-1.5 0-3 .6-4.1 1.7l-9.6 9.8v-34.2h55zm-55 39v-2l11.1-11.2c1.4-1.4 3.9-1.4 5.3 0l9.7 9.7c-5.2 1.3-9 2.4-9.4 2.5l-3.7 1h-13zm55 0h-34.2c7.1-2 23.2-5.9 33-5.9l1.2-.1v6zm-1.3-7.9c-7.2 0-17.4 2-25.3 3.9l-9.1-9.1 13.3-13.3c2.2-2.2 5.9-2.2 8.1 0l14.3 14.3v4.1l-1.3.1z">'
               html += '</path>'
               html += '  </svg>'
               html += ' </a>'
               html += '</div>'
               html += '<div class="small-text">Hello</div>'
               html += ' </div>'
               html += ' <ul class="upload-variant-list ' + (variantAlbumItem.length > 0 ? '' : 'hidden') + '" id="sortable2">' + variantAlbumItem + '</ul>'
               html += '<div class="row">'
               html += ' <div class="col-lg-2">'
               html += '  <label for="">Quan ly ton kho</label>'
               html += ' <input type="checkbox" class="js-switch" ' + ((variantData.variant_quantity !== '') ? 'checked' : '') + ' data-target="disabled">'
               html += ' </div>'
               html += ' <div class="col-lg-10">'
               html += ' <div class="row">'
               html += ' <div class="col-lg-3">'
               html += ' <label for="" class="control-label">So luong</label>'
               html += ' <input type="text" ' + ((variantData.variant_quantity != "") ? '' : 'disabled') + ' name="variant-quantity" value="' + variantData.variant_quantity + '" class=" disabled form-control">'
               html += ' </div>'
               html += '<div class="col-lg-3">'
               html += '  <label for="" class="control-label">SKU</label>'
               html += '  <input type="text" name="variant-sku" value="' + variantData.variant_sku + '" >'
               html += ' </div>'
               html += ' <div class="col-lg-3">'
               html += '  <label for="" class="control-label">Gia</label>'
               html += '<input type="text" name="variant-price" value="' + variantData.variant_price + '" >'
               html += ' </div>'
               html += '<div class="col-lg-3">'
               html += '  <label for="" class="control-label">Barcode</label>'
               html += '  <input type="text" name="variant-barcode" value="' + variantData.variant_barcode + '" >'
               html += ' </div>'
               html += '</div>'
               html += ' </div>'
               html += ' </div>'
               html += ' <div class="row">'
               html += ' <div class="col-lg-2">'
               html += ' <label for="">Quan ly File</label>'
               html += ' <input type="checkbox" class="js-switch" ' + ((variantData.variant_filename !== '') ? 'checked' : '') + ' data-target="disabled">'
               html += ' </div>'
               html += ' <div class=" col-lg-10">'
               html += ' <div class="row">'
               html += '  <div class="col-lg-6">'
               html += '   <label for="" class="control-label">Ten File</label>'
               html += '  <input type="text" ' + ((variantData.variant_filename != '') ? '' : 'disabled') + '  name="file-name-variant" class=" disabled form-control" value="' + variantData.variant_filename + '" >'
               html += ' </div>'
               html += ' <div class="col-lg-6">'
               html += ' <label for="" class="control-label">Duong dan</label>'
               html += ' <input type="text" ' + ((variantData.variant_url != '') ? '' : 'disabled') + '  name="file-url-variant" class=" disabled form-control" value="' + variantData.variant_url + '">'
               html += ' </div>'
               html += ' </div>'
               html += ' </div>'
               html += '</div>'
               html += ' </div>'
               html += ' </div>'
               html += ' </td>'
               html += ' </tr>'
               return html;
          }
          HT.updateVariant = () => {
               $(document).on('click', '.variant-row', function() {
                    let _this = $(this)
                    let variantData = {}
                    _this.find(".td-variant input[type=text][class^='variant_']").each(function() {
                         let className = $(this).attr('class')
                         console.log(className)
                         variantData[className] = $(this).val()
                    })

                    let html = HT.updateVariantHtml(variantData)

                    if ($('.updateVariantTr').length == 0) {
                         _this.after(html)
                    }
               })
          }
          HT.cancelVariantUpdate = () => {
               $(document).on('click', '.cancelUpdate', function() {
                    HT.closeVariantUpdate()
               })
          }
          HT.closeVariantUpdate = () => {
               $('.updateVariantTr').remove()
          }
          HT.saveVariantUpdate = () => {
               $(document).on('click', '.saveUpdate', function() {
                    let variant = {
                         'quantity': $('input[name=variant-quantity').val(),
                         'sku': $('input[name=variant-sku').val(),
                         'price': $('input[name=variant-price').val(),
                         'barcode': $('input[name=variant-barcode').val(),
                         'filename': $('input[name=file-name-variant').val(),
                         'url': $('input[name=file-url-variant').val(),
                         'album': $("input[name='variantAlbum[]']").map(function() {
                              return $(this).val();
                         }).get(),
                    }
                    $.each(variant, function(index, value) {
                         $('.updateVariantTr').prev().find('.variant_' + index).val(value)
                    })
                    HT.previewVariantTr(variant)
                    HT.closeVariantUpdate()
               })
          }
          HT.previewVariantTr = (variant) => {
               let option = {
                    'quantity': variant.quantity,
                    'price': variant.price,
                    'sku': variant.sku,
               }
               $.each(option, function(index, value) {
                    $('.updateVariantTr').prev().find('.td-' + index).html(value)
               })
               $('.updateVariantTr').prev().find('.imgSrc').attr('src',  + variant.album[0])
               console.log(variant.album[0])
          }
          $(document).ready(function() {
               HT.setupProductVariant();
               HT.addVariant();
               HT.niceSelect();
               HT.chooseVariantGroup();
               HT.removeAttribute()
               HT.createProductVariant()
               HT.browseVariantServerAlbum()
               HT.variantAlbum()
               HT.deleteVariantPicture()
               HT.switchChange()
               HT.updateVariant()
               HT.cancelVariantUpdate()
               HT.saveVariantUpdate()
          });
     })(jQuery);
</script>