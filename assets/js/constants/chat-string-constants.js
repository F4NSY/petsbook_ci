const messageContainerClass =
	"align-items-center justify-content-center flex-column text-center";
const chatWelcomeTemplate = `
    <h2 class="mt-0">Hi There! Welcome To</h2>
    <h2><span class="text-primary">PetsBook</span> Chat Application</h2>
    <p class="my-2">Connect to your device via Internet. Remember that you <br> must have a stable Internet Connection for a<br> greater experience.</p>
    `;
const userContainerHeader = `
    <div class="px-3 px-sm-4">
        <div class="fs-3 fw-bold py-2">Chats</div>
        <input id="messageSearchBox" class="form-control mb-4" type="text" placeholder="Search user">
        <div id="user-list"class="overflow-auto" style="max-height: calc(100vh - 120.39px)"

        </div>
    </div>
    `;
function createChatHeader(hasBack, user) {
	return `
        <div class="px-3 px-sm-4 w-100">
            <div class="py-2 border-bottom">
                <div class="d-flex align-items-center">
                    ${ hasBack ? '<a href="#" class="nav-link align-self-center"  onclick="backToUsers()"><i class="fas fa-arrow-left d-flex align-self-center"></i></a>' : "" }
                    <img
                        src="${ environment.base_url }assets/images/default_profile.jpg"
                        class="rounded-circle me-3"
                        height="45"
                        width="45"
                        style="object-fit: cover;"
                    />
                    <div class="flex-grow-1 fs-7">
                        <div class="fw-bold">
                            ${ user.firstName } ${ user.lastName }
                        </div>
                        <div id="lastSeen">
                        </div>
                    </div>
                    <div>
                        <div class="nav-link align-self-center d-flex justify-content-end dropdown">
                            <a class="text-dark dropdown-toggle hidden-arrow" href="#" role="button" id="dropdownMenuLink" data-mdb-toggle="dropdown"                         data-mdb-auto-close="outside" aria-expanded="false">
                                <i class="fas fa-exclamation-circle d-flex align-self-center"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                                <li><a href="" class="dropdown-item" id="reportBtn">Report user</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="chat-box">
            </div>
            <form id="chatForm" class="chat-typing-area px-3 d-flex align-items-center justify-content-between" enctype="multipart/form-data">
                <div id="chatImageContainer">
                    <label for="chatImage" id="chatImageLabel" class="me-2">
                        <i class="fas fa-images"></i>
                    </label>
                    <input type="file" name="chatImage" id="chatImage" accept="image/*">
                </div>
                <input type="text" id="chatContent" name="chatContent" autocomplete="off" placeholder="Type something...">
                <button id="submitChat" type="submit"><i class="fab fa-telegram-plane"></i></button>
            </form>
        </div>
        `;
}
