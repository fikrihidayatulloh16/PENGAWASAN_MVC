document.addEventListener("DOMContentLoaded", function() {
    var activeTab = localStorage.getItem("activeTab");
    if (activeTab) {
        var tabButton = document.querySelector('#' + activeTab + '-tab');
        var tabPane = document.querySelector('#' + activeTab);

        if (tabButton && tabPane) {
            var currentlyActiveButton = document.querySelector('.nav-link.active');
            var currentlyActivePane = document.querySelector('.tab-pane.show.active');

            if (currentlyActiveButton) currentlyActiveButton.classList.remove('active');
            if (currentlyActivePane) currentlyActivePane.classList.remove('show', 'active');

            tabButton.classList.add('active');
            tabPane.classList.add('show', 'active');
        }
    }

    var tabs = document.querySelectorAll('.nav-link');
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            localStorage.setItem('activeTab', this.getAttribute('data-bs-target').substring(1));
        });
    });
});