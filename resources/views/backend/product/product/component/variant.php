<div class="ibox variant-box">
     <div class="ibox-title">
          <div>
               <h5>San pham co nhieu phien ban</h5>

          </div>
          <div class="description">
               Cho phep ban chon nhieu ban khac nhau cua san pham ,vi du quan ao co cac <strong class="text-danger">Mau sac va Size</strong> khac nhau Moi phien ban laf 1 dong trong muc danh sach ben duoi
          </div>
     </div>
     <div class="ibox-content">
          <div class="row">
               <div class="col-lg-12">
                    <div class="variant-checkbox">
                         <input type="checkbox" value="1" id="variantCheckBox" name="accept" {{old('accept')==1?'checked':""}}>
                         <label for="variantCheckBox" class="turnOnVariant">San pham nay co nhieu bien the</label>
                    </div>
               </div>
          </div>
          <div class="variant-wrapper {{old('accept')==1 ? 'hidden':''}}">
               <div class="row variant-container">
                    <div class="col-lg-3">
                         <div class="attribute-title">
                              Chon thuoc tinh
                         </div>
                    </div>
                    <div class="col-lg-9">
                         <div class="attribute-title">Chon gia tri cua thuoc tinh</div>
                    </div>
               </div>
               <div class="variant-body">

               </div>

               <div class="variant-footer ">
                    <button type="button" class="add-variant">Them san pham moi</button>
               </div>
          </div>

     </div>
</div>


<div class="ibox product-variant">
     <div class="ibox-title">
          <h5>Danh sach phien ban</h5>
     </div>
     <div class="ibox-content">
          <div class="table-responsive">
               <table class="table table-striped variantTable">
                    <thead></thead>
                    <tbody></tbody>
               </table>
          </div>


     </div>
</div>