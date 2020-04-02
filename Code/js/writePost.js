const openWriteWindow = ( session, classroom ) => {
	if(document.querySelector("div.write-container") != undefined) {
		return false;
	}
	
	//hiding the body overflow
	document.body.style.overflow = "hidden";

	let container = document.createElement("div");
	
	container.classList.add("write-container");
	container.innerHTML = `<div class="write-bg"></div>
	<div class="write-box">
		<h1>Write a post</h1>
		<label for="title">Title</label><br />
        <input id="title" type="text" placeholder="Insert the title..."/><br />
        <label for="text">Text</label><br />
        <textarea id="text" placeholder="Insert the text..."></textarea><br />
        <button name="send" class="btn-positive" onclick="writePost( '${session}', '${classroom}' ); hideWriteWindow();"><i class="fas fa-sticky-note"></i> Post</button><button onclick="closeWriteWindow();" class="btn-negative"><i class="fas fa-ban"></i> Close</button>
	</div>`;
	
	//adding event
	container.addEventListener("keypress", (e) => {
		if(e.ctrlKey && e.charCode == 13) {
			writePost( session, classroom);
			hideWriteWindow();
		} else {
			return;
		}
	});
	
	document.body.insertBefore(container, document.body.firstChild);
}
const hideWriteWindow = () => {
	if(document.querySelector("div.write-container") == undefined) {
		return false;
	}
	let windows = document.querySelector("div.write-container");
	windows.style.display = "none";
}

const closeWriteWindow = () => {
	if(document.querySelector("div.write-container") == undefined) {
		return false;
	}
	let windows = document.querySelectorAll("div.write-container");
	
	windows.forEach(( elem ) => {
		document.body.removeChild( elem );
	});
	
	//showing the body overflow
	document.body.style.overflow = "auto";
}

const writePost = ( session, classroom ) => {
	var title = document.querySelector("div.write-container .write-box #title");
	var text = document.querySelector("div.write-container .write-box #text");
	
	
	var uploader = new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		
		xhr.open("POST", "../api/addPost");
		
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("title=" + encodeURI(title.value) + "&text=" + encodeURI(text.value) + "&class=" + classroom + "&session=" + session);
		
		xhr.onload = () => {
			if(xhr.status == 201){
					resolve(xhr.responseText);
			} else {
					reject(xhr.responseText);
			}
		};
		xhr.onerror = () => reject(xhr.responseText);
	});
	
	uploader.then(() => {
		closeWriteWindow();
		getPost( classroom, session );
		getComment( classroom, session );
	});
	
	uploader.catch((result) =>{
		console.error(result);
		
		//showing a message
		SnackAlert.make({
			message: "Unable to post",
			showAction: true, 
			actionMessage: "Retry",
			actionCallback: () => {
				writePost( session, classroom );
			}
		});
	});
}