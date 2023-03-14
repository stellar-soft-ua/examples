let allVideos = document.querySelectorAll('[data-videobanner]');
    
if (allVideos){
    allVideos.forEach(video=>{
        video.querySelector('.index__video-banner__play').addEventListener('click', function(){
            video.querySelector('.index__video-banner__play').style.opacity = 0;
            video.querySelectorAll('.common-cover').forEach(image=>{
                image.style.opacity = '0';
            });
            video.querySelectorAll('.common-video').forEach(vid=>{
                vid.style.opacity = 1;
            });
            let videotype = video.dataset.indexvid,
                videotypemob = video.dataset.indexvidmob;
            if (videotypemob){
                if (window.innerWidth < 767 ){
                    if (videotypemob == 'youtube'){
                        let mobileid = video.dataset.mobileid;
                            playvid(mobileid);
                    } else if (videotypemob == 'vimeo'){
                        let mobileid = video.dataset.mobileid;
                            playmeo(mobileid);
                    } else {
                        let vid = video.querySelector('video');
                            vid.play();
                    }
                } else {
                    if (videotype == 'youtube'){
                        let videoId = video.dataset.videoid;
                            playvid(videoId);
                    } else if (videotype == 'vimeo'){
                        let videoId = video.dataset.videoid;
                            playmeo(videoId);
                    } else {
                        let vid = video.querySelector('video');
                            vid.play();
                    }
                }
            } else {
                if (videotype == 'youtube'){
                    let videoId = video.dataset.videoid;
                        playvid(videoId);
                } else if (videotype == 'vimeo'){
                    let videoId = video.dataset.videoid;
                        playmeo(videoId);
                } else {
                    let vid = video.querySelector('video');
                        vid.play();
                }
            }
            
        });
    });
}

    // 2. This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
function onYouTubeIframeAPIReady() {
    console.log("Iframe api is ready");
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
    event.target.playVideo();
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
var done = false;
function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING && !done) {
        // setTimeout(stopVideo, 6000);
        done = true;
    }
}
function stopVideo() {
    player.stopVideo();
}

var player;

function playvid(vidid){
    player = new YT.Player(`player-${vidid}`, {
        height: '390',
        width: '640',
        videoId: vidid,
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

function playmeo(id){
    let options = {
        id: id,
        loop: true
    };

    let player = new Vimeo.Player(`player-${id}`, options);

    player.play();
}