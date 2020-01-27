function showDeleteButtons( session, classroom ) {
	var container = document.querySelector("section.posts");
	
	container.childNodes.forEach( ( elem ) => {
		var btn = document.createElement("button");
		btn.classList = "btn-remove-post fas fa-times";
		btn.addEventListener("click", () => {
			hideDeleteButtons();
			removePost( elem, session, classroom );
		});
	
		elem.appendChild( btn );
	});
}
function hideDeleteButtons() {
	var buttons = document.querySelectorAll("button.btn-remove-post");
	
	buttons.forEach( ( elem ) => {
		elem.parentElement.removeChild( elem );
	});
}

function removePost( elem, session, classroom ) {
	var container = document.querySelector("section.posts");
	var id = elem.getAttribute("id").slice( 5 );
	
	container.removeChild( elem );
	
	var loader = new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		
		xhr.open("POST", "../api/deletePost");
		
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("session=" + session + "&id=" + id + "&class=" + classroom);
		
		xhr.onload = () => resolve(xhr.responseText);
		xhr.onerror = () => reject(xhr.statusText);
	});
	
	loader.then(( result ) => {
		getPost( classroom, session );
		getComment( classroom, session );
	});
}