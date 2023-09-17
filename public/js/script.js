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

// Concluir card e alterar o SVG
function toggleSVG(event, id) {
    event.preventDefault();

    var clickedElement = event.currentTarget;
    var svg = clickedElement.querySelector(".bi-check-circle");
    var svgFilled = clickedElement.querySelector(".bi-check-circle-fill");

    // Faz a chamada à rota notes.check para alterar o status do elemento clicado
    var csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("/notes/" + id + "/check", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({ id: id }),
    })
        .then((response) => response.json())
        .then((data) => {
            // Atualiza a exibição dos ícones SVG com base na resposta da requisição
            if (data.status === "success") {
                if (svg.style.display === "none") {
                    svg.style.display = "inline";
                    svgFilled.style.display = "none";
                } else {
                    svg.style.display = "none";
                    svgFilled.style.display = "inline";
                }
            } else {
                console.error("Ocorreu um erro na atualização do status.");
            }
        })
        .catch((error) => {
            console.error("Ocorreu um erro:", error);
        });
}

document.addEventListener("DOMContentLoaded", function () {
    closedMessage();
});
