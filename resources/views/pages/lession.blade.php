@extends('templade.app')

@section('content')
    <!-- Top info -->
    <div class="container-fluid my-5">
        <div class="row bg-dark mb-5 p-4 text-light">
            <div class="col-2"></div>
            <div class="col-10">
                <h2>{{$course->name}}</h2>
                <p>
                    Tác giả:
                    @if(empty($course->user_id))
                        Admin
                    @else
                        {{ App\User::query()->findOrFail($course->user_id)->name ?? "Admin"}}</p>
                @endif

            </div>
        </div>
    </div>
    <!-- End top info -->

    <!-- Content -->
    <div class="container">

        <!-- breadcrumb -->
        <x-breadcrumb :course="$course"/>

        <!-- Video and list lession -->
        <div class="row py-3 px-0">
            <div class="col-12 col-md-7">
                <div class="w-100 h-100 position-relative">
                    <div id="player" class="position-absolute"
                         style="top: 0; left: 0; width: 100%; height: 100%;"></div>
                    <input class="d-none" type="text" id="video" name="video"
                           value="{{ Str::after($lession->video, 'watch?v=') }}"/>
                </div>
                <div class="my-4">
                    <h3>{{ $lession->title }}</h3>
                </div>
            </div>
            <input class="d-none" type="text" value="{{$course->id}}" id='course_id'/>
            <input class="d-none" type="text" value="{{$lession->id}}" id='lession_id'/>
            <input class="d-none" type="text"
                   value="{{ Auth::user()->lessions()->where('lession_id', $lession->id)->first()->pivot->timer }}"
                   id='timer'/>
            <div class="col-12 col-md-5 mt-5 mt-md-0">
                <x-list-lession :course="$course"/>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // 2. This code loads the IFrame Player API code asynchronously.
        var tag = document.createElement('script');

        const video_id = document.getElementById('video').value;
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // 3. This function creates an <iframe> (and YouTube player)
        //    after the API code downloads.
        var player;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                height: '390',
                width: '640',
                startSeconds: 5,
                videoId: video_id,
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        // 4. The API will call this function when the video player is ready.
        function onPlayerReady(event) {
            event.target.playVideo();

            const timer = $('#timer').val();
            player.seekTo(timer);
            console.log(timer);

            setInterval(handle, 5000);
        }

        // 5. The API calls this function when the player's state changes.
        //    The function indicates that when playing a video (state=1),
        //    the player should play for six seconds and then stop.
        function onPlayerStateChange(event) {

        }

        function handle() {
            // player.stopVideo();
            let timer = Math.round(player.getCurrentTime());

            const course_id = $('#course_id').val();
            const lession_id = $('#lession_id').val();
            const total = player.getDuration();
            // console.log(total);
            $.get('http://blackguy.test/handle', {timer: timer, total: total, lession_id: lession_id});
        }
    </script>

@endsection
