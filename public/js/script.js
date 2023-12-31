// meus scripts
document.addEventListener("DOMContentLoaded", function () {
    closedMessage();
    previewImage();
});

// Fechar as mensagens
function closedMessage() {
    setTimeout(function () {
        var alertElement = document.getElementById("alert");
        if (alertElement) {
            var bsAlert = new bootstrap.Alert(alertElement);
            bsAlert.close();
        }
    }, 2500);
}

//apresentar a preview da imagem do perfil
function previewImage() {
    const fileInput = document.getElementById("customFile");
    const profileImage = document.getElementById("profileImage");

    if (fileInput) {
        fileInput.addEventListener("change", (event) => {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = (e) => {
                profileImage.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });
    }
}

// Concluir card e alterar o SVG
function toggleSVG(event, id) {
    event.preventDefault();

    var clickedElement = event.currentTarget;
    var svg = clickedElement.querySelector(".bi-check-circle");
    var svgFilled = clickedElement.querySelector(".bi-check-circle-fill");
    var card = document.getElementById("card-" + id);

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

// incluir usuário na nota
function addUserNote(event, pageTitle, id) {
    event.preventDefault();
    var formShared = document.getElementById("form_shared");
    var idNote = document.getElementById("note_id");
    var page = document.getElementById("page");

    idNote.value = id;
    page.value = pageTitle;
    formShared.action = "/notes/" + id + "/shared";

    var meuModal = new bootstrap.Modal(
        document.getElementById("add_user_note")
    );
    meuModal.show();
}

// excluir usuário da nota
function removeUserNote(event, noteId, userId) {
    event.preventDefault();
    var clickedElement = event.currentTarget;

    // Faz a chamada à rota notes.not-shared para alterar o status do elemento clicado
    var csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("/notes/" + noteId + "/not-shared/" + userId, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            // Atualiza a exibição das imagens com base na resposta da requisição
            if (data.status === "success") {
                clickedElement.style.display = "none";
            } else {
                console.error("Ocorreu um erro na atualização do status.");
            }
        })
        .catch((error) => {
            console.error("Ocorreu um erro:", error);
        });
}
