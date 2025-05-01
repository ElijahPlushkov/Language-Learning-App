const decks = [];

function addNewDeck() {
    const deckForm = document.querySelector(".deck-form");
    deckForm.classList.toggle("d-none");
};

function Deck(name) {
    this.name = name;
    this.id = Date.now();
}

// const createDeck = document.querySelector(".create-deck");

// createDeck.addEventListener("click", (event) => {
//     event.preventDefault();
//     const template = document.getElementById("deckTemplate");
//     const clone = template.content.cloneNode(true);

//     const deckName = document.querySelector(".deck-name-input").value;

//     const newDeck = new Deck(deckName);
//     decks.push(newDeck);

//     const deck = clone.querySelector(".deck");
//     deck.classList.remove("d-none");

//     deck.id = newDeck.id;

//     const buttonName = clone.querySelector(".deck-name");
//     buttonName.textContent = deckName;

//     const decksDisplay = document.getElementById("decksDisplay");
//     decksDisplay.appendChild(clone);

//     document.querySelector(".deck-name-input").value = "";

//     editDeck(deck);
//     deleteDeck(deck);
//     addNewCard(deck);
//     createFlashCard(deck);
// });

// function editDeck(deck) {
//     deck.querySelector(".edit-deck").addEventListener("click", function () {
//         const deckId = parseInt(deck.dataset.id);
//         const deckObj = decks.find(deck => deck.id === deckId);

//         if (!deck) {
//             return;
//         }

//         const editForm = document.createElement("div");
//         editForm.id = "editForm";

//         editForm.innerHTML = `
//         <div id="editForm" class="">
//         <input type="text" id="newDeckName" value="">
//         <button class="save-edit">Save</button>
//         <button class="cancel-edit">Cancel</button>
//         </div>
//         `;

//         deck.appendChild(editForm);

//         editForm.querySelector(".save-edit").addEventListener("click", function () {
//             const newDeckName = document.getElementById("newDeckName").value;
//             deck.querySelector(".deck-name").textContent = newDeckName;

//             editForm.remove();
//         });

//         editForm.querySelector('.cancel-edit').addEventListener('click', () => {
//             editForm.remove();
//             cardElement.querySelector('.cancel').classList.remove('d-none');
//         });
//     });
// }

// function deleteDeck(deck) {
//     deck.querySelector(".delete-deck").addEventListener("click", function () {
//         const deckId = parseInt(deck.id);
//         console.log(deck.id);
//         const deckIndex = decks.findIndex(deck => deck.id === deckId);

//         if (deckIndex > -1) {
//             decks.splice(deckIndex, 1);
//             deck.remove();
//         }
//     });
// }

function addNewCard(deck) {
    const addNewCard = deck.querySelector(".add-new-card");
    addNewCard.addEventListener("click", () => {
        const newCardForm = deck.querySelector(".card-form");
        newCardForm.classList.remove("d-none");
    });
}

const cards = [];

function Card(question, answer) {
    this.question = question;
    this.answer = answer;
    this.id = Date.now();
}

function createFlashCard(deck) {
    const createCard = deck.querySelector(".create-card");
    createCard.addEventListener("click", () => {

        const question = deck.querySelector(".card-question-input").value;
        const answer = deck.querySelector(".card-answer-input").value;
        const cardDisplay = deck.querySelector(".card-display");
        const newCardForm = deck.querySelector(".card-form");

        if (!question || !answer) {
            alert("please fill both fileds");
            return;
        }

        const newCard = new Card(question, answer);
        cards.push(newCard);

        const cardElement = document.createElement("div");
        cardElement.classList.add("card");
        cardElement.dataset.id = newCard.id;

        cardElement.innerHTML = `
        <div class="card-body">
        <div class="card-front">
        <p class="card-text">${newCard.question}</p>
        <button class="show-answer">Show Answer</button>
        </div>
        <div class="card-back d-none">  
        <p class="card-text">${newCard.answer}</p>
        </div> 
        <div class="card-actions">
            <button class="edit-card btn btn-success">Edit</button>
            <button class="delete-card btn btn-warning">Delete</button>
        </div>
        </div>`;

        cardDisplay.appendChild(cardElement);

        document.querySelector(".card-question-input").value = "";
        document.querySelector(".card-answer-input").value = "";
        newCardForm.classList.add("d-none");

        showCard(cardElement);
        deleteCard(cardElement)
        editCard(cardElement)
    });
};

function showCard(cardElement) {
    cardElement.querySelector(".show-answer").addEventListener("click", function () {
        cardElement.querySelector(".card-back").classList.toggle("d-none");
    });
}

function deleteCard(cardElement) {
    cardElement.querySelector(".delete-card").addEventListener("click", function () {
        const cardId = parseInt(cardElement.dataset.id);
        const cardIndex = cards.findIndex(card => card.id === cardId);

        if (cardIndex > -1) {
            cards.splice(cardIndex, 1);
            cardElement.remove();
        }
    });
}

function editCard(cardElement) {
    cardElement.querySelector(".edit-card").addEventListener("click", function () {
        const cardId = parseInt(cardElement.dataset.id);
        const card = cards.find(card => card.id === cardId);

        if (!card) {
            return;
        }

        cardElement.querySelector(".card-front").classList.add("d-none");
        cardElement.querySelector(".card-back").classList.add("d-none");

        const editForm = document.createElement("div");
        editForm.id = "editForm";

        editForm.innerHTML = `
        <div id="editForm" class="">
        <input type="text" id="editQuestion" value="${card.question}">
        <input type="text" id="editAnswer" value="${card.answer}">
        <button class="save-edit">Save</button>
        <button class="cancel-edit">Cancel</button>
        </div>`;

        cardElement.appendChild(editForm);

        editForm.querySelector(".save-edit").addEventListener("click", function () {
            const editQuestion = document.getElementById("editQuestion").value;
            const editAnswer = document.getElementById("editAnswer").value;

            card.question = editQuestion;
            card.answer = editAnswer;

            cardElement.querySelector('.card-front p').textContent = card.question;
            cardElement.querySelector('.card-back p').textContent = card.answer;

            editForm.remove();
            cardElement.querySelector(".card-front").classList.remove("d-none");
        });

        editForm.querySelector('.cancel-edit').addEventListener('click', () => {
            editForm.remove();
            cardElement.querySelector('.cancel').classList.remove('d-none');
        });
    });
}

console.log(decks);
console.log(cards);