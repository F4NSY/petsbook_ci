<link rel="stylesheet" href="<?= base_url(); ?>assets/css/chat.css">
<div class="vh-100-less-navbar d-flex justify-content-center">
    <div id="users-container" class="h-100 bg-light border chat-users-container">
    <div class="px-3 px-sm-4">
            <div class="fs-3 fw-bold py-2">Chats</div>
            <input id="messageSearchBox" class="form-control mb-4" type="text" placeholder="Search PetsChat">
            <div id="user-list"class="overflow-auto" style="max-height: calc(100vh - 120.39px)">

            </div>
        </div>
    </div>
    <div id="messages-container" class="h-100 bg-light border chat-messages-container d-md-flex d-none align-items-center justify-content-center flex-column text-center">
        <h2 class="mt-0">Hi There! Welcome To</h2>
        <h2><span class="text-primary">PetsBook</span> Chat Application</h2>
        <p class="my-2">Connect to your device via Internet. Remember that you <br> must have a stable Internet Connection for a<br> greater experience.</p>
    </div>
</div>

<?php include APPPATH . 'views/user/modals/image-modal.php' ;?>
<script>
    var user = <?= json_encode($user); ?>;
</script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/constants/chat-string-constants.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/chat.js"></script>