//Simple function to underline active menu item or change color

function menu_selected(argument) {
	/*
	let s = "menu"+argument;

	try{
	//document.getElementById(s).style.fontSize = "1.05em";
}catch(e){
	console.log("Page has no entry in menu");
}
*/

let e = "menuel"+argument;
console.log(e);
	try{

	let el = document.getElementById(e);
	el.classList.add("active");

}catch(e){
	console.log("Page has no entry in menu");
}
}