function getPost(classroom, session ) {
	var container = document.querySelector("section.posts");
	
	var out = false;
	
	var loader = new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		
		xhr.open("POST", "../api/getPost");
		
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("class=" + classroom + "&session=" + session);
		
		xhr.onload = () => resolve(xhr.responseText);
		xhr.onerror = () => reject(xhr.statusText);
	});
	
	loader.then((result) => {
		var data = JSON.parse( result );
		container.innerHTML = "";
		
		data.forEach(( elem ) => {
			
			var post = document.createElement("article");
			post.classList.add("content");
			post.id = "post-" + elem.id;
			
			post.innerHTML = '<header class="title"><h2>' + elem.text.title + '</h2></header><div class="text"><p>' + elem.text.content + '</p></div><div class="info">' + elem.author + '	<i class="fas fa-user"></i><br />' + elem.date + ' <i class="fas fa-clock"></i></div>';
			
			container.appendChild( post );
			
			out = true;
		});
	}).catch(() => {
		out = false;
	});
	
	return out;
}