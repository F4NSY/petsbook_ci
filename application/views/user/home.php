<div class="container">
    <div class="bg-light my-3 p-3 rounded-6">
        <div class="py-2 border-bottom">
            <div class="d-flex align-items-center">
                <img
                    src="<?= $this->session->userdata('profilePicture'); ?>"
                    class="rounded-circle me-3"
                    height="45"
                    width="45"
                    style="object-fit: cover;"
                />
                <div class="flex-grow-1 fs-7">
                    <input type="text" name="" id="" class="form-control form-control-lg" placeholder="What's on your mind?">
                </div>
            </div>
        </div>
        <div class="py-2 d-flex align-items-center justify-content-between">
            <div>
                <i class="fas fa-video me-3 fa-lg"></i>
                <i class="fas fa-camera fa-lg"></i>
            </div>
            <a href="#!" class="btn btn-primary">Submit</a>
        </div>
    </div>
    <div id="home-page-contents">
        <div class="bg-light my-3 p-3 rounded-6">
            <div class="py-2">
                <div class="d-flex align-items-center">
                    <img
                        src="<?= $this->session->userdata('profilePicture'); ?>"
                        class="rounded-circle me-3"
                        height="45"
                        width="45"
                        style="object-fit: cover;"
                    />
                    <div class="fs-7">
                        <div class="fw-bold">
                            Earnest Piolo Fano
                        </div>
                        <div>
                            50mins
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-2">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae nemo quis iste natus voluptas impedit optio, sequi at. Sapiente voluptates ad necessitatibus assumenda doloribus ipsam adipisci fuga, ullam reiciendis magni.
            </div>
            <div class="py-2 border-bottom border-top">
                <div class="row text-center">
                    <div class="col">Like</div>
                    <div class="col">Comment</div>
                    <div class="col">Share</div>
                </div>
            </div>
            <div class="py-2">
                <div class="d-flex align-items-center">
                    <img
                        src="<?= $this->session->userdata('profilePicture'); ?>"
                        class="rounded-circle me-3"
                        height="35"
                        width="35"
                        style="object-fit: cover;"
                    />
                    <div class="flex-grow-1 fs-7">
                        <input type="text" name="" id="" class="form-control form-control" placeholder="Write a comment...">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>