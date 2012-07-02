function resetAllNav() {
	
	document.getElementById('default_nav').style.display = "none";
	var eventNav = document.getElementById('event_nav');
	//var publishNav = document.getElementById('publish_nav');
	var manageNav = document.getElementById('manage_nav');
	//var systemNav = document.getElementById('system_nav');
	
	eventNav.style.display = "none";
	//publishNav.style.display = "none";
	manageNav.style.display = "none";
	//systemNav.style.display = "none";
	
	
	
	var eventNavLink = document.getElementById('event_nav_link');
	//var publishNavLink = document.getElementById('publish_nav_link');
	var manageNavLink = document.getElementById('manage_nav_link');
	//var systemNavLink = document.getElementById('system_nav_link');
	
	eventNavLink.className = "main_nav";
	//publishNavLink.className = "main_nav";
	manageNavLink.className = "main_nav";
	//systemNavLink.className = "main_nav";

}


function showSubNav(nav, nav_link) {
	
	resetAllNav();
	
	subNav = document.getElementById(nav);
	Nav = document.getElementById('sub_nav');
	navLink = document.getElementById(nav_link);
	
	navLink.className = "selected_nav";
	Nav.style.display = "block";
	subNav.style.display = "block";
	
}