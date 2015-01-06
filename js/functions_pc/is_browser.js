// is_browser
function is_browser( browser ) {
	var ua = navigator.userAgent.toLowerCase();
	if ( ua.indexOf( browser ) !== -1 ) {
		return true;
	}
}

