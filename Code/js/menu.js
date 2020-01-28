const showMenu = ( elem ) => {
	let content = elem.querySelector(".menu-content");
	content.style.display = "block";

}
const hideMenu = ( elem ) => {
	let content = elem.querySelector(".menu-content");
	content.style.display = "none";
}

//add auto close
document.body.addEventListener("click", ( e ) => {
	let menu = document.querySelectorAll(".menu .menu-content"); //all menu
	let inner = false;
	
	menu.forEach(( elem ) => {
		let tmp = elem.parentElement; //menu elem
		
		if(tmp == e.target || tmp.contains(e.target)) {
			inner = true;
		}
	});
	
	if(inner) {
		return;
	} else {
		menu.forEach(( elem ) => {
			hideMenu(elem.parentElement);
		});
	}
});