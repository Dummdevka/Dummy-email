<div class="de_menu">
    <form id="admin_email" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
        <label for="html">Is HTML(don't touch it unless you have a cool markup!) <input type="checkbox" name="html" id="html"></label>
        <span>To end a string or leave it blank use "*"</span>
        <input type="text" name="subject" placeholder="Subject" id="subject">
        <textarea name="body" id="body" cols="10" rows="5" required class="required" placeholder="Body"></textarea>
        <input type="hidden" name="action" value="admin_change_email">

        <input type="submit" value="Save data">
    </form>
    <div class="replacements">
        <p class="replacement" data-value="confirmation-url">Confirmation link</p>
        <p class="replacement" data-value="user-username">User username</p>
        <p class="replacement" data-value="user-email">User email</p>
        <p class="replacement" data-value="website-name">Website name</p>
        <p class="replacement" data-value="website-url">Website url</p>
        <h4>Styling</h4>
        <p class="styling" data-value="bold">Bold header</p>
        <p class="styling" data-value="semi">Semi-bold header</p>
        <p class="styling" data-value="it">Italic</p>
        <p class="styling" data-value="red">Red</p>
        <p class="styling" data-value="gr">Green</p>
        <p class="styling" data-value="btn">Button</p>
    </div>
</div>


