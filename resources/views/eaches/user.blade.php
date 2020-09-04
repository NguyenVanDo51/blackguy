<tr>
    <td>{{$user->name ?? ""}}</td>
    <td>{{$user->email ?? ""}}</td>
    <td>{{$user->role ?? ""}}</td>
    <td>{{$user->created_at ?? ""}}</td>
    <td>{{$user->courses_count ?? ""}}</td>
    <td class="position-relative">
        <a href="#password{{$user->id}}"
           class="btn btn-secondary my-1 btn-sm " data-toggle="collapse" role="button" title="Đổi mật khẩu">
            <i class="fas fa-edit"></i>
        </a>

        <a href="{{route('admin-user-remove', $user->id)}}"
           class="btn btn-secondary btn-sm" title="Xóa">
            <i class="fas fa-trash"></i>
        </a>

        <form method="POST" action="{{route('admin-user-edit', $user->id)}}" name="password" id="password{{$user->id}}" class="collapse position-absolute form-inline" style="z-index: 10; top: 100%; right: 0;">

            @csrf

            <input type="password" class="form-control" id="inputPassword2" name="passwword" placeholder="Password">
            <button type="submit" class="mt-2 btn btn-primary mb-2">OK</button>
        </form>
    </td>
</tr>
