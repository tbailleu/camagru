<video id="camera"></video>
<button id="capture">Capture</button>
<script>
  var camera = document.getElementById('camera');

  navigator.getUserMedia({ video: true }, stream=>{
		camera.srcObject = stream;
		camera.onloadedmetadata = ()=>camera.play();
	}, (err)=>{
		console.log(err.name + ": " + err.message);
	});

	var capture = document.getElementById('capture');

	var postIMG = (data, sticker)=>{
		var xhr  = new XMLHttpRequest()
		xhr.open('POST', "", true)
		xhr.onload = function () {
			var response = JSON.parse(xhr.responseText);
			if (xhr.readyState == 4 && xhr.status == "200") {
				console.table(response);
			} else {
				console.error(response);
			}
		}
		
		xhr.send(JSON.stringify({img: data, sticker: sticker}));
	}

	capture.onclick = ()=>{
		var canvas = document.createElement('canvas');
		canvas.width = camera.videoWidth;
		canvas.height = camera.videoHeight;
		var ctx = canvas.getContext('2d');
		ctx.drawImage(camera, 0, 0, canvas.width, canvas.height);
		var img = canvas.toDataURL('image/png');

		postIMG(img);
	};

</script>
