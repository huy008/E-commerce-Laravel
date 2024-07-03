<div class="row wrapper border-bottom white-bg page-heading">
     <div class="col-lg-8">
          <h2>Quan ly bai viet</h2>
          <ol
               class="breadcrumb"
               style="margin-bottom:10px;"
          >
               <li>
                    <a href="{{route('dashboard.index')}}">Dashboards</a>
               <li class="active"><strong>Quan ly bai viet</strong></li>
               </li>
          </ol>
     </div>
</div>

<div
     class="row "
     style="margin:20px;"
>
     <div class="col-lg-12">
          <div class="ibox float-e-margins">
               <div class="ibox-title">
                    <h5>Basic Table</h5>
                    @include('backend.attribute.attribute.component.tool')
               </div>
               <div class="ibox-content">
                    @include('backend.attribute.attribute.component.filter')
                    @include('backend.attribute.attribute.component.table')



               </div>
          </div>
     </div>