// meus scripts

// Fechar as mensagens
function closedMessage() {
    setTimeout(function () {
        var alertElement = document.getElementById("alert");
        if (alertElement) {
            var bsAlert = new bootstrap.Alert(alertElement);
            bsAlert.close();
        }
    }, 1500);
}

document.addEventListener("DOMContentLoaded", function () {
    closedMessage();
});
