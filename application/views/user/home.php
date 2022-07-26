<div class="container">
    <?php $attribute = array('id' => 'postingForm', 'class' => 'bg-light my-3 p-3 rounded-6', 'novalidate' => 'novalidate', 'autocomplete' => 'off');
          echo form_open('', $attribute); ?>
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
                    <input type="text" name="postContent" id="postContent" class="form-control form-control-lg" placeholder="What's on your mind?">
                </div>
            </div>
        </div>
        <div class="py-2 d-flex align-items-center justify-content-between">
            <div>
                <span class="post-file-container">
                    <label for="postVideo" class="cursor-pointer me-2">
                        <i class="fas fa-video me-3 fa-lg"></i>
                    </label>
                    <input type="file" name="postVideo" id="postVideo" accept="video/*">
                </span>
                <span class="post-file-container">
                    <label for="postImage" class="cursor-pointer me-2">
                        <i class="fas fa-camera fa-lg"></i>
                    </label>
                    <input type="file" name="postImage" id="postImage" accept="image/*">
                </span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <div id="home-page-contents">
    </div>
</div>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/home.js"></script>