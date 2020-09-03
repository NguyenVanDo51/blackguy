
<h2 class="mb-3">Đổi mật khẩu</h2>
<div>
    <form action="{{route('profile-password')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="password">Mật khẩu mới: </label>
            <input type="text" name="password" id="password" placeholder="Nhập mật khẩu mới">
            @error('password')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Nhập lại: </label>
            <input type="text" name="password_confirmation" id="password_confirmation" placeholder="Nhập lại">
        </div>

        <button type="submit">Đổi mật khẩu</button>
    </form>
</div>
