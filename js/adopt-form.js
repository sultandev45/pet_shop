// function openAdoptionForm() {
//     var width = 600; // Width of the popup window
//     var height = 600; // Height of the popup window
//     var left = (window.innerWidth - width) / 2; // Calculate left position
//     var top = (window.innerHeight - height) / 2; // Calculate top position

//     // Open the popup window with calculated position
//     var popup = window.open("adoption-form.php", "_blank", "width=" + width + ",height=" + height + ",left=" + left + ",top=" + top);
//     if (popup) {
//         popup.focus();
//     } else {
//         alert('Please allow popups for this website');
//     }
// }
function openAdoptionForm() {
    var modal = document.getElementById("myModal");
    var overlay = document.getElementById("myOverlay");

    modal.style.display = "block";
    overlay.style.display = "block";

    // Close the modal when the close button or overlay is clicked
    var closeBtn = modal.querySelector(".close");
    closeBtn.onclick = function() {
        modal.style.display = "none";
        overlay.style.display = "none";
    };
    overlay.onclick = function() {
        modal.style.display = "none";
        overlay.style.display = "none";
    };
}