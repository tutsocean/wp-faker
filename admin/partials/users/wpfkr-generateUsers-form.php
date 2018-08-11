<div class="wpfkr-success-msg" style="display: none;"></div>
<div class="wpfkr-error-msg" style="display: none;"></div>
<form method="post" id="wpfkrGenUserForm">
    <input type="hidden" name="action" value="wpfkrAjaxGenUsers" />
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Choose User Role</th>
            <td>
                <select name="wpfkr-userRole">
                    <?php wp_dropdown_roles( 'subscriber' ); ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Number of Users</th>
            <td>
                <input type="number" name="wpfkr-user_count" placeholder="Number of Users" value="10" max="200" min="1" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Generate Bio</th>
            <td>
                <input type="checkbox" name="wpfkr-bio" />
            </td>
        </tr>
    </table>
    <input class="wpfkr-btn btnFade wpfkr-btnBlueGreen wpfkrGenerateUsers" type="submit" name="wpfkrGenerateUsers" value="Generate Users">
</form>
<div class="wpfkr-info-msg">
    <strong>Please note: </strong>Input maximum of 200 in "Number of users" per generation for quicker result.
</div>