if (document.getElementById("files").addEventListener) {
    document.getElementById("files").addEventListener('contextmenu', function(e) {
        alert("You've tried to open context menu mmmmm"); //here you draw your own menu
        e.preventDefault();
    }, false);
} else {
    document.getElementById("files").addEventListener('oncontextmenu', function() {
        alert("You've tried to open context menu");
        window.event.returnValue = false;
    });
}