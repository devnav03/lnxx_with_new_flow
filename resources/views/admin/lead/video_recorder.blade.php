@extends('admin.layouts.admin')
@php
    $route  = \Route::currentRouteName();    
@endphp
@section('content')

<section class="personal_details">
<div class="container">  
<div class="row">  
<div class="col-md-7">
<div class="personal_details_box cm_dt">
<!-- <h1 class="app_form_head">Application Form</h1>   --> 
<h2 style="font-size: 22px; margin-bottom: 15px;margin-top: 20px;">Upload Video</h2>
<h4 style="font-size: 18px;">Kindly start uttering this sentence for video KYC.</h4>
<p style="line-height: 24px;">My name is {{ $user->name}} {{$user->middle_name}} {{$user->last_name}}. I have applied for financial products through JCBL and provided them with my information as asked for. I authorize JCBL to have my application processed. This is my emirates ID. My EID number is {{ $user->eid_number}} .<br><br>
<b><i>Instructions:</i></b> Display the front and back of your Emirate ID card while speaking these words out loud.</p>
<div id="container">

    <video id="gum" style="width: 64%; margin-left: 18%;" playsinline autoplay muted></video>
    <video style="width: 64%; margin-left: 18%;display: none;" id="recorded" playsinline loop></video>

    <div style="text-align: center;">
        <span id="start" style="margin-top: 10px;cursor: pointer;" class="btn btn-danger">Start camera</span>
        <span id="record" style="color: #fff;background: #5EB495;margin-top: 10px;cursor: pointer;" class="btn" disabled>Start Recording</span>
        <span id="play" style="color: #fff;background: #5EB495; display: none;margin-top: 10px;cursor: pointer;" class="btn" disabled>Play</span>
        <span id="download" style="color: #fff;background: #5EB495; display: none;margin-top: 10px;cursor: pointer;" class="btn" disabled>Upload</span>

        @if(auth()->user()->user_type == 3)
        <p style="text-align: center; margin-top: 20px;"><a href="{{ route('agent.thank-you', $user_id) }}" id="skip" style="color: #ddd; font-size: 14px;">Skip & Submit</a></p>
        @else
        <p style="text-align: center; margin-top: 20px;"><a href="{{ route('admin.thank-you', $user_id) }}" id="skip" style="color: #ddd; font-size: 14px;">Skip & Submit</a></p>
        @endif
    </div>

    <div>
         <select style="opacity: 0;" id="codecPreferences" disabled></select>
    </div>

        <input style="opacity: 0;" type="checkbox" id="echoCancellation">


    <div>
        <span id="errorMsg"></span>
    </div>

  

</div>




<!-- <h6 style="color: #000;font-size: 17px;">Important Guidelines for Video-KYC:</h6> -->
<!-- <p style="color: rgba(9, 15, 5, 0.5); font-size: 14px;">Lorem ipsum dolor sit amet consectetur. Tempor cum amet ac purus sed. Faucibus lobortis bibendum eu pellentesque a morbi sit varius. Lobortis in ultricies placerat accumsan. Ac pharetra dolor aliquam libero sit at consectetur. Diam eu pulvinar mauris pulvinar enim egestas magna venenatis non. </p> -->
<!-- <ul style="padding: 0px; list-style: none;">
<li style="color: #555; font-size: 13px; margin-bottom: 5px;">It is important to keep the following guidelines in mind during your video KYC to ensure that it is completed smoothly:Make sure your background is white in color</li>
<li style="color: #555; font-size: 13px; margin-bottom: 5px;">There should not be anyone else in the frame</li>
<li style="color: #555; font-size: 13px; margin-bottom: 5px;">Your face should be clearly seen on the call</li>
<li style="color: #555; font-size: 13px; margin-bottom: 5px;">When displaying a document for the live capture, it should be displayed vertically from above
Make sure your ‘'location’' feature on your device is turned on</li>
</ul> -->
<form action="#" enctype="multipart/form-data" method="post">
{{ csrf_field() }}  
 <span id="start2"></span>

<div class="row">
  <div class="col-md-6">

</div>
</div>
</form>

</div>

</div>

<div class="col-md-5">
  <div class="service-step" style="margin-top: 0px;  border: 0px;">
    <img src="{!! asset('assets/frontend/images/video_record.png') !!}" style="max-width: 83%;" class="img-responsive const_vid_img">
  </div>
</div>

</div>
</div>
</section>

<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<!-- <script src="{{asset('js/video.js')}}"></script> -->


<script type="text/javascript">
let mediaRecorder;
let recordedBlobs;

