@extends('templade.app')

@section('content')
    <div class="container pt-3">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3><i class="fas fa-user-cog mr-2"></i>Hồ sơ</h3>
                    </div>
                    <div class="btn-group-vertical p-3">
                        <a @if($function == 'info') class="btn btn-primary font-weight-bold"
                           @else class="btn font-weight-bold" @endif
                           href="{{ route('test', 'info') }}">
                            <i class="far fa-id-card mr-2"></i>
                            Thông tin
                        </a>

                        <a @if($function == 'password') class="btn btn-primary font-weight-bold"
                           @else class="btn font-weight-bold" @endif
                           href="{{ route('test', 'password') }}">
                            <i class="fas fa-key mr-2"></i>
                            Đổi mật khẩu
                        </a>

                    </div>
                </div>
            </div>
            <div class="col-9">
                @switch($function)
                    @case('info')
                    <x-profile.info/>
                    @break

                    @case('password')
                    <x-profile.password/>
                    @break
                @endswitch
            </div>
        </div>
    </div>
@endsection
