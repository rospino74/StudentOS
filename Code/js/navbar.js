const back = document.querySelectorAll('.navbar *[data-action=back]');
const quit = document.querySelectorAll('.navbar *[data-action=quit]');
const home = document.querySelectorAll('.navbar *[data-action=home]');
const scrollTop = document.querySelectorAll('.navbar *[data-action=scrollTop]');

back.forEach((item) => {
	item.addEventListener("click", (e) => {
		history.back();
	});
});

quit.forEach((item) => {
	item.addEventListener("click", (e) => {
		window.location.href = "../check.php?action=logout";
	});
});

home.forEach((item) => {
	item.addEventListener("click", (e) => {
		window.location.href = "../";
	});
});

scrollTop.forEach((item) => {
	item.addEventListener("click", (e) => {
		window.scrollTo(0,0);
	});
});