const codecPreferences = document.querySelector('#codecPreferences');
const errorMsgElement = document.querySelector('span#errorMsg');
const recordedVideo = document.querySelector('video#recorded');
const recordButton = document.querySelector('span#record');
recordButton.addEventListener('click', () => {
  if (recordButton.textContent === 'Start Recording') {
    startRecording();
  } else {
    stopRecording();
    recordButton.textContent = 'Start Recording';
    playButton.disabled = false;
    downloadButton.disabled = false;
    codecPreferences.disabled = false;
  }
});

const playButton = document.querySelector('span#play');
playButton.addEventListener('click', () => {
  $("#recorded").show();
  const mimeType = codecPreferences.options[codecPreferences.selectedIndex].value.split(';', 1)[0];
  const superBuffer = new Blob(recordedBlobs, {type: mimeType});
  recordedVideo.src = null;
  recordedVideo.srcObject = null;
  recordedVideo.src = window.URL.createObjectURL(superBuffer);
  recordedVideo.controls = true;
  recordedVideo.play();
});
</script>

@if(auth()->user()->user_type == 3)

<script type="text/javascript">
const downloadButton = document.querySelector('span#download');
downloadButton.addEventListener('click', () => {
   var formdata = new FormData();
   formdata.append('blobFile', new Blob(recordedBlobs));
    fetch('<?php echo route('get-started'); ?>/agent/agent-consent-form/<?php echo $user_id; ?>', {
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: 'POST',
        body: formdata
    }).then(() => {
        window.location.href = '<?php echo route('get-started'); ?>/agent/agent-thank-you/<?php echo $user_id; ?>';
    });
});
</script>

@else

<script type="text/javascript">
const downloadButton = document.querySelector('span#download');
downloadButton.addEventListener('click', () => {
   var formdata = new FormData();
   formdata.append('blobFile', new Blob(recordedBlobs));
    fetch('<?php echo route('get-started'); ?>/admin/consent-form/<?php echo $user_id; ?>', {
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: 'POST',
        body: formdata
    }).then(() => {
        window.location.href = '<?php echo route('get-started'); ?>/admin/thank-you/<?php echo $user_id; ?>';
    });
});
</script>

@endif

<script type="text/javascript">
function handleDataAvailable(event) {
  console.log('handleDataAvailable', event);
  if (event.data && event.data.size > 0) {
    recordedBlobs.push(event.data);
  }
}

function getSupportedMimeTypes() {
  const possibleTypes = [
    'video/webm;codecs=vp9,opus',
    'video/webm;codecs=vp8,opus',
    'video/webm;codecs=h264,opus',
    'video/mp4;codecs=h264,aac',
  ];
  return possibleTypes.filter(mimeType => {
    return MediaRecorder.isTypeSupported(mimeType);
  });
}

function startRecording() {
  recordedBlobs = [];
  const mimeType = codecPreferences.options[codecPreferences.selectedIndex].value;
  const options = {mimeType};
  try {
    mediaRecorder = new MediaRecorder(window.stream, options);
  } catch (e) {
    console.error('Exception while creating MediaRecorder:', e);
    errorMsgElement.innerHTML = `Exception while creating MediaRecorder: ${JSON.stringify(e)}`;
    return;
  }
  console.log('Created MediaRecorder', mediaRecorder, 'with options', options);
  recordButton.textContent = 'Stop Recording';
  playButton.disabled = true;
  downloadButton.disabled = true;
  codecPreferences.disabled = true;
  mediaRecorder.onstop = (event) => {
    console.log('Recorder stopped: ', event);
    console.log('Recorded Blobs: ', recordedBlobs);
  };
  mediaRecorder.ondataavailable = handleDataAvailable;
  mediaRecorder.start();
  console.log('MediaRecorder started', mediaRecorder);
}

function stopRecording() {
  $("#play").show();
  $("#download").show();
  mediaRecorder.stop();
}

function handleSuccess(stream) {
  recordButton.disabled = false;
  console.log('getUserMedia() got stream:', stream);
  window.stream = stream;
  const gumVideo = document.querySelector('video#gum');
  gumVideo.srcObject = stream;

  getSupportedMimeTypes().forEach(mimeType => {
    const option = document.createElement('option');
    option.value = mimeType;
    option.innerText = option.value;
    codecPreferences.appendChild(option);
  });
  codecPreferences.disabled = false;
}

async function init(constraints) {
  try {
    const stream = await navigator.mediaDevices.getUserMedia(constraints);
    handleSuccess(stream);
  } catch (e) {
    console.error('navigator.getUserMedia error:', e);
    errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
  }
}

document.querySelector('span#start').addEventListener('click', async () => {
  document.querySelector('span#start').disabled = true;
  const hasEchoCancellation = document.querySelector('#echoCancellation').checked;
  const constraints = {
    audio: {
      echoCancellation: {exact: hasEchoCancellation}
    },
    video: {
      width: 1280, height: 720
    }
  };
  console.log('Using media constraints:', constraints);
  await init(constraints);
});
</script>


@endsection    