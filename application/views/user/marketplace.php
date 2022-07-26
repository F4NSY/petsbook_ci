<div class="vh-100-less-navbar d-flex">
    <div class="sidebar py-4 border-end bg-light">
        <div class="px-sm-4 px-2">
            <div class="fs-3 fw-bold mb-md-4 mb-3 d-sm-block d-none">Marketplace</div>
            <div id="marketplace-options">
                <a href="" class="link-dark" onclick="openOptions(event, 'browse-all')">
                    <div class="mb-4 d-flex align-items-center">
                        <div class="flex-grow-1 d-flex justify-content-center justify-content-md-start align-items-center">
                            <div class="p-1 custom-icons rounded-circle d-flex justify-content-center align-items-center me-sm-2 me-0">
                                <i class="fas fa-store fa-lg"></i>
                            </div>
                            <div class="sidebar-texts d-md-block d-none">
                                Browse All
                            </div>
                        </div>
                        <div class="d-sm-inline d-none">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </a>
                <div class="d-grid">
                    <button id="marketplaceButton" type="button" class="btn btn-primary btn-sm" data-mdb-toggle="modal" data-mdb-target="#marketplaceModal">
                        Create new listing 
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid overflow-auto py-4">
        <div class="row" id="marketplace-list">
        </div>
    </div>
</div>

<?php include APPPATH . 'views/user/modals/marketplace-modal.php' ;?>
