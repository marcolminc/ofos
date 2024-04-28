<?php
session_start();
if (!file_exists(('./config.php'))) {
    header('Location: ./installation.php');
    exit;
}

include_once('./header.php');
?>
    <h1>Business Signup</h1>
    <div class="form business-reg-form">
    <form action="./handle_rep_reg.php" name="validjs-form" id="validjs-form" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Representative</legend>
                    <div class="form-group">
                        <label for="first_name">First Name:<span class="error" id="first_name_err">* </span></label>
                        <input type="text" id="first_name" name="first_name" required autocomplete="TRUE">
                        </div>

                        <div class="form-group">
                            <label for="middle_name">Middle Name:<span class="error" id="middle_name_err"></span></label>
                            <input type="text" id="middle_name" name="middle_name" >
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:<span class="error" id="last_name_err">* </span></label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:<span class="error" id="email_err">* </span></label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username:<span class="error" id="username_err">* </span></label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:<span class="error" id="password_err">* </span></label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="cpassword">Confirm Password:<span class="error" id="cpassword_err">* </span></label>
                            <input type="password" id="cpassword" name="cpassword" required>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Business Profile</legend>
                        <div class="form-group">
                            <label for="restaurant_name">Restaurant Name:<span class="error" id="restaurant_name_err">* </span></label>
                            <input type="text" id="restaurant_name" name="restaurant_name" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category:<span class="error" id="category_err">* </span></label>
                            <select id="category" name="category" required>
                                <option value="food">Food</option>
                                <option value="drinks">Drinks</option>
                                <option value="grocery">Grocery</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="location">Location:<span class="error" id="location_err">* </span></label>
                            <input type="text" id="location" name="location" required>
                        </div>
                        <div class="form-group">
                            <label for="contact">Contact Number:<span class="error" id="contact_err">* </span></label>
                            <input type="tel" id="contact" name="contact" required>
                        </div>
                        <div class="form-group">
                            <label for="open_hours">Opening Hours:<span class="error" id="open_hours_err">* </span></label>
                            <input type="time" id="open_hours" name="open_hours" required>
                        </div>
                        <div class="form-group">
                            <label for="close_hours">Closing Hours:<span class="error" id="close_hours_err">* </span></label>
                            <input type="time" id="close_hours" name="close_hours" required>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo:<span class="error" id="logo_err">* </span></label>
                            <input type="file" id="logo" name="logo" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="cover">Cover Image:<span class="error" id="cover_err">* </span></label>
                            <input type="file" id="cover" name="cover" accept="image/*" required>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <button type="button" name="btn-submit" id="btn-submit" value="submit">Submit</button>
            </div>
        </form>
    </div>
<script src="./js/index.js"></script>
<script src="./js/jsvalid.js"></script>
</body>
</html>