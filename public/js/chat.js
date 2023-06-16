let csrf_token = document.querySelector("meta[name='csrf-token']").content;

async function getUsers() {
    const response = await axios.get("/users", {
        headers: {
            "X-CSRF-TOKEN": csrf_token,
        },
    });
    return fetchUsers(response.data);
}

async function getMessages(user_to) {
    const response = await axios.get("/messages/" + user_to, {
        headers: {
            "X-CSRF-TOKEN": csrf_token,
        },
    });
    return fetchMessages(response.data);
}

function sendMessage(data) {
    axios
        .post("/messages", {
            message: data[0],
            user_to: data[1],
        })
        .then((response) => {
            if (!response.data.status) {
                console.log(response.data);
            }
        });
}

// function addMessage(list_message, data) {
//     let html = "";
//     if (data.user.id == 1) {
//         html = `<div class="chat-bubble me">
// 					<div class="your-mouth"></div>
// 					<div class="content">${data.message.message}</div>
// 					<div class="time">17:24</div>
// 				</div>`;
//         list_message.innerHTML += html;
//     } else {
//         html = `<div class="chat-bubble you">
// 					<div class="your-mouth"></div>
// 					<div class="content">${data.message.message}</div>
// 					<div class="time">17:24</div>
// 				</div>`;
//         list_message.innerHTML += html;
//     }
// }

// function fetchMessages(data) {
//     let html = "";
//     data.data.forEach((message) => {
//         if (message.user_id == 1) {
//             html += `<div class="chat-bubble me">
//                         <div class="your-mouth"></div>
//                         <div class="content">${message.message}</div>
//                         <div class="time">${message.created_at}</div>
//                     </div>`;
//         } else {
//             html += `<div class="chat-bubble you">
//                         <div class="your-mouth"></div>
//                         <div class="content">${message.message}</div>
//                         <div class="time">${message.created_at}</div>
//                     </div>`;
//         }
//     });
//     return html;
// }

function fetchUsers(data) {
    let html = "";
    data.data.forEach((user) => {
        html += `<div class="contact" data-id="${user.id}"><img
						src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1089577/contact7.JPG">
					<div class="contact-preview">
						<div class="contact-text">
							<h1 class="font-name">${user.name}</h1>
						</div>
					</div>
					<div class="contact-time">
						<p>17:54</p>
					</div>
				</div>`;
    });
    return html;
}

document.addEventListener(
    "DOMContentLoaded",
    async function () {
        let contacts = document.querySelector(".contact-list");
        let input_message = document.querySelector(".input-message");
        let btn_send = document.querySelector(".bi.bi-send");
        let list_message = document.querySelector(".chat");

        contacts.innerHTML = await getUsers();

        let contact = document.querySelectorAll(".contact");
        let user_first = contact[0];
        let user_to = user_first.getAttribute("data-id");

        user_first.classList.add("active-contact");
        list_message.innerHTML = await getMessages(user_to);

        contact.forEach((user) => {
            user.onclick =  async () => {
                document
                    .querySelector(".contact.active-contact")
                    .classList.remove("active-contact");
                user_to = user.getAttribute("data-id");
                list_message.innerHTML = await getMessages(user_to);

                user.classList.add("active-contact");
            };
        });

        input_message.onkeyup = function (e) {
            if (e.keyCode == 13 && input_message != null) {
                sendMessage([input_message.value, user_to]);
                input_message.value = "";
            }
        };

        btn_send.onclick = function () {
            if (input_message != null) {
                sendMessage([input_message.value, user_to]);
                input_message.value = "";
            }
        };

    },
    false
);

