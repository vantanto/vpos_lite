// On page load or when changing sidebar
if (localStorage.getItem('sidebar-collapse') === 'true') {
    document.body.classList.add('sidebar-collapse');
} else {
    document.body.classList.remove('sidebar-collapse')
}

var sidebarToggleBtn = $('[data-widget="pushmenu"]');
sidebarToggleBtn.on('click', function() {
	// if set via local storage previously
	if (localStorage.getItem('sidebar-collapse')) {
        if (localStorage.getItem('sidebar-collapse') === 'false') {
			localStorage.setItem('sidebar-collapse', 'true');
		} else {
            localStorage.setItem('sidebar-collapse', 'false');
		}

    // if NOT set via local storage previously
	} else {
		if (document.body.classList.contains('sidebar-collapse')) {
			localStorage.setItem('sidebar-collapse', 'false');
		} else {
			localStorage.setItem('sidebar-collapse', 'true');
		}
	}

});