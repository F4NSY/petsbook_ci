<div class="container">
    <div class="bg-image rounded-6">
        <img src="<?= base_url(); ?>assets/images/default_cover_photo.jpg" alt="" class="w-100" style="height: 25vw; object-fit: cover;">
        <div class="mask" style="background-color: rgba(0, 0, 0, 0.2)"></div>
    </div>
    <div class="p-3 my-3 bg-light d-flex align-items-center rounded-6">
        <img
            src="<?= $user['profilePicture']; ?>"
            class="rounded-circle me-3"
            height="150"
            width="150"
            alt=""
            loading="lazy"
            style="object-fit: cover;"
        />
        <div class="flex-grow-1">
            <div class="fs-3 fw-bold">
                <?= $user['firstName'] . ' ' . $user['lastName']; ?>
            </div>
            <div>
                909 friends
            </div>
        </div>
        <div>
            <a href="#!" class="btn btn-primary">Add Friend</a>
			<a href="<?= base_url(); ?>chat/<?= $user['userId']; ?>"  class="btn">Message</a>
        </div>
    </div>
</div>