<div class="de_menu">
    <form class="de-admin-form" id="admin_email" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
        <label class="de-checkbox-label" for="html">Is HTML(don't touch it unless you have a cool markup!)
             <input class="de-checkbox" type="checkbox" name="html" id="html">
        </label>
        <input class="de-input" type="text" name="subject" placeholder="Subject" id="subject">
        <textarea class="de-textarea" name="body" id="body" cols="10" rows="5" required class="required" placeholder="Body"></textarea>
        <input type="hidden" name="action" value="admin_change_email">

        <input class="de-btn" type="submit" value="Save data">
    </form>
    <div class="de-replacements">
        <p class="de-replacement" data-value="confirmation-url">Confirmation link</p>
        <p class="de-replacement" data-value="user-username">User username</p>
        <p class="de-replacement" data-value="user-email">User email</p>
        <p class="de-replacement" data-value="website-name">Website name</p>
        <p class="de-replacement" data-value="website-url">Website url</p>
        <h4>Styling</h4>
        <p class="de-styling" data-value="bold">Bold header</p>
        <p class="de-styling" data-value="semi">Semi-bold header</p>
        <p class="de-styling" data-value="it">Italic</p>
        <p class="de-styling" data-value="red">Red</p>
        <p class="de-styling" data-value="gr">Green</p>
        <p class="de-styling" data-value="btn">Button</p>
    </div>
</div>


