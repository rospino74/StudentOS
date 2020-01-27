async function getPost( classroom, session ) {
	var container = document.querySelector("section.posts");
	
	var out = false;
	
	let loader = new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		
		xhr.open("POST", "../api/getPost");
		
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("class=" + classroom + "&session=" + session);
		
		xhr.onload = () => resolve(xhr.responseText);
		xhr.onerror = () => reject(xhr.statusText);
	});
	
	await loader.then((result) => {
		let data = JSON.parse( result );
		container.innerHTML = "";
		
		data.forEach(( elem ) => {
			
			let post = document.createElement("article");
			post.classList.add("post");
			post.id = "post-" + elem.id;
			
			if( elem.isOwner ) {
				//creating new elements
				let menu = document.createElement("nav");
				let btn = document.createElement("button");
				
				//appending classes to the elements
				menu.classList.add("menu");
				btn.classList.add("fas", "fa-ellipsis-v", "menu-btn");
				btn.setAttribute("onclick", "showMenu(this.parentElement)");
				
				//adding the button to the menu
				menu.appendChild(btn);
				menu.innerHTML += `<div class="menu-content">
										<a href="#" onclick="removePost(this.parentElement.parentElement.parentElement, s_id, c_id)">Delete</a>
									</div>`;
									
				//appending the menu to the post
				post.appendChild(menu);
			}
			
		post.innerHTML += `
						<div class="content">
							<h3 class="title">
								${elem.text.title}
							</h3>
							<p class="text">
								${elem.text.content}
							</p>
							<div class="info">
								${elem.author.name} <i class="fas fa-user"></i>
								<br />
								${elem.date} <i class="fas fa-clock"></i>
							</div>
						</div>
						<div class="separator"></div>
						<div class="comments">
							<p class="empty">No comments here!</p>
						</div>`;

			container.appendChild( post );
			
		});
		out = true;
	});
	loader.catch((e) => {
		console.error("Post error: " + e);
		out = false;
	});
	
	return out;
}