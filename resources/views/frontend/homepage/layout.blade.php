<!DOCTYPE html>
<html lang="en">
@include('frontend.component.head')

<body>
     @include('frontend.component.header')
     @include($template)
     @include('frontend.component.footer')
     @include('frontend.component.script')
</body>

</html>