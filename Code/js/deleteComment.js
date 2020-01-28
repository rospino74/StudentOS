const removeComment = ( elem, session, classroom ) => {
	let container = elem.parentElement;
	let id = elem.getAttribute("id").slice( 8 );
	let parent_id = container.parentElement.getAttribute("id").slice( 5 );
	
	container.removeChild( elem );
	
	let loader = new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		
		xhr.open("POST", "../api/deleteComment");
		
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("session=" + session + "&id=" + id + "&parent_id=" + parent_id + "&class=" + classroom);
		
		xhr.onload = () => resolve(xhr.responseText);
		xhr.onerror = () => reject(xhr.statusText);
	});
	
	loader.then(( result ) => {
		getComment( classroom, session );
	});
	loader.catch((r) => {
		console.error(r);
	});
}