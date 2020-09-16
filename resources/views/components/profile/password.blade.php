
<h2 class="mb-3">Đổi mật khẩu</h2>
<div>
    <form action="{{route('profile-password')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="old-password">Mật khẩu hiện tại: </label>
            <input type="password" name="old-password" id="old-password" class="form-control" placeholder="Mật khẩu hiện tại">

            <small class="text-danger">{{$error ?? ""}}</small>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu mới: </label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu mới">
            @error('password')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Nhập lại: </label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Nhập lại">
        </div>

        <button class="btn btn-primary" type="submit">Đổi mật khẩu</button>
    </form>
</div>
