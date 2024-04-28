<?php
session_start();
if (!file_exists(('./config.php'))) {
    header('Location: ./installation.php');
    exit;
}
require('./functions.php');

//placeholders for data fields:
$fname = $mname = $lname = $mail = $uname = $pass = $cpass = '';
$rname = $cat = $logo = $cover = $ohr = $chr = $loc = $cont = $rid = '';

// $fnameErr = $mnameErr = $lnameErr = $mailErr = $unameErr = $passErr = $cpassErr = '';
// $rnameErr = $catErr = $logoErr = $coverErr = $ohrErr = $chrErr = $locErr = $contErr = $ridErr ='';
$inputErrs = [];
$pwd = null;

// validation and insertion of data
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    //validation and data sanitization

        //rep
    if (empty($_POST["first_name"])) {
        $inputErrs[] = "Firstname is required";
    } else if (!checkName($_POST["first_name"])){
        $inputErrs[] = "Only letters allowed";
    } else {
        $fname = filterInput($_POST["first_name"]);
    }

    if (!empty($_POST['middle_name'])) {
        if (!checkName($_POST['middle_name'])) {
            $inputErrs[] = "Only letters allowed";
        } else {
            $mname = filterInput($_POST['middle_name']);
        }
    }
 
    if (empty($_POST["last_name"])) {
        $inputErrs[] = "Lastname is required";
    } else if (!checkName($_POST["last_name"])){
        $inputErrs[] = "Only letters allowed";
    } else {
        $lname = filterInput($_POST["last_name"]);
    }
    //check email
    if (empty($_POST["email"])) {
        $inputErrs[] = "Email is required";
    } else if (!checkEmail($_POST["email"])){
        $inputErrs[] = "Invalid Email Address";
    }
    else {
        $mail = filterInput($_POST["email"]);
    }
    if (empty($_POST["username"])) {
        $inputErrs[] = "Username is required";
    } else if (!checkName($_POST["username"])){
        $inputErrs[] = "Only letters allowed";
    } else {
        $uname = filterInput($_POST["username"]);
    }
    if (empty($_POST["password"])) {
        $inputErrs[] = "Password is required";
    } else if (!validatePass($_POST["password"])) {
        $inputErrs[] = "password strength {a-z, A-Z, 0-9, special characters}";
    } else {
        $pass = $_POST["password"];
    }
    if (empty($_POST["cpassword"])) {
        $inputErrs[] = "Confirmation is mandatory";
    } else {
        $cpass = $_POST["cpassword"];
    }
        //password strength and match
    if (!empty($pass) && !empty($cpass)) {
        if (strcmp($pass, $cpass) !== 0) {
            $inputErrs[] = "Passwords do not match";
        }
        else {
            $pwd = $cpass;
        }
    }


        //business
    if (empty($_POST["restaurant_name"])) {
        $inputErrs[] = "Brand name is required";
    } else if (!validateBrand($_POST['restaurant_name'])){
        $inputErrs[] = 'only {alphabets, @ # - _\' . : & } allowed';
    } else {
        $rname = $_POST["restaurant_name"];
    }
    if (empty($_POST["category"])) {
        $inputErrs[] = "Category is required";
    } else {
        $cat = filterInput($_POST["category"]);
    }
    if (empty($_FILES["logo"])) {
        $inputErrs[] = "Logo is required";
    } else if ($_FILES['logo']['size'] == 0) {
        //empty logo upload field
        $inputErrs[] = "Logo photo is required";
    }
    if (empty($_FILES["cover"])) {
        $inputErrs[] = "Cover is required";
    } else if ($_FILES['cover']['size'] == 0) {
        //empty cover upload field
        $inputErrs[] = "Cover photo is required";
    }

    if (empty($_POST["open_hours"])) {
        $inputErrs[] = "Opening hrs is required";
    } else if (!validateTime($_POST['open_hours'])){
        $inputErrs[] = 'Invalid opening time';
    } else {
        $ohr = filterInput($_POST["open_hours"]);
    }

    if (empty($_POST["close_hours"])) {
        $inputErrs[] = "Closing hrs is required";
    } else if (!validateTime($_POST['close_hours'])){
        $inputErrs[] = 'Invalid closing time';
    } else {
        $ohr = filterInput($_POST["close_hours"]);
    }

    if (empty($_POST["location"])) {
        $inputErrs[] = "Location is required";
    } else if (!validateLocation($_POST['location'])){
        $inputErrs[] = 'only {alphabets, -_ .:\'#} allowed';
    } else {
        $loc = filterInput($_POST["location"]);
    }
    if (empty($_POST["contact"])) {
        $inputErrs[] = "Contact is required";
    } else if (!validateContact($_POST['contact'])) {
        $inputErrs[] = "invalid number. 0(+255) 123 456 789";
    } else {
        $cont = filterInput($_POST["contact"]);
    }

    $response = array();
    if(empty($inputErrs)) {
        // //insert rep into db
        $folder = "./uploads/";
        $imgFormats = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF);
        $uploadOk = true;
        require_once('./config.php');
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

        $repQuery = "INSERT INTO representatives (first_name, middle_name, last_name, email, username, password)
                    VALUES (:first_name, :middle_name, :last_name, :email, :username, :password)";
        $repStatement = $pdo->prepare($repQuery);
        $repStatement->bindParam(':first_name', $fname);
        $repStatement->bindParam(':middle_name', $mname);
        $repStatement->bindParam(':last_name', $lname);
        $repStatement->bindParam(':email', $mail);
        $repStatement->bindParam(':username', $uname);
        $repStatement->bindParam(':password', $pwd);

        if ($repStatement->execute()) {
            // Get the representative's ID
            $repId = $pdo->lastInsertId();
    
            //handle file uploads
             //logo
             if ($_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
                $uploadOk = false;
                $response = "Error uploading logo image";
            } else {
                $logo = $_FILES['logo']['tmp_name'];
                $logoInfo = getimagesize($logo);
                if ($logoInfo === false) {
                    $uploadOk = false;
                    $response = 'Invalid image file';
                } else if (!in_array($logoInfo[2], $imgFormats)) {
                    $uploadOk = false;
                    $response = "Unsupported image format";
                } else {
                    $logoName = generateName($_FILES['logo']['name']);
                    $logoPath = $folder.$logoName;
            
                    move_uploaded_file($logo, $logoPath);
                    // unlink($logo);
                }
            }
            

        //cover
        if ($_FILES['cover']['error'] !== UPLOAD_ERR_OK) {
            $uploadOk = false;
            $response = "Error uploading cover image";
        } else {
            $cover = $_FILES['cover']['tmp_name'];
            $coverInfo = getimagesize($cover);
            if ($coverInfo === false) {
                $uploadOk = false;
                $response = 'Invalid image file';
            } else if (!in_array($coverInfo[2], $imgFormats)) {
                $uploadOk = false;
                $response = "Unsupported image format";
            } else {
                $coverName = generateName($_FILES['cover']['name']);
                $coverPath = $folder.$coverName;
        
                move_uploaded_file($cover, $coverPath);
                // unlink($cover);
            }
        }
        

        if ($uploadOk) {
            //insert business (restaurant) info in to db
            $restQuery = "INSERT INTO restaurants (name, category, logo, cover, openHrs, closeHrs, location, contact, rep_id)
                        VALUES (:name, :category, :logo, :cover, :openHrs, :closeHrs, :location, :contact, :rep_id)";
            $restStatement = $pdo->prepare($restQuery);
            $restStatement->bindParam(':name', $rname);
            $restStatement->bindParam(':category', $cat);
            $restStatement->bindParam(':logo', $logoPath);
            $restStatement->bindParam(':cover', $coverPath);
            $restStatement->bindParam(':openHrs', $ohr);
            $restStatement->bindParam(':closeHrs', $chr);
            $restStatement->bindParam(':location', $loc);
            $restStatement->bindParam(':contact', $cont);
            $restStatement->bindParam(':rep_id', $repId);

            if ($restStatement->execute()) {
                //rep and rest data successfully inserted
                // $response['success'] = true;
                // $response['message'] = "Registered successfully!";
                $response = "Registered successfully!";
            } else {
                //error inserting rest data
                // $response['success'] = false;
                // $response['message'] = "Error inserting restaurant data into the database.";    
                $response = "Error inserting restaurant data into the database.";    
            }
        }
    } else {
        //error inserting rep data
        // $response['success'] = false;
        // $response['message'] = "Error inserting representative data into the database.";    
        $response = "Error inserting representative data into the database.";    
    }

 } else {
    // $response['success'] = false;
    // $response['message'] = "Form field errors:\n" . implode("\n", $inputErrs);
    $response = "Form field errors:\n" . implode("\n", $inputErrs);
 }




//send response back as json
header('Content-Type: application/json');
echo json_encode($response);
exit;
//the doc and header  
}

