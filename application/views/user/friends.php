<div class="vh-100-less-navbar d-flex">
    <div class="sidebar py-4 border-end bg-light">
        <div class="px-sm-4 px-2">
            <div class="fs-3 fw-bold mb-md-4 mb-3 d-sm-block d-none">Friends</div>
            <div id="friends-options">
                <a href="" class="link-dark" onclick="openOptions(event, 'lists')">
                    <div class="mb-4 d-flex align-items-center">
                        <div class="flex-grow-1 d-flex justify-content-center justify-content-md-start align-items-center">
                            <div class="p-1 custom-icons rounded-circle d-flex justify-content-center align-items-center me-sm-2 me-0">
                                <i class="fas fa-user-friends fa-lg"></i>
                            </div>
                            <div class="sidebar-texts d-md-block d-none">
                                All Friends
                            </div>
                        </div>
                        <div class="d-sm-inline d-none">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </a>
                <a href="" class="link-dark" onclick="openOptions(event, 'requests')">
                    <div class="mb-4 d-flex align-items-center">
                        <div class="flex-grow-1 d-flex justify-content-center justify-content-md-start align-items-center">
                            <div class="p-1 custom-icons rounded-circle d-flex justify-content-center align-items-center me-sm-2 me-0">
                                <i class="fas fa-user-plus fa-lg"></i>
                            </div>
                            <div class="sidebar-texts d-md-block d-none">
                                Friend Requests
                            </div>
                        </div>
                        <div class="d-sm-inline d-none">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </a>
                <a href="" class="link-dark" onclick="openOptions(event, 'suggestions')">
                    <div class="mb-4 d-flex align-items-center">
                        <div class="flex-grow-1 d-flex justify-content-center justify-content-md-start align-items-center">
                            <div class="p-1 custom-icons rounded-circle d-flex justify-content-center align-items-center me-sm-2 me-0">
                                <i class="fas fa-address-book fa-lg"></i>
                            </div>
                            <div class="sidebar-texts d-md-block d-none">
                                Suggestions
                            </div>
                        </div>
                        <div class="d-sm-inline d-none">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid overflow-auto py-4">
        <div class="row" id="friend-lists">
        </div>
    </div>
</div>

<script>
    var currentPath = '<?= $currentPath; ?>';
</script>
<script type="text/javascript" src="<?= base_url(); ?>assets/js/friends.js">
</script>
