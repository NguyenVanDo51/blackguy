@component('mail::message')
# Introduction

Chúc mừng bạn đã đăng kí thành công tài khoản trên blackguy.

<p>{{$name ?? ""}}</p>
<p>{{$name2 ?? ""}}</p>
<h3>Click nút bên dưới để đi đến trang chủ</h3>
@component('mail::button', ['url' => 'http://blackguy.test/'])
Trang chủ
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
