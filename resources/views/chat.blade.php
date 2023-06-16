<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
</head>

<body>
    <div class="green-background"></div>
    <div class="wrap">
        <section class="left">
            <div class="profile">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1089577/user.jpg">
                <span>{{ auth()->user()->name }}</span>
            </div>
            <div class="wrap-search">
                <div class="search">
                    <i class="bi bi-search"></i>
                    <input type="text" class="input-search" placeholder="Enter name">
                </div>
            </div>
            <div class="contact-list"></div>
        </section>

        <section class="right">
            <div class="chat-head">
                <img alt="profilepicture">
                <div class="chat-name">
                    <h1 class="font-name"></h1>
                    <p class="font-online"></p>
                </div>
                <i class="bi bi-list" id="show-contact-information"></i>
                <i class="bi bi-x-lg" aria-hidden="true" id="close-contact-information"></i>
            </div>
            <div class="wrap-chat">
                <div class="chat"></div>
                <div class="information d-none"><img
                        src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1089577/contact4.jpg">
                    <div>
                        <h1>Name:</h1>
                        <p>Marina Pühringer</p>
                    </div>
                    <div id="listGroups">
                        <h1>Gemeinsame Gruppen:</h1>
                        <div class="listGroups"><img
                                src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1089577/contact7.JPG">
                            <p>Cool Kids</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap-message">
                <i class="bi bi-emoji-smile"></i>
                <div class="message">
                    <input type="text" name="message" class="input-message" placeholder="Enter message">
                </div>
                <i class="bi bi-send"></i>
            </div>
        </section>
    </div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    let csrf_token = document.querySelector("meta[name='csrf-token']").content;
    let currentDate = new Date();
    // call api get list user
    async function getUsers() {
        const response = await axios.get("/users", {
            headers: {
                "X-CSRF-TOKEN": csrf_token,
            },
        });
        return dataUsersToHtml(response.data);
    }
    // handle data from getUsers as HTML
    function dataUsersToHtml(data) {
        let html = "";

        data.data.forEach((user) => {
            html += `<div class="contact" data-id="${user.id}"><img
						src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1089577/contact7.JPG">
					<div class="contact-preview">
						<div class="contact-text">
							<h1 class="font-name">${user.name}</h1>
                            <p class="font-preview">${ handlePreviewMessageFirst(user.message) }</p>
						</div>
					</div>
					<div class="contact-time">
						<p title="${ handlePreviewTitleMessage(user.message) }">${ handlePreviewDateTimeFirst(user.message) }</p>
					</div>
				</div>`;
        });
        return html;
    }

    function check_null_message(message) {
        if (message == null) {
            return false;
        }
        return true;
    }

    function diffTime(time) {
        let created_at = new Date(time);
        let time_to_text = " " + getTimeDiffAndPrettyText(created_at).friendlyNiceText;
        return time_to_text;
    }

    function getTimeDiffAndPrettyText(oDatePublished) {

        var oResult = {};

        var oToday = new Date();

        var nDiff = oToday.getTime() - oDatePublished.getTime();

        // Get diff in days
        oResult.days = Math.floor(nDiff / 1000 / 60 / 60 / 24);
        nDiff -= oResult.days * 1000 * 60 * 60 * 24;

        // Get diff in hours
        oResult.hours = Math.floor(nDiff / 1000 / 60 / 60);
        nDiff -= oResult.hours * 1000 * 60 * 60;

        // Get diff in minutes
        oResult.minutes = Math.floor(nDiff / 1000 / 60);
        nDiff -= oResult.minutes * 1000 * 60;

        // Get diff in seconds
        oResult.seconds = Math.floor(nDiff / 1000);

        // Render the diffs into friendly duration string

        // Days
        var sDays = '00';
        if (oResult.days > 0) {
            sDays = String(oResult.days);
        }
        if (sDays.length === 1) {
            sDays = '0' + sDays;
        }

        // Format Hours
        var sHour = '00';
        if (oResult.hours > 0) {
            sHour = String(oResult.hours);
        }
        if (sHour.length === 1) {
            sHour = '0' + sHour;
        }

        //  Format Minutes
        var sMins = '00';
        if (oResult.minutes > 0) {
            sMins = String(oResult.minutes);
        }
        if (sMins.length === 1) {
            sMins = '0' + sMins;
        }

        //  Format Seconds
        var sSecs = '00';
        if (oResult.seconds > 0) {
            sSecs = String(oResult.seconds);
        }
        if (sSecs.length === 1) {
            sSecs = '0' + sSecs;
        }

        //  Set Duration
        var sDuration = sDays + ':' + sHour + ':' + sMins + ':' + sSecs;
        oResult.duration = sDuration;

        // Set friendly text for printing
        if (oResult.days === 0) {

            if (oResult.hours === 0) {

                if (oResult.minutes === 0) {
                    var sSecHolder = oResult.seconds > 1 ? 'Seconds' : 'Second';
                    oResult.friendlyNiceText = oResult.seconds + ' ' + sSecHolder + ' ago';
                } else {
                    var sMinutesHolder = oResult.minutes > 1 ? 'Minutes' : 'Minute';
                    oResult.friendlyNiceText = oResult.minutes + ' ' + sMinutesHolder + ' ago';
                }

            } else {
                var sHourHolder = oResult.hours > 1 ? 'Hours' : 'Hour';
                oResult.friendlyNiceText = oResult.hours + ' ' + sHourHolder + ' ago';
            }
        } else {
            var sDayHolder = oResult.days > 1 ? 'Days' : 'Day';
            oResult.friendlyNiceText = oResult.days + ' ' + sDayHolder + ' ago';
        }

        return oResult;
    }

    function handlePreviewTitleMessage(message) {
        if (check_null_message(message)) {
            return message.created_at;
        }
        return "";
    }

    function handlePreviewDateTimeFirst(message) {
        if (check_null_message(message)) {
            return diffTime(message.created_at);
        }
        return "";
    }

    function handlePreviewMessageFirst(message) {
        if (message == null) {
            return "";
        }
        if (message.user_id == {{ auth()->id() }}) {
            return "You: " + message.message;
        }
        return message.message;
    }

    // call api get list message
    async function getMessages(user_to) {
        const response = await axios.get("/messages/" + user_to, {
            headers: {
                "X-CSRF-TOKEN": csrf_token,
            },
        });
        return dataMessagesToHtml(response.data);
    }

    function genarateMessageByUser(message, user_to = null) {
        let user;
        if (user_to == null) {
            user = document.querySelector(`.contact[data-id="${message.user_id}"]`);
        } else {
            user = document.querySelector(`.contact[data-id="${user_to}"]`);
        }
        let preview_message = user.querySelector(".font-preview");
        preview_message.innerHTML = handlePreviewMessageFirst(message);
    }
    // handle data from getMessages as HTML
    function dataMessagesToHtml(data) {
        let html = "";
        data.data.forEach((message) => {
            if (message.user_id == {{ auth()->id() }}) {
                html += `<div class="chat-bubble me">
                        <div class="my-mouth"></div>
                        <div class="content">${message.message}</div>
                        <div class="time" title=${ handlePreviewTitleMessage(message) }>${diffTime(message.created_at)}</div>
                    </div>`;
            } else {
                html += `<div class="chat-bubble you">
                        <div class="your-mouth"></div>
                        <div class="content">${message.message}</div>
                        <div class="time" title=${ handlePreviewTitleMessage(message) }>${ diffTime(message.created_at)}</div>
                    </div>`;
            }
        });
        return html;
    }
    // call api post content message and receiver 
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
    // handle 
    function generateMessage(list_message, data, user_to) {
        let html = "";
        if (data.user_id == {{ auth()->id() }}) {
            html = `<div class="chat-bubble me">
					<div class="my-mouth"></div>
					<div class="content">${data.message}</div>
					<div class="time" title=${ handlePreviewTitleMessage(data) }>${ diffTime(data.created_at)}</div>
				</div>`;
        }
        if (data.user_id == user_to) {
            html = `<div class="chat-bubble you">
					<div class="your-mouth"></div>
					<div class="content">${data.message}</div>
					<div class="time" title=${ handlePreviewTitleMessage(data) }>${ diffTime(data.created_at) }</div>
				</div>`;
        }
        list_message.innerHTML += html;
    }

    function handleSendMessage(input_message, user_to, list_message) {
        if (input_message.value != null) {
            sendMessage([input_message.value, user_to]);
            let message = {
                "created_at": Date.now(),
                "message": input_message.value,
                "user_id": {{ auth()->id() }}
            }
            generateMessage(list_message, message, user_to);
            genarateMessageByUser(message, user_to);
            input_message.value = "";
        }
    }
    document.addEventListener(
        "DOMContentLoaded",
        async function() {
                let chat = document.querySelector(".chat")
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

                chat.scrollTo(0, chat.scrollHeight);

                let time_send = document.querySelectorAll(".contact-time p");
                let time_valid = Array.from(time_send).filter((time) => {
                    return time.title != "";
                });

                let time_list_message = document.querySelectorAll(".chat .time");

                contact.forEach((user) => {
                    user.onclick = async () => {
                        document
                            .querySelector(".contact.active-contact")
                            .classList.remove("active-contact");
                        user_to = user.getAttribute("data-id");
                        list_message.innerHTML = await getMessages(user_to);
                        chat.scrollTo(0, chat.scrollHeight)

                        time_list_message = document.querySelectorAll(".chat .time");

                        user.classList.add("active-contact");
                    };
                });

                input_message.onkeyup = function(e) {
                    if (e.keyCode == 13) {
                        handleSendMessage(input_message, user_to, list_message);
                        chat.scrollTo(0, chat.scrollHeight)
                    }
                };

                btn_send.onclick = function() {
                    handleSendMessage(input_message, user_to, list_message);
                    chat.scrollTo(0, chat.scrollHeight)

                }


                window.Echo.private('chat.{{ auth()->id() }}').listen("MessageSent", (data) => {
                    generateMessage(list_message, data.message, user_to);
                    genarateMessageByUser(data.message);
                    chat.scrollTo(0, chat.scrollHeight)

                });

                setInterval(() => {
                    time_valid.forEach(e => {
                        e.innerHTML = diffTime(e.title);
                    })
                    time_list_message.forEach(e => {
                        e.innerHTML = diffTime(e.title);
                    })
                }, 60000);


            },
            false
    );
</script>

</html>
