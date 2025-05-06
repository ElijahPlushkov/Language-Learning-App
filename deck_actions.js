document.addEventListener("DOMContentLoaded", function() {

document.querySelectorAll('.add-new-card').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('deckId').value = btn.dataset.deckId;
        });
    });

    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("toggle-card-display")) {
            const toggleDisplay = event.target;
            const cardDisplay = toggleDisplay.closest(".deck").querySelector(".card-display");

            cardDisplay.classList.toggle("d-none");
            toggleDisplay.textContent = cardDisplay.classList.contains("d-none")
            ? "Show Cards" : "Hide Cards";
        }
    })

    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("show-answer")) {
            const toggleButton = event.target;
            const card = toggleButton.closest(".card");
            const back = card.querySelector(".card-back");

            back.classList.toggle("d-none");
            toggleButton.textContent = back.classList.contains("d-none")
            ? "Show Answer" : "Hide Answer";
        }
    });

});